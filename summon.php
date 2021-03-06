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

	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"></script>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>
	<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
	
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
                    <i class="fa fa-user"></i> Administrator</a>
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
                                <i class="fa fa-file"></i> Summons
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

			<div class="col-lg-6">
			
				<form class="form-inline" id="form1" name="form1" method="post" action="summon.php">
					<label for="from">From</label>
						<input class="form-control" name="from" type="date" id="from" size="10" value="<?php echo $_REQUEST["from"]; ?>" required/>
					<label for="to">to</label>
						<input class="form-control" name="to" type="date" id="to" size="10" value="<?php echo $_REQUEST["to"]; ?>" required/>
					<label>Plate Number:</label>
						<input class="form-control" type="text" name="string" id="string" value="<?php echo stripcslashes($_REQUEST["string"]); ?>" pattern="[a-zA-Z0-9\s]+"/>
						<input type="submit" name="button" id="button" class="btn btn-primary" value="Filter" />
						<a class="btn btn-info" href="summon.php">Reset</a>
  
  					<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
					<script type="text/javascript" src="tableExport.js"></script>
					<script type="text/javascript" src="jquery.base64.js"></script>

					<script type="text/javascript" src="jspdf/libs/sprintf.js"></script>
					<script type="text/javascript" src="jspdf/jspdf.js"></script>
					<script type="text/javascript" src="jspdf/libs/base64.js"></script>

					<a class="fa fa-file-pdf-o fa-lg" target="_blank" href="#" onClick ="$('#summon').tableExport({type:'pdf',escape:'false',pdfFontSize:6,pdfLeftMargin:4});"></a>
					<a class="fa fa-file-excel-o fa-lg" href="#" onClick ="$('#summon').tableExport({type:'excel',escape:'false'});"></a>  
				</form>
				<br />
						<div class="table-responsive">
                            <table id="summon" class="table table-bordered table-condensed">
								<tr>
									<td width="" bgcolor=""><strong>Summon ID</strong></td>
									<td width="" bgcolor=""><strong>Summon Time</strong></td>
									<td width="" bgcolor=""><strong>Summon Date</strong></td>
									<td width="" bgcolor=""><strong>Summon Plate Number</strong></td>
									<td width="" bgcolor=""><strong>Summon Fee</strong></td>
									<td width="" bgcolor=""><strong>Summon Status</strong></td>
								</tr>
								<?php
								if ($_REQUEST["string"]<>'') {
									$search_string = " AND (summon_plate_num LIKE '%".mysql_real_escape_string($_REQUEST["string"])."%')";	
								}

								if ($_REQUEST["from"]<>'' and $_REQUEST["to"]<>'') {
									$sql = "SELECT * FROM summon_info WHERE summon_date >= '".mysql_real_escape_string($_REQUEST["from"])."' AND summon_date <= '".mysql_real_escape_string($_REQUEST["to"])."'".$search_string;
								} else if ($_REQUEST["from"]<>'') {
									$sql = "SELECT * FROM summon_info WHERE summon_date >= '".mysql_real_escape_string($_REQUEST["from"])."'".$search_string;
								} else if ($_REQUEST["to"]<>'') {
									$sql = "SELECT * FROM summon_info WHERE summon_date <= '".mysql_real_escape_string($_REQUEST["to"])."'".$search_string;
								} else if ($_REQUEST["string"]<>'') {
									$sql = "SELECT * FROM summon_info WHERE (summon_plate_num LIKE '%".mysql_real_escape_string($_REQUEST["string"])."%')";
								} else {
									$sql = "SELECT * FROM summon_info ORDER BY summon_date DESC, summon_time DESC".$search_string;
								}

								$sql_result = mysql_query ($sql, $con ) or die ('request "Could not execute SQL query" '.$sql);
								if (mysql_num_rows($sql_result)>0) {
									while ($row = mysql_fetch_assoc($sql_result)) {
								?>
								<tr>
									<td><a href="update.php?summon_id=<?php echo $row["summon_id"]; ?>"><?php echo $row["summon_id"]; ?></a></td>
									<td><?php echo $row["summon_time"]; ?></td>
									<td><?php echo $row["summon_date"]; ?></td>
									<td><?php echo $row["summon_plate_num"]; ?></td>
									<td><?php echo $row["summon_fee"]; ?></td>
									<td><?php echo $row["summon_status"]; ?></td>
								</tr>
								<?php
									}
								} else {
								?>
								<tr><td colspan="7">No results found.</td>
								<?php	
								}
								?>
								<tr class="success">
									<td colspan="5" bgcolor="" align="right"><strong>Total Paid Summon</strong></td>
									<td><strong>RM
										<?php
										if ($_REQUEST["from"]<>'' and $_REQUEST["to"]<>'') {
										$sql = "SELECT sum(summon_fee) FROM summon_info WHERE summon_status='paid' AND summon_date >= '".mysql_real_escape_string($_REQUEST["from"])."' AND summon_date <= '".mysql_real_escape_string($_REQUEST["to"])."'".$search_string;
										}
										else if ($_REQUEST["from"]<>'') {
										$sql = "SELECT sum(summon_fee) FROM summon_info WHERE summon_status='paid' AND summon_date >= '".mysql_real_escape_string($_REQUEST["from"])."'".$search_string;
										}
										else if ($_REQUEST["to"]<>'') {
										$sql = "SELECT sum(summon_fee) FROM summon_info WHERE summon_status='paid' AND summon_date <= '".mysql_real_escape_string($_REQUEST["to"])."'".$search_string;
										}
										else if ($_REQUEST["string"]<>'') {
										$sql = "SELECT sum(summon_fee) FROM summon_info WHERE summon_status='paid'".$search_string;
										}
										else
										{
										$sql = "SELECT sum(summon_fee) FROM summon_info WHERE summon_status='paid'";
										}
										$result = mysql_query($sql) or die(mysql_error());
										while ($rows = mysql_fetch_array($result)) {
										echo number_format($rows['sum(summon_fee)'], 2);
										}
										?></strong>
									</td>
								</tr>
								<tr class="danger">
									<td colspan="5" bgcolor="" align="right"><strong>Total Unpaid Summon</strong></td>
									<td><strong>RM
										<?php
										if ($_REQUEST["from"]<>'' and $_REQUEST["to"]<>'') {
										$sql = "SELECT sum(summon_fee) FROM summon_info WHERE summon_status='unpaid' AND summon_date >= '".mysql_real_escape_string($_REQUEST["from"])."' AND summon_date <= '".mysql_real_escape_string($_REQUEST["to"])."'".$search_string;
										}
										else if ($_REQUEST["from"]<>'') {
										$sql = "SELECT sum(summon_fee) FROM summon_info WHERE summon_status='unpaid' AND summon_date >= '".mysql_real_escape_string($_REQUEST["from"])."'".$search_string;
										}
										else if ($_REQUEST["to"]<>'') {
										$sql = "SELECT sum(summon_fee) FROM summon_info WHERE summon_status='unpaid' AND summon_date <= '".mysql_real_escape_string($_REQUEST["to"])."'".$search_string;
										}
										else if ($_REQUEST["string"]<>'') {
										$sql = "SELECT sum(summon_fee) FROM summon_info WHERE summon_status='unpaid'".$search_string;
										}
										else
										{
										$sql = "SELECT sum(summon_fee) FROM summon_info WHERE summon_status='unpaid'";
										}
										$result = mysql_query($sql) or die(mysql_error());
										while ($rows1 = mysql_fetch_array($result)) {
										echo number_format($rows1['sum(summon_fee)'], 2);
										}
										?></strong>
									</td>
								</tr>						
							</table>
						</div>
            </div>
            <!-- /.container-fluid -->
			
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

	<script>
	$(function() {
		var dates = $( "#from, #to" ).datepicker({
			defaultDate: "+1w",
			changeMonth: true,
			numberOfMonths: 2,
			dateFormat: 'yy-mm-dd',
			onSelect: function( selectedDate ) {
				var option = this == "from" ? "minDate" : "maxDate",
					instance = $( this ).data( "datepicker" ),
					date = $.datepicker.parseDate(
						instance.settings.dateFormat ||
						$.datepicker._defaults.dateFormat,
						selectedDate, instance.settings );
				dates.not( this ).datepicker( "option", option, date );
			}
		});
	});
	</script>	
</body>
</html>
