<?php
//Defines system constant
define("SSC", "Secure System Constant");

//Loads requirement files
require ("core/config.php");
require ("../core/libs/Smarty.class.php");
require ("../core/model/class.database.php");
require ("../core/model/class.common.php");
require ("../core/model/class.account.php");
require ("core/class.data.php");
require ("../core/model/class.statistics.php");

$system = new Smarty();
$db = new Database();
$common = new Common();
$objAccount = new Account();
$objData = new Data();
$statistics = new Statistics();

//$smarty->force_compile = true;
$system->debugging = false;
$system->caching = false;
$system->cache_lifetime = 120;

//Checks for language change
if (isset($_GET['lang']) && !empty($_GET['lang'])){
	$_SESSION['lang'] = $_GET['lang'];
	$common->redirect();
}

//Checks for language
if (!isset($_SESSION['lang']) || empty($_SESSION['lang'])){
	$_SESSION['lang'] = "en";
	include (LANGUAGE_PATH ."/". $_SESSION['lang'] ."/general.php");
}
else{
	include (LANGUAGE_PATH ."/". $_SESSION['lang'] ."/general.php");
}

//Checks for preload file
if (file_exists(INCLUDE_PATH ."/preload.php")){
	include (INCLUDE_PATH ."/preload.php");
}

//Displays the header
$system->display(VIEW_PATH ."/header.html");

//Checks for content page
if (isset($_GET) && !empty($_GET)){
	if (file_exists(CONTROLLER_PATH ."/". $_GET['page'] .".php")){
		include (CONTROLLER_PATH ."/". $_GET['page'] .".php");
	}
	else{
		//Displays the menu plugins
		include (INCLUDE_PATH ."/page.php");
	}
}
else{
	include (CONTROLLER_PATH ."/home.php");
}

//Displays the sidebox plugins
include (INCLUDE_PATH ."/sidebox.php");

//Displays the footer
$system->display(VIEW_PATH . "/footer.html");

//Checks for postload file
if (file_exists(INCLUDE_PATH ."/postload.php")){
	include (INCLUDE_PATH ."/postload.php");
}