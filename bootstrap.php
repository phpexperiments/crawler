<?php
include_once('config/config.php');
if(!PRODUCTION){
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
}
include_once('AutoLoader.php');
// Register the directory to your include files
AutoLoader::registerDirectory('classes');
