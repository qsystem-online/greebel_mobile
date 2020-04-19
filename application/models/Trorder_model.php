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
		/*
		$ssql = "select SUBSTRING_INDEX(fst_order_id,'_',1) as fst_order_id,fst_status 
			FROM tr_order 
			WHERE fst_appid = ? and  fdt_order_datetime >= (DATE_SUB(CURDATE(), INTERVAL 1 MONTH))";
		*/
		$ssql = "select fst_order_id,fst_status 
			FROM tr_order 
			WHERE fst_appid = ? and  fdt_order_datetime >= (DATE_SUB(CURDATE(), INTERVAL 1 MONTH))";
		
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
				$rsDetails = $qr->result_array();
				$rw["details"] = $rsDetails;
			}
			
			return $rw;
		}
	}
	
	public function approved($fin_rec_id,$approved = true){
		$ssql = "select * from tr_order where fin_rec_id = ?";
		$qr = $this->db->query($ssql,[$fin_rec_id]);
		$rw = $qr->row();
		if(! $rw){
			return false;
		}else{
			if ($approved){
				$data = [
					"fst_status"=>"APPROVED"
				];
			}else{
				$data = [
					"fst_status"=>"REJECTED"
				];
			}
			$this->db->where("fin_rec_id",$fin_rec_id);
			$this->db->update($this->tableName,$data);		
		}
	}

	public function showTransaction($fin_rec_id){
		$ssql = "select * from tr_order where fin_rec_id = ?";
		$qr = $this->db->query($ssql,[$fin_rec_id]);
		$rw = $qr->row();
		if(! $rw){
			show_404();
		}else{
			redirect('/espb/view/' . $rw->fst_order_id);
		}

	}


	public function getSummary($fst_order_id){

		$ssql ="select sum(fin_qty) as total_qty, sum(fin_qty * (fin_price - fdc_disc)) as total_amount from tr_order_details where fst_order_id = ?";
		$qr = $this->db->query($ssql,[$fst_order_id]);
		return $qr->row();

	}
}
