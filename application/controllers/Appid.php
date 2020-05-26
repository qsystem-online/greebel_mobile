<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Appid extends MY_Controller {

    public function __construct(){
        parent:: __construct();
        $this->load->library('form_validation');
    }

    public function index(){
        $this->view_list();
    }

    public function view_list(){
		$this->load->model("appid_model");

        $this->load->library('menus');
        $this->list['page_name']="APLICATION ID";
        $this->list['list_name']="App ID List";
        
      

        $this->list['breadcrumbs']=[
			['title'=>'Home','link'=>'#','icon'=>"<i class='fa fa-dashboard'></i>"],
			['title'=>'APP ID','link'=>'#','icon'=>''],
			['title'=>'List','link'=> NULL ,'icon'=>''],
		];


        $main_header = $this->parser->parse('inc/main_header',[],true);
    	$main_sidebar = $this->parser->parse('inc/main_sidebar',[],true);
        $page_content = $this->parser->parse('pages/appidList',$this->list,true);
        $main_footer = $this->parser->parse('inc/main_footer',[],true);
        $control_sidebar=null;
        $this->data['ACCESS_RIGHT']="A-C-R-U-D-P";
        $this->data['MAIN_HEADER'] = $main_header;
        $this->data['MAIN_SIDEBAR']= $main_sidebar;
        $this->data['PAGE_CONTENT']= $page_content;
        $this->data['MAIN_FOOTER']= $main_footer;        
        $this->parser->parse('template/main',$this->data);
    }

	public function ajx_update_status(){
		$this->load->model("appid_model");

		
		$id = $this->input->post("fin_rec_id");
		$checked = $this->input->post("checked");

		$this->appid_model->updateStatus($id,$checked);

		$this->json_output([
			"status"=>"SUCCESS",
			"message"=>"",
			"data"=>[]
		]);
		
	}
	
	
















	
	public function maps(){
		$this->load->library("menus");
		$this->load->model("sales_model");
		
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
            'fst_cust_code' => 'Code',
            'fst_cust_name' => 'Name'
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
			['title' => 'Zoom Level', 'width' =>'10%', 'data'=>'fin_view_zoom_level'],
			['title' => 'Radius (meters)', 'width' =>'10%', 'data'=>'fin_radius_meters'],
			['title' => 'Action', 'width'=>'10%', 'data'=>'action','sortable'=>false, 'className'=>'text-center']
		];

		$this->list["pickup_location_modal"] = $this->parser->parse('template/pickup_location_modal',[],true);
		
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

	public function ajxUpdateLocation(){
		$input =$this->input->post();
		
		$fstCustCode = $this->input->post("fst_cust_code");
		$ssql = "SELECT * FROM tblocation where fst_cust_code =?";
		$qr = $this->db->query($ssql,[$fstCustCode]);
		$rw = $qr->row();
		$mode = "";
		if ($rw == null){
			//insert
			$data = [
				"fst_cust_code"=>$fstCustCode,
				"fst_cust_location"=> $this->input->post("fst_cust_location"),
				"fin_view_zoom_level"=> $this->input->post("fin_view_zoom_level"),
				"fin_radius_meters"=> $this->input->post("fin_radius_meters"),
				"fst_active"=>'A',
				"fin_insert_id"=>$this->aauth->get_user_id(),
				"fdt_insert_datetime"=>date("Y-m-d H:i:s")
			];
			$this->db->insert("tblocation",$data);
			$mode = "INSERT";
		}else{
			$data = [
				"fst_cust_code"=>$fstCustCode,
				"fst_cust_location"=> $this->input->post("fst_cust_location"),
				"fin_view_zoom_level"=> $this->input->post("fin_view_zoom_level"),
				"fin_radius_meters"=> $this->input->post("fin_radius_meters"),
				"fst_active"=>'A',
				"fin_update_id"=>$this->aauth->get_user_id(),
				"fdt_update_datetime"=>date("Y-m-d H:i:s")
			];
			$this->db->where("fst_cust_code",$fstCustCode);
			$this->db->update("tblocation",$data);
			$mode = "UPDATE";
		}
		$error = $this->db->error();
		if ($error["code"] == 0){
			$result = [
				"status"=>"SUCCESS",	
				"mode"=>$mode,			
			];
		}else{
			$result = [
				"status"=>"FAILED",
			];
		}
		header('Content-Type: application/json');
		echo json_encode($result);
		
		
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
			(Select a.*,b.fst_cust_location,b.fin_view_zoom_level,b.fin_radius_meters from tbcustomers a inner join tblocation b on a.fst_cust_code = b.fst_cust_code) as tbcustloc
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
				<a class='btn-edit' href='#' data-original-title='' title=''><i class='fa fa-pencil'></i></a>	
				<a class='btn-delete' href='#' data-toggle='confirmation' data-original-title='' title=''><i class='fa fa-trash'></i></a>	
				<a style='display:unset' class='btn-map' href='#'  data-original-title='' title=''><i class='fa fa-map-marker' aria-hidden='true'></i></a>			
			</div>";
	
			$arrDataFormated[] = $data;
			}

		$datasources["data"] = $arrDataFormated;
		$this->json_output($datasources);
	}
	
	public function delete_location($fst_cust_code){
		$this->db->where('fst_cust_code', $fst_cust_code);
		$this->db->delete("tblocation");
		$result =[
			"status"=>"SUCCESS"
		];
		header('Content-Type: application/json');
		echo json_encode($result);

	}

	public function ajxCustHaveNoLocation(){
		$term  = $this->input->get("term");

		$ssql = "select fst_cust_code,fst_cust_name from tbcustomers where fst_cust_code not in (select fst_cust_code from tblocation) and( fst_cust_name like ? or fst_cust_code like ?)";
		$qr = $this->db->query($ssql,["%$term%","%$term%"]);
		$rs = $qr->result();
		$result=[
			"status"=>"SUCCESS",
			"data"=>$rs
		];

		header('Content-Type: application/json');
		echo json_encode($result);

	}

	public function ajxCustList(){
		$this->load->model("customer_model");

		$fstSalesCode = $this->input->get("fstSalesCode");

		$data = $this->customer_model->get_select2($fstSalesCode);
		$result = [];
		$result["status"] ="SUCCESS";		
		$result["data"] = $data;

		$this->json_output($result);
	}

	public function ajx_get_cust_by_sales(){
		$this->load->model("customer_model");

		$fstSalesCode = $this->input->get("fst_sales_code");

		$rs = $this->customer_model->get_select2($fstSalesCode);
		
		$result["status"] ="SUCCESS";		
		$result["message"] ="";		
		$result["data"] = $rs;

		$this->json_output($result);

	}
}