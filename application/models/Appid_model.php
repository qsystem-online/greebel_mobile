
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

		$ssql = "select * from tbappid where fst_appid =?";
		$query = $this->db->query($ssql,[$appid]);
		return $query->row();
				
	}

	public function isValidAppid($appid){		

		$ssql = "select * from " . $this->tableName . " where fst_appid = ? and fst_active ='A'";
		
		$query =  $this->db->query($ssql,[$appid]);		
		$rw = $query->row();
		if(!$rw){
			return false;
		}
		return true;

	}
	
	public function updateVersion($appid,$versionName){
		$data =[
			"fst_last_version"=>"$versionName"
		];
		$this->db->where($this->pkey,$appid);
		$this->db->update($this->tableName,$data);
	}


	public function updateFCMToken($appid,$tokenFCM){
		$data =[
			"fst_fcm_token"=>"$tokenFCM"
		];
		$this->db->where($this->pkey,$appid);
		$this->db->update($this->tableName,$data);
	}

}
