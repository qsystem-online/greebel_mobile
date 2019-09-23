<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Newcustomer_model extends MY_Model {
	public $tableName = "tbnewcustomers";
	public $pkey = "fin_id";
	
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
    
}
