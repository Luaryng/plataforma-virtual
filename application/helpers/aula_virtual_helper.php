<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(!function_exists('getMaxSizeUpload')){
	function getMaxSizeUpload(){
		return 30;
	}
}

if(!function_exists('getMaxCountFileUpload')){
	function getMaxCountFileUpload(){
		return 10;
	}
}



