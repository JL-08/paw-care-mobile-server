<?php
require 'conn.php';
$json = json_decode(file_get_contents('php://input'), true);
 
$user_id = $json["user_id"];

$data = array(); 
 
$sql = "SELECT `id`, `name`, `type`, `breed`, `weight`, `height`, `age` FROM pets WHERE owner_id = '$user_id';";
$stmt = $conn->prepare($sql);
$stmt->execute();
$stmt->bind_result($id, $name, $type, $breed, $weight, $height, $age);
 
while($stmt->fetch()){
 
 $temp = [
 'id'=>$id,
 'name'=>$name,
 'type'=>$type,
 'breed'=>$breed,
 'weight'=>$weight,
 'height'=>$height,
 'age'=>$age
 ];
 
 array_push($data, $temp);
}
 
echo json_encode($data);

$conn->close();
?>