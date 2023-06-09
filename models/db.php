<?php 
namespace app\models;
class db{
	private $db;

	public function __construct($name,$host,$login,$password){
		if(!empty($name) && !empty($host) && !empty($login)){
			//if exists
			try{
			    $this->db = new \PDO("mysql:host={$host};dbname={$name}",$login,$password);
			    $this->db->query("SET NAMES 'utf8'");
				$this->db->query("SET CHARACTER SET 'utf8'");
				$this->db->query("SET SESSION collation_connection = 'utf8_general_ci'");
			}catch(PDOexception $e){
				//if not, create
				$db = new \PDO("mysql:host={$host}",$login,$password);
				$db->exec("CREATE DATABASE {$name}");
				$this->db = new \PDO("mysql:host={$host};dbname={$name}",$login,$password);
				$this->db->query("SET NAMES 'utf8'");
				$this->db->query("SET CHARACTER SET 'utf8'");
				$this->db->query("SET SESSION collation_connection = 'utf8_general_ci'");
			}
		}else{$error[] = "ошибка подключения к Базе";}
		$this->db->setAttribute(\PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION);
	}
	// get db from outside;
	public function getDb(){
		return $this->db;
	}

}