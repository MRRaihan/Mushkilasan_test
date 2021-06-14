<?php
/**
 * These parameters need to be configured before the script can
 * work. You would receive these paramters from Credimax when you
 * submit the application for an online credit card processing
 * account.
 */

$CONFIG = array(
	"script-out"    => "https://mushkilasan.com/test/credimax/out.php", // The script that redirects the user out
	"script-in"	    => "https://mushkilasan.com/test/credimax/in.php", // The callback URL, once payment is complete
	"merchant"      => "E16175950", // Replace this with your Merchant key from Credimax
	"access_code"  	=> "VoL@#2020", // Replace this with your Access Code from Credimax
	"secure_secret" => "a70980834a720e7c80d9203d38576b99" // Replace this with your Secure Secret from Credimax
	);
?>
