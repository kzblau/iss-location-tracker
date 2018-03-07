<?php 

$url = 'http://api.open-notify.org/iss-now.json';

$contents = file_get_contents($url); 

$results = json_decode($contents);

$zone = $results->iss_position;
$latitude = $zone->latitude;
$longitude = $zone->longitude;


print_r($latitude . "," . $longitude);
?>