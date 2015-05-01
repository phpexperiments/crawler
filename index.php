<?php
include_once('bootstrap.php');

$ObjCore = new Core();
$setValidRequest = false;

if($ObjCore->isCommandLineInterface()){
	$ObjCore->parseCliArguments($argv);
	if($ObjCore->validateUrl()){
		$setValidRequest = true;
	}
}
else{
	$ObjCore->setCrawlerUrl();
	if($ObjCore->crawlerUrl != ''){
		$setValidRequest = true;
		echo '<pre>';
	}	
}

if($setValidRequest){
	$ObjCore->initExecutionTime();
	$curl = new Curl($ObjCore->crawlerUrl);
	$ObjCore->serCrawlerData($curl->get());		
	$ObjCore->showCrawlerResult();
	$ObjCore->showExecutionTime();
}else{
	echo "Invalid URL!! Enter a valid URL\n";
}

