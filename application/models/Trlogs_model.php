
<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Trlogs_model extends MY_Model {
	public $tableName = "tr_logs";
	public $pkey = "rec_id";
	
	public function  __construct(){
		parent::__construct();
	}

	

	public function getRules($mode="ADD",$id=0){
		$rules = [];
		return $rules;		
	}

	
	public function isLastUpdate($date,$type){
		$ssql = "select * from " . $this->tableName . " where date(fdt_log_datetime) = ? and fst_log_type = ?";
		$qr = $this->db->query($ssql,[$date,$type]);
		$rw = $qr->row();
		if ($rw){
			return true;
		}
		return false;
	}
	

}
