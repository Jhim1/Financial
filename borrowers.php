<?php include 'db_connect.php' ?>

<div class="container-fluid">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<large class="card-title">
					<b>Application List</b>
				</large>
				<button class="btn btn-primary btn-block col-md-2 float-right" type="button" id="new_borrower"><i class="fa fa-plus"></i> Apply</button>
			</div>
			<div class="card-body">
				<table class="table table-bordered" id="borrower-list">
					<colgroup>
						<col width="10%">
						<col width="35%">
						<col width="30%">
						<col width="15%">
						<col width="10%">
					</colgroup>
					<thead>
						<tr>
							<th class="text-center">#</th>
							<th class="text-center">Client Details</th>
							<th class="text-center">Credit Details</th>
							<!-- <th class="text-center">Next Payment Schedule</th> -->
							<th class="text-center">Client Status</th>
							<th class="text-center">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
						error_reporting(0);
						$i = 1;
						$type = $conn->query("SELECT * FROM loan_types where id in (SELECT loan_type_id from loan_list) ");
							while($row=$type->fetch_assoc()){
								$type_arr[$row['id']] = $row['type_name'];
							}
							$plan = $conn->query("SELECT *,concat(months,' month/s [ ',interest_percentage,'%, ',penalty_rate,' ]') as plan FROM loan_plan where id in (SELECT plan_id from loan_list) ");
							while($row=$plan->fetch_assoc()){
								$plan_arr[$row['id']] = $row;
							}

							$qry = $conn->query("SELECT * FROM borrowers ORDER BY id DESC");
								while($row = $qry->fetch_assoc()):
								    
								    $qrys = $conn->query("SELECT * FROM loan_list WHERE borrower_id = ".$row['id']);
								    
								    if ($qrys->num_rows > 0) {

								        $loan = $qrys->fetch_assoc();
								        $monthly = ($loan['amount'] + ($loan['amount'] * ($plan_arr[$loan['plan_id']]['interest_percentage']/100))) / $plan_arr[$loan['plan_id']]['months'];
								        $ref_no = $loan['ref_no']; 
								        $plan_id = $plan_arr[$loan['plan_id']]['plan']; 
								        $loan_type = $type_arr[$loan['loan_type_id']]; 
								        $amount = $loan['amount'];
								        $date_release = $loan['date_released'];
								        $valid_status1 = $loan['status'] == 2;
								        $valid_status2 = $loan['status'] == 3;
								        
										$penalty = $monthly * ($plan_arr[$loan['plan_id']]['penalty_rate']/100);
										$payments = $conn->query("SELECT * from payments where loan_id =".$loan['id']);
										$paid = $payments->num_rows;
										$offset = $paid > 0 ? " offset $paid ": "";
										if($loan['status'] == 2):
											$next = $conn->query("SELECT * FROM loan_schedules where loan_id = '".$loan['id']."'  order by date(date_due) asc limit 1 $offset ")->fetch_assoc()['date_due'];
										endif;
										$sum_paid = 0;
										while($p = $payments->fetch_assoc()){
											$sum_paid += ($p['amount'] - $p['penalty_amount']);
										}
								    } else {
								        
								        $ref_no = "N/A";
								        $amount = "N/A";
								        $loan_type = "N/A";
								        $date_release = null;
								        $valid_status1 = null;
								        $valid_status2 = null;
								        $plan_id = null;
								        $penalty = null;
								        $monthly = null;
								        
								    }

						 ?>
						 <tr>
						 	
						 	<td class="text-center"><?php echo $i++ ?></td>
						 	<td>
						 		<p>Name :<b><?php echo ucwords($row['lastname'].", ".$row['firstname'].' '.$row['middlename']) ?></b></p>
						 		<p><small>Address :<b><?php echo $row['address'] ?></small></b></p>
						 		<p><small>Contact # :<b><?php echo $row['contact_no'] ?></small></b></p>
						 		<p><small>Email :<b><?php echo $row['email'] ?></small></b></p>
						 		
						 		<p><small>ID Number :<b><?php echo $row['tax_id'] ?></small></b></p>
						 		
						 		
						 	</td>
						 	<td class="">
						 		<p><small>Credit Amount:<b><?php echo $row['credit_amount'] ?></small></b></p>
						 		<p><small>Credit Limit :<b><?php echo $row['crdt_limit'] ?></small></b></p>
						 	
						 		<!-- <p>Reference :<b><?php echo $ref_no ?></b></p>
						 		<p><small>Loan type :<b><?php echo $loan_type ?></small></b></p>
						 		<p><small>Plan :<b><?php echo $plan_id ?></small></b></p>
						 	<p><small>Amount :<b><?php echo $amount ?></small></b></p>
						 		<p><small>Total Payable Amount :<b><?php echo number_format($monthly * $plan_id,2) ?></small></b></p>
						 		<p><small>Monthly Payable Amount: <b><?php echo number_format($monthly,2) ?></small></b></p>
						 		<p><small>Overdue Payable Amount: <b><?php echo number_format($penalty,2) ?></small></b></p>
						 		
						 		<?php if($valid_status1 || $valid_status2): ?>
						 		<p><small>Date Released: <b><?php echo date("M d, Y",strtotime($date_release)) ?></small></b></p>
						 		<?php endif; ?> -->
						 	
							</td>
						 	
						 		<td class="">
						 		
						 		<?php if($row['client_status'] == 2): ?>
						 			<span class="badge badge-warning">Not Active</span>
						 		<?php elseif($row['client_status'] == 1): ?>
						 			<span class="badge badge-info">Active</span>
						 		<?php elseif($row['client_status'] == 0): ?>
					 				N/A
						 		<?php endif; ?>
						 		</td>
						 	<td class="text-center">
						 			<button class="btn btn-outline-primary btn-sm edit_borrower" type="button" data-id="<?php echo $row['id'] ?>"><i class="fa fa-edit"></i></button>
						 			<button class="btn btn-outline-danger btn-sm delete_borrower" type="button" data-id="<?php echo $row['id'] ?>"><i class="fa fa-trash"></i></button>
						 	</td>


						 </tr>

						<?php endwhile; ?>
						
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
	$('#borrower-list').dataTable()
	$('#new_borrower').click(function(){
		uni_modal("Client Application","manage_borrower.php",'mid-large')
	})
	$('.edit_borrower').click(function(){
		uni_modal("Edit Client Application","manage_borrower.php?id="+$(this).attr('data-id'),'mid-large')
	})
	$('.delete_borrower').click(function(){
		_conf("Are you sure to delete this client?","delete_borrower",[$(this).attr('data-id')])
	})
function delete_borrower($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_borrower',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("borrower successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
</script>