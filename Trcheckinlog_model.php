
<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class trcheckinlog_model extends MY_Model {
	public $tableName = "trcheckinlog";
	public $pkey = "fin_id";
	
	public function  __construct(){
		parent::__construct();
	}

	

	public function getRules($mode="ADD",$id=0){
		$rules = [];
		return $rules;		
	}

}
