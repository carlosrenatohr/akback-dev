<?php defined('BASEPATH') OR exit('No direct script access allowed');

class credit_card_check {

	public function get_cc_type($cardNumber)
	{
		// Strip non-digits from the number
		$cardNumber = preg_replace('/\D/', '', $cardNumber);

		// First we make sure that the credit
		// card number is under 15 characters
		// in length, otherwise it is invalid;
		$len = strlen($cardNumber);
		if ($len < 15 || $len > 16) {
			throw new Exception("Invalid credit card number: must be 15 or 16 digits.");
		}else {
			switch($cardNumber) {
				case(preg_match ('/^4/', $cardNumber) >= 1):
					return 'Visa';
				case(preg_match ('/^5[1-5]/', $cardNumber) >= 1):
					return 'Mastercard';
				case(preg_match ('/^3[47]/', $cardNumber) >= 1):
					return 'Amex';
				case(preg_match ('/^3(?:0[0-5]|[68])/', $cardNumber) >= 1):
					return 'Diners Club';
				case(preg_match ('/^6(?:011|5)/', $cardNumber) >= 1):
					return 'Discover';
				case(preg_match ('/^(?:2131|1800|35\d{3})/', $cardNumber) >= 1):
					return 'JCB';
				default:
					throw new Exception("Could not determine the credit card type.");
					return 'Invalid Credit Card Number';
					//break;
			}
		}
	}
}