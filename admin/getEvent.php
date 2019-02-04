<?php 
include'../config/db.php';
include'../config/main_function.php';
        $max = single_get("*","setting_id","site_settings","3");

        $result = $dbcon->query("SELECT * FROM reservations INNER JOIN user_account on user_account.user_id = reservations.user_id WHERE reservation_status != 'Draft' AND reservation_status != 'Cancelled'") or die(mysqli_error());
        $events = array();
        while ($row = $result->fetch_array()) {
            $full = $dbcon->query("SELECT * FROM reservations WHERE event_date = '".$row['event_date']."' AND reservation_status != 'Draft'") or die(mysqli_error());
            $count = mysqli_num_rows($full);
            if($count >= $max['setting_value']){
                $mycolor = 'red';
            }else{
                $mycolor = '#069';
            }
            $e = array();
            $e['id'] = "";
            $e['title'] = $row['full_name'];
            $e['start'] = $row['event_date'];
            $e['end'] = "";
            $e['color'] = $mycolor;
            $e['url'] = 'http://tratskitchenette.study-call.com/admin/other-reservation.php?tcode='.$row['tcode'].'&tab=1';
            //$e['allDay'] = false;

        // Merge the event array into the return array
        array_push($events, $e);
        }
    echo json_encode($events);

?>