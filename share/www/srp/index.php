<?php

define('PROXY_START', microtime(true));

require "vendor/autoload.php";
require_once "share.inc";
require_once "sec/secure.inc";
require_once "ctrl.inc";

use Proxy\Http\Request;
use Proxy\Http\Response;
use Proxy\Plugin\AbstractPlugin;
use Proxy\Event\FilterEvent;
use Proxy\Config;
use Proxy\Proxy;

// check privilege
if (!secure_privilege("srp_link")) {
  http_error(403);
  die('Access denied.');
}

// load config...
Config::load('./config.php');

// custom config file to be written to by a bash script or something
Config::load('./custom_config.php');

if(!Config::get('app_key')){
	die("app_key inside config.php cannot be empty!");
}

if(!function_exists('curl_version')){
	die("cURL extension is not loaded!");
}

// how are our URLs be generated from this point? this must be set here so the proxify_url function below can make use of it
if(Config::get('url_mode') == 1){
	Config::set('encryption_key', md5(Config::get('app_key').$_SERVER['REMOTE_ADDR']));
} else if(Config::get('url_mode') == 2){
	Config::set('encryption_key', md5(Config::get('app_key').session_id()));
}

// very important!!! otherwise requests are queued while waiting for session file to be unlocked
session_write_close();

$srp = cfg("srpaddress");

if(!empty($srp)) {
	$url = 'https://'.$srp.':445/'; 
} else {
	$url = '';
}

if (isset($_GET['q'])) {
	// FIX: Port is lost during encryption
	$url = str_replace($srp."/", $srp.":445/", base64_decrypt($_GET['q']));
}

if($url !== "") {
	$proxy = new Proxy();

	// load plugins
	foreach(Config::get('plugins', array()) as $plugin) {

		$plugin_class = $plugin.'Plugin';
	
		if(file_exists('./plugins/'.$plugin_class.'.php')){
	
			// use user plugin from /plugins/
			require_once('./plugins/'.$plugin_class.'.php');
		
		} else if(class_exists('\\Proxy\\Plugin\\'.$plugin_class)){
	
			// does the native plugin from php-proxy package with such name exist?
			$plugin_class = '\\Proxy\\Plugin\\'.$plugin_class;
		}
	
		// otherwise plugin_class better be loaded already through composer.json and match namespace exactly \\Vendor\\Plugin\\SuperPlugin
		$proxy->getEventDispatcher()->addSubscriber(new $plugin_class());
	}	

	try {

		// request sent to index.php
		$request = Request::createFromGlobals();
	
		// remove all GET parameters such as ?q=
		$request->get->clear();
	
		// forward it to some other URL
		$response = $proxy->forward($request, $url);
	
		// if that was a streaming response, then everything was already sent and script will be killed before it even reaches this line
		$response->send();
	
	} catch (Exception $e) {
		PageBlue("Schulrouter Plus", "tfk/srp");
		echo "<strong>".icon("dlg-error")._("Error during connect to the Schulrouter Plus: ").$e->getMessage()."</strong>";
		_PageBlue();
	}

} else {
        PageBlue("Schulrouter Plus", "tfk/srp");
	echo icon("dlg-info")._("Please configure initally the address of the Schulrouter Plus in iservcfg.");
	_PageBlue();
}
?>
