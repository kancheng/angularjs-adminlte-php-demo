<?php

header("Content-Type: application/json");

$routes = array_slice($routes, 1);
$error = true;
$data = null;
$message = "Not Found";

$draw            = 1;
$recordsTotal    = 0;
$recordsFiltered = 0;
$debug = false;

$post =  $_POST;
if ($_POST) {
    foreach ($_POST as $key => $value) {
        if (is_string($value)) {
            $_POST[$key] = mysqli_escape_string($conn, $_POST[$key]);
        }
    }
}
$page   = isset( $post['page'] ) ? $post['page'] : 0;
$length = isset( $post['length'] ) ? $post['length'] : 10;
$offset = $page * $length;
mysqli_set_charset( $conn, 'utf8' );

include join("/", $routes).".php";

if ( isset( $from ) && $recordsTotal == 0 ) {
	$r               = mysqli_query( $conn, "SELECT COUNT(1) as total $from" );
	$total           = mysqli_fetch_assoc( $r );
	$recordsTotal    = $total["total"];
	$recordsFiltered = $total["total"];
}

if ($error == true) {
    $output = new stdClass();
    $output->error = true;
    $output->success = false;
    $output->message = $message;
    $output->data = $data;
	$output->draw            = $draw;
	$output->recordsTotal    = $recordsTotal;
	$output->recordsFiltered = $recordsFiltered;
	$output->debug = $debug;
} else {
    $output = new stdClass();
    $output->error = false;
    $output->success = true;
    $output->message = $message;
    $output->data = $data;
	$output->draw            = $draw;
	$output->recordsTotal    = $recordsTotal;
	$output->recordsFiltered = $recordsFiltered;
	$output->debug = $debug;
}
if(isset($infom))
    $output->infom = $infom;
print_r(json_encode($output));

mysqli_close($conn);

?>