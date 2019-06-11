
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

	public function getSales($appid){
		$ssql = "select b.* from " . $this->tableName . " a
			inner join tbsales b on a.fst_sales_code = b.fst_sales_code
			where a.fst_appid = ?";
		$query = $this->db->query($ssql,[$appid]);
		return $query->row();
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

}
