<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en" xmlns="http://www.w3.org/1999/xhtml>

<?php
//error_reporting(0);
include("connectDB2.php");

session_start();
if((!isset ($_SESSION['username']) == true) and (!isset ($_SESSION['password']) == true))             // check session condition
{
unset($_SESSION['username']);                                
unset($_SESSION['password']);
header('location:login.php');
}
$logged = $_SESSION['username'];

if(isset($_POST['upd']))
{
header('location:option.php');
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
					<li class="active">
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
                            Option
                        </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-wrench"></i> Option
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

			<div class="col-lg-6">
			<?php 			
				$sql=mysql_query("SELECT rate FROM parking_rate");
				$row=mysql_fetch_array($sql);
				extract($_POST);

				if(isset($_POST['upd']))
				{
				mysql_query("UPDATE parking_rate SET rate='$rate'");
				}

				if(isset($_POST['ins']))
				{	
					$id = $_POST['id'];
					$username = $_POST['username'];
					$password = $_POST['password'];
					$password = md5($password);
					$first_name = $_POST['first_name'];
					$last_name = $_POST['last_name'];
					$contact_no = $_POST['contact_no'];
					
					$sql="INSERT INTO enforcer VALUES('$id', '$first_name', '$last_name', '$contact_no', '$username', '$password' )" or die(mysql_error());
					mysql_query($sql, $con);	
				}
				?>
					
					<div class="tabbable">
					  <ul class="nav nav-tabs">
						<li class="active"><a href="#pane1" data-toggle="tab">Update Parking Rate</a></li>
						<li><a href="#pane2" data-toggle="tab">Add User</a></li>
						<li><a href="#pane3" data-toggle="tab">Edit/Delete User</a></li>
					  </ul>
					  <div class="tab-content">
						<div id="pane1" class="tab-pane active">
							<br />
							<form class="form-inline" method="post" enctype="multipart/form-data">
							<table class="table table-bordered table-condensed">
								<tr>
								<td width="200"><strong>Option</strong></td>
								<td  width="500"><strong>Value</strong></td>
								</tr>
								<tr>
									<td>Parking Rate</td>
									<td>
									<div class="input-group">
									<span class="input-group-addon">RM</span>
									<input class="form-control" type="number" step="any" name="rate" value="<?php echo $row['rate'];?>"/>
									</div>
									<input class="btn btn-primary btn-sm" type="submit" value="Update" name="upd"/>
									</td>
								</tr>
							</table>
							</form>
						</div>
						<div id="pane2" class="tab-pane">
							<br />
							<form class="form-inline" method="post" enctype="multipart/form-data">
							<table class="table table-condensed">
								<tr>
								<td width="425"><strong></strong></td>
								<td  width=""><strong>Value</strong></td>
								</tr>
								<tr>
									<td align="right">ID</td>
									<td><input class="form-control" type="text" name="id" required/></td>
								</tr>
								<tr>
									<td align="right">First Name</td>
									<td><input class="form-control" type="text" name="first_name" required/></td>
								</tr>
								<tr>
									<td align="right">Last Name</td>
									<td><input class="form-control" type="text" name="last_name" required/></td>
								</tr>
								<tr>
									<td align="right">Contact Number</td>
									<td><input class="form-control" type="text" step="any" name="contact_no" pattern="[0-9\s]+" required/></td>
								</tr>
								<tr>
									<td align="right">Username</td>
									<td><input class="form-control" type="text" name="username" required/></td>
								</tr>
								<tr>
									<td align="right">Password</td>
									<td><input class="form-control" type="password" name="password" required/></td>
								</tr>
							</table>
							<center><input class="btn btn-primary btn-sm" type="submit" value="Add User" name="ins"/></td></center>
							</form>
						</div>
						<div id="pane3" class="tab-pane">
							<br />
							<form class="form-inline" method="post" enctype="multipart/form-data">
							<table class="table table-condensed">
								<tr>
									<td><strong>ID</strong></td>
									<td><strong>First Name</strong></td>
									<td><strong>Last Name</strong></td>
									<td><strong>Contact Number</strong></td>
									<td><strong></strong></td>
								</tr>
								<?php			
								$sql = "SELECT * FROM enforcer";
								
								$sql_result = mysql_query ($sql, $con ) or die ('request "Could not execute SQL query" '.$sql);
								if (mysql_num_rows($sql_result)>0) {
									while ($row = mysql_fetch_assoc($sql_result)) {
								?>
								<tr>
									<td><?php echo $row["id"]; ?></td>
									<td><?php echo $row["first_name"]; ?></td>
									<td><?php echo $row["last_name"]; ?></td>
									<td><?php echo $row["contact_no"]; ?></td>
									<td>
									<a href="update_user.php?id=<?php echo $row["id"]; ?>"><span class="glyphicon glyphicon-edit"></span></a>
										<script language="JavaScript" type="text/javascript">
											function checkDelete(){
												return confirm('Delete user?');
											}
										</script>
									<a href="delete.php?id=<?php echo $row["id"]; ?>" onclick="return checkDelete()"><span class="glyphicon glyphicon-remove"></a>
									</td>
								</tr>
								<?php
									}
								} else {
								?>
								<tr><td colspan="8">No results found.</td>
								<?php	
								}
								?>
							</table>
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
