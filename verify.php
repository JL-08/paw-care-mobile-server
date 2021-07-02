<?php 

require "conn.php";
$json = json_decode(file_get_contents('php://input'), true);

$email = $json['email'];
$code = $json['code'];

$sql = "SELECT `verification_code` FROM users WHERE email = '$email'";
$stmt = $conn->prepare($sql);
$stmt->execute();
$stmt->bind_result($verification_code);
$data = array(); 

while($stmt->fetch()){
    $temp = [
        'verification_code'=>$verification_code,
    ];
    array_push($data, $temp);
}

if($data[0]['verification_code'] != $code){
    echo json_encode('Incorrect verification code.');

}else{
    date_default_timezone_set('Asia/Manila');
	$date = new DateTime();
	$current_date = $date->format('Y-m-d H:i:s');

    $mysql_qry = "UPDATE users SET email_verified_at='$current_date' WHERE email='$email'";

    if($conn->query($mysql_qry) == TRUE){
        echo json_encode('Account activated. You can now use your account.');
    }else{
        echo json_encode("Error: ".$mysql_qry."<br>".$conn->error);
    }
}

$conn->close();
?>