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
?>

<?php
if(isset($_POST['updt']))
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
                                <i class="fa fa-file"></i> Update User
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

			<div class="col-lg-6">
			<?php
				$sql=mysql_query("SELECT * FROM enforcer WHERE id='{$_GET['id']}'");
				$row=mysql_fetch_array($sql);
				extract($_POST);
			?>
					<form class="form-inline" method="post" enctype="multipart/form-data">
						<div class="table-responsive">
							<table class="table table-condensed">
							<tr>
								<td width="490" align="right">ID</td>
								<td><input class="form-control" readonly="readonly" type="text" name="id" value="<?php echo $row['id'];?>"/></td>
							</tr>
							<tr>
								<td align="right">First Name</td>
								<td><input class="form-control" value="<?php echo $row['first_name'];?>" type="text" name="first_name"/></td>
							</tr>
							<tr>
								<td align="right">Last Name</td>
								<td><input class="form-control" value="<?php echo $row['last_name'];?>" type="text" name="last_name"/></td>
							</tr>
							<tr>
								<td align="right">Contact Number</td>
								<td><input class="form-control" value="<?php echo $row['contact_no'];?>" type="text" name="contact_no" pattern="[0-9\s]+"/></td>
							</tr>
							<tr>
								<td align="right">Username</td>
								<td><input class="form-control" value="<?php echo $row['username'];?>" type="text" name="username"/></td>
							</tr>
							<tr>
								<td align="right">Password</td>
								<td><input class="form-control" value="<?php echo $row['password'];?>" type="password" name="password"/></td>
							</tr>
							</table>
							<?php
							if(isset($_POST['updt']))
							{
							mysql_query("UPDATE enforcer SET first_name='$first_name', last_name='$last_name', contact_no='$contact_no', username='$username', password='$password' WHERE id='{$_GET['id']}'");
							//header('location:option.php');
							}
							?>
							<center><input class="btn btn-primary" type="submit" value="Update" name="updt"/></center>
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
