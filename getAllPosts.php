<?php
require 'conn.php';

$data = array(); 
 
$sql = "SELECT p.id, p.title, p.body, p.img_name, p.created_at, v.name
        FROM posts AS p JOIN veterenarians as v ON p.vet_id=v.id ORDER BY p.created_at DESC LIMIT 20;";

$stmt = $conn->prepare($sql);
$stmt->execute();
$stmt->bind_result($id, $title, $body, $img_name, $created_at, $vet_name);
 
while($stmt->fetch()){
 
 $temp = [
 'id'=>$id,
 'title'=>$title,
 'body'=>$body,
 'img_name'=>$img_name,
 'created_at'=>$created_at,
 'vet_name'=>$vet_name,
 ];
 
 array_push($data, $temp);
}
 
echo json_encode($data);

$conn->close();
?>