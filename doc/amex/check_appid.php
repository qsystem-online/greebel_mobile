<?php
	if (isset($_POST["app_id"])){
		$appId = $_POST["app_id"];
		$status = "NOK";
		if ($appId == "1234567890"){
			$status = "OK";
		}
				
		$result = [
			"status" => $status,
			"app_id" => $appId			
		];			
	}else{
		$result = [
			"status" => "NOK",
			"app_id" => ""
		];			
	}
		
	
	
	header('Content-Type: application/json');
	echo json_encode($result);
	
?>