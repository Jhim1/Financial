<?php include 'db_connect.php' ?>
<?php 

if(isset($_GET['id'])){
	$qry = $conn->query("SELECT * FROM borrowers where id=".$_GET['id']);
	foreach($qry->fetch_array() as $k => $val){
		$$k = $val;
	}


}


?>
<div class="container-fluid">
	<div class="col-lg-12">
		<form id="manage-borrower">
			<input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : '' ?>">
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label for="" class="control-label">Last Name</label>
						<input name="lastname" class="form-control" required="" value="<?php echo isset($lastname) ? $lastname : '' ?>">
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label for="">First Name</label>
						<input name="firstname" class="form-control" required="" value="<?php echo isset($firstname) ? $firstname : '' ?>">
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label for="">Middle Name</label>
						<input name="middlename" class="form-control" value="<?php echo isset($middlename) ? $middlename : '' ?>">
					</div>
				</div>
			</div>
			<div class="row form-group">
				<div class="col-md-6">
							<label for="">Address</label>
							<textarea name="address" id="" cols="30" rows="2" class="form-control" required=""><?php echo isset($address) ? $address : '' ?></textarea>
				</div>
				<div class="col-md-6">
					<div class="">
						<label for="">Contact #</label>
						<input type="text" class="form-control" name="contact_no" value="<?php echo isset($contact_no) ? $contact_no : '' ?>">
					</div>
				</div>
			</div>
			<div class="">
					<label for="">Email</label>
							<input type="email" class="form-control" name="email" value="<?php echo isset($email) ? $email : '' ?>">
<br/>
</div>

			<div class="row form-group">
    <div class="col-md-6">
        <label for="">Type of Credit</label>
        <select name="type_credit" id="valid_ids_select"  class="custom-select browser-default select2">
        	  
        	 <?php 
    $qry = $conn->query("SELECT * FROM credit_type ORDER BY id DESC");
    while($row = $qry->fetch_assoc()) :
        $selected = '';
        if (isset($_GET['id'])) {
            $qrys = $conn->query("SELECT * FROM borrowers WHERE type_credit = ".$row['id']);
            while($rows = $qrys->fetch_assoc()) {
                if ((!isset($credit_type) && $rows['type_credit'] == $row['id']) || $credit_type == $row['id']) {
                    $selected = "selected";
                    break;
                }
            }
        }
?>

<option value="<?php echo $row['id'] ?>" <?php echo $selected ?>><?php echo $row['name'] ?></option>
<?php endwhile; ?>


</select>

    </div>
    <div class="col-md-6">
        <div class="">
            <label for="">Total Credit Amount</label>
            <input type="text" class="form-control" name="credit_amount"  value="<?php echo isset($credit_amount) ? $credit_amount : '' ?>">
        </div>
    </div>
</div>


			<div class="row form-group">
    <div class="col-md-6">
        <label for="">Valid ID's</label>
        <select name="valid_ids" id="valid_ids_select" class="custom-select browser-default select2">
        	  
        	 <?php 
    $qry = $conn->query("SELECT * FROM list_valid ORDER BY id DESC");
    while($row = $qry->fetch_assoc()) :
        $selected = '';
        if (isset($_GET['id'])) {
            $qrys = $conn->query("SELECT * FROM borrowers WHERE valid_ids = ".$row['id']);
            while($rows = $qrys->fetch_assoc()) {
                if ((!isset($valid_ids) && $rows['valid_ids'] == $row['id']) || $valid_ids == $row['id']) {
                    $selected = "selected";
                    break;
                }
            }
        }
?>

<option value="<?php echo $row['id'] ?>" <?php echo $selected ?>><?php echo $row['label'] ?></option>
<?php endwhile; ?>


</select>

    </div>
    <div class="col-md-6">
        <div class="">
            <label for="">ID Number</label>
            <input type="text" class="form-control" name="tax_id" id="tax_id_input" value="<?php echo isset($tax_id) ? $tax_id : '' ?>">
        </div>
    </div>
</div>
			<div class="row form-group">
				<div class="col-md-6">
			<div class="">
						<label for="">Credit Limit</label>
						<input required type="text" class="form-control"  name="crdt_limit" id="crdt_limit"  value="<?php echo isset($crdt_limit) ? $crdt_limit : '' ?>">
					</div>
					</div>
					<div class="col-md-6">
					<label for="">Status</label>
					<select name="client_status"  class="custom-select browser-default select2">
					<option value=0 <?php echo (isset($_GET['id']) &&(!isset($client_status) || $client_status == 0 ))? "selected" : '' ?> > --- </option>
					<option value=1 <?php echo (isset($_GET['id']) &&(!isset($client_status) || $client_status == 1 ))? "selected" : '' ?>> Active </option>
					<option value=2 <?php echo (isset($_GET['id']) &&(!isset($client_status) ||$client_status == 2 ))? "selected" : '' ?>> Not Active </option>
				
				</select>
</div>
			</div>
		</form>
	</div>
</div>

<script>

	const crdtLimitInput = document.getElementById('crdt_limit');

    crdtLimitInput.addEventListener('change', function() {
        
     <?php

$loan_amount = 0;

if(isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
    // Sanitize the input to prevent SQL injection
    $borrower_id = intval($_GET['id']);
    // Query to fetch the amount from loan_list based on borrower_id
    $loan_qry = $conn->query("SELECT amount FROM loan_list WHERE borrower_id = $borrower_id ORDER BY id DESC LIMIT 1");
    // Check if the query was successful and if it returned any rows
    if ($loan_qry && $loan_qry->num_rows > 0) {
        // Fetch the result row
        $loan_row = $loan_qry->fetch_assoc();
        // Extract the 'amount' value
        $loan_amount = $loan_row['amount'];
    }
}
?>
var loan_amount = <?php echo isset($crdt_limit) ? $loan_amount : 10000000; ?>;
// Check if the credit limit exceeds the loan amount
if (parseInt(this.value) > loan_amount) {
    // Display an error message
    alert('Credit limit cannot exceed the loan amount.');
    // Clear the input value
    this.value = '';
}

        // if (parseInt(this.value) > $qry = $conn->query("SELECT * FROM list_valid ORDER BY id DESC");30000) {
        //     // Display an error message
        //     alert('Credit limit cannot exceed 30000.');
        //     // Clear the input value
        //     this.value = '';
        // }
    });
    //  document.addEventListener('DOMContentLoaded', function() {
    //     const validIdsSelect = document.getElementById('valid_ids_select');
    //     const taxIdInput = document.getElementById('tax_id_input');

    //     // Disable the input field initially if valid_ids_select value is 0
    //     if (val1dIdsSelect.value === 1) {
    //         taxIdInput.disabled = true;
    //     }

       
    // });
    $('#manage-borrower').submit(function(e){
        // const datas = {
        //     id: 21,
        //     name: "aj"
        // };
        console.log($(this).serializeArray().map(field => field.value), "id=20&name=as", $(this).serialize());
        e.preventDefault();
        start_load();

        $.ajax({
            url: 'ajax.php?action=save_borrower',
            method: 'POST',
            data: $(this).serialize(),
            success: function(resp){
            	console.log(resp)
                if(resp == 1){
                    alert_toast("Borrower data successfully saved.", "success");
                    setTimeout(function(e){
                        location.reload();
                    }, 1500);
                }
            }
        });
    });
</script>

