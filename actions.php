<?php

function pr($data)
{
    echo '<pre>';
    print_r($data);
    echo '<pre>';
}

class Actions {
    static $googleMapsKye = 'AIzaSyBu6ShisHv8uABtNotv6BiQAJqcwHYIAc8';

    static function routing()
    {
        $p0 = 'place_id:'.$_REQUEST['places'][0];
        $p1 = 'place_id:'.$_REQUEST['places'][1];

        $apiKey = self::$googleMapsKye;
        $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=$p0&destinations=$p1&mode=transit&transit_mode=train&key=$apiKey";

        $fileName = time().'.json';

        $apiResponse = Array('status' => 'FAIL');
        if($data = @file_get_contents($url)) {
            $apiResponse = json_decode($data);
        }

        $response = Array();
        $response['url'] = $url;
        $response['data'] = $apiResponse;
        $response['request'] = $_REQUEST;
        echo json_encode($response);
    }
    static function geocoding()
    {
        $apiKey = self::$googleMapsKye;
        $address = $_REQUEST['address'];
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address=$address&key=$apiKey";
        //$url = "place.json";
        $apiResponse = Array('status' => 'FAIL');
        if($data = @file_get_contents($url)) {
            //file_put_contents('place.json', $data);
            $apiResponse = json_decode($data);
        }

        $response = Array();
        $response['url'] = $url;
        $response['data'] = $apiResponse;
        $response['request'] = $_REQUEST;
        echo json_encode($response);
    }
}

if(isset($_REQUEST['action'])) {
    ob_end_clean();
    header('Content-Type: application/json');

    $action = $_REQUEST['action'];
    Actions::$action();

    die();
}