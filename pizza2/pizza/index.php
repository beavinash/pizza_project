<?php
require('../util/main.php');
require('../model/database.php');
require('../model/order_db.php');
require('../model/topping_db.php');
require('../model/size_db.php');
require('../model/day_db.php');
require('../model/inventory_db.php');

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action == NULL) {
        $action = 'student_welcome';
    }
}

/* PROJECT 2 */
$inventory = get_inventory($db);
$insufficient_inventory = FALSE;
if ($inventory['flour'] == 0 || $inventory['cheese'] == 0) {
    $insufficient_inventory = TRUE;
}

$room = filter_input(INPUT_POST, 'room', FILTER_VALIDATE_INT);
if ($room == NULL) {
    $room = filter_input(INPUT_GET, 'room');
    if ($room == NULL || $room == FALSE) {
        $room = 1;
    }
}
if ($action == 'student_welcome' || $action == 'select_room') {
    try {
        $sizes = get_sizes($db);
        $toppings = get_toppings($db);
        $room_preparing_orders = get_preparing_orders_of_room($db, $room);
        $room_baked_orders = get_baked_orders_of_room($db, $room);
    } catch (Exception $e) {
        include('../errors/error.php');
        exit();
    }
    include('student_welcome.php');
} else if ($action == 'order_pizza') {
    try {
        $sizes = get_sizes($db);
        $toppings = get_toppings($db);
    } catch (Exception $e) {
        include('../errors/error.php');
        exit();
    }
    include ('order_pizza.php');
} elseif ($action == 'add_order') {
    $size_id = filter_input(INPUT_GET, 'pizza_size', FILTER_VALIDATE_INT);
    $room = filter_input(INPUT_GET, 'room', FILTER_VALIDATE_INT);
    $n = filter_input(INPUT_GET, 'n', FILTER_VALIDATE_INT);
    if (empty($n)) {
        $n = 1; // no input: default to old single order case
    }
    $topping_ids = filter_input(INPUT_GET, 'pizza_topping', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

    if ($size_id == NULL || $size_id == FALSE || $topping_ids == NULL) {
        // string $e will be displayed as is--see errors.php
        $e = "Invalid size or topping data size_id =$size_id, topping_ids = , $topping_ids";
        include('../errors/error.php');
        exit();
    }
    try {
        $current_day = get_current_day($db);
    } catch (Exception $e) {
        include('../errors/error.php');
        exit();
    }
    $status = 'Preparing';

    try {
        for ($i = 0; $i < $n; $i++) {
            /* PROJECT 2 */
            $inventory = get_inventory($db);
            if ($inventory['flour'] == 0 || $inventory['cheese'] == 0) {
                echo "<script type='text/javascript'>alert('No more cheese or flour... Complete your order in another moment...');</script>";
            } else {
                add_order($db, $room, $size_id, $current_day, $status, $topping_ids);
            }
        }
    } catch (Exception $e) {
        include('../errors/error.php');
        exit();
    }
    header("Location: .?room=$room");
} elseif ($action == 'update_order_status') {
    try {
        update_to_finished($db, $room);
    } catch (Exception $e) {
        include('../errors/error.php');
        exit();
    }
    header("Location: .?room=$room");
}
?>