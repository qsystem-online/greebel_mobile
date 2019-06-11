<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Target_model extends MY_Model {
	public $tableName = "trtargetpercustomer";
	public $pkey = "fin_target_id";
	
	public function  __construct(){
		parent::__construct();
	}

	
	public function getRules($mode="ADD",$id=0){
		$rules = [];
		return $rules;		
    }
    
    
    public function getData(){
        $ssql = "select * from ". $this->tableName;
        $query = $this->db->query($ssql,[]);
        $result = $query->result();
        return $result;

    }
}
