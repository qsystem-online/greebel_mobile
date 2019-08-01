<?php defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Phpspreadsheet extends Spreadsheet {
	
	
	public function __construct(){
		parent::__construct();
	}
	
	public function save($filename,$spreadsheet = null){
		
		$spreadsheet =  $spreadsheet == null ? $this : $spreadsheet;
		
		//$writer = new Xlsx($spreadsheet);
		$writer = new Xlsx($spreadsheet);
		
		//$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
		//$writer->save($filename.'.xlsx');
		
		
		header('Content-Type: application/vnd.ms-excel'); // generate excel file
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');        
        $writer->save('php://output');	// download file 		
	}

	public function load($filename){
		//$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('template.xlsx');
		//$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($filename);
		$spreadsheet = IOFactory::load($filename);
		
		return $spreadsheet;
		/*
		$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('template.xlsx');
		$worksheet = $spreadsheet->getActiveSheet();
		$worksheet->getCell('A1')->setValue('John');
		$worksheet->getCell('A2')->setValue('Smith');
		$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
		$writer->save('write.xls');
		*/


	}
	

	
}