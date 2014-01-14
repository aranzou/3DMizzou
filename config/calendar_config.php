<?php
    include_once 'functions_misc.php';

	$year = date('Y');
	$month = date('m');
        
        $calendar = getrsvpeventscalendar();
        
        $event = array();
        
        $count = 0;
        while($count < count($calendar)) {
            if(date("Y-m-d H:i:s") < $calendar[$count]["date"]) {
                $event[$count] = array('color' => $calendar[$count]["color"], 'id' => $calendar[$count]["id"], 'title' => $calendar[$count]["name"], 'start' => date('Y-m-d',strtotime($calendar[$count]["date"])));
            } else {
                $event[$count] = array('color' => "#D8D8D8", 'id' => $calendar[$count]["id"], 'title' => $calendar[$count]["name"], 'start' => date('Y-m-d',strtotime($calendar[$count]["date"])));
            }
            $count++;
        }
        
        echo json_encode($event);      


?>
