<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en" xmlns="http://www.w3.org/1999/xhtml>

<?php
error_reporting(0);
include('connectDB2.php');
include('QrCode-master/src/QrCode.php');
include "phpqrcode-master/qrlib.php";

session_start();
if((!isset ($_SESSION['username']) == true) and (!isset ($_SESSION['password']) == true))             // check session condition
{
unset($_SESSION['username']);
unset($_SESSION['password']);
header('location:login.php');
}
$logged = $_SESSION['username'];

	if(isset($_POST['ins']))
	{
		$qrCredit = $_POST['credit'];
		$qrQuantity = $_POST['quantity'];
		$code = array();
		for($i = 0; $i < $qrQuantity; $i++) {
			do {  $code[$i] = uniqid();

			  $sqlValidateCode = "SELECT * FROM qr_code WHERE qrCode='".$code[$i]."'";
			  $resultValidateCode = mysql_query($sqlValidateCode, $con);
			} while($num_rows > 0);

			$sqlInsertQRCode="INSERT INTO qr_code (qrCode,qrCredit) VALUES('$code[$i]', '$qrCredit')";
			$resultInsertCode = mysql_query($sqlInsertQRCode, $con) or die(mysql_error());
			$num_rows = mysql_num_rows($resultInsertCode); echo $num_rows;						
		}
		$_SESSION["code"] = $code;	 			
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

	<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="js/jquery-2.2.1.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/jquery.qrcode-0.12.0.min.js"></script>

<!-- Export to Image File -->
<script src="js/html2canvas.js"></script>

<!-- Export to PDF File -->
<!--script type="text/javascript" src="js/jspdf.debug.js"></script-->
<script>
	var qrCodeValues;
	$(document).ready(function(){
		$("#checkAll").click(function(){
			$('.qrcodeValueCheckBox:checkbox').not(this).prop('checked', this.checked);
		});
		$('#btnGenerate').click(function(event) {
			var checkedValues = $('.qrcodeValueCheckBox:checkbox:checked').map(function() {
				return this.value;
			}).toArray();
			qrCodeValues = checkedValues;
			//alert(checkedValues.length);
			generateQRCode(checkedValues);
		});
	});
	
	function generateQRCode(checkedValues) {
		$( "#containerQRCode" ).empty();
		for(var i=0; i<checkedValues.length; i++) {
			var qrCodeDivId = checkedValues[i];
			$( "#containerQRCode" ).append( "<center><div class='qrCodeDiv' id='"+qrCodeDivId+"'></div><center>" );
			$( "#containerQRCode" ).append( "<input class='form-control' style='width:150px;' type='text' readonly value='"+qrCodeDivId+"'/><hr/>" );
			$('#'+qrCodeDivId).qrcode({
				"render": 'div',
				"size": 150,
				"color": "#3a3",
				"text": qrCodeDivId
			});			
		}
		if(checkedValues.length == 0) {
			$("#btnPrintPDFQRCode, #btnExportQRCode").css('display','none');
		}
		else {
			$("#btnPrintPDFQRCode, #btnExportQRCode").css('display','');
		}
		$('#modalShowQrCode').modal('toggle'); 
	}
	
	function exportToImage() {
		html2canvas($('#containerQRCode'), {
			onrendered: function(canvas) {
				var img = canvas.toDataURL();
				//window.location.href = img;
				window.open(img); // open to new tab
			},
			letterRendering: true
		});
	}
	
	function exportToPDF() {
		var doc = new jsPDF();
		var specialElementHandlers = {
			'#editor': function (element, renderer) {
				return true;
			}
		};
		
		var pdfFileName = qrCodeValues;
			console.log("clicked");
			doc.fromHTML($('#containerQRCode2').html(), 15, 15, {
				'width': 170,
					'elementHandlers': specialElementHandlers
			});
			doc.save(pdfFileName);		
	}
	
	
</script>
<style>
.qrCodeDiv {
	max-width:150px;
	max-height:300px;
}
</style>
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
<center><input type="button" class="btn btn-primary btn-sm" id="btnGenerate" value="Generate QR Codes"/></center>
                   <table width="275" class="table table-hover">
                     <tr>
					<td><input type="checkbox" id="checkAll"></td>
                   	<td width="" bgcolor=""><strong>QR Code</strong></td>
                   	<td width="" bgcolor=""><strong>QR Credit</strong></td>
                     </tr>
                   <?php

                   	$sql = "SELECT qrCode, qrCredit FROM qr_code ORDER BY qrId DESC".$search_string;

                   $sql_result = mysql_query ($sql, $con ) or die ('request "Could not execute SQL query" '.$sql);
                   if (mysql_num_rows($sql_result)>0) {
                   	while ($row = mysql_fetch_assoc($sql_result)) {
                   ?>
                     <tr>
						<td><input class="qrcodeValueCheckBox" type="checkbox" value="<?php echo $row["qrCode"]; ?>"/></td>
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
			  <script>var value = <?php echo json_encode($_SESSION['code']); ?>;</script>
						</div>

					  </div><!-- /.tab-content -->
					</div><!-- /.tabbable -->


            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
<div class="modal fade bs-example-modal-lg" id="modalShowQrCode" tabindex="-1" role="dialog" >
	<div class="modal-dialog modal-lg">
	<div class="modal-content">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title" id="modalTitleAddScoreOR">Generate QR Codes</h4>
	</div>
	<div class="modal-body">
	<center>
		<!--img id="loading-image" src="../images/ajax-loader.gif" style="display:none;"/-->
		<div class="" id="containerQRCode">
		</div>
	</center>
	</div>		
	<div class="modal-footer">
		<div id="editor"></div>
		<!--a class="btn btn-default fa fa-file-pdf-o fa-lg" href="#" id="btnPrintPDFQRCode" onClick ="exportToPDF()"></a-->
		<button type="button" class="btn btn-primary" id="btnExportQRCode" name="btnExportQRCode" onclick="exportToImage()">Export QR Code</button>
		<button type="button" class="btn btn-default" id="btnCancel" data-dismiss="modal">Close</button>
	</div>
	</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->		
</body>

</html>
