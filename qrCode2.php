<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en" xmlns="http://www.w3.org/1999/xhtml>

<?php
error_reporting(0);
include('connectDB2.php');
include('phpqrcode-master/qrlib.php');
require_once('QrCode-master/src/QrCode.php');

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
				    <li class="">
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
                    <li class="active">
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
                            QR Code
                        </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="glyphicon glyphicon-qrcode"></i> QR Code
                            </li>
                        </ol>
                    </div>
                </div>
		<!-- /.row -->

			<div class="col-lg-6">
			<?php
				if(isset($_POST['ins']))
				{
          $qrCredit = $_POST['credit'];
          $qrQuantity = $_POST['quantity'];
          $code = array();

          // include "phpqrcode-master/qrlib.php";
          // header('Content-Type: image/png');
          // QRcode::png("skdj");

          for($i = 0; $i < $qrQuantity; $i++) {
            $code[$i] = uniqid(); echo $code[$i]."/";
            do {  $code[$i] = uniqid();

              $sqlValidateCode = "SELECT * FROM qr_code WHERE qrCode='".$code[$i]."'";
              $resultValidateCode = mysql_query($sqlValidateCode, $con);
              $num_rows = mysql_num_rows($resultValidateCode); echo $num_rows;
            } while($num_rows > 0);
?>

<?php
                // header('Content-Type: image/png');
                // QRcode::png($code[$i]);

                //$qrCredit = $_POST['credit'];
                $sqlInsertQRCode="INSERT INTO qr_code (qrCode,qrCredit) VALUES('$code[$i]', '$qrCredit')" or die(mysql_error());
                $result = mysql_query($sqlInsertQRCode, $con);
            }
				}
			?>
      
					<div class="tabbable">
					  <ul class="nav nav-tabs">
						<li class="active"><a href="#pane1" data-toggle="tab">Latest QR code</a></li>
						<li><a href="#pane2" data-toggle="tab">Add QR code</a></li>
					  </ul>
					  <div class="tab-content">
              <div id="pane1" class="tab-pane active">
  							<br />
                <div class="col-lg-12">
                  <div class="panel panel-green">
                    <div class="panel-heading">
                       <h3 class="panel-title"><i class="fa fa-clock-o fa-fw"></i> Latest QR Code</h3>
                    </div>
                    <div class="panel-body">

                   <table width="275" class="table table-hover">
                     <tr>
                   	<td width="" bgcolor=""><strong>QR Code</strong></td>
                   	<td width="" bgcolor=""><strong>QR Credit</strong></td>
                     </tr>
                   <?php

                   	$sql = "SELECT qrCode, qrCredit FROM qr_code ORDER BY qrId DESC LIMIT 10".$search_string;

                   $sql_result = mysql_query ($sql, $con ) or die ('request "Could not execute SQL query" '.$sql);
                   if (mysql_num_rows($sql_result)>0) {
                   	while ($row = mysql_fetch_assoc($sql_result)) {
                   ?>
                     <tr>
                   	   <td><?php echo $row["qrCode"]; ?></td>
                   	   <td><?php echo $row["qrCredit"]; ?></td>
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

						<div id="pane2" class="tab-pane">
							<br />
							<form class="form-inline" method="post" enctype="multipart/form-data" action="">
							<table class="table table-condensed">
								<tr>
								<td width="425"><strong></strong></td>
								<td width=""><strong>Value</strong></td>
								</tr>
								<tr>
									<td align="right">QR Credit</td>
									<td>
                    <div class="input-group">
                      <span class="input-group-addon">RM</span>
                      <input class="form-control" type="number" step="any" name="credit" value="<?php echo $row['credit'];?>"/>
                    </div>
                  </td>
								</tr>
								<tr>
									<td align="right">Quantity</td>
									<td><input class="form-control" type="text" name="quantity" pattern="[0-9\s]+" required/></td>
								</tr>
							</table>
							<center><input class="btn btn-primary btn-sm" type="submit" value="Create code" name="ins"/></td></center>

              </form>

						</div>

					  </div><!-- /.tab-content -->
					</div><!-- /.tabbable -->


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


</body>

</html>
