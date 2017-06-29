<?php
function get_systemDay() {
    global $db;
    $query = '
        SELECT *
        FROM systemDay';
           
          
    
    try {
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetch();
        $statement->closeCursor();
        $current_day = $result['dayNumber'];
        return $current_day;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}
function update_systemDay($day) {
    global $db;
    $query = 
        'UPDATE systemDay SET dayNumber = :day';
           
          
    
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':day', $day);
        $statement->execute();
        $statement->closeCursor();
        
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}
?>
