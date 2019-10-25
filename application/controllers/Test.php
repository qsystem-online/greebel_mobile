<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class Test extends CI_Controller {
	
	
	
	public function testJWT(){

		$this->load->library("tokenJWT",null,"token");
		
		//$tokenId    = base64_encode(mcrypt_create_iv(32));
		$issuedAt   = time();
		$notBefore  = $issuedAt + 10;             //Adding 10 seconds
		$expire     = $notBefore + 60;            // Adding 60 seconds
		$serverName = "localhost";
		
		$data =[
			'iat'  => $issuedAt,         // Issued at: time when the token was generated
			//'jti'  => $tokenId,          // Json Token Id: an unique identifier for the token
			'iss'  => $serverName,       // Issuer
			'nbf'  => $notBefore,        // Not before
			'exp'  => $expire,           // Expire
			"data" => [
				"user"=>"devibong",
				"password"=>"12345"
			]
		];
		
		
		$secretKey = "12345678";
		$jwt = $this->token->encode(
			$data,      //Data to be encoded in the JWT
			$secretKey, // The signing key
			'HS512'     // Algorithm used to sign the token, see https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40#section-3
        );
		
		
		echo "test jwt " . $jwt ."<br>";
		
		try{
			$token = $this->token->decode($jwt, $secretKey, array('HS512'));
			var_dump($token->user);
			
			
			
		}catch(Exception $e){
			echo 'Message: ' .$e->getMessage();
		}
		
		
		
		
	}
	
	public function testCrypto(){
		$this->load->library('encryption');
		//echo $this->encryption->create_key(16);
		//die();
		
	 
		$this->encryption->initialize(
			array(
					'driver' => 'openssl',
					'cipher' => 'aes-128',
					'mode' => 'cbc',
					'key' => 'DeviBastian12345'
			)
		);
		

		//$strEncy =  $this->encryption->encrypt("Saya Devi Bastian");

		//echo $strEncy;
		//die();

		//$strEncy = "5d3272fa19c5174969364a0ea7a5baca26e5b9d708c393f6f6a84beadf4d54f495372496f73081db5c090e5238bb1916355cf65cc848f6aec3287e9e95cd9976HdXc0j7JiQq6HdU0IML0HJ8QHmNRhuVOyuzbJaaZooBHhAtqM/zwzCRW95gyfNHq";
		//$strEncy = "49cda540c22cdf87dd8e9810819f7a196f5ac0d8993f4d785c239c0ac64fc38566de456d0c50c91a5b3d6a233fa71de163d737daa88745f3fac990731feda58bRufN3Vhh6oqsDGSsgGpyAFSINs1mmqtA8/+q6P17RsZpTM5OoKd29l32jA5SIk3I";
		//$strEncy = "f2e646acfb69a59c4c49e47a7fad064ddc3926cf5e8eafb019e8cb9fdda1dbfbd6f7a3a918f77b682c8e4d819c37e7ad628a6ca4d45a3a4d1494d3e3e993b0f5KMSXzaapnfx+07+yyGOORhSjTvL/kYNhIell+zQCoMpltI5xml6D5lxqiAoeC0ki";

		//$strEncy =   "4efa58980c9b9c62f4e4a0fca04e71186ce3bd298b8e0b47d6b4b170bd987f14df8ef45fa0a7434351b2c3abc21edd45";
		//$strEncy = "50efc6e8a8da9a4e138ec2fc4a398ebc72d30f7f23a93b6b7d66625f116bc5af";
		
		$strEncy = "08D1F7435815265B3EBF4222483C4BA5299A97B6D41F3DBC96B07104F301A7B7";
		


		echo "<br>";
		$strDecry = $this->encryption->decrypt($strEncy);
		
		echo "Decrypt :" . $strDecry;		
		//echo "Done!!!";
		
	}

	public function test1($var){
		echo "uri string : ". uri_string();
		echo "<br>";
		echo "site_url : ". site_url();
		echo "<br>";
		echo "site_url (uri_string) : ". site_url(uri_string());
		echo "<br>";
		
	}


	public function index(){
		$this->load->library('unit_test');
		$test = dBDateFormat("20-04-2019");
		$expected_result = "2019-04-20";
		$test_name = 'Test dBdateFormat';
		$this->unit->run($test, $expected_result, $test_name,$test);
		

		$test = parseNumber("200.000.000,15",",");
		$expected_result = (float) 200000000.15;
		$test_name = 'Test parseNumber';
		$this->unit->run($test, $expected_result, $test_name,$test ." vs " .$expected_result);
		
		echo $this->unit->report();

	}


	public function test_page(){
		$this->parser->parse('pages/sample/test',[]);
	}


	public function test_ajax(){
		//echo "AJAX REQUEST :" .$this->input->is_ajax_request();
		$this->ajxResp["status"] = AJAX_STATUS_SESSION_EXPIRED;
		$this->json_output(403);
	}

	public function get_file(){
		$this->load->helper('download');
		$this->load->helper('file');
		
		$ssql = "select * from permission_token where fst_token = '123456' and fbl_active = true";
		$qr = $this->db->query($ssql,[]);
		$rw = $qr->row();
		if ($rw){
			$data = ["fbl_active"=>false];
			$this->db->where("fst_token","123456");
			//$this->db->update("permission_token",$data);

			$fileLoc ='d:\\test.pdf';
			$string = read_file($fileLoc);
			header("Content-type:application/pdf");
			header("Content-Disposition:inline;filename=download.pdf");
			echo $string;
		}else{
			die();
		}
		//die();		
		//force_download($fileLoc, NULL,true);
		//echo file_get_contents('http://some.secret.location.com/secretfolder/the_file.tar.gz');
	}
	

	public function coba2(){
		$plain_txt = "This is my plain text";
		//echo "Plain Text =" .$plain_txt. "\n";
		$encrypted_txt = $this->encrypt_decrypt('encrypt', $plain_txt);
		//HQ2cZwGexQnjR961YNbDMhFxkF/YefnMa/rGoo99LZk=
		//HQ2cZwGexQnjR961YNbDMhFxkF/YefnMa/rGoo99LZk=
		
		
		//$encrypted_txt = "CNH3Q1gVJls+v0IiSDxLpSmal7bUHz28lrBxBPMBp7c=";
		echo "Encrypted Text = " .$encrypted_txt. "\n";
		//$decrypted_txt = $this->encrypt_decrypt('decrypt', $encrypted_txt);
		//echo "Decrypted Text =" .$decrypted_txt. "\n";

		//if ( $plain_txt === $decrypted_txt ) echo "SUCCESS";
		//else echo "FAILED";
		//echo "\n";
	}
	
	/**
	 * simple method to encrypt or decrypt a plain text string
	 * initialization vector(IV) has to be the same when encrypting and decrypting
	 * 
	 * @param string $action: can be 'encrypt' or 'decrypt'
	 * @param string $string: string to encrypt or decrypt
	 *
	 * @return string
	 */
	public function encrypt_decrypt($action, $string) {
		$output = false;

		$encrypt_method = "AES-128-CBC";
		$secret_key = 'DeviBastian12345';
		$secret_iv = 'DeviBastian12345';

		// hash
		$key = hash('sha256', $secret_key);
		//$key = $secret_key;
		
		// iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
		$iv = substr(hash('sha256', $secret_iv), 0, 16);

		if ( $action == 'encrypt' ) {
			//$output = openssl_encrypt($string, $encrypt_method, $key, 0,$iv);
			$output = openssl_encrypt($string, $encrypt_method, $secret_key, 0,$secret_iv);
			
			//$output = base64_encode($output);
		} else if( $action == 'decrypt' ) {
			$output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0,null);
		}

		return $output;
	}

	public function map(){
		$this->parser->parse('map_demo',[]);
	}
	

	public function testExcel(){
		$this->load->library('phpspreadsheet');
		
		//$spreadsheet = $this->phpspreadsheet->load(FCPATH . "assets\\templates\\template_macro.xlsm","xlsm");
		//$spreadsheet = $this->phpspreadsheet->load(FCPATH . "assets\\templates\\template_sales_log.xlsx","xlsx");
		//$spreadsheet = $this->phpspreadsheet->load(FCPATH . "assets\\templates\\template_sales_log.xls","xls");
		$spreadsheet = $this->phpspreadsheet->load(FCPATH . "assets\\templates\\devi.xlsx","xlsx");
		//$spreadsheet->getSecurity()->setLockWindows(true);
		//$spreadsheet->getSecurity()->setLockStructure(true);
		$security = $spreadsheet->getSecurity();
		$security->setLockWindows(true);
		$security->setLockStructure(true);
		$security->setWorkbookPassword("bastian");
		$spreadsheet->setSecurity($security);

		
		//$spreadsheet->getSecurity()->setRevisionsPassword("bastian");
		

		
		$sheet = $spreadsheet->getActiveSheet();

		$sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
		//$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);	
		$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_PORTRAIT);	
		$sheet->getPageMargins()->setLeft(0.1);	
		$sheet->getPageMargins()->setRight(0.1);
		$sheet->getPageMargins()->setTop(2);
		$sheet->getPageMargins()->setBottom(2);

		$sheet->getPageSetup()->setFitToPage(false);
		$sheet->getPageSetup()->setScale(10);
		//$sheet->getPageSetup()->setFitToWidth(1);
		//$sheet->getPageSetup()->setFitToHeight(0);

		$sheet->getPageMargins()->setTop(1);
		$sheet->getPageMargins()->setRight(0.5);
		$sheet->getPageMargins()->setLeft(0.5);
		$sheet->getPageMargins()->setBottom(1);
		
		$this->phpspreadsheet->protectSheet($sheet,"bastian");

		$filename = 'test';
		$this->phpspreadsheet->save($filename,$spreadsheet,"xlsx");
		//$this->phpspreadsheet->saveHTML($filename);
		//$this->phpspreadsheet->savePDF($filename);
	}
}
