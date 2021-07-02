<?php
require 'conn.php';
$json = json_decode(file_get_contents('php://input'), true);

$user_id = $json["user_id"];
//$user_id = 19;

$data = array(); 
 
$sql = "SELECT a.id, a.start_date, a.type, a.reason ,a.status, a.is_approved, a.is_completed, a.meeting_link, v.name, v.specialization, p.name
        FROM appointments AS a JOIN veterenarians as v ON a.vet_id=v.id JOIN pets as p ON a.pet_id=p.id WHERE a.user_id = $user_id;";
$stmt = $conn->prepare($sql);
$stmt->execute();
$stmt->bind_result($id, $start_date, $type, $reason, $status, $is_approved, $is_completed, $meeting_link, $vet_name, $vet_specialization, $pet_name);
 
while($stmt->fetch()){
 
 $temp = [
 'id'=>$id,
 'start_date'=>$start_date,
 'type'=>$type,
 'reason'=>$reason,
 'status'=>$status,
 'is_approved'=>$is_approved,
 'is_completed'=>$is_completed,
 'meeting_link'=>$meeting_link,
 'vet_name'=>$vet_name,
 'vet_specialization'=>$vet_specialization,
 'pet_name'=>$pet_name,
 ];
 
 array_push($data, $temp);
}
 
echo json_encode($data);

$conn->close();
?>