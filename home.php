<?php include 'db_connect.php' ?>
<?php
// Query to get the total amount for each day where the amount is not zero
$query = "SELECT *, DATE(date_created) AS date, SUM(credit_amount) AS total_amount
          FROM borrowers
          
          GROUP BY DATE(date_created)";


// Execute the query
$result = $conn->query($query);

// Check if there are any results
if ($result->num_rows > 0) {
   
    $data = array();
    $activestatusCount = 0;
    $notactivestatusCount = 0;

    
    // Fetch the data and store it in the array
    while ($row = $result->fetch_assoc()) {
     
 if ($row['client_status'] == 1) {
            $loans = $conn->query("SELECT * FROM borrowers where client_status = 1");
            $activestatusCount = $loans->num_rows > 0 ? $loans->num_rows : "0";
        };
        if ($row['client_status'] == 2) {
            $loans = $conn->query("SELECT * FROM borrowers where client_status = 2");
            $notactivestatusCount = $loans->num_rows > 0 ? $loans->num_rows : "0";
        };
            // if ($row['d']) {
        $loans = $conn->query("SELECT SUM(credit_amount) AS total_credit FROM borrowers");
$totalCredit = $loans->fetch_assoc()['total_credit'] ?? 0;        // };

       $data[] = array(
            'total_amount' => $totalCredit,
            'credit_amount' => $row['total_amount'],
            'active' => $activestatusCount,
            'notactive' => $notactivestatusCount            
        );
    }
    

    $json_data = json_encode($data[1]);

    // Get the current date
    $current_date = date('Y-m-d');
?>
    <script>

        // Store the JSON data in browser's local storage with the key as the current date
        localStorage.setItem('<?php echo $current_date; ?>', <?php echo json_encode($json_data); ?>);
    </script>
<?php
} else {
    echo "No data found.";
}
?>



<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<style>
.chart {
  width: 100%; 
  min-height: 550px;
}

</style>

<div class="containe-fluid">

	<div class="row">
		<div class="col-lg-12">
			
		</div>
	</div>

	<div class="row mt-3 ml-3 mr-3">
			<div class="col-lg-12">
			<div class="card">
				<div class="card-body">
				<?php echo "Welcome back ".($_SESSION['login_type'] == 3 ? "Dr. ".$_SESSION['login_name'].','.$_SESSION['login_name_pref'] : $_SESSION['login_name'])."!"  ?>
									
				</div>
				<hr>
				<div class="row ml-2 mr-2">
                    <div class="col-md-3">
                        <div class="card bg-success text-white mb-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="mr-3">
                                        <div class="text-white-75 small">ALL Users</div>
                                        <div class="text-lg font-weight-bold">
                                            <?php 
                                            $borrowers = $conn->query("SELECT * FROM borrowers");
                                            echo $borrowers->num_rows > 0 ? $borrowers->num_rows : "0";
                                             ?>
                                                
                                        </div>
                                    </div>
                                    <i class="fa fa-user-friends"></i>
                                </div>
                            </div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="index.php?page=borrowers">View All Users</a>
                                <div class="small text-white">
                                    <i class="fas fa-angle-right"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-info text-white mb-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="mr-3">
                                        <div class="text-white-75 small">Active Users</div>
                                        <div class="text-lg font-weight-bold">
                                            <?php 
                                            $loans = $conn->query("SELECT * FROM borrowers where client_status = 1");
                                            echo $loans->num_rows > 0 ? $loans->num_rows : "0";
                                             ?>
                                                
                                        </div>
                                    </div>
                                    <i class="fa fa-user-friends"></i>
                                </div>
                            </div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="index.php?page=users">View Active User</a>
                                <div class="small text-white">
                                    <i class="fas fa-angle-right"></i>
                                </div>
                            </div>
                        </div>
                    </div>
				<div class="col-md-3">
                        <div class="card bg-primary text-white mb-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="mr-3">
                                        <div class="text-white-75 small">Total Credit Amount</div>
                                        <div class="text-lg font-weight-bold">
                                        	<?php 
                                        	$payments = $conn->query("SELECT sum(credit_amount) as total FROM borrowers");
                                        	echo "&#8369; " . number_format($payments->fetch_array()['total']);

                                        	 ?>
                                        		
                                    	</div>
                                    </div>
                                    <i class="fa fa-calendar"></i>
                                </div>
                            </div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="index.php?page=bank_reconciliation">View User Credit</a>
                                <div class="small text-white">
                                	<i class="fas fa-angle-right"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                 <div class="col-md-3">
                        <div class="card bg-primary text-white mb-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="mr-3">
                                        <div class="text-white-75 small">Total Transactions Amount</div>
                                        <div class="text-lg font-weight-bold">
                                            <?php 
                                            $payments = $conn->query("SELECT sum(amount) as total FROM payments ");
                                            
                                            // $loans =  $payment->num_rows > 0 ? $payments->fetch_array()['total'] : "0";
                                            
                                            echo "&#8369; " . number_format($payments->fetch_array()['total']);
                                             ?>
                                                
                                        </div>
                                    </div>
                                    <i class="fa fa-user-friends"></i>
                                </div>
                            </div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="index.php?page=payments">View Transactions</a>
                                <div class="small text-white">
                                    <i class="fas fa-angle-right"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                
                    <!-- <div class="row"> -->
                        <div class="col-sm-12 col-md-6">
                            <div id="chart_div1" class="chart"></div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div id="chart_div2" class="chart"></div>
                        </div>
                       
                    <!-- </div> -->

                  
                    

				</div>
			</div>
			
		</div>
		</div>
	</div>

</div>

<script>

var filteredData = [];


for (var i = localStorage.length - 1; i >= 0 && filteredData.length < 5; i--) {
    var key = localStorage.key(i);
    
 
    if (key.includes("2024")) {
        // Retrieve the value (data) associated with the key
        var value = localStorage.getItem(key);
        

        var parsedValue = JSON.parse(value);
        

        var itemData = {
            itemName: key,
            data: parsedValue
        };
        

        filteredData.push(itemData);
    }
}


console.log('Filtered data:', filteredData[0].data);


	google.load("visualization", "1", {packages:["corechart"]});
google.setOnLoadCallback(drawChart1);
function drawChart1() {
var data = new google.visualization.DataTable();
data.addColumn('string', 'Year');
data.addColumn('number', 'Credit Amount per day');
data.addColumn('number', 'Total Credit Amount');


for (var i = filteredData.length - 1; i >= 0 && i >= filteredData.length - 5; i--) {
    var row = [
        filteredData[i].itemName,
        parseFloat(filteredData[i].data.credit_amount),
        parseFloat(filteredData[i].data.total_amount)
    ];
    data.addRow(row);
}


  var options = {
    title: 'Credit',
    hAxis: {title: 'Year', titleTextStyle: {color: 'black'}}
 };

var chart = new google.visualization.ColumnChart(document.getElementById('chart_div1'));
  chart.draw(data, options);
}


let filteredStatus1 = filteredData.filter(function(item) {
    return item.data.status === "1";
});

let filteredStatus2 = filteredData.filter(function(item) {
    return item.data.status === "2";
});



google.load("visualization", "1", {packages:["corechart"]});
google.setOnLoadCallback(drawChart2);
function drawChart2() {
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Year');
    data.addColumn('number', 'Client Status Active');
    data.addColumn('number', 'Client Status Not Active');

   

for (var i = filteredData.length - 1; i >= 0 && i >= filteredData.length - 5; i--) {
    var row = [
        filteredData[i].itemName,
        parseFloat(filteredData[i].data.active),
        parseFloat(filteredData[i].data.notactive)
    ];
    data.addRow(row);
}


    var options = {
        title: 'Users',
        hAxis: {title: 'Year',  titleTextStyle: {color: '#333'}},
        vAxis: {minValue: 0}
    };

    var chart = new google.visualization.AreaChart(document.getElementById('chart_div2'));
    chart.draw(data, options);
}


$(window).resize(function(){
  drawChart1();
  drawChart2();
});
</script>