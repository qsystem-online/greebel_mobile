<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Discitem_model extends MY_Model {
	public $tableName = "tbdiscountitems";
	public $pkey = "fst_disc_item";
	
	public function  __construct(){
		parent::__construct();
	}

	

	public function getRules($mode="ADD",$id=0){
		$rules = [];
		return $rules;		
    }
    
    public function getData(){
        $ssql = "select distinct fst_disc_item from ". $this->tableName;
        $query = $this->db->query($ssql,[]);
        $result = $query->result();
        return $result;
    }

   

    
	
}
