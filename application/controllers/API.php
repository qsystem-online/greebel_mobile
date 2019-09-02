<?php
use Dompdf\Exception;

defined('BASEPATH') OR exit('No direct script access allowed');

class API extends CI_Controller {
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

	public function feed_all_data(){
		$tmpResult =  $this->feed_customers(0);
		$appid = $this->input->post("app_id");

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

			$data = [
				"arrCustomer" => $arrCustomer,
				"arrItems" => $arrItems,
				"arrCompany" => $arrCompany,
				"arrPromo" => $arrPromo,
				"arrTarget" => $arrTarget
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
		header("Content-Type: application/json");	
		echo json_encode($result);
		

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

		$sales =  $this->appid_model->getSales($appid);
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
		}
	}

	public function newcust(){
		$this->load->model("appid_model");
		$sales = $this->appid_model->getSales($this->input->post("app_id"));
		$data = [
			"fst_cust_name" => $this->input->post("fst_cust_name"),
			"fst_cust_address" =>$this->input->post("fst_cust_address"),
			"fst_cust_phone" =>$this->input->post("fst_cust_phone"),
			"fst_cust_location" => $this->input->post("fst_cust_location"),
			"fst_sales_code" => $sales->fst_sales_code,
			"fst_active" => "A",
			"fin_insert_id" => 1,
			"fdt_insert_datetime" => date("Y-m-d H:i:s")
		];

		$this->db->insert("tbnewcustomers",$data);
		$result = [
			"status" => "OK",
			"fin_cust_id" => $this->input->post("fin_cust_id")
		];
		header('Content-Type: application/json');
		echo json_encode($result);
	}

	public function neworder(){
		var_dump($_POST);
		
	}
}