<?php

require "conn.php";
$json = json_decode(file_get_contents('php://input'), true);

$post_id = $json["post_id"];

$mysql_qry = "DELETE FROM posts WHERE id = '$post_id'";

if($conn->query($mysql_qry) == TRUE){
	echo "The post has been deleted.";
	
}else{
	echo "Error: ".$mysql_qry."<br>".$conn->error;
}

$conn->close();

?>