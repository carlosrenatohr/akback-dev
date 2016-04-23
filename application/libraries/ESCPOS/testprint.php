<?php
	require_once("Escpos.php");
	try {
		// Enter the share name for your USB printer here
		$connector = null;
		$connector = new WindowsPrintConnector("smb://Henry-PC/AKPrinter");
		/* Print a "Hello world" receipt" */
		$printer = new Escpos($connector);
		$printer -> text("Hello World!\n");
		$printer -> cut();
		
		/* Close printer */
		$printer -> close();
	} catch(Exception $e) {
		echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
	}
?>