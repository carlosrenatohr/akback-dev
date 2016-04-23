<?php defined('BASEPATH') OR exit('No direct script access allowed');
/* DataCap
*  Created by Henry Deazeta Jr
*  Created 03/09/2016
*/
class pos_emvx_receipt {
	private $label;
	private $amount;
	
	public function __construct($label = '', $amount = '') {
		$this -> label = $label;
		$this -> amount = $amount;
	}
	
	public function __toString() {
		$rightCols = 20;
		$leftCols = 6;
		$left = str_pad($this -> label, $leftCols);
		$right = str_pad($this -> amount, $rightCols, ' '.' ', STR_PAD_LEFT);
		return "$left$right\n";
	}
}