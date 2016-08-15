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

if(isset($_POST['update']))
{
	header('location:summon.php');
}
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
			<?php
				$sql=mysql_query("SELECT * FROM summon_info WHERE summon_id='{$_GET['summon_id']}'");
				$row=mysql_fetch_array($sql);
				extract($_POST);
			?>
					<form class="form-inline" method="post" enctype="multipart/form-data">
						<div class="table-responsive">
							<table class="table table-condensed">
							<tr>
								<td width="490" align="right">Summon ID</td>
								<td><input class="form-control" readonly="readonly" type="text" name="summon_id" value="<?php echo $row['summon_id'];?>"/></td>
							</tr>
							<tr>
								<td align="right">Summon Time</td>
								<td><input class="form-control" readonly="readonly" value="<?php echo $row['summon_time'];?>" type="text" name="summon_time"/></td>
							</tr>
							<tr>
								<td align="right">Summon Date</td>
								<td><input class="form-control" readonly="readonly" value="<?php echo $row['summon_date'];?>" type="text" name="summon_date"/></td>
							</tr>
							<tr>
								<td align="right">Summon Plate Number</td>
								<td><input class="form-control" readonly="readonly" value="<?php echo $row['summon_plate_num'];?>" type="text" name="summon_plate_num"/></td>
							</tr>
							<tr>
								<td align="right">Summon Fee</td>
								<td><input class="form-control" readonly="readonly" value="<?php echo $row['summon_fee'];?>" type="text" name="summon_fee"/></td>
							</tr>
							<tr>
								<td align="right">Summon Status</td>
								<td>
								<select class="form-control input-sm" name="summon_status" required>
								<option></option>
								<option value="paid">Paid</option>
								<option value="unpaid">Unpaid</option>
								</select>
								</td>
							</tr>
							</table>
							<?php
								if(isset($_POST['update']))
								{
								mysql_query("UPDATE summon_info SET summon_status='$summon_status' WHERE summon_id='{$_GET['summon_id']}'");
								}
							?>
							<center><input class="btn btn-primary" type="submit" value="Update" name="update"/></center>
						</div>
					</form>

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
