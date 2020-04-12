<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Item_model extends MY_Model {
	public $tableName = "tbitems";
	public $pkey = "fst_item_code";
	
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

    public function getDataByAppid($appId){
        $ssql = "SELECT   a.* FROM tbitems a ";            
        $qr = $this->db->query($ssql,[$appId]);
        return $qr->result();
    }

    
	public function createDummy(){
        //Delete data
        $ssql = "delete from ". $this->tableName;
        $this->db->simple_query($ssql);
        for($i = 0 ; $i < 200 ; $i++){
            $item = [
                "fst_item_code"=> "ITM-CODE-$i",
                "fst_item_name"=> "ITEM NAME $i",
                "fst_satuan_1"=> "GRAM",
                "fst_satuan_2"=> "KILO",
                "fst_satuan_3"=> "BOX",
                "fin_conversion_2" => 1000,
                "fin_conversion_3" => 5525.5431,
                "fin_selling_price1A"=>1000.01,
                "fin_selling_price2A"=>2000.01,
                "fin_selling_price3A"=>3000.01,
                "fin_selling_price1B"=>1000.02,
                "fin_selling_price2B"=>2000.02,
                "fin_selling_price3B"=>3000.02,
                "fin_selling_price1C"=>1000.03,
                "fin_selling_price2C"=>2000.03,
                "fin_selling_price3C"=>3000.03,
                "fin_selling_price1D"=>1000.04,
                "fin_selling_price2D"=>2000.04,
                "fin_selling_price3D"=>3000.04,
                "fin_selling_price1E"=>1000.05,
                "fin_selling_price2E"=>2000.05,
                "fin_selling_price3E"=>3000.05,
                "fin_selling_price1F"=>1000.06,
                "fin_selling_price2F"=>2000.06,
                "fin_selling_price3F"=>3000.06,
                "fin_selling_price1G"=>1000.07,
                "fin_selling_price2G"=>2000.07,
                "fin_selling_price3G"=>1000.07,
                "fin_selling_price1H"=>1000.08,
                "fin_selling_price2H"=>2000.08,
                "fin_selling_price3H"=>3000.08,
                "fin_selling_price1I"=>1000.09,
                "fin_selling_price2I"=>2000.09,
                "fin_selling_price3I"=>3000.09,
                "fin_selling_price1J"=>1000.10,
                "fin_selling_price2J"=>2000.10,
                "fin_selling_price3J"=>3000.10,
                "fst_memo" => "Ini Test Demo untuk item $i",
                "fst_active" => "A",
                "fdt_insert_datetime" => date("Y-m-d H:i:s"),
                "fin_insert_id" => 1,
            ];
            $this->db->insert($this->tableName,$item);
        }


    }

    public function getLogistics(){
        $ssql = "select * from tbitems where fin_item_type_id = 5 and fst_active='A'";
        $qr =$this->db->query($ssql,[]);
        return $qr->result();
    }
}
