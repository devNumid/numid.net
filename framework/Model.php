<?php
	require_once 'config/config_db.php';

	abstract class Model{

		private $LogPath;
		private $pdo;

		function Open_DB($LogPath){
			ini_set('memory_limit', '-1');
			$this->LogPath = $LogPath;
			$this->Connect_DB();
		}

		function Close_DB(){
			$this->Disconnect_DB();
		}

		function Connect_DB(){
			try {
				$this->pdo = new PDO(
								"mysql:host=".DB_HOST.";dbname=".DB_DB.";charset=utf8",
								DB_USER,
								DB_PASS,
								[
									PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
									PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
									PDO::ATTR_EMULATE_PREPARES => false,
								]
							);
			}catch(PDOException $e) {
				$this->Log_DBError("db_connect", $e->getMessage(), $this->LogPath);
			}
		}

		function Disconnect_DB(){
			if ($this->pdo!==null) { $this->pdo = null; }
		}

		function SqlSelect($table, $columns, $conditions = null, $values = null){
			try{
				$query = "SELECT ".$columns." FROM ".$table;
				if ($conditions != null) $query .= " WHERE ".$conditions;
				$prep = $this->pdo->prepare($query);
				$req = $prep->execute($values);
				if ($req){
					$resultat = $prep->fetchAll();
					$prep->closeCursor();
					$prep = NULL;
					return $resultat;
				}else{
					$prep->closeCursor();
					$prep = NULL;
					$this->Log_DBError($query, $resultat, $this->LogPath);
				}
			}catch(PDOException $e){
				$this->Log_DBError($query, $e, $this->LogPath);
			}
		}

		function SqlCount($table, $conditions = null, $values = null){
			try{
				$query = "SELECT count(*) AS value_sum FROM ".$table;
				if ($conditions != null) $query .= " WHERE ".$conditions;
				$prep = $this->pdo->prepare($query);
				$req = $prep->execute($values);
				if ($req){
					$resultat = $prep->fetchAll();
					$prep->closeCursor();
					$prep = NULL;
					return $resultat[0]["value_sum"];
				}else{
					$prep->closeCursor();
					$prep = NULL;
					$this->Log_DBError($query, $resultat, $this->LogPath);
				}
			}catch(PDOException $e){
				$this->Log_DBError($query, $e, $this->LogPath);
			}
		}

		function SqlInsert($table, $columns, $index, $values){
			try{
				$query = "INSERT INTO ".$table." (".$columns.") VALUES (".$index.")";
				$prep = $this->pdo->prepare($query);
				$req = $prep->execute($values);
				$prep->closeCursor();
				$prep = NULL;
				if ($req){
					return true;
				}else{
					$this->Log_DBError($query, $resultat, $this->LogPath);
				}
			}catch(PDOException $e){
				$this->Log_DBError($query, $e, $this->LogPath);
			}
		}

		function SqlUpdate($table, $columns, $conditions = null, $values){
			try{
				$query = "UPDATE ".$table." SET ".$columns;
				if ($conditions != null) $query .= " WHERE ".$conditions;
				$prep = $this->pdo->prepare($query);
				$req = $prep->execute($values);
				$prep->closeCursor();
				$prep = NULL;
				if ($req){
					return true;
				}else{
					$this->Log_DBError($query, $resultat, $this->LogPath);
				}
			}catch(PDOException $e){
				$this->Log_DBError($query, $e, $this->LogPath);
			}
		}

		function SqlDelete($table, $conditions = null, $values = null){
			try{
				$query = "DELETE FROM ".$table;
				if ($conditions != null) $query .= " WHERE ".$conditions;
				$prep = $this->pdo->prepare($query);
				$req = $prep->execute($values);
				$prep->closeCursor();
				$prep = NULL;
				if ($req){
					return true;
				}else{
					$this->Log_DBError($query, $resultat, $this->LogPath);
				}
			}catch(PDOException $e){
				$this->Log_DBError($query, $e, $this->LogPath);
			}
		}

		function Log_DBError($SqlQuery, $resultat){
			$RappError  = "DATE    : ".date ("Y-m-d H:i:s")."<br>\r\n";
			$RappError .= "FILE : ".$this->LogPath."<br>\r\n";
			$RappError .= "REQUEST : ".$SqlQuery."<br>\r\n";
			$RappError .= "DEBUG   : ".$resultat."<br>\r\n";
			$RappError .= "<br>\r\n";
			error_log($RappError, 3, $this->LogPath);
			echo json_encode(array("status" => false,	"message" => "Internal error has occurred".$this->LogPath));
			exit();
		}

		function GetPdoResult($Row, $Index, $columns){
			if ($Row != null) {
				if ((!isset($Row[$Index][$columns]))||(empty($Row[$Index][$columns]))){
					return 0;
				}else{
					return $Row[$Index][$columns];
				}
			}else{
				return 0;
			}
		}
	}
?>