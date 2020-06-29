
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
		$this->load->model("customer_model");
		/*
		$ssql = "select a.*,b.fst_cust_name,b.fin_visit_day from trcheckinlog a
			inner join tbcustomers b on a.fst_cust_code = b.fst_cust_code
			where a.fst_sales_code = ?  and fdt_checkin_datetime >= ? and fdt_checkin_datetime <= ? order by fin_id";
		*/

		$ssql = "select a.*,b.fst_cust_name from trcheckinlog a
			inner join tbcustomers b on a.fst_cust_code = b.fst_cust_code
			where a.fst_sales_code = ?  and fdt_checkin_datetime >= ? and fdt_checkin_datetime <= ? order by fin_id";
		
		$qr = $this->db->query($ssql,[$fst_sales_code,$fdt_date,$fdt_date . " 23:59:59"]);
		
		$rs = $qr->result();		
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
				"isOnSchedule" => $this->customer_model->inSchedule($rw->fst_cust_code,$rw->fst_sales_code,$rw->fdt_checkin_datetime)
			];
			$datas[] = $data;
			$i++;
		}
		
		return $datas;
	}

	public function getDataByDate($fst_sales_code,$fst_cust_code,$fdt_date){
		$ssql = "select * from trcheckinlog where fst_sales_code = ? and fst_cust_code = ? and date(fdt_checkin_datetime) = ? order by fin_distance_meters limit 1";
		$qr = $this->db->query($ssql,[$fst_sales_code,$fst_cust_code,$fdt_date]);
		$rw = $qr->row();
		return $rw;
	}

	public function getLastCheckin($fst_sales_code,$fdt_date){
		$ssql = "select * from trcheckinlog where fst_sales_code = ? and CAST(fdt_checkin_datetime as DATE) = ? order by fin_id desc limit 1";
		$qr = $this->db->query($ssql,[$fst_sales_code,$fdt_date]);
		return $qr->row();

	}

	
	
	public function fillCompareDurationAndDistance($id){
		$ssql = "SELECT * from trcheckinlog where fin_id = ?";
		$qr = $this->db->query($ssql,[$id]);
		$rw = $qr->row();
		if ($rw != null){
			$tglCheckin = date("Y-m-d",strtotime($rw->fdt_checkin_datetime));
			$salesCode = $rw->fst_sales_code;

			//GET LAST RECORD BEFORE THIS
			$ssql = "select * from trcheckinlog where fst_sales_code = ? and CAST(fdt_checkin_datetime AS DATE) = ? and fin_id < ? limit 1";
			$qr =$this->db->query($ssql,[$salesCode,$tglCheckin,$id]);
			$rwLast = $qr->row();
			if ($rwLast == null){
				$data=[
					"fin_distance_from_last_checkin_meters"=>0,
					"fin_distance_from_last_checkin_seconds"=>0,
					"fst_distance_from_last_checkin_meters"=>"",
					"fst_distance_from_last_checkin_seconds"=>"",
					"fin_duration_from_last_checkout"=>0
				];

			}else{

				$strlastPos = $rwLast->fst_checkin_location;
				$arrLastPos = [
					"lat"=>explode(",",$strlastPos)[0],
					"long"=>explode(",",$strlastPos)[1]
				];

				$strPos = $rw->fst_checkin_location;
				$arrCurPos = [
					"lat"=>explode(",",$strPos)[0],
					"long"=>explode(",",$strPos)[1]
				];

				$distObj = getDistance($arrLastPos, $arrCurPos);
				$diffSecFromLastCheckout = strtotime($rw->fdt_checkin_datetime) - strtotime($rwLast->fdt_checkout_datetime);
				$data=[
					"fin_distance_from_last_checkin_meters"=> $distObj["distance"]["value"],
					"fin_distance_from_last_checkin_seconds"=>$distObj["duration"]["value"],
					"fst_distance_from_last_checkin_meters"=>$distObj["distance"]["text"],
					"fst_distance_from_last_checkin_seconds"=>$distObj["duration"]["text"],
					"fin_duration_from_last_checkout"=>$diffSecFromLastCheckout
				];
			}
			$data["fin_id"] = $id;
			$this->trcheckinlog_model->update($data);

		}
		


	}


}
