<?php

	$result = [
		"status"=>"OK",
		"fin_cust_id"=> $_POST["fin_cust_id"]
	];
	header('Content-Type: application/json');
	echo json_encode($result);
?>