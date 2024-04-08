<?php include 'db_connect.php' ?>
<?php 

if(isset($_GET['id'])){
	$qry = $conn->query("SELECT * FROM payments where id=".$_GET['id']);
	foreach($qry->fetch_array() as $k => $val){
		$$k = $val;
	}
}

?>
<div class="container-fluid">
	<div class="col-lg-12">
		<form id="manage-payment">
			<input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : '' ?>">

			
<hr>
<div class="row">
	<div class="col-md-5">
		
			<div class="form-group">
						<label for="ewan" class="control-label">Name</label>
						<select name="loan_id" id="ewan" required class="custom-select browser-default ">
							<option value=""></option>
							<?php 
								    $qry = $conn->query("SELECT * FROM borrowers ORDER BY id asc");
								    while($row = $qry->fetch_assoc()) :
								        $selected = '';
								        	// $disabled = '';
								        if(isset($_GET['id'])){
								        	 $selected = '';
								        	// $disabled = 'disabled';
								            $qrys = $conn->query("SELECT * FROM loan_list WHERE borrower_id = ".$row['id']." LIMIT 1");

								            while($rows = $qrys->fetch_assoc()) {
								                if ((!isset($loan_id) && $rows['borrower_id'] == $row['id']) ||$loan_id== $row['id']) {
								                    $selected = "selected";
								                    // $disabled = "";
								                    break;
								                }
								            }
								        }
								?>
							<option value="<?php echo $row['id'] ?>"  <?php echo isset($loan_id) ? $loan_id== $row['id'] ? "selected":"" : "" ?>>
								<!-- <?php echo $selected ?> -->
								 <!-- <?php echo isset($loan_id) ? $loan_id== $row['id'] ? "arjay":"natoy" : "" ?> -->
								<?php echo $row['firstname'] ?> 
									<?php echo $row['middlename'] ?> 
									<?php echo $row['lastname'] ?>
								</option>
							

							<?php endwhile; ?>
						</select>
						
					</div>

	</div>
	<div class="col-md-6">
			<label for="">Type of Credit Transactions </label>
			<select name="penalty_amount" id="ewan" required class="custom-select browser-default ">
							<option value=""></option>
							<?php 
								    $qry = $conn->query("SELECT * FROM transaction_type ORDER BY id asc");
								    while($row = $qry->fetch_assoc()) :
								        	$selected = '';
								    
								        if(isset($_GET['id'])){
								        	 $selected = '';
								        	
								            $qrys = $conn->query("SELECT * FROM payments WHERE penalty_amount = ".$row['id']);
								            while($rows = $qrys->fetch_assoc()) {
								                if ( $penalty_amount== $row['id']) {
								                    $selected = "selected";
								                    
								                    break;
								                }
								            }
								        }
								?>
							<option value="<?php echo $row['id'] ?>"  <?php echo $selected ?>>
								 
								<?php echo $row['name'] ?> 
									
								</option>
							

							<?php endwhile; ?>
						</select>
			<!-- <input type="number" name="penalty_amount" class="form-control text-left" required="" value="<?php echo isset($penalty_amount) ? $penalty_amount : '' ?>"> -->

		
		</div>
	
</div>
<hr>
<div class="row">
	
	<div class="col-md-6">
		<div class="form-group">
			<label for="">Amount</label>
		

			<input type="number" name="amount" class="form-control text-left" required="" value="<?php echo isset($amount) ? $amount : '' ?>">
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
</div>
	</div>
<div class="col-md-6">
			<label for="">Proof of Payment (gcash and paymaya ref no.)</label>
			<input type="text" name="payment_method_validation" class="form-control text-left" required="" value="<?php echo isset($payment_method_validation) ? $payment_method_validation : '' ?>">

		</div>
		</div>
<!-- <input type="hidden" name="payee" value="<?php isset($payee) ?>"> -->

		</form>
	</div>
</div>

<script>
	
	 $('#manage-payment').submit(function(e){
	 	// console.log("kkk", $(this).serialize())
	 	e.preventDefault()
	 	start_load()
	 	$.ajax({
	 		url:'ajax.php?action=save_payment',
	 		method:'POST',
	 		data:$(this).serialize(),
	 		success:function(resp){
	 			console.log(resp)
	 			if(resp == 1){
	 				alert_toast("Payment data successfully saved.","success");
	 				setTimeout(function(e){
	 					location.reload()
	 				},1500)
	 			}
	 		}
	 	})
	 })
	
</script>