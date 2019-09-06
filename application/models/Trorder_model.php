
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
    

    public function getDataStatusByAppid($appid){
        $ssql = "select fst_order_id,fst_status from tr_order WHERE fst_appid = ? and  fdt_order_datetime >= (DATE_SUB(CURDATE(), INTERVAL 1 MONTH)";
        $qr = $this->db->qr($ssql,[$appid]);
        $rs= $qr->result();
        return $rs;
    }
    
}
