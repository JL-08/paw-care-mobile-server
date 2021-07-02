<?php
require 'conn.php';
$json = json_decode(file_get_contents('php://input'), true);

$vet_id = $json["vet_id"];

$data = array(); 
 
$sql = "SELECT a.id, a.start_date, a.type, a.reason, a.status, a.meeting_link, u.name, u.mobile_num, p.name, p.age, p.type, p.breed, p.weight, p.height
        FROM appointments AS a
        JOIN users as u ON a.user_id=u.id
        JOIN pets as p ON a.pet_id=p.id
        WHERE a.vet_id = $vet_id;";

$stmt = $conn->prepare($sql);
$stmt->execute();
$stmt->bind_result($id, $start_date, $type, $reason, $status, $meeting_link, $user_name, $user_mobile_num, $pet_name, $pet_age, $pet_type, $pet_breed, $pet_weight, $pet_height);
 
while($stmt->fetch()){
 
 $temp = [
 'id'=>$id,
 'start_date'=>$start_date,
 'type'=>$type,
 'reason'=>$reason,
 'status'=>$status,
 'meeting_link'=>$meeting_link,
 'user_name'=>$user_name,
 'user_mobile_num'=>$user_mobile_num,
 'pet_name'=>$pet_name,
 'pet_age'=>$pet_age,
 'pet_type'=>$pet_type,
 'pet_breed'=>$pet_breed,
 'pet_weight'=>$pet_weight,
 'pet_height'=>$pet_height,
 ];
 
 array_push($data, $temp);
}
 
echo json_encode($data);

$conn->close();
?>