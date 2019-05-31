<?php
	//$appid = $_POST["appid"];	
	$customers = [];
	for($i = 0; $i< 20;$i++){
		$customer = [
			"fin_cust_id"=> 1000 + $i,
			"fst_cust_name"=> "Name of customer $i",
			"fst_cust_address" => "Customer Address at address $i",
			"fst_cust_phone" => "Phone Number $i",
			"fin_visit_day" => rand(1,7),
			"fst_cust_location" => null
		];
		
		$customers[] = $customer;
	}
	sleep(10);
	header("Content-Type: application/json");	
	$result = [
		"post" => $_POST,
		"status"=>"OK",
		"message"=>"OK",
		"data"=>$customers
	];	
	echo json_encode($result);
	
?>