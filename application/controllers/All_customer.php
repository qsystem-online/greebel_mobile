<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class All_customer extends MY_Controller {

    public function __construct(){
        parent:: __construct();
        $this->load->library('form_validation');
    }

    public function index(){
        $this->view_list();
    }

    public function view_list(){
        $this->load->library('menus');
        $this->list['page_name']="All Customer";
        $this->list['list_name']="All Customer List";
        $this->list['fetch_list_data_ajax_url']=site_url().'all_customer/fetch_list_data';
        $this->list['arrSearch']=[
            'a.fst_cust_name' => 'Customer Name',
            'a.fst_sales_code' => 'Sales Code'
		];

        $this->list['breadcrumbs']=[
			['title'=>'Home','link'=>'#','icon'=>"<i class='fa fa-dashboard'></i>"],
			['title'=>'All Customer','link'=>'#','icon'=>''],
			['title'=>'List','link'=> NULL ,'icon'=>''],
		];

		$this->list['columns']=[
            ['title' => 'Cust Code', 'width'=>'10%', 'data'=>'fst_cust_code'],
			['title' => 'Full Name', 'width'=>'20%', 'data'=>'fst_cust_name'],
			['title' => 'Address', 'width' =>'25%', 'data'=>'fst_cust_address'],
            ['title' => 'Sales', 'width' =>'10%', 'data'=>'fst_sales_name',
                'render'=>"function(data,type,row){
                    return row.fst_sales_name.replace(/\\r/g,'<br>');
                }"
			],
			['title' => 'Group', 'width' =>'10%', 'data'=>'fin_price_group_id',
                'render'=>"function(data,type,row){
					//1;Retail;2;Hypermarket;3;Grosir;4;Sekolah/PO;5;MT Lokal;9;Group SMM/Internal
                    if (data ==1){
						return 'RETAIL';
					}else if(data ==2){
						return 'HYPERMARKET';
					}else if(data ==3){
						return 'GROSIR';
					}else if(data ==4){
						return 'SEKOLAH/PO';
					}else if(data ==5){
						return 'MT LOKAL';
					}else if(data == 9){
						return 'GROUP SMM/INTERNAL';
					}				
                }"
			],
			
            ['title' => 'Status', 'width' =>'5%', 'data'=>'fbl_is_new',
				'render'=>"function(data,type,row){
					if (data ==0){
						return 'OLD';
					}else if(data ==1){
						return 'NEW';
					}
				}"
		    ],
            ['title' => 'Create Date', 'width' =>'10%', 'data'=>'fdt_created_datetime'],            
            ['title' => 'Action', 'width'=>'10%', 'data'=>'','sortable'=>false, 'className'=>'dt-center',
                'render'=>"function(data,type,row){
					action = '<a class=\"btn-detail\" href=\"#\"><i style=\"font-size:14pt;margin-right:10px;\" class=\"fa fa-info\"></i></a>';
					return action;
                        
                }"
            ]
		];

        $main_header = $this->parser->parse('inc/main_header',[],true);
    	$main_sidebar = $this->parser->parse('inc/main_sidebar',[],true);
        $page_content = $this->parser->parse('allCustomerList',$this->list,true);
        $main_footer = $this->parser->parse('inc/main_footer',[],true);
        $control_sidebar =null;
        $this->data['ACCESS_RIGHT']="A-C-R-U-D-P";
        $this->data['MAIN_HEADER'] = $main_header;
        $this->data['MAIN_SIDEBAR']= $main_sidebar;
        $this->data['PAGE_CONTENT']= $page_content;
        $this->data['MAIN_FOOTER']= $main_footer;        
        $this->parser->parse('template/main',$this->data);
    }



    public function fetch_list_data(){
		$this->load->library("datatables");
		$this->load->model("allcustomer_model");
		$this->load->model("msarea_model");		
        $isAllStatus = $this->input->get("optionIsAllStatus");

		$datecreate = $this->input->get("dateCreate");
		$arrDateCreate = explode("-",$datecreate);
		$dateStart = dateFormat(trim($arrDateCreate[0]),"j/m/Y","Y-m-d");
		$dateEnd = dateFormat(trim($arrDateCreate[1]),"j/m/Y","Y-m-d");

		switch ($isAllStatus){
			case 0:
				$this->datatables->setTableName(" (select a.*,b.fst_sales_name from tbcustomers a inner join tbsales b on a.fst_sales_code =b.fst_sales_code WHERE DATE(a.fdt_created_datetime) >= '$dateStart' and DATE(a.fdt_created_datetime) <= '$dateEnd' ) a ");
				break;
			case 1:
				$this->datatables->setTableName(" (select a.*,b.fst_sales_name from tbcustomers a inner join tbsales b on a.fst_sales_code =b.fst_sales_code  WHERE DATE(a.fdt_created_datetime) >= '$dateStart' and DATE(a.fdt_created_datetime) <= '$dateEnd' AND  a.fbl_is_new = '1') a ");
				break;
			case 2:
				$this->datatables->setTableName(" (select a.*,b.fst_sales_name from tbcustomers a inner join tbsales b on a.fst_sales_code =b.fst_sales_code  WHERE DATE(a.fdt_created_datetime) >= '$dateStart' and DATE(a.fdt_created_datetime) <= '$dateEnd' AND a.fbl_is_new = '0') a ");
				break;
		}
		
		$selectFields = "a.*";
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
			$data["action"]	= "<div style='font-size:16px'>
				<a class='btn-detail' href='#' data-id=''>Detail</a>				
			</div>";
			$data["area_detail"] = $this->msarea_model->getAreaDetail($data["fst_area_code"]);
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

	public function show_link_pics($id)	{
		//$pic = md5("doc_" . $id) . "*";		
		//$dir = APPPATH . '../uploads/customers/';
		//chdir($dir);
		//$arrFiles = glob($pic);
		//$arrFiles = glob($pic);		

       	$this->data["unique_id"] = $id;
		$this->parser->parse('pages/customer_pic',$this->data);
		
	}
	public function toExcel(){
		set_time_limit(0);   
		ini_set('mysql.connect_timeout','0');
		ini_set('max_execution_time', '0'); 

		$this->load->model("allcustomer_model");
		$this->load->model("msarea_model");

		$datecreated = $this->input->get("datecreated");
		//var_dump($datecreated);
		//die();
		$arrDateCreate = explode("-",$datecreated);
		$dateStart = dateFormat(trim($arrDateCreate[0]),"j/m/Y","Y-m-d");
		$dateEnd = dateFormat(trim($arrDateCreate[1]),"j/m/Y","Y-m-d");
		$status = $arrDateCreate[2];
		$nouStart = $arrDateCreate[3];
		$nouEnd = $arrDateCreate[4];

		switch ($status){
			case 0:
				//$this->datatables->setTableName(" (select a.*,b.fst_sales_name from tbcustomers a inner join tbsales b on a.fst_sales_code =b.fst_sales_code WHERE DATE(a.fdt_created_datetime) >= '$dateStart' and DATE(a.fdt_created_datetime) <= '$dateEnd' ) a ");
				$ssql ="SELECT a.*,b.fst_sales_name 
				FROM (SELECT *,ROW_NUMBER() OVER () AS Id FROM tbcustomers WHERE DATE(fdt_created_datetime) >= '$dateStart' AND DATE(fdt_created_datetime) <= '$dateEnd') a 
				INNER JOIN tbsales b on a.fst_sales_code =b.fst_sales_code 
				WHERE a.Id BETWEEN $nouStart AND $nouEnd ORDER BY a.Id";
				break;
			case 1:
				//$this->datatables->setTableName(" (select a.*,b.fst_sales_name from tbcustomers a inner join tbsales b on a.fst_sales_code =b.fst_sales_code  WHERE DATE(a.fdt_created_datetime) >= '$dateStart' and DATE(a.fdt_created_datetime) <= '$dateEnd' AND  a.fbl_is_new = '1') a ");
				$ssql ="SELECT a.*,b.fst_sales_name 
				FROM (SELECT *,ROW_NUMBER() OVER () AS Id FROM tbcustomers WHERE DATE(fdt_created_datetime) >= '$dateStart' AND DATE(fdt_created_datetime) <= '$dateEnd' AND  fbl_is_new = '1') a 
				INNER JOIN tbsales b on a.fst_sales_code =b.fst_sales_code 
				WHERE a.Id BETWEEN $nouStart AND $nouEnd ORDER BY a.Id";
				break;
			case 2:
				//$this->datatables->setTableName(" (select a.*,b.fst_sales_name from tbcustomers a inner join tbsales b on a.fst_sales_code =b.fst_sales_code  WHERE DATE(a.fdt_created_datetime) >= '$dateStart' and DATE(a.fdt_created_datetime) <= '$dateEnd' AND a.fbl_is_new = '0') a ");
				$ssql ="SELECT a.*,b.fst_sales_name 
				FROM (SELECT *,ROW_NUMBER() OVER () AS Id FROM tbcustomers WHERE DATE(fdt_created_datetime) >= '$dateStart' AND DATE(fdt_created_datetime) <= '$dateEnd' AND  fbl_is_new = '0') a 
				INNER JOIN tbsales b on a.fst_sales_code =b.fst_sales_code 
				WHERE a.Id BETWEEN $nouStart AND $nouEnd ORDER BY a.Id";
				break;
		}
		/*$ssql ="select a.*,ROW_NUMBER() OVER () AS Id,
			b.fst_sales_name 
			from tbcustomers a 
			inner join tbsales b on a.fst_sales_code =b.fst_sales_code 
			WHERE Id > ? order by Id limit ?";
		*/

		$qr = $this->db->query($ssql,[]);

		//var_dump($this->db->last_query());
		//die();
		$rs = $qr->result();

		$this->load->library('phpspreadsheet');		
		$template = FCPATH . "assets". DIRECTORY_SEPARATOR  ."templates" .DIRECTORY_SEPARATOR ."template_all_customers.xls";
		$spreadsheet = $this->phpspreadsheet->load($template,"xls");		
		
		
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->getPageSetup()->setFitToWidth(1);
		$sheet->getPageSetup()->setFitToHeight(0);
		$sheet->getPageMargins()->setTop(1);
		$sheet->getPageMargins()->setRight(0.5);
		$sheet->getPageMargins()->setLeft(0.5);
		$sheet->getPageMargins()->setBottom(1);
		
		
		//$sheet->setTitle('Coba Aja');
		$iRow = 3;
		foreach($rs as $rw){
			$sheet->setCellValue("A$iRow", $rw->fst_cust_code); 
			$sheet->setCellValue("B$iRow", $rw->fst_cust_name);
			$sheet->setCellValue("C$iRow", $rw->fst_contact);
			$sheet->setCellValue("D$iRow", $rw->fst_cust_phone);
			$rental = "";
			if ($rw->fbl_is_rent == 1){
				$rental = "YES";
			}else{
				$rental = "NO";
			}
			$sheet->setCellValue("E$iRow", $rental);
			$sheet->setCellValue("F$iRow", $rw->fst_cust_address);
			$sheet->setCellValue("G$iRow", $rw->fdc_max_disc);
			
			$result = $this->msarea_model->getAreaDetail($rw->fst_area_code);
			
			$sheet->setCellValue("H$iRow", $result["provinsi"]["code"] ." - " . $result["provinsi"]["name"]);
			$sheet->setCellValue("I$iRow", $result["kabupaten"]["code"] ." - " . $result["kabupaten"]["name"]);
			$sheet->setCellValue("J$iRow", $result["kecamatan"]["code"] ." - " . $result["kecamatan"]["name"]);
			$sheet->setCellValue("K$iRow", $result["kelurahan"]["code"] ." - " . $result["kelurahan"]["name"]);
			$sheet->setCellValue("L$iRow", $rw->fst_area_code);
			$sheet->setCellValue("M$iRow", $rw->fst_sales_name);
			$priceGroup = "";
			switch ($rw->fin_price_group_id){
				case 1:
					$priceGroup = "RETAIL";
					break;
				case 2:
					$priceGroup = "HYPERMARKET";
					break;
				case 3:
					$priceGroup = "GROSIR";
					break;
				case 4:
					$priceGroup = "SEKOLAH/PO";
					break;
				case 5:
					$priceGroup = "MT LOKAL";
					break;
				case 9:
					$priceGroup = "GROUP SMM/INTERNAL";
					break;
				default:
					$priceGroup = $rw->fin_price_group_id;
			}
			$sheet->setCellValue("N$iRow", $priceGroup);
			$status = "";
			switch ($rw->fbl_is_new){
				case 0:
					$status = "OLD";
					break;
				case 1:
					$status = "NEW";
					break;
				default:
					$status = $rw->fbl_is_new;
			}			
			$sheet->setCellValue("O$iRow", $status);			
			$sheet->setCellValue("P$iRow", date("d-m-Y H:i:s",strtotime($rw->fdt_created_datetime)));

			
			//$sheet->setCellValue("Q$iRow", 'Photo');
			//$sheet->getCell("Q$iRow")->getHyperlink()->setUrl(site_url() . "all_customer/show_link_pics/" .$rw->fst_unique_id);	

			
			if ($rw->fst_unique_id !='' || $rw->fst_unique_id != null ) {
				if (file_exists(FCPATH . 'uploads/customers/'.$rw->fst_unique_id . '_front.jpg')
					OR file_exists(FCPATH . 'uploads/customers/'.$rw->fst_unique_id . '_inside.jpg') 
					OR file_exists(FCPATH . 'uploads/customers/'.$rw->fst_unique_id . '_other.jpg'))
				{
					$sheet->setCellValue("Q$iRow", 'Photo');
					$sheet->getCell("Q$iRow")->getHyperlink()->setUrl(site_url() . "all_customer/show_link_pics/" .$rw->fst_unique_id);	

				}else {
					$sheet->setCellValue("Q$iRow", '---');
				}

			}else{
				$sheet->setCellValue("Q$iRow", '---');
			}
		
			


			/*
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
			*/

			$iRow++;
		}		
		//var_dump($spreadsheet);
		$this->phpspreadsheet->save("AllCustomer_list_" .$nouStart."-".$nouEnd ,$spreadsheet);
		//$this->phpspreadsheet->save("test-coba",$spreadsheet);		
		//$this->phpspreadsheet->saveHTML("test-coba");		
		
	}


	public function toExcelXXX(){
		set_time_limit(0);   
		ini_set('mysql.connect_timeout','0');
		ini_set('max_execution_time', '0'); 

		$this->load->model("allcustomer_model");
		$this->load->model("msarea_model");

		$datecreated = $this->input->get("datecreated");
		//var_dump($datecreated);
		//die();
		$arrDateCreate = explode("-",$datecreated);
		$dateStart = dateFormat(trim($arrDateCreate[0]),"j/m/Y","Y-m-d");
		$dateEnd = dateFormat(trim($arrDateCreate[1]),"j/m/Y","Y-m-d");
		$status = $arrDateCreate[2];
		$nouStart = $arrDateCreate[3];
		$nouEnd = $arrDateCreate[4];

		switch ($status){
			case 0:
				//$this->datatables->setTableName(" (select a.*,b.fst_sales_name from tbcustomers a inner join tbsales b on a.fst_sales_code =b.fst_sales_code WHERE DATE(a.fdt_created_datetime) >= '$dateStart' and DATE(a.fdt_created_datetime) <= '$dateEnd' ) a ");
				$ssql ="SELECT a.*,b.fst_sales_name 
				FROM (SELECT *,ROW_NUMBER() OVER () AS Id FROM tbcustomers WHERE DATE(fdt_created_datetime) >= '$dateStart' AND DATE(fdt_created_datetime) <= '$dateEnd') a 
				INNER JOIN tbsales b on a.fst_sales_code =b.fst_sales_code 
				WHERE a.Id BETWEEN $nouStart AND $nouEnd ORDER BY a.Id";
				break;
			case 1:
				//$this->datatables->setTableName(" (select a.*,b.fst_sales_name from tbcustomers a inner join tbsales b on a.fst_sales_code =b.fst_sales_code  WHERE DATE(a.fdt_created_datetime) >= '$dateStart' and DATE(a.fdt_created_datetime) <= '$dateEnd' AND  a.fbl_is_new = '1') a ");
				$ssql ="SELECT a.*,b.fst_sales_name 
				FROM (SELECT *,ROW_NUMBER() OVER () AS Id FROM tbcustomers WHERE DATE(fdt_created_datetime) >= '$dateStart' AND DATE(fdt_created_datetime) <= '$dateEnd' AND  fbl_is_new = '1') a 
				INNER JOIN tbsales b on a.fst_sales_code =b.fst_sales_code 
				WHERE a.Id BETWEEN $nouStart AND $nouEnd ORDER BY a.Id";
				break;
			case 2:
				//$this->datatables->setTableName(" (select a.*,b.fst_sales_name from tbcustomers a inner join tbsales b on a.fst_sales_code =b.fst_sales_code  WHERE DATE(a.fdt_created_datetime) >= '$dateStart' and DATE(a.fdt_created_datetime) <= '$dateEnd' AND a.fbl_is_new = '0') a ");
				$ssql ="SELECT a.*,b.fst_sales_name 
				FROM (SELECT *,ROW_NUMBER() OVER () AS Id FROM tbcustomers WHERE DATE(fdt_created_datetime) >= '$dateStart' AND DATE(fdt_created_datetime) <= '$dateEnd' AND  fbl_is_new = '0') a 
				INNER JOIN tbsales b on a.fst_sales_code =b.fst_sales_code 
				WHERE a.Id BETWEEN $nouStart AND $nouEnd ORDER BY a.Id";
				break;
		}
		/*$ssql ="select a.*,ROW_NUMBER() OVER () AS Id,
			b.fst_sales_name 
			from tbcustomers a 
			inner join tbsales b on a.fst_sales_code =b.fst_sales_code 
			WHERE Id > ? order by Id limit ?";
		*/

		$qr = $this->db->query($ssql,[]);

		//var_dump($this->db->last_query());
		//die();
		$rs = $qr->result();
		$ttlRecord = count($rs);
		$maxRecord = 100;
		$loopTemplate = 0;
		if ($ttlRecord > $maxRecord){
			$loopTemplate = ROUND($ttlRecord / $maxRecord,0);
		}else{
			$loopTemplate = 1;
		}
		//var_dump($loopTemplate);
		//die();
		/*$this->load->library('phpspreadsheet');		
		$template = FCPATH . "assets". DIRECTORY_SEPARATOR  ."templates" .DIRECTORY_SEPARATOR ."template_all_customers.xls";
		$spreadsheet = $this->phpspreadsheet->load($template,"xls");		
		
		
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->getPageSetup()->setFitToWidth(1);
		$sheet->getPageSetup()->setFitToHeight(0);
		$sheet->getPageMargins()->setTop(1);
		$sheet->getPageMargins()->setRight(0.5);
		$sheet->getPageMargins()->setLeft(0.5);
		$sheet->getPageMargins()->setBottom(1);*/
		for ($k = 0 ; $k < $loopTemplate; $k++){
			if($k == 0){
				$this->prepareExcel($k);
			}
			if($k == 1){
				$this->prepareExcel1($k);
			}
			
			/*$sheet->setCellValue("A$iRow", $rw->fst_cust_code); 
			$sheet->setCellValue("B$iRow", $rw->fst_cust_name);
			$sheet->setCellValue("C$iRow", $rw->fst_contact);
			$sheet->setCellValue("D$iRow", $rw->fst_cust_phone);
			$rental = "";
			if ($rw->fbl_is_rent == 1){
				$rental = "YES";
			}else{
				$rental = "NO";
			}
			$sheet->setCellValue("E$iRow", $rental);
			$sheet->setCellValue("F$iRow", $rw->fst_cust_address);
			$sheet->setCellValue("G$iRow", $rw->fdc_max_disc);
			
			$result = $this->msarea_model->getAreaDetail($rw->fst_area_code);
			
			$sheet->setCellValue("H$iRow", $result["provinsi"]["code"] ." - " . $result["provinsi"]["name"]);
			$sheet->setCellValue("I$iRow", $result["kabupaten"]["code"] ." - " . $result["kabupaten"]["name"]);
			$sheet->setCellValue("J$iRow", $result["kecamatan"]["code"] ." - " . $result["kecamatan"]["name"]);
			$sheet->setCellValue("K$iRow", $result["kelurahan"]["code"] ." - " . $result["kelurahan"]["name"]);
			$sheet->setCellValue("L$iRow", $rw->fst_area_code);
			$sheet->setCellValue("M$iRow", $rw->fst_sales_name);
			$priceGroup = "";
			switch ($rw->fin_price_group_id){
				case 1:
					$priceGroup = "RETAIL";
					break;
				case 2:
					$priceGroup = "HYPERMARKET";
					break;
				case 3:
					$priceGroup = "GROSIR";
					break;
				case 4:
					$priceGroup = "SEKOLAH/PO";
					break;
				case 5:
					$priceGroup = "MT LOKAL";
					break;
				case 9:
					$priceGroup = "GROUP SMM/INTERNAL";
					break;
				default:
					$priceGroup = $rw->fin_price_group_id;
			}
			$sheet->setCellValue("N$iRow", $priceGroup);
			$status = "";
			switch ($rw->fbl_is_new){
				case 0:
					$status = "OLD";
					break;
				case 1:
					$status = "NEW";
					break;
				default:
					$status = $rw->fbl_is_new;
			}			
			$sheet->setCellValue("O$iRow", $status);			
			$sheet->setCellValue("P$iRow", date("d-m-Y H:i:s",strtotime($rw->fdt_created_datetime)));
			if ($rwItem) {
				if (file_exists(FCPATH . 'uploads/customers/'.$rw->fst_unique_id . '_front.jpg')) {

				} else {

				}

			}
			$sheet->setCellValue("Q$iRow", 'Photo');
			$sheet->getCell("Q$iRow")->getHyperlink()->setUrl(site_url() . "all_customer/show_link_pics/" .$rw->fst_unique_id);
			*/
			/*if($k == 0){
				$this->load->library('phpspreadsheet');		
				$template = FCPATH . "assets". DIRECTORY_SEPARATOR  ."templates" .DIRECTORY_SEPARATOR ."template_all_customers.xls";
				$spreadsheet = $this->phpspreadsheet->load($template,"xls");		
				
				
				$sheet = $spreadsheet->getActiveSheet();
				$sheet->getPageSetup()->setFitToWidth(1);
				$sheet->getPageSetup()->setFitToHeight(0);
				$sheet->getPageMargins()->setTop(1);
				$sheet->getPageMargins()->setRight(0.5);
				$sheet->getPageMargins()->setLeft(0.5);
				$sheet->getPageMargins()->setBottom(1);
				$this->phpspreadsheet->save("AllCustomer_list_X" .$nouStart."-".$nouEnd ,$spreadsheet);
			}
			if($k == 1){
				$this->load->library('phpspreadsheet');		
				$template = FCPATH . "assets". DIRECTORY_SEPARATOR  ."templates" .DIRECTORY_SEPARATOR ."template_all_customers.xls";
				$spreadsheet = $this->phpspreadsheet->load($template,"xls");		
				
				
				$sheet = $spreadsheet->getActiveSheet();
				$sheet->getPageSetup()->setFitToWidth(1);
				$sheet->getPageSetup()->setFitToHeight(0);
				$sheet->getPageMargins()->setTop(1);
				$sheet->getPageMargins()->setRight(0.5);
				$sheet->getPageMargins()->setLeft(0.5);
				$sheet->getPageMargins()->setBottom(1);
				$this->phpspreadsheet->save("AllCustomer_list_1" .$nouStart."-".$nouEnd ,$spreadsheet);
			}
			if($k == 2){
				$this->load->library('phpspreadsheet');		
				$template = FCPATH . "assets". DIRECTORY_SEPARATOR  ."templates" .DIRECTORY_SEPARATOR ."template_all_customers.xls";
				$spreadsheet = $this->phpspreadsheet->load($template,"xls");		
				
				
				$sheet = $spreadsheet->getActiveSheet();
				$sheet->getPageSetup()->setFitToWidth(1);
				$sheet->getPageSetup()->setFitToHeight(0);
				$sheet->getPageMargins()->setTop(1);
				$sheet->getPageMargins()->setRight(0.5);
				$sheet->getPageMargins()->setLeft(0.5);
				$sheet->getPageMargins()->setBottom(1);
				$this->phpspreadsheet->save("AllCustomer_list_2" .$nouStart."-".$nouEnd ,$spreadsheet);
			}*/
			
			/*
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
			*/

			/*
			$iRow++;
			$nou++;
			*/
		}
		
		
		//$sheet->setTitle('Coba Aja');
		$iRow = 3;
		$nou = 0;
		/*foreach($rs as $rw){

		}*/		
		
		//$this->phpspreadsheet->save("AllCustomer_list_" .$nouStart."-".$nouEnd ,$spreadsheet);
		//$this->phpspreadsheet->save("test-coba");		
		
	}
	public function prepareExcel($part){
		if($part == 0){
			$this->load->library('phpspreadsheet');		
			$template = FCPATH . "assets". DIRECTORY_SEPARATOR  ."templates" .DIRECTORY_SEPARATOR ."template_all_customers.xls";
			$spreadsheet = $this->phpspreadsheet->load($template,"xls");
			
			
			$sheet = $spreadsheet->getActiveSheet();
			$sheet->getPageSetup()->setFitToWidth(1);
			$sheet->getPageSetup()->setFitToHeight(0);
			$sheet->getPageMargins()->setTop(1);
			$sheet->getPageMargins()->setRight(0.5);
			$sheet->getPageMargins()->setLeft(0.5);
			$sheet->getPageMargins()->setBottom(1);
			$this->phpspreadsheet->save("AllCustomer_list_X" .$part ,$spreadsheet);
		}else{
			$this->load->library('phpspreadsheet');		
			$template = FCPATH . "assets". DIRECTORY_SEPARATOR  ."templates" .DIRECTORY_SEPARATOR ."template_all_customers.xls";
			$spreadsheet = $this->phpspreadsheet->load($template,"xls");
			
			
			$sheet = $spreadsheet->getActiveSheet();
			$sheet->getPageSetup()->setFitToWidth(1);
			$sheet->getPageSetup()->setFitToHeight(0);
			$sheet->getPageMargins()->setTop(1);
			$sheet->getPageMargins()->setRight(0.5);
			$sheet->getPageMargins()->setLeft(0.5);
			$sheet->getPageMargins()->setBottom(1);
			$this->phpspreadsheet->save("AllCustomer_list_XY" .$part ,$spreadsheet);
		}
	}

	public function prepareExcel1($part){
		if($part == 0){
			$this->load->library('phpspreadsheet');		
			$template = FCPATH . "assets". DIRECTORY_SEPARATOR  ."templates" .DIRECTORY_SEPARATOR ."template_all_customers.xls";
			$spreadsheet = $this->phpspreadsheet->load($template,"xls");
			
			
			$sheet = $spreadsheet->getActiveSheet();
			$sheet->getPageSetup()->setFitToWidth(1);
			$sheet->getPageSetup()->setFitToHeight(0);
			$sheet->getPageMargins()->setTop(1);
			$sheet->getPageMargins()->setRight(0.5);
			$sheet->getPageMargins()->setLeft(0.5);
			$sheet->getPageMargins()->setBottom(1);
			$this->phpspreadsheet->save("AllCustomer_list_Y" .$part ,$spreadsheet);
		}else{
			$this->load->library('phpspreadsheet');		
			$template = FCPATH . "assets". DIRECTORY_SEPARATOR  ."templates" .DIRECTORY_SEPARATOR ."template_all_customers.xls";
			$spreadsheet = $this->phpspreadsheet->load($template,"xls");
			
			
			$sheet = $spreadsheet->getActiveSheet();
			$sheet->getPageSetup()->setFitToWidth(1);
			$sheet->getPageSetup()->setFitToHeight(0);
			$sheet->getPageMargins()->setTop(1);
			$sheet->getPageMargins()->setRight(0.5);
			$sheet->getPageMargins()->setLeft(0.5);
			$sheet->getPageMargins()->setBottom(1);
			$this->phpspreadsheet->save("AllCustomer_list_Z" .$part ,$spreadsheet);
		}
	}
}