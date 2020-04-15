<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sales extends MY_Controller {

    public function __construct(){
        parent:: __construct();
        $this->load->library('form_validation');
    }

    public function index(){
        $this->lizt();
    }

    public function lizt(){
        $this->load->library('menus');
        $this->list['page_name']="User";
        $this->list['list_name']="User List";
        $this->list['addnew_ajax_url']=site_url().'user/add';
        $this->list['pKey']="id";
		$this->list['fetch_list_data_ajax_url']=site_url().'user/fetch_list_data';
        $this->list['delete_ajax_url']=site_url().'user/delete/';
        $this->list['edit_ajax_url']=site_url().'user/edit/';
        $this->list['arrSearch']=[
            'a.fin_user_id' => 'User ID',
            'a.fst_username' => 'User Name'
		];

        $this->list['breadcrumbs']=[
			['title'=>'Home','link'=>'#','icon'=>"<i class='fa fa-dashboard'></i>"],
			['title'=>'User','link'=>'#','icon'=>''],
			['title'=>'List','link'=> NULL ,'icon'=>''],
		];

		$this->list['columns']=[
			['title' => 'User ID', 'width'=>'10%', 'data'=>'fin_user_id'],
			['title' => 'Full Name', 'width'=>'25%', 'data'=>'fst_fullname'],
			['title' => 'Gender', 'width' =>'10%', 'data'=>'fst_gender'],
			['title' => 'Birthdate', 'width' =>'15%', 'data'=>'fdt_birthdate'],
			['title' => 'Birthplace', 'width' =>'15%', 'data'=>'fst_birthplace'],
			['title' => 'Action', 'width'=>'10%', 'data'=>'action','sortable'=>false, 'className'=>'dt-center']
		];

        $main_header = $this->parser->parse('inc/main_header',[],true);
    	$main_sidebar = $this->parser->parse('inc/main_sidebar',[],true);
        $page_content = $this->parser->parse('template/standardList',$this->list,true);
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

    public function record(){
        $this->load->library('menus');
        $this->list['page_name']="Sales";
        $this->list['list_name']="Sales Records";
        $this->list['addnew_ajax_url']=site_url().'user/add';
        $this->list['pKey']="id";
		$this->list['fetch_list_data_ajax_url']=site_url().'sales/fetch_list_data';
        $this->list['delete_ajax_url']=site_url().'user/delete/';
		$this->list['edit_ajax_url']=site_url().'user/edit/';
		
        $this->list['arrSearch']=[
            'fst_sales' => 'Sales',
            'fst_customer' => 'Customer'
		];
		
		

        $this->list['breadcrumbs']=[
			['title'=>'Home','link'=>'#','icon'=>"<i class='fa fa-dashboard'></i>"],
			['title'=>'Sales','link'=>'#','icon'=>''],
			['title'=>'Records','link'=> NULL ,'icon'=>''],
		];

		$this->list['columns']=[
			['title' => 'ID', 'width'=>'10%', 'data'=>'fin_id'],
			['title' => 'Sales', 'width'=>'10%', 'data'=>'fst_sales'],
			['title' => 'Customer', 'width'=>'25%', 'data'=>'fst_customer'],
			['title' => 'Date IN', 'width' =>'15%', 'data'=>'fdt_checkin_datetime'],
			['title' => 'Date Out', 'width' =>'15%', 'data'=>'fdt_checkout_datetime'],
			['title' => 'Range (meters)', 'width' =>'15%', 'data'=>'fin_distance_meters'],
			['title' => 'Duration', 'width' =>'15%', 'data'=>'fin_visit_duration','className'=>'dt-body-right text-right'],
			['title' => 'Action', 'width'=>'10%', 'data'=>'action','sortable'=>false, 'className'=>'dt-center']
		];

        $main_header = $this->parser->parse('inc/main_header',[],true);
    	$main_sidebar = $this->parser->parse('inc/main_sidebar',[],true);
        $page_content = $this->parser->parse('sales_records',$this->list,true);
        $main_footer = $this->parser->parse('inc/main_footer',[],true);
        $control_sidebar=null;
        $this->data['ACCESS_RIGHT']="A-C-R-U-D-P";
        $this->data['MAIN_HEADER'] = $main_header;
        $this->data['MAIN_SIDEBAR']= $main_sidebar;
        $this->data['PAGE_CONTENT']= $page_content;
        $this->data['MAIN_FOOTER']= $main_footer;        
        $this->parser->parse('template/main',$this->data);
    }

    public function fetch_list_data(){
		$this->load->library("datatables");
		$this->load->model("customer_model");
		
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
			(SELECT a.fin_id,
			CONCAT(a.fst_sales_code,' - ',b.fst_sales_name) as fst_sales,a.fst_sales_code,
			CONCAT (a.fst_cust_code,' - ',c.fst_cust_name) as fst_customer,a.fst_cust_code,
			fdt_checkin_datetime,fdt_checkout_datetime,fin_distance_meters,a.fst_active,			
			TIMEDIFF(fdt_checkout_datetime,fdt_checkin_datetime) as fin_visit_duration
			FROM trcheckinlog a 
			INNER JOIN tbsales b ON a. fst_sales_code = b.fst_sales_code
			INNER JOIN tbcustomers c ON a.fst_cust_code = c.fst_cust_code
			WHERE DATE(fdt_checkin_datetime) >= '$dateStart' and DATE(fdt_checkin_datetime) <= '$dateEnd' 
			) as trcheckinlog
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
		foreach ($arrData as $data) {
			//action			
			//$data["inSchedule"] = $this->customer_model->inSchedule($data["fst_cust_code"],$data["fst_sales_code"],$data["fdt_checkin_datetime"]);
			$data["inSchedule"] = $this->customer_model->inSchedule($data["fst_cust_code"],$data["fdt_checkin_datetime"]);
			$diff = strtotime($data["fdt_checkout_datetime"]) - strtotime($data["fdt_checkin_datetime"]);
			$days = floor($diff/86400);
			$diff = $diff % 86400;
			$days = $days == 0 ? "": $days .' days ';
			$data["fin_visit_duration"] = $days . gmdate("H:i:s", $diff);
			$data["action"]	= "<div style='font-size:16px'>
				<a class='btn-detail' href='#' data-id=''>Detail</a>				
			</div>";
	
			$arrDataFormated[] = $data;
			}

		$datasources["data"] = $arrDataFormated;
		$this->json_output($datasources);
    }

	public function fetch_detail_log(){
		$this->load->model('trcheckinlog_model');
		$fstSalesCode = $this->input->post("fst_sales_code");
		$fstCustomerCode = $this->input->post("fst_cust_code");
		$fdtDate = $this->input->post("fdt_date");
		$data = $this->trcheckinlog_model->getDataDetail($fstSalesCode,$fstCustomerCode,$fdtDate);
		$this->json_output($data);
	}

    
	public function show_log_pic($id){
		$pic = md5("doc_" . $id) . ".jpg";
		redirect(base_url() ."uploads/checkinlog/" . $pic, 'auto', $code = NULL);
	}

	public function get_log_pics($id){
		//$pic = md5("doc_" . $id) . ".jpg";
		$pic = md5("doc_" . $id) . "*";
		
		//$pic ="*.*";

		//$dir = APPPATH . '..\\uploads\\checkinlog\\' . $pic;
		//$dir = APPPATH . '..\\uploads\\checkinlog\\';
		$dir = APPPATH . '../uploads/checkinlog/';
		chdir($dir);

		//$dir = APPPATH . '../uploads/checkinlog/' . $pic;
		//echo $dir;
		//$arrfiles = glob(base_url()."uploads/checkinlog/". $pic . "*");
		$arrFiles = glob($pic);		
		$result =[
			"files"=>$arrFiles
		];
		//var_dump($arrfiles);
		$this->json_output($result);
	}

	public function show_link_pics($id)	{
		$pic = md5("doc_" . $id) . "*";		
		$dir = APPPATH . '../uploads/checkinlog/';
		chdir($dir);
		$arrFiles = glob($pic);	
		
		

		

       	$this->data["arrFiles"] = $arrFiles;
		$this->parser->parse('pages/checkin_pic',$this->data);
		

		
	}

    public function tracking(){
		$this->load->library("menus");
	    $main_header = $this->parser->parse('inc/main_header',[],true);
		$main_sidebar = $this->parser->parse('inc/main_sidebar',[],true);

		//$data["mode"] = $mode;
		$data = [];
		$data["title"] = "Sales Tracking";
		//$data["fin_user_id"] = $fin_user_id;
		
		$page_content = $this->parser->parse('sales_tracking',$data,true);
		$main_footer = $this->parser->parse('inc/main_footer',[],true);
			
		$control_sidebar = NULL;
		$this->data["MAIN_HEADER"] = $main_header;
		$this->data["MAIN_SIDEBAR"] = $main_sidebar;
		$this->data["PAGE_CONTENT"] = $page_content;
		$this->data["MAIN_FOOTER"] = $main_footer;
		$this->data["CONTROL_SIDEBAR"] = $control_sidebar;
		$this->parser->parse('template/main',$this->data);
	}

	public function data_tracking(){
		$this->load->model("trcheckinlog_model");
		$fstSalesCode = $this->input->post("fst_sales_code");
		$fdtDate = dateFormat($this->input->post("fdt_date"),"j-m-Y","Y-m-d");
		//print_r($_POST);
		$data = $this->trcheckinlog_model->getDataTracking($fstSalesCode,$fdtDate);
		$this->json_output($data);


	}
	
	public function get_sales(){
		$this->load->model("sales_model");
		$data = $this->sales_model->get_select2();
		$result["data"] = $data;
		$this->json_output($result);

	}

    public function getAllList(){
		$this->load->model('users_model');
        $result = $this->users_model->getAllList();
		$this->ajxResp["data"] = $result;
		$this->json_output();	
	}
	
	public function report_users(){
        $this->load->library('pdf');
        //$customPaper = array(0,0,381.89,595.28);
        //$this->pdf->setPaper($customPaper, 'landscape');
        //$this->pdf->setPaper('A4', 'portrait');
		$this->pdf->setPaper('A4', 'landscape');
		
		$this->load->model("users_model");
		$listUser = $this->users_model->get_Users();
        $data = [
			"datas" => $listUser
		];
			
        $this->pdf->load_view('report/users_pdf', $data);
        $this->Cell(30,10,'Percobaan Header Dan Footer With Page Number',0,0,'C');
		$this->Cell(0,10,'Halaman '.$this->PageNo().' dari {nb}',0,0,'R');
    }

	public function record2Excel(){
		
		$this->load->model("customer_model");
		$datelog = $this->input->get("dateLog");

		//selectSearch
		
		$arrDateLog = explode("-",$datelog);
		$dateStart = dateFormat(trim($arrDateLog[0]),"j/m/Y","Y-m-d");
		$dateEnd = dateFormat(trim($arrDateLog[1]),"j/m/Y","Y-m-d");
		
		$ssql = "SELECT a.fin_id,
			CONCAT(a.fst_sales_code,' - ',b.fst_sales_name) as fst_sales,a.fst_sales_code,
			CONCAT (a.fst_cust_code,' - ',c.fst_cust_name) as fst_customer,a.fst_cust_code,
			fdt_checkin_datetime,fdt_checkout_datetime,fin_distance_meters,a.fst_active,
			TIMEDIFF(fdt_checkout_datetime,fdt_checkin_datetime) as fin_visit_duration,
			c.fin_visit_day 
			FROM trcheckinlog a 
			INNER JOIN tbsales b ON a. fst_sales_code = b.fst_sales_code
			INNER JOIN tbcustomers c ON a.fst_cust_code = c.fst_cust_code
			WHERE DATE(fdt_checkin_datetime) >= '$dateStart' and DATE(fdt_checkin_datetime) <= '$dateEnd'";
	
		$query = $this->db->query($ssql,[]);
		$rs = $query->result();
		
		$this->load->library('phpspreadsheet');
		
		//echo FCPATH . "assets\\templates\\". "template_sales_log.xlsx";		 
		//$spreadsheet = $this->phpspreadsheet->load(FCPATH . "assets\\templates\\template_sales_log.xlsx");		
		$spreadsheet = $this->phpspreadsheet->load(FCPATH . "assets/templates/template_sales_log.xls","xls");		
		//$spreadsheet = $this->phpspreadsheet->load(FCPATH . "assets/templates/template_espb_list.xls","xls");		

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
		
		$inScheduleStyle =[
			'fill' => array(
				'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_NONE,
				'color' => array('rgb' => 'FFFFFF')
			)
		];

		$outOfScheduleStyle =[
			'fill' => array(
				'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
				'color' => array('rgb' => 'F5BEBE')
			)
		];
		
		foreach($rs as $rw){
			if ($this->customer_model->inSchedule($rw->fst_cust_code,$rw->fst_sales_code,$rw->fdt_checkin_datetime)){
				$sheet->getStyle("A$iRow:H$iRow")->applyFromArray($inScheduleStyle);
			}else{
				$sheet->getStyle("A$iRow:H$iRow")->applyFromArray($outOfScheduleStyle);
			}

			$sheet->setCellValue("A$iRow", $rw->fin_id); 
			$sheet->setCellValue("B$iRow", $rw->fst_sales);
			$sheet->setCellValue("C$iRow", $rw->fst_customer);
			$sheet->setCellValue("D$iRow", $rw->fdt_checkin_datetime);
			$sheet->setCellValue("E$iRow", $rw->fdt_checkout_datetime);			
			$sheet->setCellValue("F$iRow", $rw->fin_visit_duration);
			$sheet->setCellValue("G$iRow", $rw->fin_distance_meters);
			$checkindate = strtotime($rw->fdt_checkin_datetime);
			$sheet->setCellValue("H$iRow", date("Y-m-d",$checkindate));

			$sheet->setCellValue("I$iRow", visit_day_name($rw->fin_visit_day));
			$sheet->setCellValue("J$iRow", 'Photo');
			$sheet->getCell("J$iRow")->getHyperlink()->setUrl(site_url() . "sales/show_link_pics/" .$rw->fin_id);
			//$sheet->getCell("H$iRow")->getHyperlink()->setUrl("http://armex.qsystem-online.com/sales/show_link_pics/" .$rw->fin_id);
			
			//$sheet->getStyle("H$iRow")->applyFromArray($outOfScheduleStyle);

			$iRow++;
		}
		
		//var_dump($spreadsheet);
		$this->phpspreadsheet->save("sales_report_" . date("Ymd") ,$spreadsheet);
		//$this->phpspreadsheet->save("test-coba");		
	}
	

	public function schedule(){
		$this->load->library("menus");
		//$this->load->model("groups_model");

		if($this->input->post("submit") != "" ){
			$this->add_save();
		}

        $main_header = $this->parser->parse('inc/main_header',[],true);
		$main_sidebar = $this->parser->parse('inc/main_sidebar',[],true);
		
		$data["title"] = "Schedule";
		
		$ssql ="SELECT * FROM tbsales where fst_active = 'A'";
		$qr = $this->db->query($ssql);
		$arrSales = $qr->result();
		$data["arrSales"] = $arrSales;		
		$page_content = $this->parser->parse('pages/sales/schedule',$data,true);
		$main_footer = $this->parser->parse('inc/main_footer',[],true);
			
		$control_sidebar = NULL;
		$this->data["MAIN_HEADER"] = $main_header;
		$this->data["MAIN_SIDEBAR"] = $main_sidebar;
		$this->data["PAGE_CONTENT"] = $page_content;
		$this->data["MAIN_FOOTER"] = $main_footer;
		$this->data["CONTROL_SIDEBAR"] = $control_sidebar;
		$this->parser->parse('template/main',$this->data);
	}


	public function ajxGetCustomer($fst_sales_code){
		$ssql = "Select * from tbcustomers where fst_sales_code = ?";
		$qr = $this->db->query($ssql,[$fst_sales_code]);
		$rs = $qr->result();

		$result=[
			"arrCustomer"=>$rs
		];

		header('Content-Type: application/json');
		echo json_encode($result);
		
	}

	public function ajxSchedule_add(){
		$this->load->helper("utils");
		$fdt_schedule_date = $this->input->post("fdt_schedule_date");
		$fst_cust_code = $this->input->post("fst_cust_code");
		$fdt_schedule_date = dBDateFormat($fdt_schedule_date);
		$data = [
			"fdt_schedule_date" => $fdt_schedule_date,
			"fst_cust_code" => $fst_cust_code
		];

		$this->db->insert("tbjadwalsales",$data);
		$error = $this->db->error(); // Has keys 'code' and 'message'
		if ($error["code"] != 0){
			$message = "Failed add schedule !";
			if ($error["code"] == 1062){
				$message = "Customer sudah terdaftar";
			}
			$result=[
				"status"=>"FAILED",
				"message"=>$message,
				"data"=>$error,
			];
		}else{	
			$insert_id = $this->db->insert_id();	
			$result=[
				"status"=>"SUCCESS",
				"message"=>"",
				"data"=>$data,
				"insertId"=>$insert_id,
			];
		}
		header('Content-Type: application/json');
		echo json_encode($result);
	}	

	public function ajxSchedule_list($fdt_schedule_date,$fst_sales_code){
		$this->load->helper("utils");
		//$fdt_schedule_date = $this->input->post("fdt_schedule_date");
		$fdt_schedule_date = dBDateFormat($fdt_schedule_date);
		if ($fst_sales_code == "ALL"){
			$ssql = "SELECT a.*,b.fst_cust_name,b.fst_sales_code,c.fst_sales_name FROM tbjadwalsales a
				INNER JOIN tbcustomers b on a.fst_cust_code = b.fst_cust_code 
				INNER JOIN tbsales c on b.fst_sales_code= c.fst_sales_code 
				WHERE a.fdt_schedule_date = ?";		
			$qr = $this->db->query($ssql,[$fdt_schedule_date]);
		}else{
			$ssql = "SELECT a.*,b.fst_cust_name,b.fst_sales_code,c.fst_sales_name FROM tbjadwalsales a
				INNER JOIN tbcustomers b on a.fst_cust_code = b.fst_cust_code 
				INNER JOIN tbsales c on b.fst_sales_code= c.fst_sales_code 
				WHERE a.fdt_schedule_date = ? and c.fst_sales_code = ?";		
			$qr = $this->db->query($ssql,[$fdt_schedule_date,$fst_sales_code]);
		}

		
		$error = $this->db->error(); // Has keys 'code' and 'message'
		//var_dump($error);
		$rs = $qr->result();
		$result=[
			"status"=>"SUCCESS",
			"data"=>$rs,
		];
		
		header('Content-Type: application/json');
		echo json_encode($result);
	}	
	function ajxSchedule_delete($finRecId){
		//$ssql ="DELETE FROM tbjadwalsales where fin_rec_id = ?";
		$this->db->delete('tbjadwalsales', array('fin_rec_id' => $finRecId)); 
		$error = $this->db->error(); // Has keys 'code' and 'message'
		if ($error["code"] != 0){
			$result=[
				"status"=>"FAILED",		
				"message"=>$error["message"],
				"data"=>$error,
			];
		}else{
			$result=[
				"status"=>"SUCCESS",			
				"message"=>"",
			];
		}
		header('Content-Type: application/json');
		echo json_encode($result);

		
		
		

	}


	public function schedule_monitoring(){
		$this->load->library("menus");
		//$this->load->model("groups_model");

        $main_header = $this->parser->parse('inc/main_header',[],true);
		$main_sidebar = $this->parser->parse('inc/main_sidebar',[],true);
		
		$data["title"] = "Schedule Monitoring";
		
		$page_content = $this->parser->parse('pages/sales/schedule_monitoring',$data,true);
		$main_footer = $this->parser->parse('inc/main_footer',[],true);
			
		$control_sidebar = NULL;
		$this->data["MAIN_HEADER"] = $main_header;
		$this->data["MAIN_SIDEBAR"] = $main_sidebar;
		$this->data["PAGE_CONTENT"] = $page_content;
		$this->data["MAIN_FOOTER"] = $main_footer;
		$this->data["CONTROL_SIDEBAR"] = $control_sidebar;
		$this->parser->parse('template/main',$this->data);
	}

	public function ajxScheduleMonitoringData(){
		$fstDateRange = $this->input->post("fstDateRange");
		$fstStatus = $this->input->post("fstStatus");

		$arrDateRange = explode(" - ",$fstDateRange);
		if (sizeof($arrDateRange) != 2){
			$result = [
				"status"=>"SUCCESS",
				"data"=>[]
			];
			header('Content-Type: application/json');
			echo json_encode($result);
			die();
		}

		$fstStartDate = dBDateFormat($arrDateRange[0]);
		$fstEndDate = dBDateFormat($arrDateRange[1]);
		$ssql = "";
		switch ($fstStatus){
			case "ALL":
				$ssql = "SELECT a.*,b.fst_cust_name,b.fst_sales_code,c.fst_sales_name FROM tbjadwalsales a
					INNER JOIN tbcustomers b on a.fst_cust_code = b.fst_cust_code
					INNER JOIN tbsales c on b.fst_sales_code = c.fst_sales_code
					where a.fdt_schedule_date between  ? and ?";
				break;
			case "VISITED":
				$ssql = "SELECT a.*,b.fst_cust_name,b.fst_sales_code,c.fst_sales_name FROM tbjadwalsales a
					INNER JOIN tbcustomers b on a.fst_cust_code = b.fst_cust_code
					INNER JOIN tbsales c on b.fst_sales_code = c.fst_sales_code
					where a.fdt_schedule_date between  ? and ? and fbl_visited = true";
				break;
			case "UNVISITED":
				$ssql = "SELECT a.*,b.fst_cust_name,b.fst_sales_code,c.fst_sales_name FROM tbjadwalsales a
					INNER JOIN tbcustomers b on a.fst_cust_code = b.fst_cust_code
					INNER JOIN tbsales c on b.fst_sales_code = c.fst_sales_code
					where a.fdt_schedule_date between  ? and ? and fbl_visited = false";
				break;
		}
		$qr = $this->db->query($ssql,[$fstStartDate,$fstEndDate]);
		$rs = $qr->result();

		$result = [
			"status"=>"SUCCESS",
			"data"=>$rs
		];

		header('Content-Type: application/json');
		echo json_encode($result);

	}


}