<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Location_model extends MY_Model {
	public $tableName = "tblocation";
	public $pkey = "fst_cust_code";
	
	public function  __construct(){
		parent::__construct();
	}

	
	public function getRules($mode="ADD",$id=0){
		$rules = [];
		return $rules;		
    }
    
    
    
}
