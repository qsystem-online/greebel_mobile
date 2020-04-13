<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Area_analys extends MY_Controller {

    public function __construct(){
        parent:: __construct();
        $this->load->library('form_validation');
    }

    public function index(){
        $this->load->library("menus");
		$this->load->model("msarea_model");

		if($this->input->post("submit") != "" ){
			$this->add_save();
		}

        $main_header = $this->parser->parse('inc/main_header',[],true);
		$main_sidebar = $this->parser->parse('inc/main_sidebar',[],true);

		
		$data["title"] = "Area Analyzer";
		$data["pickup_location_modal"] = $this->parser->parse('template/pickup_location_modal',[],true);
		
		$ssql = "SELECT a.*,b.fst_cust_name,b.fst_cust_name,b.fin_price_group_id FROM tblocation a 
			inner join tbcustomers b on a.fst_cust_code = b.fst_cust_code where b.fst_active ='A'";
		$qr = $this->db->query($ssql,[]);
		$rs = $qr->result();
		$data["listCustLocation"] = $rs;

		$data["listProvinsi"] = $this->msarea_model->getListProvinsi();

		$page_content = $this->parser->parse('pages/report/area_analys',$data,true);
		$main_footer = $this->parser->parse('inc/main_footer',[],true);
		
			
		$control_sidebar = NULL;
		$this->data["MAIN_HEADER"] = $main_header;
		$this->data["MAIN_SIDEBAR"] = $main_sidebar;
		$this->data["PAGE_CONTENT"] = $page_content;
		$this->data["MAIN_FOOTER"] = $main_footer;
		$this->data["CONTROL_SIDEBAR"] = $control_sidebar;
		$this->parser->parse('template/main',$this->data);
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
    


}