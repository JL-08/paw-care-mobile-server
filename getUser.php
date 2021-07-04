<?php
require "conn.php";
if ($conn->connect_error) {
    die();
    echo json_encode("Connection Failed");
}
$json = json_decode(file_get_contents('php://input'), true);
 
$id = $json["user_id"];

$data = array(); 
$sql = "SELECT `id`, `email`, `name`, `mobile_num`, `email_verified_at`, `img_name` FROM users WHERE id = '$id';";
 
$stmt = $conn->prepare($sql);
$stmt->execute();
$stmt->bind_result($id, $email, $name, $mobile_num, $email_verified_at, $img_name);
 
while($stmt->fetch()){
 $temp = [
 'user_id'=>$id,
 'email'=>$email,
 'name'=>$name,
 'mobile_num'=>$mobile_num,
 'email_verified_at'=>$email_verified_at,
 'img_name'=>$img_name
 ];
 
 array_push($data, $temp);
}

$result = json_encode($data);

if($result != "[]"){
    echo $result;
}


$conn->close();

?>