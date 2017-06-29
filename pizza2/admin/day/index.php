<?php
require('../../util/main.php');
require('../../model/database.php');
require('../../model/day_db.php');
require('../../model/initial.php');
require('web_services.php');
/* PROJECT 2*/
require('../../model/inventory_db.php');


// Note that you don't have to put all your code in this file.
// You can use another file day_helpers.php to hold helper functions
// and call them from here.

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action == NULL) {
        $action = 'list';
    }
}

/* PROJECT 2 - Testing Day REST call*/
// get_server_day();

/* PROJECT 2 - check and process any Undelivered Supply Orders */
$undelivered_orders = get_undelivered_orders($db);

$current_day = get_current_day($db);
if ($action == 'list') {
    try {
        $todays_orders = get_todays_orders($db, $current_day);

        /* PROJECT 2*/
        $inventory = get_inventory($db);

    } catch (Exception $e) {
        include('../errors/error.php');
        exit();
    }
    include('day_list.php');
} else if ($action == 'next_day') {
    try {
        finish_orders_for_day($db, $current_day);
        increment_day($db);

        /* PROJECT 2 - Update Server*/
        post_day($current_day+1);

        if (!empty($undelivered_orders)) {
            foreach ($undelivered_orders as $undelivered_orders){
                get_order_status($undelivered_orders['id']);
            }
        } else {
            echo "<script type='text/javascript'>alert('EMPTY');</script>";
        }

        header("Location: .");
    } catch (Exception $e) {
        include('../errors/error.php');
        exit();
    }
} else if ($action == 'initial_db') {
    try {
        initial_db($db);

        /* PROJECT 2 */
        post_initial_day();
        
        header("Location: .");
    } catch (Exception $e) {
        include ('../errors/error.php');
        exit();
    } 
}
?>