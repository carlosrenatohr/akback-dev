<?php defined('BASEPATH') OR exit('No direct script access allowed');
/* POS Computation 
*  Created by Henry Deazeta Jr
*  Created 10/14/2015
*/
class pos_computation {
	
	public function tax($label = '', $sellprice = 0, $quantity = 0, $rate = 0){
		if($label == "By Amount"){
			$TotalPrice = $sellprice * $quantity;
			$WithHoldTax = $TotalPrice * $rate / 100;
		}else if($label == "By Quantity"){
			$WithHoldTax = $quantity * $rate;
		}
		return $WithHoldTax;
	}
	
	public function receipt_details_discount($list_price = 0, $sell_price = 0, $quantity = 0){
		$Discount = $list_price - $sell_price;
		$TotalDiscount = $quantity * $Discount;
		if($sell_price > $list_price){
			$TotalDiscount = 0;
		}else{
			if($TotalDiscount  < 0){
				$TotalDiscount = 0;
			}
		}
		return $TotalDiscount;
	}
	
	public function receipt_details_discount_original($list_price = 0, $sell_price = 0){
		$TotalDiscount = $list_price - $sell_price;
		//if($TotalDiscount < 0){
		//	$TotalDiscount = 0;
		//}
		return $TotalDiscount;
	}
	
	public function item_discount_computation($option = '', $discount_amount = 0, $list_price = 0, $quantity = 0){
		if($option == 1){ /* Percent Discount */
			$RealNumberConverted = $discount_amount / 100;
			$ItemDiscount = $RealNumberConverted * $list_price;
			$NewSellPrice = $list_price - $ItemDiscount;
		}else if($option == 2){ /* Dollar Discount */
			$ItemDiscount = $discount_amount;
			$NewSellPrice = $list_price - $ItemDiscount;
		}
		$Result = array(
			"ItemDiscount" 	=> $ItemDiscount,
			"NewSellPrice" 	=> $NewSellPrice,
			"DiscountTotal" => $ItemDiscount * $quantity
		);
		return $Result;
	}
	
	public function receipt_discount_computation($option = '', $discount_amount = 0, $total_list_price = 0, $total_quantity = 0){
		if($option == 1){ /* Perent Discount */
			$DecreasedPercent = $discount_amount / 100;
			$TotalDiscountAmount = $total_list_price * $DecreasedPercent;
			$ItemDiscount = $TotalDiscountAmount - $total_quantity;
		}else if($option == 2){ /* Dollar Discount */
			$TotalDiscountAmount = $discount_amount;
			$ItemDiscount = $TotalDiscountAmount - $total_quantity;
		}
		$Result = array(
			"ItemDiscount" => $ItemDiscount,
			"TotalDiscountAmount" => $TotalDiscountAmount
		);
		return $Result;
	}
	
	public function receipt_discount_proportion_computation($data){
		$Proportion = $data["list_price"] / $data["total_list_price"];
		$ActualItemDiscount = $data["total_discount_amount"] * $Proportion;
		$NewSellPrice = $data["list_price"] - $ActualItemDiscount;
		$Result = array(
			"ActualItemDiscount" => $ActualItemDiscount,
			"NewSellPrice" => $NewSellPrice,
			"DiscountTotal" => $ActualItemDiscount * $data["total_quantity"]
		);
		return $Result;
	}
	
	
	public function receipt_details_total($quantity = 0, $sellprice = 0, $totaltax = 0){
		$total = $quantity * $sellprice + $totaltax;
		return $total;
	}
	
	public function get_receipt_status($item_total = 0, $payment_total = 0, $change = 0){
			$balance = $item_total - $payment_total;
			if($balance > 0){
				$json["paymentlabel"] = "Amount Due";
				$json["Total"] = $balance;
			}else if ($balance <= 0) {
				$json["paymentlabel"] = "Change";
				$json["Total"] = $balance;
				//var_dump($balance." | ".$item_total." | ".$payment_total);
			}
		return $json;
	}
	
	public function receipt_tip_by_percent_computation($tip, $curtotal){
		$DecreasedPercent = $tip / 100;
		$TotalTipAmount = $curtotal * $DecreasedPercent;
		$tipAmount = number_format($TotalTipAmount,2,'.','');
		return $tipAmount;
	}	
}