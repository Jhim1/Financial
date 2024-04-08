<?php include 'db_connect.php' ?>
<?php 
error_reporting(0);
extract($_POST);
if(isset($id)){

	$qry = $conn->query("SELECT * FROM Payments where id=".$id);
	foreach($qry->fetch_array() as $k => $val){
		$$k = $val;

	}
}
$loan = $conn->query("SELECT l.*,concat(b.lastname,', ',b.firstname,' ',b.middlename)as name, b.contact_no, b.address from loan_list l inner join borrowers b on b.id = l.borrower_id where l.id = ".$lid);
foreach($loan->fetch_array() as $k => $v){
	$meta[$k] = $v;
}
$type_arr = $conn->query("SELECT * FROM loan_types where id = '".$meta['loan_type_id']."' ")->fetch_array();

$plan_arr = $conn->query("SELECT *,concat(months,' month/s [ ',interest_percentage,'%, ',penalty_rate,' ]') as plan FROM loan_plan where id  = '".$meta['plan_id']."' ")->fetch_array();
$monthly = ($meta['amount'] + ($meta['amount'] * ($plan_arr['interest_percentage']/100))) / $plan_arr['months'];
$penalty = $monthly * ($plan_arr['penalty_rate']/100);
$payments = $conn->query("SELECT * from payments where loan_id =".$lid);
$paid = $payments->num_rows;
$offset = $paid > 0 ? " offset $paid ": "";
	$next = $conn->query("SELECT * FROM loan_schedules where loan_id = '".$lid."'  order by date(date_due) asc limit 1 $offset ")->fetch_assoc()['date_due'];
$sum_paid = 0;
while($p = $payments->fetch_assoc()){
	$sum_paid += ($p['amount'] - $p['penalty_amount']);
}
$payment_method_id = $meta['payment_method_id'];
// $payment_method_validation = $meta['payment_method_validation'];

?>
<div class="col-lg-12">
<hr>
<div class="row">
	<div class="col-md-5">
		<div class="form-group">
			<label for="">Payer</label>
			<input name="payee" class="form-control" required="" value="<?php echo isset($payee) ? $payee : (isset($meta['name']) ? $meta['name'] : '') ?>">
		</div>
	</div>
	
</div>
<hr>
<div class="row">
	<div class="col-md-5">
	</div>
	<div class="col-md-5">
		<div class="form-group">
			<label for="">Amount</label>
		

			<input type="number" name="amount" step="any" min="" class="form-control text-right" required="" value="<?php echo isset($amount) ? $amount : '' ?>">
			<p></p>
				<label for="">Payment Method</label>
        <select name="payment_method_id" id="valid_ids_select" class="custom-select browser-default select2">
			    	 <?php 
    $qry = $conn->query("SELECT * FROM payment_method ORDER BY id DESC");
    while($row = $qry->fetch_assoc()) :
        $selected = '';
        if(isset($id)){
            $qrys = $conn->query("SELECT * FROM payments WHERE payment_method_id = ".$row['id']);
            while($rows = $qrys->fetch_assoc()) {
                if ((!isset($payment_method_id) && $rows['payment_method_id'] == $row['id']) || $payment_method_id == $row['id']) {
                    $selected = "selected";
                    break;
                }
            }
        }
?>

<option value="<?php echo $row['id'] ?>" <?php echo $selected ?>><?php echo $row['Name'] ?></option>
<?php endwhile; ?>
</select>
<p></p>
			<label for="">Proof of Payment (gcash and paymaya ref no.)</label>
			<input type="text" name="payment_method_validation" class="form-control text-right" required="" value="<?php echo isset($payment_method_validation) ? $payment_method_validation : '' ?>">

			<input type="hidden" name="penalty_amount" value="<?php echo $add ?>">
			<input type="hidden" name="loan_id" value="<?php echo $lid ?>">
			<input type="hidden" name="overdue" value="<?php echo $add > 0 ? 1 : 0 ?>">
		</div>
	</div>
</div>
</div>