<?php 
include'../config/db.php';
        
        $result = $dbcon->query("SELECT * FROM reservations INNER JOIN user_account on user_account.user_id = reservations.user_id") or die(mysqli_error());
        $events = array();
        while ($row = $result->fetch_array()) {
            $e = array();
            $e['id'] = "";
            $e['title'] = $row['full_name']."";
            $e['start'] = $row['event_date'];
            $e['end'] = "";
            //$e['allDay'] = false;

        // Merge the event array into the return array
        array_push($events, $e);
        }
    echo json_encode($events);

?>