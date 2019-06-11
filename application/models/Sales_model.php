<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sales_model extends MY_Model {
	public $tableName = "tbsales";
	public $pkey = "fst_sales_code";
	
	public function  __construct(){
		parent::__construct();
	}

	
	public function getRules($mode="ADD",$id=0){
		$rules = [];
		return $rules;		
    }
    
    public function get_select2(){
        $ssql = "select fst_sales_code, fst_sales_name from " . $this->tableName . " where fst_active = 'A'";
        $qr = $this->db->query($ssql,[]);
        $rs = $qr->result();
        return $rs;
    }
}
