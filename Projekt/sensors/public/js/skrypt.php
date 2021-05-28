<?php
class Database
    
$sql = "SELECT * FROM waypoint";

$dbhost = "localhost";
$dbuser = "SENSOR";
$dbpass = "haslosensora";
$dbname = "sensors";
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

$result = mysqli_query($conn, $sql);

$geojson = array('type' => 'FeatureCollection', 'features' => array());

while ($row = mysqli_fetch_assoc($result)) {
    $marker = array(
        'type' => 'Feature',
        'features' => array(
            'type' => 'Feature',
            "geometry" => array(
                'type' => 'Point',
                'coordinates' => array(
                    $row['szerokosc'],
                    $row['dlugosc']
                )
            )
        )
    );
    array_push($geojson['features'], $marker);
}

echo json_encode($geojson);
