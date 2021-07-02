<?php
require "conn.php";
if ($conn->connect_error) {
    die();
    echo json_encode("Connection Failed");
}
header('Content-Type: application/json');
$json = json_decode(file_get_contents('php://input'), true);
 
// $email = $json["email"];
// $password = sha1($json["password"]);
$email = 'aimee@gmail.com';
$password = sha1('test123');

$data = array(); 
$sql = "SELECT `id`, `name`, `email`, `specialization` FROM veterenarians WHERE email = '$email' and password = '$password';";
 
$stmt = $conn->prepare($sql);
$stmt->execute();
$stmt->bind_result($id, $name, $email, $specialization);
 
while($stmt->fetch()){
 $temp = [
 'id'=>$id,
 'name'=>$name,
 'email'=>$email,
 'specialization'=>$specialization,
 ];
 
 array_push($data, $temp);
}

$result = json_encode($data);

if($result != "[]"){
    echo $result;
}else{
    echo json_encode('Incorrect email or password.');
}


$conn->close();

?>