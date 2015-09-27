<?php

include_once '/var/www/vtc/includes/config.php';
set_time_limit(0);

$query = "SELECT * FROM schools.school where lng <> '' and `COL 1` = 'NEW DELHI'";
$result = mysql_query($query) or die(mysql_error());
$i = 1;
if (mysql_num_rows($result) > 0) {
    $schools = array();
    while ($row = mysql_fetch_array($result)) {
        $id = $row['id'];
        $school_id = $row['id'];
        $school_name = $row['COL 3'];
        $lat = floatval($row['lat']);
        $lng = floatval($row['lng']);

        $location = array("location" => array('name' => $school_name, 'lat' => $lat, 'lng' => $lng), "start" => "10:00", "end" => "14:00", "duration" => 5);

        $schools["$school_id"] = $location;


        $i++;
    }
    $location_1 = array('id' => "depot", 'name' => "Kitchen", 'lat' => 28.6746196, 'lng' => 77.1801757);
    $vehicle_1 = array('start_location' => $location_1, 'end_location' => $location_1, 'shift_start' => "10:00", 'shift_end' => "16:00");
    $vehicle_2 = array('start_location' => $location_1, 'end_location' => $location_1, 'shift_start' => "10:00", 'shift_end' => "16:00");
    $fleet = array('vehicle_1' => $vehicle_1, 'vehicle_2' => $vehicle_2);
    $meal = array('visits' => $schools, 'fleet' => $fleet);
}
$json_data = json_encode($meal);
//echo $json_data;
$url = "https://api.routific.com/v1/vrp";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Authorization: bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJfaWQiOiI1MzEzZDZiYTNiMDBkMzA4MDA2ZTliOGEiLCJpYXQiOjEzOTM4MDkwODJ9.PR5qTHsqPogeIIe0NyH2oheaGR-SJXDsxPTcUQNq90E'
));
$json = curl_exec($ch);
$f_output = json_decode($json);
curl_close($ch);
echo "Total travel time: " . $f_output->total_travel_time;
echo "<hr />";
$vehicle_1 = $f_output->solution->vehicle_1;
$vehicle_2 = $f_output->solution->vehicle_2;
echo "<table border='1'>";
foreach ($vehicle_1 as $val) {
    if ($val->location_id != "depot") {
        $query_lat = "SELECT * FROM schools.school where id = $val->location_id";
        $result_lat = mysql_query($query_lat) or die(mysql_error());
        if (mysql_num_rows($result_lat) > 0) {
            $row_lat = mysql_fetch_array($result_lat);
            $lat = $row_lat['lat'];
            $long = $row_lat['lng'];
        }
    } else {
        $lat = 28.6746196;
        $long = 77.1801757;
    }

    echo "<tr><td>" . $val->location_id . "</td><td>" . $val->location_name . "</td><td>" . $val->arrival_time . "</td><td>" . $val->finish_time . "</td><td>" . $lat . "</td><td>" . $lng . "</td></tr>";
}
echo "</table>";
echo "<hr />";
echo "<table border='1'>";
foreach ($vehicle_2 as $val) {
    if ($val->location_id != "depot") {
        $query_lat = "SELECT * FROM schools.school where id = $val->location_id";
        $result_lat = mysql_query($query_lat) or die(mysql_error());
        if (mysql_num_rows($result_lat) > 0) {
            $row_lat = mysql_fetch_array($result_lat);
            $lat = $row_lat['lat'];
            $long = $row_lat['lng'];
        }
    } else {
        $lat = 28.6746196;
        $long = 77.1801757;
    }

    echo "<tr><td>" . $val->location_id . "</td><td>" . $val->location_name . "</td><td>" . $val->arrival_time . "</td><td>" . $val->finish_time . "</td><td>" . $lat . "</td><td>" . $lng . "</td></tr>";
}
echo "</table>";



