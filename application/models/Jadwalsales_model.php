
<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Jadwalsales_model extends MY_Model {
	public $tableName = "tbjadwalsales";
	public $pkey = "fin_rec_id";
	
	public function  __construct(){
		parent::__construct();
	}

	

	public function getRules($mode="ADD",$id=0){
		$rules = [];
		return $rules;		
	}

	public function onSchedule($fst_cust_code,$fdt_date){        
        $ssql = "SELECT * FROM tbjadwalsales where fst_cust_code = ? and fdt_schedule_date = ?";
        $qr = $this->db->query($ssql,[$fst_cust_code,$fdt_date]);
        $rw = $qr->row();
        if ($rw == null){
            return false;
        }else{
            return true;
        }
    }
    public function updateVisited($fst_cust_code,$fdt_date,$finCheckInId){
        
        $this->db->where('fst_cust_code', $fst_cust_code);
        $this->db->where('fdt_schedule_date', $fdt_date);


        $data =[
            "fbl_visited"=>true,
            "fin_last_checkin_id"=>$finCheckInId
        ];
        $this->db->update('tbjadwalsales', $data);

        $error = $this->db->error();

        if ($error["code"] == 0){
            return true;
        }else{
            return false;
        }
        /*
        $ssql = "update tbjadwalsales set fbl_visited = true , fin_last_checkin_id = ? where fst_cust_code = ? and fdt_schedule_date = ?";


        $qr = $this->db->query($ssql,[$finCheckInId,$fst_cust_code,$fdt_date]);
        $rw = $qr->row();
        if ($rw == null){
            return false;
        }else{
            return true;
        }
        */
    }

}
