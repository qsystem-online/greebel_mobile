
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


	public function getDataDetail($fst_sales_code,$fst_cust_code,$fdt_date){
		$ssql = "select * from trcheckinlog where fst_sales_code = ? and fst_cust_code = ? and fdt_checkin_datetime >= ? and fdt_checkin_datetime < ? order by fin_id";
		$qr = $this->db->query($ssql,[$fst_sales_code,$fst_cust_code,$fdt_date,$fdt_date . " 23:59:59"]);
		$rs = $qr->result();
		return $rs;
	}

	public function getDataTracking($fst_sales_code,$fdt_date){
		$ssql = "select a.*,b.fst_cust_name from trcheckinlog a
			inner join tbcustomers b on a.fst_cust_code = b.fst_cust_code
			where a.fst_sales_code = ?  and fdt_checkin_datetime >= ? and fdt_checkin_datetime <= ? order by fin_id";

		
		$qr = $this->db->query($ssql,[$fst_sales_code,$fdt_date,$fdt_date . " 23:59:59"]);
		//echo $this->db->last_query();
		$rs = $qr->result();
		//var_dump($rs);
		//die();

		$datas = [];
		$i = 0;
		foreach($rs as $rw){
			$arrLoc = explode(",",$rw->fst_checkin_location);
			$locLat = $arrLoc[0];
			$locLog = $arrLoc[1];

			$data = [
				"id" => $i,
				"fin_id" => $rw->fin_id,
				"fst_cust_code" => $rw->fst_cust_code,
				"fst_cust_name" => $rw->fst_cust_name,
				"fst_lat" => $locLat,
				"fst_log" => $locLog,
				"fdt_checkin_datetime" => $rw->fdt_checkin_datetime,
			];
			$datas[] = $data;
			$i++;
		}
		
		return $datas;
	}
}
