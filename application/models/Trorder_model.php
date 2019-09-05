
<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Trorder_model extends MY_Model {
	public $tableName = "tr_order";
	public $pkey = "fst_order_id";
	
	public function  __construct(){
		parent::__construct();
	}

	public function getRules($mode="ADD",$id=0){
		$rules = [];
		return $rules;		
	}

	
	
}
