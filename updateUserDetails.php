<?php

require "conn.php";
$json = json_decode(file_get_contents('php://input'), true);

$id = $json['user_id'];
$email = $json['email'];
$mobile_num = $json['mobile_num'];
$password = sha1($json['password']);

$sql = "SELECT * FROM users WHERE id = '$id' AND password = '$password';";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    date_default_timezone_set('Asia/Manila');
    $newdate = new DateTime();
    $current_date = $newdate->format('Y-m-d H:i:s');
    $mysql_qry = "UPDATE users SET email = '$email', mobile_num = '$mobile_num', updated_at = '$current_date' WHERE id = '$id'";
        
    if($conn->query($mysql_qry) == TRUE){
        echo json_encode("Your profile has been updated.");
    }else{
        //echo json_encode("Something wen't wrong. Please try again.");
        echo json_encode("Error: ".$mysql_qry."<br>".$conn->error);
    }
}else{
    echo json_encode("Incorrect Password");
}



?>