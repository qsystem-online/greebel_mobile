<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//use PhpOffice\PhpSpreadsheet\Spreadsheet;
//use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class Excel extends CI_Controller {
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

    public function index() {

        $spreadsheet = new Spreadsheet(); // instantiate Spreadsheet

        $sheet = $spreadsheet->getActiveSheet();

        // manually set table data value
        $sheet->setCellValue('A1', 'Gipsy Danger'); 
        $sheet->setCellValue('A2', 'Gipsy Avenger');
        $sheet->setCellValue('A3', 'Striker Eureka');
		
		$sheet->setCellValue('B1', 30000); 
        $sheet->setCellValue('B2', 150000);
        $sheet->setCellValue('B3', 17000.532);
		
        
		$sheet->getStyle("A")->getFont()->setBold(true);
		
		$styleArray = [
			'font' => [
				'bold' => true,
			],
			'alignment' => [
				'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
			],
			'borders' => [
				'top' => [
					'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
				],
			],
			'numberFormat' =>[
				'formatCode'=>'#,##0.00',
			]
		];

		$sheet->setCellValue('B4', '=sum(B1:B3)');
		
		$sheet->getStyle("A")->getFont()->setBold(true);
		$sheet->getStyle('B1:B3')->applyFromArray($styleArray);
		
		
        $writer = new Xlsx($spreadsheet); // instantiate Xlsx
 
        $filename = 'list-of-jaegers'; // set filename for excel file to be exported
 
        header('Content-Type: application/vnd.ms-excel'); // generate excel file
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output');	// download file 
    }
  
	public function testlib(){
		
		$this->load->library('phpspreadsheet');
		
		//$spreadsheet = new Spreadsheet(); // instantiate Spreadsheet
		//$this->phpspreadsheet->setActiveSheetIndex(2);
		$sheet = $this->phpspreadsheet->createSheet();
		$sheet->setTitle('Another sheet');
        //$sheet = $this->phpspreadsheet->getActiveSheet();

        // manually set table data value
        $sheet->setCellValue('A1', 'Gipsy Danger'); 
        $sheet->setCellValue('A2', 'Gipsy Avenger');
        $sheet->setCellValue('A3', 'Striker Eureka');
		
		$sheet->setCellValue('B1', 30000); 
        $sheet->setCellValue('B2', 150000);
        $sheet->setCellValue('B3', 17000.532);
		$sheet->getStyle("A")->getFont()->setBold(true);		
		$styleArray = [
			'font' => [
				'bold' => true,
			],
			'alignment' => [
				'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
			],
			'borders' => [
				'top' => [
					'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
				],
			],
			'numberFormat' =>[
				'formatCode'=>'#,##0.00',
			]
		];
		$sheet->setCellValue('B4', '=sum(B1:B3)');		
		$sheet->getStyle("A")->getFont()->setBold(true);
		$sheet->getStyle('B1:B3')->applyFromArray($styleArray);
		$filename = 'list-of-jaegers'; // set filename for excel file to be exported
		
		$this->phpspreadsheet->save($filename);
		
		
	}
} 