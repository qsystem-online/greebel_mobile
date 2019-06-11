<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Promo_free_item_model extends MY_Model {
	public $tableName = "tbfreeitemperinvoice";
	public $pkey = "fin_promo_id";
	
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
