<?php

class Logger{
	
	private $logfile;

	public function __construct($filepath) {
		$this->logfile = $filepath;
	}

	private function get_req_array($input){
		$req_array = array(
			'head' => 	"REQUEST AT:\t" . date('H:i:s d-m-Y'),
			'from' =>	"   FROM:\t" . $_SERVER['REMOTE_ADDR'] . ":" . $_SERVER['REMOTE_PORT'],
			'method' =>	"   METHOD:\t" . $_SERVER['REQUEST_METHOD'],
			'uri' =>	"   URI:\t\t" . $_SERVER['REQUEST_URI'],
			'input' =>	"   INPUT:\t" . $input
		);
		return $req_array;
	}

	private function get_res_array($output){
		$res_array = array(
			'head' => 	"RESPONSE AT:\t" . date('H:i:s d-m-Y'),
			'from' =>	"   FROM:\t" . $_SERVER['SERVER_NAME'] . ":" . $_SERVER['SERVER_PORT'],
			'output' =>	"   OUTPUT:\t" . $output
		);
		return $res_array;
	}
	
	public function log($type, $content) {
		$array = array();		
		if ($type == "req") {
			$array = $this->get_req_array($content);
		} else {
			$array = $this->get_res_array($content);
		}
		$log_string = "";
		foreach ($array as $row) {
			$log_string .= $row . "\n";
		}
		$log_string .= "\n";
		file_put_contents('log.txt', $log_string, FILE_APPEND);
		
		if ($type == "res") {
			file_put_contents('log.txt', "--------------------------------------------------\n\n", FILE_APPEND);		
		}
	}

}

?>
