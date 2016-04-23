<?php
	//require("class.phpmailer.php");
	require 'PHPMailerAutoload.php';
	
	$mail = new PHPMailer();
	$mail->IsSMTP();
	$mail->CharSet = 'UTF-8';
	$mail->SMTPSecure = 'tls';
	$mail->Host       = "smtp.gmail.com"; // SMTP server example
	$mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
	$mail->SMTPAuth   = true;                  // enable SMTP authentication
	$mail->Port       = 587;                    // set the SMTP port for the GMAIL server
	$mail->Username   = ""; // SMTP account username example
	$mail->Password   = "";        // SMTP account password example
	
	$mail->From     = " ";
	$mail->AddAddress(" ");
	
	$mail->Subject  = "First PHPMailer Message";
	$mail->Body     = 	'<!DOCTYPE HTML>'.
						'<head>'.
						'<meta http-equiv="content-type" content="text/html">'.
						'<title>Email notification</title>'.
						'</head>'.
						'<body>'.
						'<div id="header" style="width: 80%;height: 60px;margin: 0 auto;padding: 10px;color: #fff;text-align: center;background-color: #E0E0E0;font-family: Open Sans,Arial,sans-serif;">'.
						'</div>'.
						
						'<div id="outer" style="width: 80%;margin: 0 auto;margin-top: 10px;">'. 
						   '<div id="inner" style="width: 78%;margin: 0 auto;background-color: #fff;font-family: Open Sans,Arial,sans-serif;font-size: 13px;font-weight: normal;line-height: 1.4em;color: #444;margin-top: 10px;">'.
							   '<p>test1</p>'.
							   '<p>test2</p>'.
							   '<p>test3</p>'.
							   '<p>test4</p>'.
							   '<p>test5</p>'.
						   '</div>'.  
						'</div>'.
						
						'<div id="footer" style="width: 80%;height: 40px;margin: 0 auto;text-align: center;padding: 10px;font-family: Verdena;background-color: #E2E2E2;">'.
						   'All rights reserved @ mysite.html 2014'.
						'</div>'.
						'</body>';
						
	$mail->WordWrap = 50;
	
	if(!$mail->Send()) {
	  echo 'Message was not sent.';
	  echo 'Mailer error: ' . $mail->ErrorInfo;
	} else {
	  echo 'Message has been sent.';
	}

?>
    