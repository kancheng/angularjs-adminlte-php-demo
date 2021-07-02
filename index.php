<?php
date_default_timezone_set( 'Asia/Taipei' );
setlocale( LC_TIME, "zh_TW.UTF-8" );

session_start();

require_once "vendor/autoload.php";
require_once "conf.php";
require_once "models/db.php";
require_once "models/controllers.php";

$route = $_SERVER['REQUEST_URI'];
$data          = new stdClass();


switch ( $routes[0] ) {
	case "home":
		//$data->title_name = "intro";
		$view = "intro";
		break;
	default:
		//$data->title_name = "Home";
		$view          = "home";
}


if ( $routes[0] != 'home' && $view == 'home' && is_file( "views/" . $routes[0] . ".php" ) ) {
	$view = $routes[0];
}

if ( empty( $view ) ) {
	die( 'Not found. Please check again....' );
}

include "views/" . $view . ".php";

exit();

?>
