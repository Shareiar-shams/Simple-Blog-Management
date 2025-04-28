<?php
  require_once 'db.php';
	class Dashboard_Controller extends Database{

		public function selectData($tableName, $data='', $conditons = '',$limit=''){
			if($data !='' && $conditons != '' && $tableName != '' && $limit != ''){
				$sql = "SELECT $data FROM $tableName WHERE $conditons order by id desc limit $limit";
				$stmt = $this->db->prepare($sql); 
				$stmt->execute();
				$value = $stmt->fetchAll(2); 
			 	return sizeof($value);
			}
			elseif($tableName != '' && $data == '' && $conditons != '' && $limit == ''){
				$sql = "SELECT * FROM $tableName WHERE $conditons";
				$stmt = $this->db->prepare($sql); 
				$stmt->execute();
				return $stmt->fetchAll(2);
			}
			elseif($tableName != '' && $data != '' && $conditons != '' && $limit == ''){
				$sql = "SELECT $data FROM $tableName WHERE $conditons";
				$stmt = $this->db->prepare($sql); 
				$stmt->execute();
				return $stmt->fetchAll(2);
			}
		}	

		public function insertData($tableName, $data){
			if($data != '' && $tableName != ''){
	            $sql = "INSERT INTO $tableName (";
	            foreach($data as $key => $v){
	                $sql .= "$key, ";
	            }
	            $sql = rtrim($sql, ", ");
	            $sql .= ") VALUES (";

	            foreach($data as $key => $v){
	                $sql .= ":$key, ";
	            }

	            $sql = rtrim($sql, ", ");
	            $sql .= ")";
	            try{
	                $stmt = $this->db->prepare($sql);
	                $stmt->execute($data);
	                return true;
	                
	            }catch(PDOException $e){
	                die("Error: " . $e->getMessage());
	            }
	        }else{
	            die("Invalid operations!");
	        }	
		}

		public function updateData($tableName, $data, $conditions=''){
	        if($tableName != '' && $data != '' && $conditions != ''){
	            $sql = "UPDATE $tableName SET ";
	            foreach($data as $key => $v){
	                $sql .= "$key = :$key, ";
	            }

	            $sql = rtrim($sql, ", ");
	            $sql .= " WHERE $conditions";
	            try{
	                $stmt = $this->db->prepare($sql);
	                $stmt->execute($data);
	                return true;
	            }catch(PDOException $e){
	                die("Error: " . $e->getMessage());
	            }
	        }else{
	            die("Invalid operations!");
	        }
	    }

	    public function delete($tableName, $conditions){
	        if($tableName != '' && $conditions != ''){
	            try{
	            	$sql = "DELETE FROM $tableName WHERE $conditions";
	                $stmt = $this->db->prepare($sql);
	                $stmt->execute();
	                return true;
	            }catch(PDOException $e){
	                die("Error: " . $e->getMessage());
	            }
	        }else{
	            die("Invalid operations!");
	        }
	    }
	}

?>