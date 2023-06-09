<?php
namespace app\models;

class table{
	private $db,$name,$columns,$key;
	private $Texists = 0;
	private $errors = 0;
	//here you need an instance of the db class and the name of the table 
	public function __construct($db,$name){
		if(get_called_class() != "user"){
			if($name == "users"){
				$this->errors = 1;
			}
		}else if(get_called_class() == "user"){
			if($name != "users"){
				$this->errors = 1;
			}
		}

		if($this->errors == 0){
			$this->db = $db;
			$this->name = $name;
			$searchTable = $this->db->query("SHOW TABLES",\PDO::FETCH_ASSOC)->fetchall();
			foreach ($searchTable as $tables) {
				if(array_values($tables)[0] == $this->name){
					$this->Texists = 1;
				}
			}
		}
		
	}
	//save the new column of the table
	public function columns($column){
		if($this->errors == 0){
			if($this->Texists  == 0){
				$this->columns .= $column.",";	
			}
		}
		
	}
	//new index for column
	public function keys($key){
		if($this->errors == 0){
			if($this->Texists  == 0){
				$this->key .= "KEY({$key})".",";
			}
		}
	}
	//create new table 
	public function create(){
		if($this->errors == 0){
			if($this->Texists  == 0){
				$query = $this->columns.$this->key;
				$query = preg_replace("/,$/",'',$query);
				$this->db->exec("CREATE TABLE IF NOT EXISTS {$this->name}({$query})");
			}
		}
	}
	//select from table
	public function select($columns,$fetch = 0,$query= false,$order=false,$group=false,$having=false){
		if($this->errors == 0){
			//if isset query
			if(!empty($query) && $query != false){
				$query = "WHERE $query";	
			}
			if(!empty($order) && $order != false){
				$order = "ORDER BY $order";
			}
			if(!empty($group) && $group != false){
				$group = "GROUP BY $group";
			}
			if(!empty($having) && $having != false){
				$having .= " HAVING $having";
			}
			$terms = $query." ".$order." ".$group." ".$having;
			//if fetch == 1 fetch assoc
			if($fetch != 0){
				$data = $this->db->query("SELECT {$columns} FROM {$this->name} {$terms}",\PDO::FETCH_ASSOC)->fetchall();
			//if fetch == 0 fetch all
			}elseif($fetch == 0){
				$data = $this->db->query("SELECT {$columns} FROM {$this->name} {$terms}")->fetchall();
			}
			//if fetch is double-digit fetch row = the second digit of the number
			if($fetch > 1){
				$pos = substr($fetch,1);
				$data = $data[$pos];
			}
			return $data;
		}
	}
	//update from table
	public function update($column,$newValue,$where){
		if($this->errors == 0 && !empty($column) && !empty($newValue) && !empty($where)){
			$columns = explode(',',$column);
			$newValue = explode(',',$newValue);
			if(count($columns) == count($newValue)){
				$update = '';
				for($i = 0;$i<count($columns);$i++){
					$update .= $columns[$i]."=".$newValue[$i].',';
				}
				$update = preg_replace("/,$/",'',$update);
				$this->db->exec("UPDATE {$this->name} SET {$update} WHERE {$where}");
			}
			
		}
	}
	//delete from table
	public function delete($where){
		if($this->errors == 0){
			if(isset($where) && !empty($where)){
				$this->db->exec("DELETE FROM {$this->name} WHERE {$where}");	
			}
		}
			
	}
	//delete from table columns as string values as array
	public function insert(string $columns,...$values){
		if($this->errors == 0){
			$error = 0;
			if(!empty($columns)){
				$columns = "($columns)";
				//if columns length != values length error
				if(count(explode(',',$columns)) != count($values)){
					$error = $error +1;
				}
			}
		
		
 			if($error == 0){
 				//for prepare bind
 				$val = '';
 				for($i = 0;$i < count($values);$i++){
					$val .= ":v".$i.","; 	
				}
 				//drop last comma
 				$val = preg_replace("/,$/","",$val);
 				$userAdd = $this->db->prepare("INSERT INTO {$this->name} $columns VALUES({$val})");
 				//bind vN with valueN
				for($i2 = 0;$i2 < count($values);$i2++){
					$userAdd->bindValue(":v".$i2,$values[$i2]);
				}	
				$userAdd->execute();
 			}
 		}
	}
}