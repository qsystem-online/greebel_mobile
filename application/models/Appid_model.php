
<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Appid_model extends MY_Model {
	public $tableName = "tbappid";
	public $pkey = "fst_appid";
	
	public function  __construct(){
		parent::__construct();
	}

	

	public function getRules($mode="ADD",$id=0){
		$rules = [];
		return $rules;		
	}

	public function getSales($appid,$custCode = ""){
		if ($custCode == ""){
			$ssql = "select b.* from " . $this->tableName . " a
				inner join tbsales b on a.fst_sales_code = b.fst_sales_code
				where a.fst_appid = ?";
			$query = $this->db->query($ssql,[$appid]);
			return $query->row();
		}else{

			$ssql = "select c.* from " . $this->tableName . " a
				inner join tbcustomers b on a.fst_sales_code = b.fst_sales_code
				inner join tbsales c on a.fst_sales_code = c.fst_sales_code
				where a.fst_appid = ? and b.fst_cust_code = ?";
			$query = $this->db->query($ssql,[$appid,$custCode]);
			return $query->row();

		}
	}

	public function isValidAppid($appid){
        //Delete data
		$ssql = "select * from " . $this->tableName . " where fst_appid = ?";
		
		$query =  $this->db->query($ssql,[$appid]);		
		$rw = $query->row();
		if($rw){
			return true;
		}
		return false;

	}
	
	public function updateFCMToken($appid,$tokenFCM){
		$data =[
			"fst_fcm_token"=>"$tokenFCM"
		];
		$this->db->where($this->pkey,$appid);
		$this->db->update($this->tableName,$data);
	}

}
