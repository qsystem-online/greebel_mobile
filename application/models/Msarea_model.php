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
	

	public function getAreaDetail($fstAreaCode){
		$arrAreaCode = explode(".",$fstAreaCode);
		$result=[
			"provinsi"=>["code"=>"","name"=>""],
			"kabupaten"=>["code"=>"","name"=>""],
			"kecamatan"=>["code"=>"","name"=>""],
			"kelurahan"=>["code"=>"","name"=>""],
		];
		if (isset($arrAreaCode[0])){
			//Get Provinsi
			$provinsiCode = $arrAreaCode[0];
			$ssql = "select * from msarea where fst_kode = ? ";
			$qr = $this->db->query($ssql,[$provinsiCode]);
			$rw = $qr->row();
			if ($rw == null){
				return $result;
			}else{
				$result["provinsi"] = [
					"code"=>$provinsiCode,
					"name"=>$rw->fst_nama
				];
			}

			//Get Kabupaten
			if (isset($arrAreaCode[1])){
				$kabupatenCode = $arrAreaCode[0] . "." .$arrAreaCode[1];
				$ssql = "select * from msarea where fst_kode = ? ";
				$qr = $this->db->query($ssql,[$kabupatenCode]);
				$rw = $qr->row();
				if ($rw == null){
					return $result;
				}else{
					$result["kabupaten"] = [
						"code"=>$kabupatenCode,
						"name"=>$rw->fst_nama
					];
				}
			}	
			
			//Get Kecamatan
			if (isset($arrAreaCode[2])){
				$kecamatanCode = $arrAreaCode[0] . "." .$arrAreaCode[1]. "." .$arrAreaCode[2];
				$ssql = "select * from msarea where fst_kode = ? ";
				$qr = $this->db->query($ssql,[$kecamatanCode]);
				$rw = $qr->row();
				if ($rw == null){
					return $result;
				}else{
					$result["kecamatan"] = [
						"code"=>$kecamatanCode,
						"name"=>$rw->fst_nama
					];
				}
			}
			
			//Get Kelurahan
			if (isset($arrAreaCode[3])){
				$kelurahanCode = $arrAreaCode[0] . "." .$arrAreaCode[1]. "." .$arrAreaCode[2]. "." .$arrAreaCode[3];
				$ssql = "select * from msarea where fst_kode = ? ";
				$qr = $this->db->query($ssql,[$kelurahanCode]);
				$rw = $qr->row();
				if ($rw == null){
					return $result;
				}else{
					$result["kelurahan"] = [
						"code"=>$kelurahanCode,
						"name"=>$rw->fst_nama
					];
				}
			}
		}

		return $result;
	}
}
