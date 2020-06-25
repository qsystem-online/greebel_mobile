<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sales_report extends CI_Controller {

	public function __construct(){
		parent:: __construct();
		$this->load->library('form_validation');
	}

	public function index(){		
		$this->load->library("pHP_AES_Cipher");
		$this->load->model("appid_model");
		$appId = $this->input->post("appid");


		//$appId = "AMING";
		$key="com_greebel_key";
		
		$token = $this->input->post("token");
		//$encryptedData =  PHP_AES_Cipher::encrypt($key,"1111111111111111","hello wordld !");
		//$token =  PHP_AES_Cipher::encrypt($key,"1111111111111111","WITONO|202006123");
		//var_dump($encryptedData);
		
		try{
			$decryptToken =  PHP_AES_Cipher::decrypt($key,$token);
			$arrDecryptToken = explode("|",$decryptToken);

			//$arrDecryptToken =["AMING","asdasdasd"];
			//var_dump($arrDecryptToken);

			if (sizeof($arrDecryptToken) < 2){
				show_404();
			}
			$appId = $arrDecryptToken[0];
			$keyNow = $arrDecryptToken[1];

		}catch(Exception $e){
			var_dump($e);
		}	

		var_dump($appId);	
		//$appId = "WITONO";
		//var_dump($this->input->post());
		
		//$main_header = $this->parser->parse('inc/main_header',[],true);
		//$main_sidebar = $this->parser->parse('inc/main_sidebar',[],true);
		$rwSales = $this->appid_model->getSales($appId);
		if ($rwSales == null){
			show_404();
		}

		$data["title"] = "Sales Summary";
		$data["salesCode"] = $rwSales->fst_sales_code;
		
		$page_content = $this->parser->parse('pages/report/sales_report',$data,true);
		
		
			
		$control_sidebar = NULL;
		//$this->data["MAIN_HEADER"] = $main_header;
		//$this->data["MAIN_SIDEBAR"] = $main_sidebar;
		$this->data["PAGE_CONTENT"] = $page_content;
		//$this->data["MAIN_FOOTER"] = $main_footer;
		//$this->data["CONTROL_SIDEBAR"] = $control_sidebar;
		$this->parser->parse('template/android_report',$this->data);
	}

	


	public function ajxQueryLocation($fstKodeArea){
		$ssql = "SELECT a.*,b.fst_cust_name,b.fst_cust_name,b.fin_price_group_id FROM tblocation a 
			inner join tbcustomers b on a.fst_cust_code = b.fst_cust_code 
			where b.fst_area_code like ? and b.fst_active ='A'";

		$qr = $this->db->query($ssql,["$fstKodeArea%"]);
		$rs = $qr->result();
		$result =[
			"status"=>"SUCCESS",
			"data"=>$rs
		];
		header('Content-Type: application/json');
		echo json_encode($result);
	}
	

	public function ajxGetSumReport(){
		$salesCode = $this->input->post("salesCode");
		$rangeDate = $this->input->post("daterange");
		$fstLevel = $this->input->post("level");
		//var_dump($fstLevel);
		//die();
		//$appId = 'AMING';
		//$rangeDate = "01/05/2020 - 18/05/2020";
		//$fstLevel = "";

		$arrRangeDate = explode("-",$rangeDate);
		$dateStart = dateFormat(trim($arrRangeDate[0]),"j/m/Y","Y-m-d");
		$dateEnd = dateFormat(trim($arrRangeDate[1]),"j/m/Y","Y-m-d");
		$dateEnd = $dateEnd . " 23:59:59";

		//$rwSales = $this->appid_model->getSales($appId)			

		if ($fstLevel == ""){
			$rsData = $this->getReport($salesCode,$dateStart,$dateEnd,"NATIONAL");
			$fstLevel = "NATIONAL";
			if (sizeof($rsData) == 0){
				$rsData = $this->getReport($salesCode,$dateStart,$dateEnd,"REGIONAL");
				$fstLevel = "REGIONAL";
				if (sizeof($rsData) == 0){
					$rsData = $this->getReport($salesCode,$dateStart,$dateEnd,"AREA");
					$fstLevel = "AREA";
					if (sizeof($rsData) == 0){
						$rsData = $this->getReport($salesCode,$dateStart,$dateEnd,"SALES");
						$fstLevel = "SALES";
					}
				}
			}
			header('Content-Type: application/json');
			echo json_encode([
				"status"=>"SUCCESS",
				"message"=>"",
				"data"=>[
					"level"=>$fstLevel,
					"detail"=>$rsData,
				]
			]);
		}else{
			$rsData = $this->getReport($salesCode,$dateStart,$dateEnd,$fstLevel);
			header('Content-Type: application/json');
			echo json_encode([
				"status"=>"SUCCESS",
				"message"=>"",
				"data"=>[
					"level"=>$fstLevel,
					"detail"=>$rsData,
				]
			]);
		}
		

	}

	private function getReport($fstSalesCode,$startDate,$endDate,$fstLevel){
		//var_dump($fstLevel);
		//var_dump($fstSalesCode);
		//die();
		//$fstLevel ="AREA";
		if ($fstLevel == "NATIONAL"){
			$ssql = "SELECT a.fst_sales_regional_code as fst_code,e.fst_sales_name as fst_name,
				SUM(IFNULL(b.ttl_schedule,0)) as ttl_schedule,
				SUM(IFNULL(c.ttl_visited,0)) as ttl_visited,
				SUM(IFNULL(f.ttl_visited_all,0)) as ttl_visited_all,
				IFNULL(d.ttl_espb,0) as ttl_daily_omset,
				SUM(a.fdc_total_current_monthly_omset) as ttl_monthly_omset
			FROM tbcustomers a 
			LEFT JOIN 
				(
					SELECT fst_cust_code,COUNT(fin_rec_id) AS ttl_schedule FROM tbjadwalsales 
					WHERE fdt_schedule_date >= ? AND fdt_schedule_date <= ? GROUP BY fst_cust_code
				) b ON a.fst_cust_code = b.fst_cust_code
			LEFT JOIN 
				(
					SELECT fst_cust_code,COUNT(fin_rec_id) AS ttl_visited FROM tbjadwalsales 
					WHERE fdt_schedule_date >= ? AND fdt_schedule_date <= ? AND fbl_visited = 1 GROUP BY fst_cust_code
				) c ON a.fst_cust_code = c.fst_cust_code	
			LEFT JOIN
				(
					SELECT a.fst_sales_code,SUM(b.fin_qty * (fin_price - fdc_disc)) AS ttl_espb FROM tr_order a
					INNER JOIN tr_order_details b ON a.fst_order_id = b.fst_order_id
					WHERE fdt_order_datetime >= ? AND fdt_order_datetime <= ? GROUP BY a.fst_sales_code
				) d ON a.fst_sales_code = d.fst_sales_code 			
			LEFT JOIN 
				(
					select fst_cust_code,count(fin_id) as ttl_visited_all from trcheckinlog 
					where fdt_checkin_datetime >= ? and fdt_checkin_datetime <= ?  
					GROUP BY fst_cust_code
				) f ON a.fst_cust_code = f.fst_cust_code 
			INNER JOIN tbsales e on a.fst_sales_regional_code = e.fst_sales_code 
			WHERE 
			a.fst_sales_national_code = ? GROUP BY a.fst_sales_regional_code";
		}else if ($fstLevel == "REGIONAL"){
			$ssql = "SELECT a.fst_sales_area_code as fst_code,e.fst_sales_name as fst_name,
				SUM(IFNULL(b.ttl_schedule,0)) as ttl_schedule,
				SUM(IFNULL(c.ttl_visited,0)) as ttl_visited,
				SUM(IFNULL(f.ttl_visited_all,0)) as ttl_visited_all,
				IFNULL(d.ttl_espb,0) as ttl_daily_omset,
				SUM(a.fdc_total_current_monthly_omset) as ttl_monthly_omset
			FROM tbcustomers a 
			LEFT JOIN 
				(
					SELECT fst_cust_code,COUNT(fin_rec_id) AS ttl_schedule FROM tbjadwalsales 
					WHERE fdt_schedule_date >= ? AND fdt_schedule_date <= ? GROUP BY fst_cust_code
				) b ON a.fst_cust_code = b.fst_cust_code
			LEFT JOIN 
				(
					SELECT fst_cust_code,COUNT(fin_rec_id) AS ttl_visited FROM tbjadwalsales 
					WHERE fdt_schedule_date >= ? AND fdt_schedule_date <= ? AND fbl_visited = 1 GROUP BY fst_cust_code
				) c ON a.fst_cust_code = c.fst_cust_code	
			LEFT JOIN
				(
					SELECT a.fst_sales_code,SUM(b.fin_qty * (fin_price - fdc_disc)) AS ttl_espb FROM tr_order a
					INNER JOIN tr_order_details b ON a.fst_order_id = b.fst_order_id
					WHERE fdt_order_datetime >= ? AND fdt_order_datetime <= ? GROUP BY a.fst_sales_code
				) d ON a.fst_sales_code = d.fst_sales_code 
			LEFT JOIN 
				(
					select fst_cust_code,count(fin_id) as ttl_visited_all from trcheckinlog 
					where fdt_checkin_datetime >= ? and fdt_checkin_datetime <= ?  
					GROUP BY fst_cust_code
				) f ON a.fst_cust_code = f.fst_cust_code 
			INNER JOIN tbsales e on a.fst_sales_area_code = e.fst_sales_code 
			WHERE 
			a.fst_sales_regional_code = ? GROUP BY a.fst_sales_area_code";
		}else if ($fstLevel == "AREA"){
			$ssql = "SELECT a.fst_sales_code as fst_code,e.fst_sales_name as fst_name,
				SUM(IFNULL(b.ttl_schedule,0)) as ttl_schedule,
				SUM(IFNULL(c.ttl_visited,0)) as ttl_visited,
				SUM(IFNULL(f.ttl_visited_all,0)) as ttl_visited_all,
				IFNULL(d.ttl_espb,0) as ttl_daily_omset,
				SUM(a.fdc_total_current_monthly_omset) as ttl_monthly_omset
			FROM tbcustomers a 
			LEFT JOIN 
				(
					SELECT fst_cust_code,COUNT(fin_rec_id) AS ttl_schedule FROM tbjadwalsales 
					WHERE fdt_schedule_date >= ? AND fdt_schedule_date <= ? GROUP BY fst_cust_code
				) b ON a.fst_cust_code = b.fst_cust_code
			LEFT JOIN 
				(
					SELECT fst_cust_code,COUNT(fin_rec_id) AS ttl_visited FROM tbjadwalsales 
					WHERE fdt_schedule_date >= ? AND fdt_schedule_date <= ? AND fbl_visited = 1 GROUP BY fst_cust_code
				) c ON a.fst_cust_code = c.fst_cust_code	
			LEFT JOIN
				(
					SELECT a.fst_sales_code,SUM(b.fin_qty * (fin_price - fdc_disc)) AS ttl_espb FROM tr_order a
					INNER JOIN tr_order_details b ON a.fst_order_id = b.fst_order_id
					WHERE fdt_order_datetime >= ? AND fdt_order_datetime <= ? GROUP BY a.fst_sales_code
				) d ON a.fst_sales_code = d.fst_sales_code 
			LEFT JOIN 
				(
					select fst_cust_code,count(fin_id) as ttl_visited_all from trcheckinlog 
					where fdt_checkin_datetime >= ? and fdt_checkin_datetime <= ?  
					group by fst_cust_code
				) f ON a.fst_cust_code = f.fst_cust_code 
			INNER JOIN tbsales e on a.fst_sales_code = e.fst_sales_code 
			WHERE 
			a.fst_sales_area_code = ? GROUP BY a.fst_sales_code";
		}else{
			$ssql = "SELECT a.fst_cust_code as fst_code,a.fst_cust_name as fst_name,
				SUM(IFNULL(b.ttl_schedule,0)) as ttl_schedule,
				SUM(IFNULL(c.ttl_visited,0)) as ttl_visited,
				SUM(IFNULL(e.ttl_visited_all,0)) as ttl_visited_all,
				IFNULL(d.ttl_espb,0) as ttl_daily_omset,
				SUM(a.fdc_total_current_monthly_omset) as ttl_monthly_omset
			FROM tbcustomers a 
			LEFT JOIN 
				(
					SELECT fst_cust_code,COUNT(fin_rec_id) AS ttl_schedule FROM tbjadwalsales 
					WHERE fdt_schedule_date >= ? AND fdt_schedule_date <= ? GROUP BY fst_cust_code
				) b ON a.fst_cust_code = b.fst_cust_code
			LEFT JOIN 
				(
					SELECT fst_cust_code,COUNT(fin_rec_id) AS ttl_visited FROM tbjadwalsales 
					WHERE fdt_schedule_date >= ? AND fdt_schedule_date <= ? AND fbl_visited = 1 GROUP BY fst_cust_code
				) c ON a.fst_cust_code = c.fst_cust_code	
			LEFT JOIN
				(
					SELECT a.fst_cust_code,SUM(b.fin_qty * (fin_price - fdc_disc)) AS ttl_espb 
					FROM tr_order a
					INNER JOIN tr_order_details b ON a.fst_order_id = b.fst_order_id
					WHERE fdt_order_datetime >= ? AND fdt_order_datetime <= ? 
					AND fst_sales_code = '$fstSalesCode' 
					GROUP BY a.fst_cust_code
				) d ON a.fst_cust_code = d.fst_cust_code 
			LEFT JOIN 
				(
					SELECT fst_cust_code,count(fin_id) as ttl_visited_all from trcheckinlog 
					WHERE fdt_checkin_datetime >= ? and fdt_checkin_datetime <= ?  
					GROUP BY fst_cust_code 
				) e on a.fst_cust_code = e.fst_cust_code 
			WHERE 
			a.fst_sales_code = ? GROUP BY a.fst_cust_code";
		}


		$qr = $this->db->query($ssql,[$startDate,$endDate,$startDate,$endDate,$startDate,$endDate,$startDate,$endDate,$fstSalesCode]);
		//echo $fstLevel;
		//echo($this->db->last_query());
		//var_dump($this->db->error());
		//die();
		$rs = $qr->result();
		return $rs;

	}
	


}