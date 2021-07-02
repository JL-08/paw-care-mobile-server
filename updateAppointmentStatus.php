<?php

require "conn.php";
$json = json_decode(file_get_contents('php://input'), true);

$appointment_id = $json["appointment_id"];
$status = $json["status"];
// $appointment_id = 17;
// $status = 'cancelled';

		date_default_timezone_set('Asia/Manila');
		$date = new DateTime();
		$current_date = $date->format('Y-m-d H:i:s');
		
		$mysql_qry = "UPDATE appointments SET status = '$status', updated_at = '$current_date' WHERE id = '$appointment_id';";

		if($conn->query($mysql_qry) == TRUE){
            if($status == 'approved'){
                echo "Appointment Accepted";
            }

            if($status == 'rejected'){
                echo "Appointment Rejected";
            }

            if($status == 'cancelled'){
                echo "Appointment Cancelled";
            }
		}else{
			echo "Error: ".$mysql_qry."<br>".$conn->error;
		}

$conn->close();

?>