<?php
	class Dashboard_Controller extends Database{

		public function selectData($tableName, $data='', $conditons = '',$limit=''){
			if($data !='' && $conditons != '' && $tableName != '' && $limit != ''){
				$sql = "SELECT $data FROM $tableName WHERE $conditons order by id desc limit $limit";
				$stmt = $this->db->prepare($sql); 
				$stmt->execute();
				if($limit == 1)
					return $stmt->fetch(2);
				else
					return $stmt->fetchAll(2);
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

		public function insertData($tableName, $data, $fetch_id = false){
	    if (!empty($data) && !empty($tableName) && is_array($data)) {

	        // Validate column names
	        foreach ($data as $key => $value) {
	            if (!preg_match('/^[a-zA-Z0-9_]+$/', $key)) {
	                throw new Exception("Invalid column name: $key");
	            }
	        }

	        $columns = implode(", ", array_keys($data));
	        $placeholders = ":" . implode(", :", array_keys($data));
	        $sql = "INSERT INTO $tableName ($columns) VALUES ($placeholders)";

	        try {
	            $stmt = $this->db->prepare($sql);
	            $stmt->execute($data);

	            if ($fetch_id) {
	                $id = $this->db->lastInsertId();
	                return ['id' => $id, 'status' => true];
	            } else {
	                return true;
	            }

	        } catch (PDOException $e) {
	            throw new Exception("Database error: " . $e->getMessage());
	        }

	    } else {
	        throw new Exception("Invalid input or table name.");
	    }
		}


		public function updateData($tableName, $data, $conditions='', $fetch_id = false){
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