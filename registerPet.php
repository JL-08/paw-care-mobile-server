<?php 

require "conn.php";
// $email = $_POST["email"];
// $name = $_POST["name"];
// $age = $_POST["age"];
// $type = $_POST["type"];
// $breed = $_POST["breed"];
// $height = $_POST["height"];
// $weight = $_POST["weight"];

$email = 'janelle@gmail.com';
$name = 'Bruno';
$age = 6;
$type = 'Dog';
$breed = 'German Shepherd';
$height = 35;
$weight = 30;

$sql = "SELECT id FROM users WHERE email = '$email'";
$stmt = $conn->prepare($sql);
$stmt->execute();
$stmt->bind_result($user_id);
$data = array(); 
while($stmt->fetch()){
    $temp = [
        'id'=>$user_id,
    ];
    array_push($data, $temp);
}

date_default_timezone_set('Asia/Manila');
$date = new DateTime();
$current_date = $date->format('Y-m-d H:i:s');

$mysql_qry = "insert into pets (name, breed, weight, height, age, created_at, updated_at, owner_id) 
values ('$name','$breed','$weight','$height','$age', '$current_date', '$current_date', '{$data[0]['id']}')";

if($conn->query($mysql_qry) == TRUE){
	echo json_encode("Success");
	
}else{
	echo json_encode("Error: ".$mysql_qry."<br>".$conn->error);
}

$conn->close();
?>