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
$email = 'anne@gmail.com';
$password = sha1('test123');

$data = array(); 
$sql = "SELECT `id`, `email`, `name`, `mobile_num`, `email_verified_at`, `img_name` FROM users WHERE email = '$email' and password = '$password';";
 
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

if($data[0]['email_verified_at'] == null){
    echo json_encode('Account is not yet verified.');
}else{
    $result = json_encode($data);

    if($result != "[]"){
        echo $result;
    }else{
        echo json_encode('Incorrect email or password.');
    }
}


$conn->close();

?>