<?php

require "conn.php";
$json = json_decode(file_get_contents('php://input'), true);

$sample = $_POST['form'];
$sample = str_replace(str_split('\\"{}'),'', $sample);
$data_arr = (explode(",",$sample));

$title = formatInput($data_arr[0]);
$body = formatInput($data_arr[1]);
$vet_id = formatInput($data_arr[2]) + 0;


$filename = rand() . '_' . time() . '.jpeg';
$target_dir = "upload/images";
$target_dir = $target_dir . '/' . $filename;

if(move_uploaded_file($_FILES['image']['tmp_name'], $target_dir)){
    date_default_timezone_set('Asia/Manila');
    $newdate = new DateTime();
    $current_date = $newdate->format('Y-m-d H:i:s');
    $mysql_qry = "insert into posts (title, body, img_name, vet_id, created_at, updated_at) 
    values ('$title','$body','$filename','$vet_id','$current_date', '$current_date')";
	
    if($conn->query($mysql_qry) == TRUE){
        echo json_encode("The post has been created.");
    }else{
	    echo json_encode("Error: ".$mysql_qry."<br>".$conn->error);
    }
}else{
    echo json_encode("Error on uploading image");
}

function formatInput($str) {
    return substr($str, strpos($str, ":") + 1);
}

?>