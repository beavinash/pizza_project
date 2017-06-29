<?php

/* PROJECT 2*/
function get_inventory($db) {
    $query = 'SELECT * FROM inventory';    
    $statement = $db->prepare($query);
    $statement->execute();    
    $inventory = $statement->fetch();
    $statement->closeCursor();
    return $inventory;
}

/* PROJECT 2 */
function decrease_inventory($db) {
    $query = 'UPDATE inventory SET flour = flour - 1, cheese = cheese -1';
    $statement = $db->prepare($query);
    $statement->execute();
    $statement->closeCursor();
}

/* PROJECT 2 */
function get_undelivered_orders($db) {
    $query = 'SELECT * FROM undelivered_orders';
    $statement = $db->prepare($query);
    $statement->execute();
    $undelivered_orders = $statement->fetchAll();
    $statement->closeCursor();   
    return $undelivered_orders;
}