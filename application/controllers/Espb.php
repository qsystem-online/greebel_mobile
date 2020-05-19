<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Espb extends MY_Controller {

    public function __construct(){
        parent:: __construct();
        $this->load->library('form_validation');
    }

    public function index(){
        $this->lizt();
    }

    public function lizt(){
        $this->load->library('menus');
        $this->list['page_name']="ESPB";
        $this->list['list_name']="ESPB List";
        $this->list['addnew_ajax_url']=site_url().'user/add';
        $this->list['pKey']="id";
		$this->list['fetch_list_data_ajax_url']=site_url().'espb/fetch_list_data';
        $this->list['delete_ajax_url']=site_url().'user/delete/';
        $this->list['edit_ajax_url']=site_url().'user/edit/';
        $this->list['arrSearch']=[
            'a.fst_order_id' => 'ESPB ID',
            'a.fst_sales' => 'Sales Name',
            'a.fst_customer' => 'Customer Name'
		];

        $this->list['breadcrumbs']=[
			['title'=>'Home','link'=>'#','icon'=>"<i class='fa fa-dashboard'></i>"],
			['title'=>'ESPB','link'=>'#','icon'=>''],
			['title'=>'List','link'=> NULL ,'icon'=>''],
		];

		$this->list['columns']=[
            ['title' => 'ESPB ID', 'width'=>'10%', 'data'=>'fst_order_id',
                'render'=>"function(data, type, row, meta){
                    return '<a href=\'". site_url() . "espb/view/". "' + row.fst_order_id + '\'>' + row.fst_order_id + '</a>';
                }"
            ],
			['title' => 'Request Datetime', 'width'=>'15%', 'data'=>'fdt_order_datetime'],
			['title' => 'Sales', 'width' =>'10%', 'data'=>'fst_sales'],
			['title' => 'Customer', 'width' =>'30%', 'data'=>'fst_customer'],
			['title' => 'Total Qty', 'width' =>'10%', 'data'=>'total_qty', 'className'=>'text-right'],
			['title' => 'Total Amount', 'width' =>'15%', 'data'=>'total_amount_ppn' , 
				'className'=>'text-right',
				'render' => "$.fn.dataTable.render.number( '\,', '.', 2, '' )"
			],
            ['title' => 'Status', 'width' =>'15%', 'data'=>'fst_status'],
			//['title' => 'Action', 'width'=>'10%', 'data'=>'action','sortable'=>false, 'className'=>'dt-center']
		];

        $main_header = $this->parser->parse('inc/main_header',[],true);
    	$main_sidebar = $this->parser->parse('inc/main_sidebar',[],true);
        $page_content = $this->parser->parse('espb_list',$this->list,true);
        $main_footer = $this->parser->parse('inc/main_footer',[],true);
        $control_sidebar=null;
        $this->data['ACCESS_RIGHT']="A-C-R-U-D-P";
        $this->data['MAIN_HEADER'] = $main_header;
        $this->data['MAIN_SIDEBAR']= $main_sidebar;
        $this->data['PAGE_CONTENT']= $page_content;
        $this->data['MAIN_FOOTER']= $main_footer;        
        $this->parser->parse('template/main',$this->data);
    }

    public function openForm($mode="ADD",$fin_user_id=0){
        $this->load->library("menus");
		//$this->load->model("groups_model");

		if($this->input->post("submit") != "" ){
			$this->add_save();
		}

        $main_header = $this->parser->parse('inc/main_header',[],true);
		$main_sidebar = $this->parser->parse('inc/main_sidebar',[],true);

		$data["mode"] = $mode;
		$data["title"] = $mode == "ADD" ? "Add User" : "Update User";
		$data["fin_user_id"] = $fin_user_id;

		$page_content = $this->parser->parse('pages/user/form',$data,true);
		$main_footer = $this->parser->parse('inc/main_footer',[],true);
			
		$control_sidebar = NULL;
		$this->data["MAIN_HEADER"] = $main_header;
		$this->data["MAIN_SIDEBAR"] = $main_sidebar;
		$this->data["PAGE_CONTENT"] = $page_content;
		$this->data["MAIN_FOOTER"] = $main_footer;
		$this->data["CONTROL_SIDEBAR"] = $control_sidebar;
		$this->parser->parse('template/main',$this->data);
    }

    public function add(){
        $this->openForm("ADD",0);
    }

    public function Edit($fin_user_id){
        $this->openForm("EDIT",$fin_user_id);
    }

    public function ajx_add_save(){
        $this->load->model('users_model');
        $this->form_validation->set_rules($this->users_model->getRules("ADD",0));
        $this->form_validation->set_error_delimiters('<div class="text-danger">* ', '</div>');

        if ($this->form_validation->run() == FALSE){
			//print_r($this->form_validation->error_array());
			$this->ajxResp["status"] = "VALIDATION_FORM_FAILED";
			$this->ajxResp["message"] = "Error Validation Forms";
			$this->ajxResp["data"] = $this->form_validation->error_array();
			$this->json_output();
			return;
		}

        $data = [
			"fst_username"=>$this->input->post("fst_username"),
			"fst_password"=> md5("inipassword"),
			"fst_fullname"=>$this->input->post("fst_fullname"),
			"fdt_birthdate"=>dBDateFormat($this->input->post("fdt_birthdate")),
			"fst_gender"=>$this->input->post("fst_gender"),
			"fst_active"=>'A',
			"fst_birthplace"=>$this->input->post("fst_birthplace"),
			"fst_address"=>$this->input->post("fst_address"),
			"fst_email"=>$this->input->post("fst_email"),
			"fst_phone"=>$this->input->post("fst_phone"),
			"fin_department_id"=>$this->input->post("fin_department_id"),
			"fbl_admin"=>$this->input->post("fbl_admin")
		];

        $this->db->trans_start();
		$insertId = $this->users_model->insert($data);
		$dbError  = $this->db->error();
		if ($dbError["code"] != 0){			
			$this->ajxResp["status"] = "DB_FAILED";
			$this->ajxResp["message"] = "Insert Failed";
			$this->ajxResp["data"] = $this->db->error();
			$this->json_output();
			$this->db->trans_rollback();
			return;
		}

        //Save File
		if(!empty($_FILES['fst_avatar']['tmp_name'])) {
			$config['upload_path']          = './assets/app/users/avatar';
			$config['file_name']			= 'avatar_'. $insertId . '.jpg' ;
			$config['overwrite']			= TRUE;
			$config['file_ext_tolower']		= TRUE;
			$config['allowed_types']        = 'gif|jpg|png';
			$config['max_size']             = 0; //kilobyte
			$config['max_width']            = 0; //1024; //pixel
			$config['max_height']           = 0; //768; //pixel

			$this->load->library('upload', $config);

			if ( ! $this->upload->do_upload('fst_avatar')){			
				$this->ajxResp["status"] = "IMAGES_FAILED";
				$this->ajxResp["message"] = "Failed to upload images, " . $this->upload->display_errors();
				$this->ajxResp["data"] = $this->upload->display_errors();
				$this->json_output();
				$this->db->trans_rollback();
				return;
			}else{
				//$data = array('upload_data' => $this->upload->data());			
			}
			$this->ajxResp["data"]["data_image"] = $this->upload->data();
		}

        $this->db->trans_complete();

		$this->ajxResp["status"] = "SUCCESS";
		$this->ajxResp["message"] = "Data Saved !";
		$this->ajxResp["data"]["insert_id"] = $insertId;
		$this->json_output();
    }

    public function ajx_edit_save(){
        $this->load->model('users_model');
        $fin_user_id = $this->input->post('fin_user_id');
        $data = $this->users_model->getDataById($fin_user_id);
		$user = $data["user"];
		if (!$user){
			$this->ajxResp["status"] = "DATA_NOT_FOUND";
			$this->ajxResp["message"] = "Data id $fin_user_id Not Found ";
			$this->ajxResp["data"] = [];
			$this->json_output();
			return;
		}

        $this->form_validation->set_rules($this->users_model->getRules("EDIT",$fin_user_id));
		$this->form_validation->set_error_delimiters('<div class="text-danger">* ', '</div>');
		if ($this->form_validation->run() == FALSE){
			//print_r($this->form_validation->error_array());
			$this->ajxResp["status"] = "VALIDATION_FORM_FAILED";
			$this->ajxResp["message"] = "Error Validation Forms";
			$this->ajxResp["data"] = $this->form_validation->error_array();
			$this->json_output();
			return;
		}

        $data = [
			"fin_user_id"=>$fin_user_id,
			"fst_username"=>$this->input->post("fst_username"),
			"fst_password"=> md5("defaultpassword"),//$this->input->post("fst_password"),
			"fst_fullname"=>$this->input->post("fst_fullname"),
			"fdt_birthdate"=>dBDateFormat($this->input->post("fdt_birthdate")),
			"fst_gender"=>$this->input->post("fst_gender"),
			"fst_active"=>'A',
			"fst_birthplace"=>$this->input->post("fst_birthplace"),
			"fst_address"=>$this->input->post("fst_address"),
			"fst_email"=>$this->input->post("fst_email"),
			"fst_phone"=>$this->input->post("fst_phone"),
			"fin_department_id"=>$this->input->post("fin_department_id"),
			"fbl_admin"=>$this->input->post("fbl_admin")
		];

		$this->db->trans_start();

		$this->users_model->update($data);
		$dbError  = $this->db->error();
		if ($dbError["code"] != 0){			
			$this->ajxResp["status"] = "DB_FAILED";
			$this->ajxResp["message"] = "Insert Failed";
			$this->ajxResp["data"] = $this->db->error();
			$this->json_output();
			$this->db->trans_rollback();
			return;
		}

		//Save File
		if(!empty($_FILES['fst_avatar']['tmp_name'])) {
			$config['upload_path']          = './assets/app/users/avatar';
			$config['file_name']			= 'avatar_'. $fin_id . '.jpg' ;
			$config['overwrite']			= TRUE;
			$config['file_ext_tolower']		= TRUE;
			$config['allowed_types']        = 'gif|jpg|png';
			$config['max_size']             = 0; //kilobyte
			$config['max_width']            = 0; //1024; //pixel
			$config['max_height']           = 0; //768; //pixel

			$this->load->library('upload', $config);

			if ( ! $this->upload->do_upload('fst_avatar')){			
				$this->ajxResp["status"] = "IMAGES_FAILED";
				$this->ajxResp["message"] = "Failed to upload images, " . $this->upload->display_errors();
				$this->ajxResp["data"] = $this->upload->display_errors();
				$this->json_output();
				$this->db->trans_rollback();
				return;
			}else{
				//$data = array('upload_data' => $this->upload->data());			
			}
				$this->ajxResp["data"]["data_image"] = $this->upload->data();
		}

		$this->db->trans_complete();

		$this->ajxResp["status"] = "SUCCESS";
		$this->ajxResp["message"] = "Data Saved !";
		$this->ajxResp["data"]["insert_id"] = $fin_user_id;
		$this->json_output();
    }

  
    public function fetch_list_data(){
		$this->load->library("datatables");
		$this->load->model("trorder_model");
		
		$datelog = $this->input->get("dateLog");
		$arrDateLog = explode("-",$datelog);
		$dateStart = dateFormat(trim($arrDateLog[0]),"j/m/Y","Y-m-d");
		$dateEnd = dateFormat(trim($arrDateLog[1]),"j/m/Y","Y-m-d");
	
		/*
		$this->datatables->setTableName("
			(SELECT CONCAT(a.fst_sales_code,' - ',b.fst_sales_name) as fst_sales,a.fst_sales_code,
			CONCAT (a.fst_cust_code,' - ',c.fst_cust_name) as fst_customer,a.fst_cust_code,
			DATE(fdt_checkin_datetime) fdt_checkin_date,MIN(fin_distance_meters) fin_distance,
			a.fst_active
			FROM trcheckinlog a 
			INNER JOIN tbsales b ON a. fst_sales_code = b.fst_sales_code
			INNER JOIN tbcustomers c ON a.fst_cust_code = c.fst_cust_code
			WHERE DATE(fdt_checkin_datetime) >= '$dateStart' and DATE(fdt_checkin_datetime) <= '$dateEnd' 
			GROUP BY a.fst_sales_code,a.fst_cust_code,DATE(fdt_checkin_datetime) 		
			) as trcheckinlog
		");
		*/
		$this->datatables->setTableName("
			(SELECT a.fst_order_id,
			CONCAT(a.fst_sales_code,' - ',b.fst_sales_name) as fst_sales,a.fst_sales_code,
            CONCAT (a.fst_cust_code,' - ',c.fst_cust_name) as fst_customer,a.fst_cust_code,
            fdt_order_datetime,fst_status,0 as fin_total,a.fst_active
			FROM tr_order a 
			INNER JOIN tbsales b ON a. fst_sales_code = b.fst_sales_code
			INNER JOIN tbcustomers c ON a.fst_cust_code = c.fst_cust_code
			WHERE DATE(fdt_order_datetime) >= '$dateStart' and DATE(fdt_order_datetime) <= '$dateEnd' 
			) as a
		");
		
		$selectFields = "*";
		$this->datatables->setSelectFields($selectFields);
	
		//$searchFields = ["fst_sales", "fst_customer"];
		$searchFields = [$this->input->get("optionSearch")];

		$this->datatables->setSearchFields($searchFields);
	
		// Format Data
		$datasources = $this->datatables->getData();		
		$arrData = $datasources["data"];		
		$arrDataFormated = [];
		$this->load->model("trorder_model");

		foreach ($arrData as $data) {
			//action			
			$data["action"]	= "<div style='font-size:16px'>
				<a class='btn-detail' href='#' data-id=''>Detail</a>				
			</div>";

			$summ = $this->trorder_model->getSummary($data["fst_order_id"]);

			$data["total_qty"]	= $summ->total_qty;
			$data["total_amount"]	= $summ->total_amount; //DPP + PPN
			$data["total_ppn"]	= ($summ->total_amount / 1.1) * 10 /100;
			$data["total_amount_ppn"]	= $data["total_amount"];			
			$arrDataFormated[] = $data;
		}

		$datasources["data"] = $arrDataFormated;
		$this->json_output($datasources);
    }

	
	public function view($fst_order_id){
        $this->load->library('menus');
        $this->load->model("trorder_model");
        $this->list['page_name']="ESPB";        

        $this->list['breadcrumbs']=[
			['title'=>'Home','link'=>'#','icon'=>"<i class='fa fa-dashboard'></i>"],
			['title'=>'ESPB','link'=>'#','icon'=>''],
			['title'=>'','link'=> NULL ,'icon'=>''],
		];

        $order = $this->trorder_model->getDataById($fst_order_id);
		$this->list["order"] = $order;
		
        $main_header = $this->parser->parse('inc/main_header',[],true);
    	$main_sidebar = $this->parser->parse('inc/main_sidebar',[],true);
        $page_content = $this->parser->parse('espb_form',$this->list,true);
        $main_footer = $this->parser->parse('inc/main_footer',[],true);
        $control_sidebar=null;
        $this->data['ACCESS_RIGHT']="A-C-R-U-D-P";
        $this->data['MAIN_HEADER'] = $main_header;
        $this->data['MAIN_SIDEBAR']= $main_sidebar;
        $this->data['PAGE_CONTENT']= $page_content;
        $this->data['MAIN_FOOTER']= $main_footer;        
        $this->parser->parse('template/main',$this->data);
	}

	public function record2Excel_bac(){		
		$this->load->model("trorder_model");		
		$datelog = $this->input->get("dateLog");
		//selectSearch		
		$arrDateLog = explode("-",$datelog);
		$dateStart = dateFormat(trim($arrDateLog[0]),"j/m/Y","Y-m-d");
		$dateEnd = dateFormat(trim($arrDateLog[1]),"j/m/Y","Y-m-d");
		
		$ssql = "SELECT a.fst_order_id,
			CONCAT(a.fst_sales_code,' - ',b.fst_sales_name) as fst_sales,a.fst_sales_code,
			CONCAT (a.fst_cust_code,' - ',c.fst_cust_name) as fst_customer,a.fst_cust_code,
			fdt_order_datetime,fst_status,0 as fin_total,a.fst_active
			FROM tr_order a 
			INNER JOIN tbsales b ON a. fst_sales_code = b.fst_sales_code
			INNER JOIN tbcustomers c ON a.fst_cust_code = c.fst_cust_code
			WHERE DATE(fdt_order_datetime) >= ? and DATE(fdt_order_datetime) <= ?";
	
		$query = $this->db->query($ssql,[$dateStart,$dateEnd]);
		$rs = $query->result();
		
		$this->load->library('phpspreadsheet');		
		$template = FCPATH . "assets". DIRECTORY_SEPARATOR  ."templates" .DIRECTORY_SEPARATOR ."template_espb_list.xls";
		$spreadsheet = $this->phpspreadsheet->load($template,"xls");		
		
		
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->getPageSetup()->setFitToWidth(1);
		$sheet->getPageSetup()->setFitToHeight(0);
		$sheet->getPageMargins()->setTop(1);
		$sheet->getPageMargins()->setRight(0.5);
		$sheet->getPageMargins()->setLeft(0.5);
		$sheet->getPageMargins()->setBottom(1);
		
		
		//$sheet->setTitle('Coba Aja');
		$iRow = 4;
		$sheet->setCellValue("B2", $datelog); 
		
		foreach($rs as $rw){
			$summ = $this->trorder_model->getSummary($rw->fst_order_id);
			$sheet->setCellValue("A$iRow", $rw->fst_order_id); 
			$sheet->setCellValue("B$iRow", $rw->fdt_order_datetime);
			$sheet->setCellValue("C$iRow", $rw->fst_sales);
			$sheet->setCellValue("D$iRow", $rw->fst_customer);
			$sheet->setCellValue("E$iRow", $summ->total_qty);
			$sheet->setCellValue("F$iRow", $summ->total_amount + ($summ->total_amount * 10/100));
			$sheet->setCellValue("G$iRow", $rw->fst_status);			
			$iRow++;
		}		
		
		//var_dump($spreadsheet);
		$this->phpspreadsheet->save("espb_list_" . date("Ymd") ,$spreadsheet);
		//$this->phpspreadsheet->save("test-coba");		
	}
	
	public function record2Excel(){		
		$this->load->model("trorder_model");		
		$datelog = $this->input->get("dateLog");
		//selectSearch		
		$arrDateLog = explode("-",$datelog);
		$dateStart = dateFormat(trim($arrDateLog[0]),"j/m/Y","Y-m-d");
		$dateEnd = dateFormat(trim($arrDateLog[1]),"j/m/Y","Y-m-d");
		
		$ssql = "SELECT a.fst_order_id,
			CONCAT(a.fst_sales_code,' - ',b.fst_sales_name) as fst_sales,a.fst_sales_code,
			CONCAT (a.fst_cust_code,' - ',c.fst_cust_name) as fst_customer,a.fst_cust_code,
			fdt_order_datetime,fst_status,0 as fin_total,a.fst_active
			FROM tr_order a 
			INNER JOIN tbsales b ON a. fst_sales_code = b.fst_sales_code
			INNER JOIN tbcustomers c ON a.fst_cust_code = c.fst_cust_code			
			WHERE DATE(fdt_order_datetime) >= ? and DATE(fdt_order_datetime) <= ?";
	
		$query = $this->db->query($ssql,[$dateStart,$dateEnd]);
		$rs = $query->result();
		
		$this->load->library('phpspreadsheet');		
		$template = FCPATH . "assets". DIRECTORY_SEPARATOR  ."templates" .DIRECTORY_SEPARATOR ."template_espb_list.xls";
		$spreadsheet = $this->phpspreadsheet->load($template,"xls");		
		
		
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->getPageSetup()->setFitToWidth(1);
		$sheet->getPageSetup()->setFitToHeight(0);
		$sheet->getPageMargins()->setTop(1);
		$sheet->getPageMargins()->setRight(0.5);
		$sheet->getPageMargins()->setLeft(0.5);
		$sheet->getPageMargins()->setBottom(1);
		
		
		//$sheet->setTitle('Coba Aja');
		$iRow = 4;
		$sheet->setCellValue("B2", $datelog); 
		
		foreach($rs as $rw){
			$ssql ="SELECT a.*,b.fst_item_name FROM tr_order_details a
				INNER JOIN tbitems b on a.fst_item_code =  b.fst_item_code
				where fst_order_id = ? ";

			$qr = $this->db->query($ssql,[$rw->fst_order_id]);
			$rsDetail = $qr->result();

			$summ = $this->trorder_model->getSummary($rw->fst_order_id);
			$sheet->setCellValue("A$iRow", $rw->fst_order_id); 
			$sheet->setCellValue("B$iRow", $rw->fdt_order_datetime);
			$sheet->setCellValue("C$iRow", $rw->fst_sales);
			$sheet->setCellValue("D$iRow", $rw->fst_customer);
			$sheet->setCellValue("E$iRow", $rw->fst_status);			
			foreach($rsDetail as $rwDetail){
				$sheet->setCellValue("F$iRow", $rwDetail->fst_item_name);
				$sheet->setCellValue("G$iRow", $rwDetail->fst_satuan);
				$sheet->setCellValue("H$iRow", $rwDetail->fin_qty);
				$sheet->setCellValue("I$iRow", $rwDetail->fin_price);
				$sheet->setCellValue("J$iRow", $rwDetail->fdc_disc);
				$total = $rwDetail->fin_qty * ($rwDetail->fin_price - $rwDetail->fdc_disc);				
				$sheet->setCellValue("K$iRow", $total);
				$sheet->getStyle("I$iRow:K$iRow")->getNumberFormat()
					->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
	
				$iRow++;
			}			

			$styleArray = [
				'font' => [
					'bold' => true,
				],			
				'formatCode' => \PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
			];


			$sheet->setCellValue("H$iRow", $summ->total_qty);
			//$sheet->setCellValue("K$iRow", $summ->total_amount + ($summ->total_amount * 10/100));			
			$sheet->setCellValue("K$iRow", $summ->total_amount);			
			$sheet->getStyle("H$iRow:K$iRow")->applyFromArray($styleArray);
			$sheet->getStyle("H$iRow:K$iRow")->getNumberFormat()->applyFromArray($styleArray);

			$iRow++;
		}		
		
		//var_dump($spreadsheet);
		$this->phpspreadsheet->save("espb_list_" . date("Ymd") ,$spreadsheet);
		//$this->phpspreadsheet->save("test-coba");		
	}
}