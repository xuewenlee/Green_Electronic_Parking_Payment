<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en" xmlns="http://www.w3.org/1999/xhtml>

<?php
error_reporting(0);
include('connectDB2.php');

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
                    <i class="fa fa-user"></i> Administrator</b></a>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
				    <li class="active">
                        <a href="dashboard.php"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                    </li>
					<li>
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
                            Dashboard <small>Overview</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-dashboard"></i> Dashboard
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

			 <div class="col-lg-4">
          <div class="panel panel-green">
              <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-clock-o fa-fw"></i> Latest payment</h3>
              </div>
              <div class="panel-body">

                <table width="475" class="table table-hover">
                  <tr>
                    <td width="" bgcolor=""><strong>Plate Number</strong></td>
                    <td width="" bgcolor=""><strong>Parking Date</strong></td>
                 <td width="" bgcolor=""><strong>Parking Time</strong></td>
                 <td width="" bgcolor=""><strong>Parking End Time</strong></td>
                  </tr>
                <?php

                 $sql = "SELECT * FROM parking_info WHERE payment_status='approved' ORDER BY parking_date DESC, parking_start_time DESC LIMIT 10".$search_string;

                $sql_result = mysql_query ($sql, $con ) or die ('request "Could not execute SQL query" '.$sql);
                if (mysql_num_rows($sql_result)>0) {
                 while ($row = mysql_fetch_assoc($sql_result)) {
                ?>
                  <tr>
                    <td><?php echo $row["plate_num"]; ?></td>
                    <td><?php echo $row["parking_date"]; ?></td>
                 <td><?php echo $row["parking_start_time"]; ?></td>
                 <td><?php echo $row["parking_end_time"]; ?></td>
                  </tr>
                <?php
                 }
                } else {
                ?>
                <tr><td colspan="7">No results found.</td>
                <?php
                }
                ?>
                </table>
							</div>
						</div>
			</div>

						 <div class="col-lg-4">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-clock-o fa-fw"></i> Summons</h3>
                            </div>
                            <div class="panel-body">
							<table width="475" class="table table-hover">
  <tr>
    <td width="" bgcolor=""><strong>Plate Number</strong></td>
    <td width="" bgcolor=""><strong>Summon Date</strong></td>
	<td width="" bgcolor=""><strong>Summon Time</strong></td>
  </tr>
<?php

	$sql = "SELECT * FROM summon_info WHERE summon_status='unpaid' ORDER BY summon_date DESC, summon_time DESC".$search_string;

$sql_result = mysql_query ($sql, $con ) or die ('request "Could not execute SQL query" '.$sql);
if (mysql_num_rows($sql_result)>0) {
	while ($row = mysql_fetch_assoc($sql_result)) {
?>
  <tr>
    <td><a href="update.php?summon_id=<?php echo $row["summon_id"]; ?>"><?php echo $row["summon_plate_num"]; ?></a></td>
    <td><?php echo $row["summon_date"]; ?></td>
	<td><?php echo $row["summon_time"]; ?></td>
  </tr>
<?php
	}
} else {
?>
<tr><td colspan="7">No results found.</td>
<?php
}
?>
</table>
							</div>
						</div>
			</div>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
