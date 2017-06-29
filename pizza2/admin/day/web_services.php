<?php
// Functions to do the base web services needed
// Note that all needed web services are sent from this day directory
// The functions here should throw up to their callers, just like
// the functions in model.
//
// Post day number to server
// Returns if successful, or throws if not

// Client-side REST, for pizza2 project
require_once('../../util/main.php');
// use Composer autoloader, so we don't have to require Guzzle PHP files
require '../../vendor/autoload.php';


function post_day($day) {
    error_log('post_day to server: ' . $day);

    $httpClient = new \GuzzleHttp\Client();
	$base_url = 'topcat.cs.umb.edu/cs637/tamaro/proj2/proj2_server/rest';
	$url = 'http://' . $base_url . '/day/';

	try {
	    $response = $httpClient->request('POST', $url, ['json' => $day]);
	    $status = $response->getStatusCode();
	    $status = 'POST failed, error = ' . $e;
	} catch (GuzzleHttp\Exception $e) {
	    error_log($status);
	    include '../errors/error.php';  // Note new error.php code that handles Exceptions
	}
}

function get_server_day() {
	$httpClient = new \GuzzleHttp\Client();
	$base_url = 'topcat.cs.umb.edu/cs637/tamaro/proj2/proj2_server/rest';
	$url = 'http://' . $base_url . '/day/';

	try {
	    $response = $httpClient->get($url);
	    $day = $response->getBody();
	    echo "<script type='text/javascript'>alert('GET:".$day."');</script>";
	} catch (Exception $e) {
	    include '../errors/error.php'; 
	}
}

function post_initial_day() {
    error_log('post_day to server: ' . $day);

    $httpClient = new \GuzzleHttp\Client();
	$base_url = 'topcat.cs.umb.edu/cs637/tamaro/proj2/proj2_server/rest';
	$url = 'http://' . $base_url . '/day/';

	try {
	    $response = $httpClient->request('POST', $url, ['json' => 1]);
	    $status = $response->getStatusCode();
	} catch (GuzzleHttp\Exception $e) {
	    $status = 'POST failed, error = ' . $e;
	    error_log($status);
	    include '../errors/error.php';  // Note new error.php code that handles Exceptions
	}
}

function get_order_status($id) {
	$httpClient = new \GuzzleHttp\Client();
	$base_url = 'topcat.cs.umb.edu/cs637/tamaro/proj2/proj2_server/rest';
	$url = 'http://' . $base_url . '/orders/' . $id;

	try {
	    $response = $httpClient->get($url);
	    $prodJson = $response->getBody()->getContents();
	    $order = json_decode($prodJson, true);
	    return $order;
	} catch (Exception $e) {
	    include '../errors/error.php'; 
	}
}



// TODO: POST order and get back location (i.e., get new id), get all orders 
// in server and/or get a specific order by orderid

