<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Msarea_model extends MY_Model {
	public $tableName = "msarea";
	public $pkey = "fst_kode";
	
	public function  __construct(){
		parent::__construct();
	}

	
	public function getRules($mode="ADD",$id=0){
		$rules = [];
		return $rules;		
    }
    
    
    public function getListProvinsi(){
       $ssql = "SELECT * FROM msarea WHERE LOCATE('.', fst_kode) = 0";
       $qr = $this->db->query($ssql,[]);
       return $qr->result();
    }
}
