<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends MY_Controller {

    public function __construct(){
        parent:: __construct();
        $this->load->library('form_validation');
    }

    public function index(){
        $this->view_list();
    }

    public function view_list(){
        $this->load->library('menus');
        $this->list['page_name']="Customer";
        $this->list['list_name']="Customer List";
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
        $page_content = $this->parser->parse('customerList',$this->list,true);
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
			
			$data["inSchedule"] = $this->customer_model->inSchedule($data["fst_cust_code"],$data["fdt_checkin_date"]);
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

	
	
	public function maps(){
		$this->load->library("menus");
	    $main_header = $this->parser->parse('inc/main_header',[],true);
		$main_sidebar = $this->parser->parse('inc/main_sidebar',[],true);

		//$data["mode"] = $mode;
		$data = [];
		$data["title"] = "Customer Maps";
		//$data["fin_user_id"] = $fin_user_id;
		
		$page_content = $this->parser->parse('customer_map',$data,true);
		$main_footer = $this->parser->parse('inc/main_footer',[],true);
			
		$control_sidebar = NULL;
		$this->data["MAIN_HEADER"] = $main_header;
		$this->data["MAIN_SIDEBAR"] = $main_sidebar;
		$this->data["PAGE_CONTENT"] = $page_content;
		$this->data["MAIN_FOOTER"] = $main_footer;
		$this->data["CONTROL_SIDEBAR"] = $control_sidebar;
		$this->parser->parse('template/main',$this->data);
	}

	public function get_customer(){
		$this->load->model("customer_model");
		$data = $this->customer_model->get_select2();
		$result["data"] = $data;
		$this->json_output($result);
	}

    public function delete($id){
        if(!$this->aauth->is_permit("")){
		    $this->ajxResp["status"] = "NOT_PERMIT";
			$this->ajxResp["message"] = "You not allowed to do this operation !";
			$this->json_output();
			return;
		}
			
		$this->load->model("users_model");
			
		$this->users_model->delete($id);
		$this->ajxResp["status"] = "SUCCESS";
		$this->ajxResp["message"] = "";
		$this->json_output();
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

	public function listLocation(){
		$this->load->library('menus');
        $this->list['page_name']="Customer";
        $this->list['list_name']="Customer Location";
        $this->list['pKey']="id";
		$this->list['fetch_list_data_ajax_url']=site_url().'customer/fetch_list_location_data';
        $this->list['arrSearch']=[
            'a.fst_cust_code' => 'Code',
            'a.fst_cust_name' => 'Name'
		];

        $this->list['breadcrumbs']=[
			['title'=>'Home','link'=>'#','icon'=>"<i class='fa fa-dashboard'></i>"],
			['title'=>'Customer','link'=>'#','icon'=>''],
			['title'=>'Location','link'=> NULL ,'icon'=>''],
		];

		$this->list['columns']=[
			['title' => 'Code', 'width'=>'10%', 'data'=>'fst_cust_code'],
			['title' => 'Name', 'width'=>'25%', 'data'=>'fst_cust_name'],
			['title' => 'Location', 'width' =>'10%', 'data'=>'fst_cust_location'],
			['title' => 'Action', 'width'=>'10%', 'data'=>'action','sortable'=>false, 'className'=>'text-center']
		];

        $main_header = $this->parser->parse('inc/main_header',[],true);
    	$main_sidebar = $this->parser->parse('inc/main_sidebar',[],true);
        $page_content = $this->parser->parse('customerLocationList',$this->list,true);
        $main_footer = $this->parser->parse('inc/main_footer',[],true);
        $control_sidebar=null;
        $this->data['ACCESS_RIGHT']="A-C-R-U-D-P";
        $this->data['MAIN_HEADER'] = $main_header;
        $this->data['MAIN_SIDEBAR']= $main_sidebar;
        $this->data['PAGE_CONTENT']= $page_content;
        $this->data['MAIN_FOOTER']= $main_footer;        
        $this->parser->parse('template/main',$this->data);
	}

	public function fetch_list_location_data(){
		$this->load->library("datatables");
		$this->load->model("customer_model");
		
		/*
		$datelog = $this->input->get("dateLog");
		$arrDateLog = explode("-",$datelog);
		$dateStart = dateFormat(trim($arrDateLog[0]),"j/m/Y","Y-m-d");
		$dateEnd = dateFormat(trim($arrDateLog[1]),"j/m/Y","Y-m-d");
		*/

		$this->datatables->setTableName("
			(Select a.*,b.fst_cust_location from tbcustomers a inner join tblocation b on a.fst_cust_code = b.fst_cust_code) as tbcustloc
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
			
			//$data["inSchedule"] = $this->customer_model->inSchedule($data["fst_cust_code"],$data["fdt_checkin_date"]);
			$data["action"]	= "<div style='font-size:16px'>				
				<a class='btn-delete' href='#' data-toggle='confirmation' data-original-title='' title=''><i class='fa fa-trash'></i></a>	
				<a style='display:unset' class='btn-map' href='#'  data-original-title='' title=''><i class='fa fa-map-marker' aria-hidden='true'></i></a>			
			</div>";
	
			$arrDataFormated[] = $data;
			}

		$datasources["data"] = $arrDataFormated;
		$this->json_output($datasources);
	}
	
	public function delete_location($fst_cust_code){
		$this->db->where('fst_customer_code', $fst_cust_code);
		$this->db->delete("tblocation");
		$result =[
			"status"=>"SUCCESS"
		];
		header('Content-Type: application/json');
		echo json_encode($result);

	}
}