<?php 

require "conn.php";
$json = json_decode(file_get_contents('php://input'), true);

$full_name = $json["name"];
$mobile_num = $json["mobile_num"];
$email = $json["email"];
$password = sha1($json["password"]);
$pet_name = $json["pet_name"];
$age = $json["age"];
$type = $json["type"];
$breed = $json["breed"];
$height = $json["height"];
$weight = $json["weight"];
// $full_name = 'Janelle Lacsamana';
// $mobile_num = '0912345679';
// $email = 'janelle@gmail.com';
// $password = sha1('12345678');
// $pet_name = 'Bruno';
// $age = 6;
// $type = 'Dog';
// $breed = 'German Shepherd';
// $height = 35;
// $weight = 30;

$sql = "SELECT * FROM users WHERE email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
	date_default_timezone_set('Asia/Manila');
	$date = new DateTime();
	$current_date = $date->format('Y-m-d H:i:s');
	$hash = substr(md5( rand(0,1000) ), 0, 8);

    $mysql_qry = "insert into users (name, email, mobile_num, password, created_at, updated_at, verification_code) 
	values ('$full_name','$email','$mobile_num','$password','$current_date', '$current_date', '$hash')";
	
	if($conn->query($mysql_qry) == TRUE){
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

		$mysql_qry = "insert into pets (name, type, breed, weight, height, age, created_at, updated_at, owner_id) 
		values ('$pet_name', '$type', '$breed','$weight','$height','$age', '$current_date', '$current_date', '{$data[0]['id']}')";

		if($conn->query($mysql_qry) == TRUE){
			echo json_encode("Registration successful.");
			sendMail($hash, $email);
		}else{
			echo json_encode("Error: ".$mysql_qry."<br>".$conn->error);
		}
		
	}else{
		echo json_encode("Error: ".$mysql_qry."<br>".$conn->error);
	}
}else{
	echo json_encode("This email address already exists.");
}

$conn->close();

function sendMail($hash, $email) {
            include "phpmailer/PHPMailerAutoload.php";
            $gmailUsername = "janellelacsamana@gmail.com"; //Gmail username to be use as sender(make sure that the gmail settings was ON or enable)
            $gmailPassword = "Janelleacc123"; //Gmail Password used for the gmail 
//////////////////////////////////////
            $mail = new PHPMailer();
            $mail->IsSMTP();
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'ssl'; // 
            $mail->Host = "smtp.gmail.com";
            $mail->Port = 465; // or 587
            $mail->IsHTML(true);
            $mail->Username = $gmailUsername;
            $mail->Password = $gmailPassword;
/////////////////////////////////////






            $mail->SetFrom($gmailUsername, "Petsmalu Admin"); //Name of Sender: the "FEU-IT Admin" could be change and replace as the name of the sender


            $mail->Subject = "Verify Your Account"; //Email Subject: to get the subject from the form
            $mail->Body = "Welcome to Petsmalu. Your Petsmalu Account is almost ready. Please enter this code to activate your account: $hash"; //Content of Message : to get the content or body of the email from form

            $mail->AddAddress("janellelacsamana@gmail.com"); //Recepient of email: to send whatever email you want to
			$mail->Send();
		}
?>