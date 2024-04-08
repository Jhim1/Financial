<?php include 'db_connect.php' ?>

<div class="container-fluid">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <large class="card-title">
                    <b>Bank Reconciliation</b>
                    
                </large>
                
            </div>
            <div class="card-body">
                <table class="table table-bordered" id="loan-list">
                    <colgroup>
                        <col width="10%">
                        <col width="20%">
                        <col width="20%">
                        <col width="20%">
                        <col width="10%">
                        <col width="10%">
                        <col width="20%">
                    </colgroup>
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Type of Credit</th>
                            <th class="text-center">Credit Amount</th>
                            <th class="text-center">Credit Limit</th>
                            <th class="text-center">Total Amount of Transaction </th>
                             <th class="text-center">Total Credit Balance</th>
                            <th class="text-center">Client Status</th>
                           
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
                                    


                                    $qrys = $conn->query("SELECT * FROM credit_type WHERE id = ".$row['type_credit']);
                                    
                                    if ($qrys->num_rows > 0) {
                                        $databank= $qrys->fetch_assoc();
                                        $name= $databank['name'];


                                        
                                    } else {
                                        $name = "N/A";
                                        
                                        
                                    }
                                    $qries = $conn->query("SELECT *, SUM(amount) AS total_transaction FROM payments WHERE loan_id = ".$row['id']);
                                    if ($qries->num_rows > 0) {

                                        $datapayment= $qries->fetch_assoc();
                                        
                                        // $transactions= $datapayment['amount'];
                                        if($datapayment['total_transaction']){
                                            $total_transaction = $datapayment['total_transaction'];
                                            $total_balance = $row['credit_amount'] - $datapayment['total_transaction'];
                                           
                                        }else{
                                            $total_transaction = 0;
                                            $total_balance = $row['credit_amount'];
                                         }
                                        
                                         } 

                         ?>
                         <tr>
                            
                            <td class="text-center"><?php echo $i++ ?></td>
                            <td class="text-center">
                                <b><?php echo ucwords($row['lastname'].", ".$row['firstname'].' '.$row['middlename']) ?></b>
                               
                                
                            </td>
                            <td class="text-center">

                   
                            
                                <?php echo $name ?>
                                
                            
                            </td>
                            <td class="text-center">
                                <?php echo $row['credit_amount'] ?>
                                </td>
                                
                                <td class="text-center">
                                <?php echo $row['crdt_limit'] ?>
                                </td>
                                <td class="text-center">
                                    <!-- <p>Transacyion type: <b> <?php echo $transactions ?> </b></p>
                                    <p>Amount: <b> <?php echo $transactions ?> </b></p> -->
                                      <?php echo $total_transaction ?> 
                                
                                </td>
                                <td class="text-center">
                                <?php echo $total_balance?>
                                </td>
                            
                                <td class="text-center">
                                
                                <?php if($row['client_status'] == 2): ?>
                                    <span class="badge badge-warning">Not Active</span>
                                <?php elseif($row['client_status'] == 1): ?>
                                    <span class="badge badge-info">Active</span>
                                <?php elseif($row['client_status'] == 0): ?>
                                    N/A
                                <?php endif; ?>
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
<!-- <script>
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
</script> -->