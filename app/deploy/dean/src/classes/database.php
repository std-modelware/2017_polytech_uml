<?php
/**
 * Created by PhpStorm.
 * User: maxim
 * Date: 5/11/18
 * Time: 11:05 PM
 */

class Database {

	private $host;
	private $db_name;
	private $username;
	private $password;
	public $conn;

	public function __construct($host, $db_name, $username, $password){
		$this->host = $host;
		$this->db_name = $db_name;
		$this->username = $username;
		$this->password = $password;
	}

	public function getConnection(){
		$this->conn = null;
		try{
			$this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
			$this->conn->exec("set names utf8");
		}catch(PDOException $exception){
			echo "Connection error: " . $exception->getMessage();
		}
		return $this->conn;
	}
}

?>
