<?php

include_once '/var/www/vtc/includes/config.php';
set_time_limit(0);

$query = "select * from schools.school where `COL 1` = 'NEW DELHI'";
$result = mysql_query($query) or die(mysql_error());

if (mysql_num_rows($result) > 0) {
    while ($row = mysql_fetch_array($result)) {
        $id = $row['id'];
        
        $school_name = $row['COL 3'];
        $adr = $row['COL 6'];
        $city = $row['COL 1'];
        $pincode = $row['COL 7'];
        
        
       
       $address = str_replace(' ', '+', $school_name) . ",".  str_replace(' ', '+', $adr) . ','. str_replace(' ', '+', $city). ',Delhi' . ',' . str_replace(' ', '+', $pincode);
       
       
       echo $id . "-" . $address. "<hr />";
$url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . $address . "&key=AIzaSyDpM55wfpCD2ARxmyhb-CljqftzmPYZsOg";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$json = curl_exec($ch);
$output = json_decode($json);
$results = $output->results[0];
$location = $results->geometry->location;
$lat = $location->lat;
$long = $location->lng;
curl_close($ch);

        

        $sql_update = "update schools.school set lat = '$lat', lng='$long' where id = $id";
        //echo $sql_update;
        mysql_query($sql_update) or die(mysql_error());
        echo "Done - " . $id;
        usleep(100000);
    }
}


