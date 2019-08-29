<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Company_model extends MY_Model {
	public $tableName = "tbcompany";
	public $pkey = "fst_code";
	
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

    public function getDataByAppId($appId){

        $ssql = "select b.fst_code,b.fst_name,b.fin_price_group_id from tbappid a inner join tbcompany b on a.fst_company_code = b.fst_code
            where a.fst_appid = ?";

        $query = $this->db->query($ssql,[$appId]);
        $result = $query->result();
        return $result;
    }
	

}
