<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Approval extends MY_Controller{

	public function __construct(){
		parent::__construct();
		
	}
	public function index(){

		$this->load->library("menus");				

		if ($this->aauth->is_permit("approval",true) == false){
			show_404();
			die();
		}

        $main_header = $this->parser->parse('inc/main_header', [], true);
		$main_sidebar = $this->parser->parse('inc/main_sidebar', [], true);		
		$data["title"] = lang("Approval");
		$data['arrSearch']=[
            'a.fst_order_id' => 'ESPB ID',
            'a.fst_sales_code' => 'Sales Name',
            'a.fst_cust_name' => 'Customer Name'
		];
		$page_content = $this->parser->parse('pages/approval', $data, true);
		$main_footer = $this->parser->parse('inc/main_footer', [], true);
		$control_sidebar = NULL;
		$this->data["MAIN_HEADER"] = $main_header;
		$this->data["MAIN_SIDEBAR"] = $main_sidebar;
		$this->data["PAGE_CONTENT"] = $page_content;
		$this->data["MAIN_FOOTER"] = $main_footer;
		$this->data["CONTROL_SIDEBAR"] = $control_sidebar;
		$this->parser->parse('template/main', $this->data);
    }

    public function fetch_need_approval_list(){
        $this->load->library("datatables");

        $user = $this->aauth->user();
		/*
        $this->datatables->setTableName(
            "(select * from trverification 
            where fst_verification_status = 'RV' 
            and fin_department_id = ". $user->fin_department_id ." 
            and fin_user_group_id = ". $user->fin_group_id . ") a "
		);
		*/
		
		$this->datatables->setTableName(
			"(select a.*,b.fst_order_id,b.fst_cust_code,b.fst_sales_code,c.fst_cust_name from trverification a
			LEFT JOIN tr_order b on a.fin_transaction_id = b.fin_rec_id and a.fst_controller ='ESPB'
			LEFT JOIN tbcustomers c on b.fst_cust_code = c.fst_cust_code and b.fst_cust_code IS NOT NULL and a.fst_controller ='ESPB' 
            where fst_verification_status = 'RV' 
            and fin_department_id = ". $user->fin_department_id ." 
            and fin_user_group_id = ". $user->fin_group_id . ") a "
        );

		$selectFields = "a.fin_rec_id,a.fst_controller,a.fin_transaction_id,a.fst_transaction_no,a.fst_message,a.fdt_insert_datetime,a.fst_cust_code,a.fst_cust_name,a.fst_sales_code";
		$this->datatables->setSelectFields($selectFields);

		$searchFields =[];
		$searchFields[] = $this->input->get('optionSearch'); //["fin_salesorder_id","fst_salesorder_no"];
		$this->datatables->setSearchFields($searchFields);
		$this->datatables->activeCondition = "a.fst_active !='D'";

		// Format Data
		$datasources = $this->datatables->getData();
		$arrData = $datasources["data"];
		$arrDataFormated = [];
		foreach ($arrData as $data) {
			$insertDate = strtotime($data["fdt_insert_datetime"]);						
			$data["fdt_insert_datetime"] = date("d-M-Y H:i:s",$insertDate);
			$arrDataFormated[] = $data;
		}
		$datasources["data"] = $arrDataFormated;
		$this->json_output($datasources);
	}

	public function fetch_hist_approval_list(){
        $this->load->library("datatables");

        $user = $this->aauth->user();

        $this->datatables->setTableName(
			"(select * from trverification 
            where fst_verification_status in ('VF','RJ','VD')  
            and fin_department_id = ". $user->fin_department_id ." 
            and fin_user_group_id = ". $user->fin_group_id . ") a "
        );

		$selectFields = "a.fin_rec_id,a.fst_controller,a.fin_transaction_id,a.fst_transaction_no,a.fst_message,a.fdt_insert_datetime,a.fst_verification_status";
		$this->datatables->setSelectFields($selectFields);

		$searchFields =[];
		$searchFields[] = $this->input->get('optionSearch'); //["fin_salesorder_id","fst_salesorder_no"];
		$this->datatables->setSearchFields($searchFields);
		$this->datatables->activeCondition = "a.fst_active !='D'";

		// Format Data
		$datasources = $this->datatables->getData();
		$arrData = $datasources["data"];
		$arrDataFormated = [];
		foreach ($arrData as $data) {
			$insertDate = strtotime($data["fdt_insert_datetime"]);						
			$data["fdt_insert_datetime"] = date("d-M-Y H:i:s",$insertDate);
			$arrDataFormated[] = $data;
		}
		$datasources["data"] = $arrDataFormated;
		$this->json_output($datasources);
    }
    
    public function doApproval($finRecId){
        $this->load->model('trverification_model');

        $this->db->trans_start();
        $result = $this->trverification_model->approve($finRecId);
        $this->db->trans_complete();
        
        $this->ajxResp["status"] = "SUCCESS";
        $this->ajxResp["message"] = "";
        $this->ajxResp["data"]=[];
        $this->json_output();
	}

	public function doReject($finRecId){
        $this->load->model('trverification_model');

        $this->db->trans_start();
        $result = $this->trverification_model->reject($finRecId);
        $this->db->trans_complete();
        
        $this->ajxResp["status"] = "SUCCESS";
        $this->ajxResp["message"] = "";
        $this->ajxResp["data"]=[];
        $this->json_output();
	}
	
	public function viewDetail($finRecId){
		$this->load->model('trverification_model');
		$this->trverification_model->showTransaction($finRecId);
	}
}