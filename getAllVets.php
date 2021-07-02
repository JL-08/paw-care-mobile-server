<?php
require 'conn.php';

$data = array(); 
 
$sql = "SELECT v.id,v.name, v.clinic_id, v.specialization, v.availability_day, v.availability_time,c.name, c.location, c.latitude, c.longitude
        FROM veterenarians AS v JOIN clinics as c ON v.id=c.veterenarian_id;";
$stmt = $conn->prepare($sql);
$stmt->execute();
$stmt->bind_result($id, $name, $clinic_id, $specialization, $availability_day, $availability_time, $clinic_name, $location, $latitude, $longitude);
 
while($stmt->fetch()){
 
 $temp = [
 'id'=>$id,
 'name'=>$name,
 'clinic_id'=>$clinic_id,
 'specialization'=>$specialization,
 'availability_day'=>$availability_day,
 'availability_time'=>$availability_time,
 'clinic_name'=>$clinic_name,
 'location'=>$location,
 'latitude'=>$latitude,
 'longitude'=>$longitude,
 ];
 
 array_push($data, $temp);
}
 
echo json_encode($data);

$conn->close();
?>