<?php 

require "conn.php";
$json = json_decode(file_get_contents('php://input'), true);

$user_id = $json["user"];
$vet_id = $json["vet"];
$pet_id = $json["pet"];
$start_date = $json["date"];
$end_date = $json["end_date"];
$type = $json["type"];
$reason = $json["reason"];
// $user_id = 10;
// $vet_id = 1;
// $pet_id = 6;
// $current_date = new DateTime();
// $date = $current_date->format('Y-m-d H:i:s');
// $type = 'online';
// $reason = 'something';

$sql = "SELECT * FROM appointments WHERE start_date = '$start_date'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
	date_default_timezone_set('Asia/Manila');
	$newdate = new DateTime();
	$current_date = $newdate->format('Y-m-d H:i:s');

    $mysql_qry = "insert into appointments (user_id, vet_id, pet_id, start_date, end_date, type, reason, status, is_approved, is_completed, created_at) 
	values ('$user_id','$vet_id','$pet_id','$start_date', '$end_date','$type', '$reason', 'pending', 0, 0, '$current_date')";
	
	if($conn->query($mysql_qry) == TRUE){
	    echo json_encode("You have successfully booked this appointment.");
	}else{
		echo json_encode("Error: ".$mysql_qry."<br>".$conn->error);
	}
}else{
	echo json_encode("Sorry, this date isn't available. Please book on a different date or time.");
}

$conn->close();

?>