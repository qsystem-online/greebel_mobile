<?php
use Dompdf\Exception;

defined('BASEPATH') OR exit('No direct script access allowed');

class API extends CI_Controller {

	public function __construct(){
		parent::__construct();
		log_message("info", print_r($_POST,true));
		log_message("info", print_r($_SERVER,true));
	}


	public function index(){
		$this->load->library("menus");
		$main_header = $this->parser->parse('inc/main_header',[],true);
		$main_sidebar = $this->parser->parse('inc/main_sidebar',[],true);
		//$page_content = $this->parser->parse('pages/sample/template_sample',[],true);
		$page_content = "";
		$main_footer = $this->parser->parse('inc/main_footer',[],true);
		//$control_sidebar = $this->parser->parse('inc/control_sidebar',[],true);
		$control_sidebar = NULL;

		$this->data["MAIN_HEADER"] = $main_header;
		$this->data["MAIN_SIDEBAR"] = $main_sidebar;
		$this->data["PAGE_CONTENT"] = $page_content;
		$this->data["MAIN_FOOTER"] = $main_footer;
		$this->data["CONTROL_SIDEBAR"] = $control_sidebar;
		$this->parser->parse('template/main',$this->data);
    }
	
	
    public function feed_customers($returnJson = 1){
		$this->load->model("customer_model");
		$this->load->model("trlogs_model");
		
		$appid = $this->input->post("app_id");	
		//cek last sync data from server
		//if ( $this->trlogs_model->isLastUpdate(date("Y-m-d"),"sync_data") ){
		if (true){
			$customers = $this->customer_model->getDataByAppId($appid);
			$result = [
				"post" => $_POST,
				"status"=>"OK",
				"message"=>"OK",
				"data"=>$customers
			];
		}else{
			$result = [
				"post" => $_POST,
				"status"=>"NOK",
				"message"=>"Data per tgl " . date("Y-m-d") . " not ready yet !"
			];
		}

		if($returnJson === 0){
			return $result;
		}

		header("Content-Type: application/json");	
        echo json_encode($result);
	}

	public function feed_items($returnJson = 1){
		$this->load->model("item_model");
		$appid = $this->input->post("app_id");	
		$items = $this->item_model->getData();

		$result = [
            "post" => $_POST,
            "status"=>"OK",
            "message"=>"OK",
            "data"=>$items
		];	
		
		
		if($returnJson === 0){
			return $result;
		}

		header("Content-Type: application/json");	
        echo json_encode($result);
	}

	public function feed_company($returnJson = 1){
		$this->load->model("company_model");
		$appId = $this->input->post("app_id");	
		$company = $this->company_model->getDataByAppId($appId);
		$result = [
            "post" => $_POST,
            "status"=>"OK",
            "message"=>"OK",
            "data"=>$company
		];	
        
		if($returnJson === 0){
			return $result;
		}
		header("Content-Type: application/json");	
        echo json_encode($result);
	}

	public function feed_promo_free_item($returnJson = 1){
		$this->load->model("promo_free_item_model");
		$appid = $this->input->post("app_id");	
		$items = $this->promo_free_item_model->getData();
		$result = [
            "post" => $_POST,
            "status"=>"OK",
            "message"=>"OK",
            "data"=>$items
		];
		if($returnJson === 0){
			return $result;
		}
		header("Content-Type: application/json");	
        echo json_encode($result);
	}
	
	public function feed_target($returnJson = 1){
		$this->load->model("target_model");
		$appid = $this->input->post("app_id");	
		$items = $this->target_model->getData();
		$result = [
            "post" => $_POST,
            "status"=>"OK",
            "message"=>"OK",
            "data"=>$items
		];
		if($returnJson === 0){
			return $result;
		}
		header("Content-Type: application/json");	
        echo json_encode($result);
	}

	public function feed_order($returnJson = 1){
		$this->load->model("trorder_model");
		$appid = $this->input->post("app_id");	
		$orderStatus = $this->trorder_model->getDataStatusByAppid($appid);
		$result = [
            "post" => $_POST,
            "status"=>"OK",
            "message"=>"OK",
            "data"=>$orderStatus
		];
		if($returnJson === 0){
			return $result;
		}
		header("Content-Type: application/json");	
        echo json_encode($result);
	}

	public function feed_newcustomer($returnJson = 1){
		$this->load->model("newcustomer_model");
		$appId = $this->input->post("app_id");	
		$newCustomers = $this->newcustomer_model->getDataByAppId($appId);
		$result = [
            "post" => $_POST,
            "status"=>"OK",
            "message"=>"OK",
            "data"=>$newCustomers
		];
		if($returnJson === 0){
			return $result;
		}
		header("Content-Type: application/json");	
        echo json_encode($result);
	}


	public function feed_all_data(){
		$appid = $this->input->post("app_id");
		$this->load->model("appid_model");



		if (!$this->appid_model->isValidAppid($appid)){
			$result = [
				"post" => $_POST,
				"status"=>"NOK",
				"message"=>"Invalid Application Id"
			];
		}else{
			$tmpResult =  $this->feed_customers(0);
			if ($tmpResult["status"] == "OK"){
				$arrCustomer  = $tmpResult["data"];

				$tmpResult =  $this->feed_items(0);
				$arrItems = $tmpResult["data"];

				$tmpResult =  $this->feed_company(0);
				$arrCompany = $tmpResult["data"];

				$tmpResult =  $this->feed_promo_free_item(0);
				$arrPromo = $tmpResult["data"];

				$tmpResult =  $this->feed_target(0);
				$arrTarget = $tmpResult["data"];

				$tmpResult =  $this->feed_order(0);
				$arrOrderStatus = $tmpResult["data"];

				$tmpResult =  $this->feed_newcustomer(0);
				$arrNewCustomer = $tmpResult["data"];


				$data = [
					"arrCustomer" => $arrCustomer,
					"arrItems" => $arrItems,
					"arrCompany" => $arrCompany,
					"arrPromo" => $arrPromo,
					"arrTarget" => $arrTarget,
					"arrOrderStatus" => $arrOrderStatus,
					"arrNewCustomer" => $arrNewCustomer,
				];

				$result = [
					"post" => $_POST,
					"status"=>"OK",
					"message"=>"OK",
					"data"=>$data
				];


			}else{
				$result = $tmpResult;
			}
		}

		header("Content-Type: application/json");	
		echo json_encode($result);		
	} 


	public function update_fcm_token(){
		$this->load->model("appid_model");
		$appid = $this->input->post("app_id");
		$token  = $this->input->post("fcm_token");
		$this->appid_model->updateFCMToken($appid,$token);
	}

	public function generate_dummy_customer(){
		$this->load->model("customer_model");
		$this->customer_model->createDummy();
	}
	public function generate_dummy_item(){
		$this->load->model("item_model");
		$this->item_model->createDummy();
	}
	
	
	public function check_appid(){
		$this->load->model("appid_model");
		$appId = $this->input->post("app_id"); 
		$status = "NOK";
		if($this->appid_model->isValidAppid($appId)){
			$status = "OK";	
		}

		if ($status == "OK"){
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
		
	}

	
	public function test(){
		$loc1 = "-6.182307, 106.674893";
		$loc2 = "-6.1823019, 106.6747216";
		$loc1 = explode(",",$loc1);
		$loc2 = explode(",",$loc2);

		echo "Distance :" . distance($loc1[0],$loc1[1],$loc2[0],$loc2[1],"M");



	}

	public function checkinlog(){
		$this->load->model("trcheckinlog_model");
		$this->load->model("customer_model");
		$this->load->model("appid_model");


		$appid = $this->input->post("app_id");
		$fin_id = $this->input->post("fin_id");
		$fst_cust_code = $this->input->post("fst_cust_code");

		$sales =  $this->appid_model->getSales($appid,null,$fst_cust_code);
		if($sales){
			$salesCode = $sales->fst_sales_code;
			
			$loc =  explode(",",$this->input->post("fst_checkin_location"));			
			$loc_lat = $loc[0];
			$loc_log = $loc[1];
			
			$custLoc = $this->customer_model->getLocation($this->input->post("fst_cust_code"));			
			if ($custLoc == "0,0"){
				$loc2 =  explode(",",$this->input->post("fst_checkin_location"));
				$this->customer_model->setLocation($this->input->post("fst_cust_code"),$this->input->post("fst_checkin_location"));
			}else{
				$loc2 =  explode(",",$custLoc);			
			}			
			$loc2_lat = $loc2[0];
			$loc2_log = $loc2[1];

			//cek if record exist
			$distance = distance($loc_lat, $loc_log, $loc2_lat, $loc2_log,"M");
			
			$time = strtotime($this->input->post("fdt_checkin_datetime"));
			$checkinDate = date('Y-m-d',$time);

			$rw = $this->trcheckinlog_model->getDataByDate($salesCode,$this->input->post("fst_cust_code"),$checkinDate);
			$mode = "insert";
			if($rw){
				//Data Sudah ada sebelumnya
				$id = $rw->fin_id;
				if ($rw->fin_distance_meters > $distance){
					//Update data dengan jarak yg lebih dekat
					$mode = "update";
					$data = [
						"fin_id"=>$id,
						"fst_checkin_location" => $this->input->post("fst_checkin_location"),
						"fin_distance_meters" => $distance,
						"fdt_update_datetime" => date("Y-m-d H:i:s"),
						"fin_update_id" => 1
					];

				}else{
					// Distance yg baru lebih jauh, hiraukan
					$mode ="ignore";
				}

			}else{
				//Data belum ada - Insert
				$mode = "insert";
				$checkout = $this->input->post("fdt_checkout_datetime");
				if ($checkout == null){
					$checkout = $this->input->post("fdt_checkin_datetime");
				}
				$data = [
					"fst_sales_code"=>$salesCode,
					"fst_cust_code" => $this->input->post("fst_cust_code"),
					"fdt_checkin_datetime" => $this->input->post("fdt_checkin_datetime"),
					"fdt_checkout_datetime" => $checkout,
					"fst_checkin_location" => $this->input->post("fst_checkin_location"),
					"fin_distance_meters" => distance($loc_lat, $loc_log, $loc2_lat, $loc2_log,"M"),
					"fst_active" => 'A',
					"fdt_insert_datetime" => date("Y-m-d H:i:s"),
					"fin_insert_id" => 1
				];
			}

			$result = [];
			$this->db->trans_start();
			try{
				if ($mode == "insert"){
					$id = $this->trcheckinlog_model->insert($data);
				}else if($mode=="update"){
					$id = $data["fin_id"]; 
					$this->trcheckinlog_model->update($data);
				}


				if(!empty($_FILES['photoloc']['tmp_name'])) {
					//$config['upload_path']          = FCPATH . "uploads\\checkinlog\\";
					$config['upload_path']          =  APPPATH . "../uploads/checkinlog/";
					$config['file_name']			=  md5('doc_'. $id) . "_" . time();  //'doc_'. $insertId .'_0'. '.pdf' ;
					$config['overwrite']			= TRUE;
					$config['file_ext_tolower']		= TRUE;
					$config['allowed_types']        = 'jpg|png'; //'gif|jpg|png';
					$config['max_size']             = 0; //(int) getDbConfig("document_max_size"); //kilobyte
					$config['max_width']            = 0; //1024; //pixel
					$config['max_height']           = 0; //768; //pixel				
					$this->load->library('upload', $config);
					if ( ! $this->upload->do_upload('photoloc')){			
						echo $this->upload->display_errors();					
						$this->db->trans_rollback();
						return;
					}
					
				}

			} catch (Exception $e) {
				print_r($e);
				$this->db->trans_rollback();
				return;
			}

			$this->db->trans_complete();
			$result = [
				"status"=>"OK",
				"fin_id"=> $fin_id	
			];

			header('Content-Type: application/json');
			echo json_encode($result);
		}else{
			header('Content-Type: application/json');
			echo json_encode([
				"status"=>"NOK",
				"fin_id"=> $fin_id,
				"message"=>"Sales Not Found"
			]);
		}
	}

	public function newcust(){
		$this->load->model("appid_model");
		
		log_message('info', print_r($this->input->post(),true));

		//$sales = $this->appid_model->getSales($this->input->post("app_id"),$this->input->post("fst_company_code"));
		if ($this->input->post("fbl_is_new") == "3" ){
			//delete data
			$this->db->where('fin_id', $this->input->post("fin_id_server"));			
			//$this->db->where('fst_appid', $this->input->post("app_id"));
			$this->db->delete("tbnewcustomers");
			$result = [
				"status" => "OK",
				"fin_cust_id" => $this->input->post("fin_cust_id"),
				"post" => $this->input->post(),
			];
			header('Content-Type: application/json');
			echo json_encode($result);
			return;
		}

		$strCompanyCode = $this->input->post("fst_company_code");
		$arrCompanyCode  = explode ( "," ,$strCompanyCode);
		$strSalesCode = "";
		$strSalesName = "";
		$post =$this->input->post();
		foreach($arrCompanyCode as $companyCode){
			$sales = $this->appid_model->getSales($this->input->post("app_id"),$companyCode);
			if($sales){
				$strSalesCode .= $sales->fst_sales_code . ",";
				$strSalesName .= $sales->fst_sales_name . "\r\n";			
			}
		}
		$strSalesCode = rtrim($strSalesCode,",");


		$data = [
			"fst_cust_name" => $this->input->post("fst_cust_name"),
			"fst_contact" => $this->input->post("fst_contact"),
			"fst_cust_phone" =>$this->input->post("fst_cust_phone"),
			"fst_kelurahan" =>$this->input->post("fst_kelurahan"),
			"fst_kecamatan" =>$this->input->post("fst_kecamatan"),
			"fst_cust_address" =>$this->input->post("fst_cust_address"),
			"fbl_is_pasar" =>$this->input->post("fbl_is_pasar"),
			"fst_cust_location" => $this->input->post("fst_cust_location"),			
			"fst_appid" => $this->input->post("app_id"),
			"fst_company_code" => $this->input->post("fst_company_code"),	
			"fst_sales_code" => $strSalesCode,
			"fst_sales_name" => $strSalesName,	
			"fst_status" => "NEED APPROVAL",
			"fst_active" => "A",
			"fin_insert_id" => 1,
			"fdt_insert_datetime" => date("Y-m-d H:i:s")
		];

		$this->db->insert("tbnewcustomers",$data);
		$insertId = $this->db->insert_id();

		$result = [
			"status" => "OK",
			"fin_cust_id" => $this->input->post("fin_cust_id"),
			"fin_id_server" =>$insertId
		];
		header('Content-Type: application/json');
		echo json_encode($result);
	}

	public function neworder(){
		//$this->load->model("trorder_model");
		$this->load->model("appid_model");

		if ($this->input->post("fst_status") == "DELETE"){
			$fstOrderId = $this->input->post("fst_order_id");

			$this->db->where("fst_order_id",$fstOrderId);
			$this->db->where("fst_appid",$this->input->post("app_id"));
			$data=[
				"fst_active"=>"D",
			];
			$this->db->update("tr_order",$data);


			$result =[
				"status"=>"OK",
				"order_id"=>$this->input->post("fst_order_id"),
				"message"=>"",
			];
			header('Content-Type: application/json');
			echo json_encode($result);
			die();
		}


	
		$rwSales = $this->appid_model->getSales($this->input->post("app_id"),null,$this->input->post("fst_cust_code"));		
		$result =[
			"status"=>"NOK",
			"order_id"=>$this->input->post("fst_order_id"),
			"message"=>"",
		];

		if(!$rwSales){
			$result["message"] = "Invalid sales";
		}else{

			

			$dataH = [
				"fst_order_id" => $this->input->post("fst_order_id"),
				"fst_cust_code"=> $this->input->post("fst_cust_code"),
				"fst_sales_code" => $rwSales->fst_sales_code,
				"fdt_order_datetime" => $this->input->post("fdt_order_datetime"),
				"fst_notes" => $this->input->post("fst_notes"),
				"fst_appid" => $this->input->post("app_id"),
				"fst_status" => "UPLOADED",//$this->input->post("fst_status"),
				"fst_company_code"=>$rwSales->fst_company_code,
				"fst_active" => 'A',
				"fin_insert_id" => 1,
				"fdt_insert_datetime" => date("Y-m-d H:i:s"),
			];
			
			$this->db->trans_start();
			$this->db->insert("tr_order",$dataH);
			if ($this->db->error()["code"] != 0 ){				
				header('Content-Type: application/json');
				$result["message"] = $this->db->error()["message"];
				echo json_encode($result);				
				die();
			}

			$details =$_POST["details"];
			$objDetails =  json_decode($details);

			foreach($objDetails as $detail){
				//{"fst_item_code":"CCLT 320 COMPL","fst_satuan":"Ctn","fin_qty":2,"fin_price":72727.3},
				$dataD = [
					"fst_order_id"=>$dataH["fst_order_id"],
					"fst_item_code"=>$detail->fst_item_code,
					"fst_satuan"=>$detail->fst_satuan,
					"fin_qty"=>$detail->fin_qty,
					"fin_price"=>$detail->fin_price					
				];
				$this->db->insert("tr_order_details",$dataD);

			}
			//var_dump($this->db->error());
			if ($this->db->error()["code"] == 0 ){
				//$this->db->trans_complete();
			}else{

			}

			$result =[
				"status"=>"OK",
				"order_id"=>$this->input->post("fst_order_id"),
				"message"=>"",
			];
		}
		header('Content-Type: application/json');
		echo json_encode($result);
	}
}