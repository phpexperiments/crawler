<?php 

class Curl 
{ 
	var $headers; 
	var $curlUrl;
	
	public function __construct($url='')
	{		
		$this->curlUrl = $url;
		$this->headers[] = 'Content-type: application/x-www-form-urlencoded;charset=UTF-8'; 
	}
	
	//Curl get Method
	public function get() 
	{ 
		$process = curl_init($this->curlUrl); 
		curl_setopt($process, CURLOPT_HTTPHEADER, $this->headers); 
		curl_setopt($process, CURLOPT_HEADER, 0); 
		curl_setopt($process, CURLOPT_TIMEOUT, 30);  
		curl_setopt($process, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($process, CURLOPT_FOLLOWLOCATION, 1); 
		$return = curl_exec($process); 
		curl_close($process); 
		return $return; 
	} 
	
	//Curl post Method
	public function post($data = array()) 
	{ 
		$process = curl_init($this->curlUrl); 
		curl_setopt($process, CURLOPT_HTTPHEADER, $this->headers); 
		curl_setopt($process, CURLOPT_HEADER, 1); 
		curl_setopt($process, CURLOPT_TIMEOUT, 30); 
		curl_setopt($process, CURLOPT_POSTFIELDS, $data); 
		curl_setopt($process, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($process, CURLOPT_FOLLOWLOCATION, 1); 
		curl_setopt($process, CURLOPT_POST, 1); 
		$return = curl_exec($process); 
		curl_close($process); 
		return $return; 
	}
}
