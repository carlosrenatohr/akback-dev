<?php defined('BASEPATH') OR exit('No direct script access allowed');
class kitchen_receipt {
	private $quantity;
	private $description;
	public function __construct($quantity = '', $description = '') {
		$this -> quantity = $quantity;
		$this -> description = $description;
	}
	
	public function __toString() {
		$rightCols = 30;
		$leftCols = 3;
		$left = str_pad($this -> quantity, $leftCols);
		$right = str_pad($this -> description, $rightCols);
		return "$left$right";
	}
}