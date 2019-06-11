<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Customer_model extends MY_Model {
	public $tableName = "tbcustomers";
	public $pkey = "fin_cust_id";
	
	public function  __construct(){
		parent::__construct();
	}

	public function getDataById($fin_user_id){
		//$ssql = "select * from " . $this->tableName ." where fin_user_id = ?";
		$ssql = "select a.*,b.fst_department_name,c.fst_group_name,c.fin_level from " . $this->tableName ." a 
			left join departments b on a.fin_department_id = b.fin_department_id 
			left join master_groups c on a.fin_group_id = c.fin_group_id 
			where a.fin_user_id = ?";


		$qr = $this->db->query($ssql,[$fin_user_id]);		
		$rwUser = $qr->row();
		if($rwUser){
			if (file_exists(FCPATH . 'assets/app/users/avatar/avatar_' . $rwUser->fin_user_id . '.jpg')) {
				$avatarURL = site_url() . 'assets/app/users/avatar/avatar_' . $rwUser->fin_user_id . '.jpg';
			}else{
				
				$avatarURL = site_url() . 'assets/app/users/avatar/default.jpg';
			}
			$rwUser->avatarURL = $avatarURL;
		}

		//Groups
		/*$ssql = "select * from user_group where fin_user_id = ? ";
		$qr = $this->db->query($ssql,[$fin_user_id]);
		$rsGroup = $qr->result();*/

		$data = [
			"user" => $rwUser
			//"list_group" => $rsGroup
		];

		return $data;
	}

	public function getRules($mode="ADD",$id=0){
		$rules = [];
		return $rules;		
    }
    
    public function getDataByAppId($appId){
        $ssql = "select a.*,c.fst_cust_location from ". $this->tableName ." a 
            inner join tbappid b on a.fst_sales_code = b.fst_sales_code
            left join tblocation c on a.fst_cust_code = c.fst_cust_code 
            where b.fst_appid = ?";

        $query = $this->db->query($ssql,[$appId]);
        $result = $query->result();
        return $result;

    }

    public function getLocation($fin_cust_code){
        $ssql = "select fst_cust_location from tblocation where fst_cust_code = ?";
        $qr = $this->db->query($ssql,[$fin_cust_code]);
        $rw = $qr->row();
        if($rw){
            if ($rw->fst_cust_location == null){
                return "0,0";        
            }
            return $rw->fst_cust_location;
        }
        return "0,0";

    }

    public function setLocation($fst_cust_code,$fst_location){
        $this->load->model("location_model");
        $ssql = "select * from tblocation where fst_cust_code = ?";
        $qr = $this->db->query($ssql,[$fst_cust_code]);
        $rw = $qr->row();
        if ($rw){
            $data= [
                "fst_cust_code" =>$fst_cust_code,
                "fst_cust_location"=>$fst_location
            ];
            $this->location_model->update($data);
        }else{
            $data= [
                "fst_cust_code" =>$fst_cust_code,
                "fst_cust_location"=>$fst_location,
                "fst_active"=> "A",
                "fin_insert_id" => 1
            ];
            $this->location_model->insert($data);
        }
        
        
    }

	public function createDummy(){
        //Delete data
        $ssql = "delete from ". $this->tableName;
        $this->db->simple_query($ssql);
        for($i = 0 ; $i < 200 ; $i++){
            $customer = [
                "fin_cust_id"=>$i,
                "fst_cust_code"=>"CODE-" .$i,
                "fst_cust_name"=>"Customer Name " . $i,
                "fst_cust_address"=>"Customer address " .$i,
                "fst_cust_phone"=>"Phone -". $i,
                "fst_sales_code"=> "SLS01",
                "fst_location"=>null,
                "fin_visit_day"=> rand(1,7),
                "fin_price_group_id"=> 1,
                "fst_active"=>'A',
                "fdt_insert_datetime"=>date("Y-m-d H:i:s"),
                "fin_insert_id"=>1
            ];
            $this->db->insert($this->tableName,$customer);
        }


    }

    public function inSchedule($fst_cust_code,$fdt_date){
        //php => 0 = minggu -> 6 = sabtu
        //DB =>  1 = Senin  -> 7 = Minggu

        $dayofweek = date('w', strtotime($fdt_date));
        if ($dayofweek == 0 ){
            $dayofweek = 7;
        }

        $ssql = "Select * from tbcustomers where fst_cust_code = ? and fin_visit_day = ?";
        $qr = $this->db->query($ssql,[$fst_cust_code,$dayofweek]);
        //echo $this->db->last_query();
        //die();

        $rw = $qr->row();
        if($rw){
            return true;
        }
        return false;
    }

    public function get_select2(){
        $ssql = "select a.fst_cust_code, a.fst_cust_name,b.fst_cust_location from " . $this->tableName . " a
            left join tblocation b on a.fst_cust_code = b.fst_cust_code
            where a.fst_active = 'A'";
        $qr = $this->db->query($ssql,[]);
        $rs = $qr->result();

        $newRs = [];
        foreach($rs as $rw){
            $rw->fst_cust_location = ($rw->fst_cust_location == null) ? "0,0" : $rw->fst_cust_location;

            $arrLoc = explode(",",$rw->fst_cust_location);
            $rw->fst_lat = $arrLoc[0];
            $rw->fst_log = $arrLoc[1];
            $newRs[] = $rw;
        }

        return $newRs;
    }


}
