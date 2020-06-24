<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Privilegesgroup_model extends MY_Model {
	public $tableName = "privilegesgroup";
	public $pkey = "fin_recid";
	
	public function  __construct(){
		parent::__construct();
	}

	
	public function getRules($mode="ADD",$id=0){
		$rules = [];
		return $rules;		
	}
	public function getDataById($finRecId){
		return "";
	}
	public function getListGroup(){
		$ssql = "select * from privilegesgroup where fst_active = 'A'";
		$qr = $this->db->query($ssql,[]);
		$rs = $qr->result();
		return $rs;
	}
	

   
   

}
