<?php
 $code = $_request["qrcode"];
	include "phpqrcode-master/qrlib.php";
                // header('Content-Type: image/png');
                QRcode::png($code);


//	header('Content-Type: image/png');

//	require_once('QrCode-master/src/QrCode.php');

//	use Endroid\QrCode\QrCode;
//
	//$qr = new QrCode();

	//	$qr->setText("This is a QR Code!");
	//	$qr->setSize("200");
	//	$qr->render();

?>
