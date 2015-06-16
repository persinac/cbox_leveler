<?php
/**
 * Created by PhpStorm.
 * User: apersinger
 * Date: 05/13/15
 * Time: 1:34 PM
 */

$user_id = $_POST['user_id'];

$url = "https://maps.googleapis.com/maps/api/geocode/json?address=13909+greenfield+ave,+MD,+USA&sensor=false&key=AIzaSyDHN37EBR7xSeW4kXGdN0BnYE6Kvuzgs2U";
$new_retval = new stdClass();
$retVal = MakeCURLCall($url);

$events = new stdClass();

$events->id = 1;
$events->lat = 39.6551649;
$events->long = -77.705466;
$events->event_name = "Comp 1 Here";
$events->host_box = "Test Box";
$events->level = 13;
$events->date = "5/23/15";
$events->state = "MD";
$event_arr[] = $events;

$events = new stdClass();
$events->id = 2;
$events->lat = 39.664788;
$events->long = -77.710757;
$events->event_name = "Elite Games";
$events->host_box = "Crossfit 301 Elite";
$events->level = 50;
$events->date = "5/23/15";
$events->state = "MD";
$event_arr[] = $events;

$events = new stdClass();
$events->id = 3;
$events->lat = 39.3711483;
$events->long = -77.4083306;
$events->event_name = "CFF Cookout Comp";
$events->host_box = "Crossfit Frederick";
$events->level = 40;
$events->date = "5/30/15";
$events->state = "MD";
$event_arr[] = $events;

$events = new stdClass();
$events->id = 4;
$events->lat = 39.163699;
$events->long = -78.1713709;
$events->event_name = "Weightlifting Extravaganza";
$events->host_box = "Evolution Strength and Conditioning";
$events->level = 20;
$events->date = "5/16/15";
$events->state = "VA";
$event_arr[] = $events;

$new_retval->url_ret = $retVal;
$new_retval->events = $event_arr;

echo json_encode($new_retval);

function MakeCURLCall($url_to_exec, $whereDidIComeFrom = "") {
    $ch = curl_init();
    curl_setopt_array($ch, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => $url_to_exec
    ));
    $result = curl_exec($ch);
    //$this->insertIntoAPILog($url_to_exec, substr($result, 0, 1000), $whereDidIComeFrom);
    curl_close($ch);
    return $result;
}