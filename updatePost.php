<?php

require "conn.php";
$json = json_decode(file_get_contents('php://input'), true);

$title = $json['title'];
$body = $json['body'];
$post_id = $json['post_id'];

    date_default_timezone_set('Asia/Manila');
    $newdate = new DateTime();
    $current_date = $newdate->format('Y-m-d H:i:s');
    $mysql_qry = "UPDATE posts SET title = '$title', body = '$body', updated_at = '$current_date' WHERE id = '$post_id'";
	
    if($conn->query($mysql_qry) == TRUE){
        echo json_encode("The post has been updated.");
    }else{
	    echo json_encode("Error: ".$mysql_qry."<br>".$conn->error);
    }


?>