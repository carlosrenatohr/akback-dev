<?php defined('BASEPATH') OR exit('No direct script access allowed');
/* DataCap
*  Created by Henry Deazeta Jr
*  Created 02/25/2016
*/
class pos_datacap {
	private $_xmlVersion = '1.0';
	private $_charSet = 'UTF-8';
	
	public function xml_version(){
		$xml = '<?xml version="'.$this->_xmlVersion.'" encoding="'.$this->_charSet.'"?>';
		return $xml;
	}
	 
	public function xml_start($type){
		$xml  = '<TStream>';
		$xml .=	'<'.$type.'>';
		return $xml;
	}
	 
	 
	public function xml_content(array $xmlcontent){
		$xml = '';
		foreach($xmlcontent as $key=>$value){
			$xml .= '<'.$key.'>'.$value.'</'.$key.'>';
		}
		return $xml;
	}
	
	public function xml_subcontent(array $xmlsubcontent){
		$xml = '';
		for($i=0; $i < count($xmlsubcontent); $i++){
			foreach($xmlsubcontent[$i] as $key => $value){
				$xml.='<'.$key.'>';
				foreach($value as $row => $index){
					$xml.='<'.$row.'>'.$index.'</'.$row.'>';
				}
				$xml.='</'.$key.'>';
			}
		}
		return $xml;
	}
	
	public function xml_end($type){
		$xml  = '</'.$type.'>';
		$xml .=	'</TStream>';
		return $xml;
	}
	
	public function transmit($url, $body, $content_type, $control){
		 $headers = array(
			"Content-type: ".$content_type,
			"Invoke-Control: ".$control
		 );
		 try{
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            //Send xml request to a server
            curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_VERBOSE, 0);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $data = curl_exec($ch);
            //Convert the XML result into array
            if($data === false){
                $error = curl_error($ch);
                //echo $error; 
                //die('error occured');
				$data = false;
            }else{
                $data = json_decode(json_encode(simplexml_load_string($data)), true);  
            }
            curl_close($ch);
        }catch(Exception  $e){
            echo 'Message: ' .$e->getMessage();die("Error");
    	}
		return $data;
	}
}