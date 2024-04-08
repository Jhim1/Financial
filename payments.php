<?php include 'db_connect.php' ?>

<div class="container-fluid">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<large class="card-title">
					<b>Transaction List</b>
					<button class="btn btn-primary btn-sm btn-block col-md-2 float-right" type="button" id="new_payments"><i class="fa fa-plus"></i> New Transaction</button>
				</large>
				
			</div>
			<div class="card-body">
				<table class="table table-bordered" id="loan-list">
					<colgroup>
						<col width="10%">
						<col width="25%">
						<col width="25%">
						<col width="20%">
						<col width="10%">
						<col width="10%">
					</colgroup>
					<thead>
						<tr>
							<th class="text-center">#</th>
							<!-- <th class="text-center">Reference No</th> -->
							<th class="text-center">Name</th>
							<th class="text-center">Amount</th>
							<th class="text-center">Types of Credit Transaction</th>
							<th class="text-center">Payment Method</th>
							<th class="text-center">Payment Proof (e.g. Gcash or maya ref no.) </th>
							<th class="text-center">Client Status</th>
							<th class="text-center">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
							
							$i=1;
									$qrys = $conn->query("SELECT p.*,concat(b.lastname,', ',b.firstname,' ',b.middlename)as name, b.contact_no, b.address, b.client_status from payments p inner join borrowers b on b.id = p.loan_id  order by p.id asc");

										if ($qrys->num_rows > 0) {

										    while ($row = $qrys->fetch_assoc()) {
										       
										       
										       $payment_method_validation = $row['payment_method_validation']


							// $qry = $conn->query("SELECT p.*,concat(b.lastname,', ',b.firstname,' ',b.middlename)as name, b.contact_no, b.address, b.client_status from payments p inner join borrowers b on b.id = p.loan_id  order by p.id asc");
							// while($row = $qry->fetch_assoc()):
								
							// 	$payment_method_validation = $row['payment_method_validation']
								

						 ?>
						 <tr>
						 	
						 	<td class="text-center"><?php echo $i++ ?></td>
						 	
 						 	<td class="text-center" >
						 		<?php echo $row['name']  ?> 
						 		
						 	</td>
						 	<td class="text-center">
						 		<?php echo number_format($row['amount']) ?>
						 		
						 	</td>
						 	<!-- <td class="text-center"> -->
						 		<?php 
									    $qry = $conn->query("SELECT * FROM transaction_type where id =".$row['penalty_amount']);
									    while($name = $qry->fetch_assoc()) :
									        $selected = $name['name'];
									     
									?> 		
									<td>
											    	 
									<?php echo $selected ?>

										
									</td>
									<?php endwhile; ?>
						 	<!-- </td> -->
									<?php 
									    $qry = $conn->query("SELECT * FROM payment_method where id =".$row['payment_method_id']);
									    while($name = $qry->fetch_assoc()) :
									        $selected = $name['Name'];
									     
									?> 		
															 		<td>		    	 
									<?php echo $selected ?>

										
									</td>
									<?php endwhile; ?>
						 		<td class="text-center"><?php echo $payment_method_validation ?></td>

						 		<td class="text-center">
						 		
						 		<?php if($row['client_status'] == 2): ?>
						 			<span class="badge badge-warning">Not Active</span>
						 		<?php elseif($row['client_status'] == 1): ?>
						 			<span class="badge badge-info">Active</span>
						 		<?php elseif($row['client_status'] == 0): ?>
					 				N/A
						 		<?php endif; ?>
						 		</td>

						 	<td class="text-center">
						 			<button class="btn btn-outline-primary btn-sm edit_payment" type="button" data-id="<?php echo $row['id'] ?>"><i class="fa fa-edit"></i></button>
						 			<button class="btn btn-outline-danger btn-sm delete_payment" type="button" data-id="<?php echo $row['id'] ?>"><i class="fa fa-trash"></i></button>
						 	</td>

						 </tr>

						<?php     }
} else {
    echo "No payments found.";
} ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<style>
	td p {
		margin:unset;
	}
	td img {
	    width: 8vw;
	    height: 12vh;
	}
	td{
		vertical-align: middle !important;
	}
</style>	
<script>
	$('#loan-list').dataTable()
	$('#new_payments').click(function(){
		uni_modal("New Transaction","manage_payment.php",'mid-large')
	})
	$('.edit_payment').click(function(){
		// console.log($(this).attr('data-id'));
		uni_modal("Edit Transaction","manage_payment.php?id="+$(this).attr('data-id'),'mid-large')
	})
	$('.delete_payment').click(function(){
		_conf("Are you sure to delete this data?","delete_payment",[$(this).attr('data-id')])
	})
function delete_payment($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_payment',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Payment successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
</script>