<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en" xmlns="http://www.w3.org/1999/xhtml>

<?php
error_reporting(0);
include("connectDB2.php");

session_start();
if((!isset ($_SESSION['username']) == true) and (!isset ($_SESSION['password']) == true))             // check session condition
{
unset($_SESSION['username']);                                
unset($_SESSION['password']);
header('location:login.php');
}
$logged = $_SESSION['username'];
?>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Alternative Car Parking</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>
	<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
	
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
	
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>	
	<script type="text/javascript" src="js/canvasjs.min.js"></script>
	<script>
		$(document).ready(function(){
			//$('#buttonGenerateGraph').hide();
			//$('#button').click(function() {
				firstDate = $('#from').val(); 
				lastDate = $('#to').val();
				if(firstDate != '' && lastDate != '') {
					$('#buttonGenerateGraph').show();
				}
				else 
					$('#buttonGenerateGraph').hide();
			//});
			$('#buttonHideAll').click(function() {
				$('#report').toggle();
			});
			$('#buttonGenerateGraph').click(function() {
				firstDate = $('#from').val(); 
				lastDate = $('#to').val();
				plateNum = $('#string').val();
				titleBarChart = "Monthly Approved Payment of "+firstDate+" to "+lastDate;
				$('#modalTitleShowBarChart').html(titleBarChart);
				$.ajax({ 
					url:'generalFn.php',
					dataType: "json",
					cache: false,
					data:{action:'getMonthlyPayment', firstDate: firstDate, lastDate: lastDate, plateNum: plateNum},
					type:'post',
					beforeSend:function() { 
						//$('#loading-image').show();
					},
					success:function(response){ console.log(response.monthlyPayment);
						//$('#loading-image').hide();
						var chart = new CanvasJS.Chart("graphDiv", {
							height: 400,
							width: 870,
							title: {
								text: titleBarChart
							},
							animationEnabled: true,
							data: [{
								type: "column",
								dataPoints: response.monthlyPayment
							}]
						});
						if(firstDate != '' && lastDate != '') {
							chart.render();
							$('#modalShowBarChart').modal('toggle'); 							
						}
					},
					error:function(jqXHR, textStatus, response){
						console.warn(jqXHR.responseText)
						alert("Fail to load monthly info.");    
						if(textStatus === 'timeout') {     
							alert('Failed from timeout');  //do something. Try again perhaps?
						}
					},
					timeout: 4000 // setTimeout to 3 seconds
                });				
							
			});
		});
	
	</script>
</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="dashboard.php">Alternate Parking</a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <li class="navbar-brand">
                    <i class="fa fa-user"></i> Administrator</b></a>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
				    <li>
                        <a href="dashboard.php"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                    </li>
					<li class="active">
                        <a href="javascript:;" data-toggle="collapse" data-target="#reports"><i class="fa fa-fw fa-file"></i> Reports <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="reports" class="collapse">
                            <li>
                                <a href="reports.php">Parking Summary</a>
                            </li>
                            <li>
                                <a href="summon.php">Summon Info</a>
                            </li>
                        </ul>
                    </li>
			<li>
                        <a href="option.php"><i class="fa fa-fw fa-wrench"></i> Option</a>
                    </li>
		    <li>
                        <a href="qrCode.php"><i class="glyphicon glyphicon-qrcode"></i> QR Code</a>
                    </li>
                    <li>
                        <a href="logout.php"><i class="fa fa-fw fa-power-off"></i> Logout</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Reports
                        </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-file"></i> Summary
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

			<div class="col-lg-6">
			
				<form class="form-inline" id="form1" name="form1" method="post" action="reports.php">
					<label for="from">From</label>
						<input class="form-control" name="from" type="month" id="from" size="10" value="<?php echo $_REQUEST["from"]; ?>" required/>
					<label for="to">to</label>
						<input class="form-control" name="to" type="month" id="to" size="10" value="<?php echo $_REQUEST["to"]; ?>" required/>
					<label>Plate Number:</label>
						<input class="form-control" type="text" name="string" id="string" value="<?php echo stripcslashes($_REQUEST["string"]); ?>" pattern="[a-zA-Z0-9\s]+"/>
						<input type="submit" name="button" id="button" class="btn btn-primary" value="Filter" />
						<input type="button" name="buttonHideAll" id="buttonHideAll" class="btn btn-success" value="Hide All" />
						<a class="btn btn-info" href="reports.php">Reset</a>
					
					<script type="text/javascript" src="tableExport.js"></script>
					<script type="text/javascript" src="jquery.base64.js"></script>

					<script type="text/javascript" src="jspdf/libs/sprintf.js"></script>
					<script type="text/javascript" src="jspdf/jspdf.js"></script>
					<script type="text/javascript" src="jspdf/libs/base64.js"></script>

					<a class="fa fa-file-pdf-o fa-lg" target="_blank" href="#" onClick ="$('#report').tableExport({type:'pdf',escape:'false',pdfFontSize:6,pdfLeftMargin:4});"></a>
					<a class="fa fa-file-excel-o fa-lg" href="#" onClick ="$('#report').tableExport({type:'excel',escape:'false'});"></a>
				</form>
				<br />				
                        <div class="table-responsive">
                            <table id="report" class="table table-bordered table-condensed">
								<tr>
									<td width="" bgcolor=""><strong>Parking ID</strong></td>
									<td width="" bgcolor=""><strong>Plate Number</strong></td>
									<td width="" bgcolor=""><strong>Parking Duration</strong></td>
									<td width="" bgcolor=""><strong>Payment Amount</strong></td>
									<td width="" bgcolor=""><strong>Parking Date</strong></td>
									<td width="" bgcolor=""><strong>Parking Start Time</strong></td>
									<td width="" bgcolor=""><strong>Parking End Time</strong></td>
									<td width="" bgcolor=""><strong>Payment Status</strong></td>
								</tr>
								<?php

								if ($_REQUEST["string"]<>'') {
									$search_string = " AND (plate_num LIKE '%".mysql_real_escape_string($_REQUEST["string"])."%')";	
								}

								if ($_REQUEST["from"]<>'' and $_REQUEST["to"]<>'') {
									$firstDate = date('Y-m-01 00:00:00',strtotime($_REQUEST["from"]));
									$lastDate = date('Y-m-t 12:59:59',strtotime($_REQUEST['to']));
									//echo $firstDate." ".$lastDate;
									//$sql = "SELECT * FROM parking_info WHERE parking_date >= '".mysql_real_escape_string($_REQUEST["from"])."' AND parking_date <= '".mysql_real_escape_string($_REQUEST["to"])."'".$search_string;
									$sql = "SELECT * FROM parking_info WHERE parking_date >= '".mysql_real_escape_string($firstDate)."' AND parking_date <= '".mysql_real_escape_string($lastDate)."'".$search_string;
								} else if ($_REQUEST["from"]<>'') {
									$firstDate = date('01-m-Y 00:00:00',strtotime($_REQUEST["from"]));
									$sql = "SELECT * FROM parking_info WHERE parking_date >= '".mysql_real_escape_string($_REQUEST["from"])."'".$search_string;
								} else if ($_REQUEST["to"]<>'') {
									$lastDate = date('t-m-Y 12:59:59',strtotime($_REQUEST['to']));
									$sql = "SELECT * FROM parking_info WHERE parking_date <= '".mysql_real_escape_string($_REQUEST["to"])."'".$search_string;
								} else if ($_REQUEST["string"]<>'') {
									$sql = "SELECT * FROM parking_info WHERE parking_ID>0 ".$search_string;
								} else {
									$sql = "SELECT * FROM parking_info WHERE parking_ID>0 ORDER BY parking_date DESC, parking_start_time DESC".$search_string;
								}

								$sql_result = mysql_query ($sql, $con ) or die ('request "Could not execute SQL query" '.$sql);
								if (mysql_num_rows($sql_result)>0) {
									while ($row = mysql_fetch_assoc($sql_result)) {
								?>
								<tr>
									<td><?php echo $row["parking_ID"]; ?></td>
									<td><?php echo $row["plate_num"]; ?></td>
									<td><?php echo $row["parking_duration"]; ?></td>
									<td><?php echo number_format($row["payment_amount"], 2); ?></td>
									<td><?php echo $row["parking_date"]; ?></td>
									<td><?php echo $row["parking_start_time"]; ?></td>
									<td><?php echo $row["parking_end_time"]; ?></td>
									<td><?php echo $row["payment_status"]; ?></td>
								</tr>
								<?php
									}
								} else {
								?>
								<tr><td colspan="8">No results found.</td>
								<?php	
								}
								?>
								<tr class="success">
									<td colspan="7" bgcolor="" align="right"><strong>Total Approved Payment:<br/></strong></td>
								<!--tr class="success"-->
										<?php
											if ($_REQUEST["from"]<>'' and $_REQUEST["to"]<>'') {
											//$sql = "SELECT sum(payment_amount) FROM parking_info WHERE payment_status='approved' AND parking_date >= '".mysql_real_escape_string($_REQUEST["from"])."' AND parking_date <= '".mysql_real_escape_string($_REQUEST["to"])."'".$search_string;
											$sql = "SELECT sum(payment_amount) AS totalMonthlyPayment, MONTHNAME(parking_date) AS parkingMonth, YEAR(parking_date) AS parkingYear FROM parking_info WHERE payment_status='approved' AND parking_date >= '".mysql_real_escape_string($firstDate)."' AND parking_date <= '".mysql_real_escape_string($lastDate)."'".$search_string." GROUP BY YEAR(parking_date), MONTH(parking_date) ";
											}
											else if ($_REQUEST["from"]<>'') {
											$sql = "SELECT sum(payment_amount) AS totalMonthlyPayment, MONTHNAME(parking_date) AS parkingMonth, YEAR(parking_date) AS parkingYear FROM parking_info WHERE payment_status='approved' AND parking_date >= '".mysql_real_escape_string($firstDate)."'".$search_string;
											}
											else if ($_REQUEST["to"]<>'') {
											$sql = "SELECT sum(payment_amount) AS totalMonthlyPayment, MONTHNAME(parking_date) AS parkingMonth, YEAR(parking_date) AS parkingYear FROM parking_info WHERE payment_status='approved' AND parking_date <= '".mysql_real_escape_string($lastDate)."'".$search_string;
											}
											else if ($_REQUEST["string"]<>'') {
											$sql = "SELECT sum(payment_amount) AS totalMonthlyPayment FROM parking_info WHERE payment_status='approved'".$search_string;
											}
											else
											{
											$sql = "SELECT sum(payment_amount) AS totalMonthlyPayment FROM parking_info WHERE payment_status='approved'";
											}
											$resultApproved = mysql_query($sql) or die(mysql_error());
											if($lastDate<>'' AND $firstDate<>'') {
												echo "<td></td></tr>";	
												while ($rows = mysql_fetch_array($resultApproved)) {
													echo "<strong><tr class='success'>";
													echo "<td colspan='7' align='right'><strong>".$rows['parkingMonth']." / ".$rows['parkingYear']."</strong></td>";
													echo "<td><strong>RM ".number_format($rows['totalMonthlyPayment'], 2)."</strong></td>";
													echo "</tr>";
												}
											}
											else {
												while ($rows = mysql_fetch_array($resultApproved)) {
													echo "<td><strong>RM ".number_format($rows['totalMonthlyPayment'], 2)."</strong></td></tr>";
												}
											}$rows3 = mysql_fetch_array($resultApproved); print_r($rows3);
										?>	
								<!--/tr-->
								<tr class="danger">
									<td colspan="7" bgcolor="" align="right"><strong>Total Pending Payment</strong></td>
									<?php
										if ($_REQUEST["from"]<>'' and $_REQUEST["to"]<>'') {
										//$sql = "SELECT sum(payment_amount) FROM parking_info WHERE payment_status='approved' AND parking_date >= '".mysql_real_escape_string($_REQUEST["from"])."' AND parking_date <= '".mysql_real_escape_string($_REQUEST["to"])."'".$search_string;
										$sql = "SELECT sum(payment_amount) AS totalMonthlyPayment, MONTHNAME(parking_date) AS parkingMonth, YEAR(parking_date) AS parkingYear FROM parking_info WHERE payment_status='' AND parking_date >= '".mysql_real_escape_string($firstDate)."' AND parking_date <= '".mysql_real_escape_string($lastDate)."'".$search_string." GROUP BY YEAR(parking_date), MONTH(parking_date) ";
										}
										else if ($_REQUEST["from"]<>'') {
										$sql = "SELECT sum(payment_amount) AS totalMonthlyPayment, MONTHNAME(parking_date) AS parkingMonth, YEAR(parking_date) AS parkingYear FROM parking_info WHERE payment_status='' AND parking_date >= '".mysql_real_escape_string($firstDate)."'".$search_string;
										}
										else if ($_REQUEST["to"]<>'') {
										$sql = "SELECT sum(payment_amount) AS totalMonthlyPayment, MONTHNAME(parking_date) AS parkingMonth, YEAR(parking_date) AS parkingYear FROM parking_info WHERE payment_status='' AND parking_date <= '".mysql_real_escape_string($lastDate)."'".$search_string;
										}
										else if ($_REQUEST["string"]<>'') {
										$sql = "SELECT sum(payment_amount) AS totalMonthlyPayment FROM parking_info WHERE payment_status=''".$search_string;
										}
										else
										{
										$sql = "SELECT sum(payment_amount) AS totalMonthlyPayment FROM parking_info WHERE payment_status=''";
										}
										$resultPending = mysql_query($sql) or die(mysql_error());
										
										if($lastDate<>'' AND $firstDate<>'') {
											echo "<td></td></tr>";
											while ($rows = mysql_fetch_array($resultPending)) {
												echo "<strong><tr class='danger'>";
												echo "<td colspan='7' align='right'><strong>".$rows['parkingMonth']." / ".$rows['parkingYear']."</strong></td>";
												echo "<td><strong>RM ".number_format($rows['totalMonthlyPayment'], 2)."</strong></td>";
												echo "</tr>";
											}
										}
										else {
											while ($rows = mysql_fetch_array($resultPending)) {
												echo "<td><strong>RM ".number_format($rows['totalMonthlyPayment'], 2)."</strong></td></tr>";
											}
										} 
								?>									
							</table>
						</div>
						<input type="button" name="button" id="buttonGenerateGraph" class="btn btn-primary" value="Generate Bar Chart" />	
            
			</div>
            <!-- /.container-fluid -->
			
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
	
	<div class="modal fade bs-example-modal-lg" id="modalShowBarChart" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-lg">
		<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h3 class="modal-title" id="modalTitleShowBarChart"></h3>
		</div>
		<div class="modal-body" style="min-height:450px;">
		<center>
			<!--img id="loading-image" src="../images/ajax-loader.gif" style="display:none;"/-->
				<div id="graphDiv" style="z-index:-1;"></div>
		</center>
		</div>		
		<div class="modal-footer">
			<div id="editor"></div>
			<!--a class="btn btn-default fa fa-file-pdf-o fa-lg" href="#" id="btnPrintPDFQRCode" onClick ="exportToPDF()"></a-->
			<!--button type="button" class="btn btn-primary" id="btnExportQRCode" name="btnExportQRCode" onclick="exportToImage()">Export QR Code</button-->
			<button type="button" class="btn btn-default" id="btnCancel" data-dismiss="modal">Close</button>
		</div>
		</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->	

	<script>
	/* $(function() {
		var dates = $( "#from, #to" ).datepicker({
			defaultDate: "+1w",
			changeMonth: true,
			numberOfMonths: 2,
			dateFormat: 'yy-mm-dd',
			onSelect: function( selectedDate ) {
				var option = this.parking_ID == "from" ? "minDate" : "maxDate",
					instance = $( this ).data( "datepicker" ),
					date = $.datepicker.parseDate(
						instance.settings.dateFormat ||
						$.datepicker._defaults.dateFormat,
						selectedDate, instance.settings );
				dates.not( this ).datepicker( "option", option, date );
			}
		});
	}); */
	</script>	
</body>
</html>
