
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
        $ssql = "select fst_order_id,fst_status from tr_order WHERE fst_appid = ? and  fdt_order_datetime >= (DATE_SUB(CURDATE(), INTERVAL 1 MONTH))";
        $qr = $this->db->query($ssql,[$appid]);
        $rs= $qr->result();
        return $rs;
	}
	
	public function getDataById($fst_order_id,$withDetails = true){
		$ssql = "select * from tr_order a 
			inner join tbsales b on a.fst_sales_code = b.fst_sales_code
			inner join tbcustomers c on a.fst_cust_code = c.fst_cust_code
			WHERE a.fst_order_id = ?";
		
		$qr = $this->db->query($ssql,[$fst_order_id]);
		$rw = $qr->row_array();
		if(!$rw){
			return null;
		}else{
			if ($withDetails){
				$ssql = "select a.*,b.fst_item_name from tr_order_details a
					INNER JOIN tbitems b on a.fst_item_code = b.fst_item_code 
					WHERE fst_order_id = ?";
				$qr = $this->db->query($ssql,[$fst_order_id]);
				echo $this->db->last_query();
				die();
				$rsDetails = $qr->result_array();
				$rw["details"] = $rsDetails;
			}
			var_dump($rw);
			return $rw;
		}
	}
    
}
