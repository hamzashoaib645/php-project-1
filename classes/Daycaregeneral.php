<?php
/**
*
* This is a class Daycaregeneral
* @version 0.01
* @author Numan Tahir <numantahir1@gmail.com>
*
**/
class Daycaregeneral extends Database{
	public $center_id;

	/**
	* This is the constructor of the class SMS
	* @author Numan Tahir <numantahir1@gmail.com>
	*/
	public function __construct(){
		parent::__construct();
	}
	
	/**
	* This function is used to AllergyList
	* @author Numan Tahir
	*/
	public function lstAllergyList(){
		$Sql = "SELECT 
					allergy_id,
					center_id,
					user_id,
					allergy_title,
					allergy_desc,
					isActive,
					entery_date
					FROM
					rs_tbl_allergy_list
				WHERE 
					1=1";
		
		if($this->isPropertySet("allergy_id", "V"))
			$Sql .= " AND allergy_id=" . $this->getProperty("allergy_id");
		
		if($this->getProperty("center_id", "V"))
			$Sql .= " AND center_id=" . $this->getProperty("center_id");
		
		if($this->getProperty("user_id", "V"))
			$Sql .= " AND user_id=" . $this->getProperty("user_id");
		
		if($this->getProperty("isActive", "V"))
			$Sql .= " AND isActive=" . $this->getProperty("isActive");
		
		if($this->isPropertySet("ORDERBY", "V"))
			$Sql .= " ORDER BY " . $this->getProperty("ORDERBY");
		
		if($this->isPropertySet("limit", "V"))
			$Sql .= $this->appendLimit($this->getProperty("limit"));
		
		return $this->dbQuery($Sql);
	}
	
	
	
	/****************************************************************************************************
	/////////////////////////////////////////////////////////////////////////////////////////////////////
	\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
	/////////////////////////////////////////////////////////////////////////////////////////////////////
	****************************************************************************************************/
	
	/**
	* This function is AllergyList (Delete/Update/Add)
	* @author Numan Tahir
	*/
	public function actAllergyList($mode = "I"){
		$mode = strtoupper($mode);
		switch($mode){
			case "I":
				$Sql = "INSERT INTO rs_tbl_allergy_list(
							allergy_id,
							center_id,
							user_id,
							allergy_title,
							allergy_desc,
							isActive,
							entery_date) 
							VALUES(";
				$Sql .= $this->isPropertySet("allergy_id", "V") ? $this->getProperty("allergy_id") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("center_id", "V") ? $this->getProperty("center_id") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("user_id", "V") ? $this->getProperty("user_id") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("allergy_title", "V") ? "'" . $this->getProperty("allergy_title") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("allergy_desc", "V") ? "'" . $this->getProperty("allergy_desc") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("isActive", "V") ? "'" . $this->getProperty("isActive") . "'" : "1";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("entery_date", "V") ? "'" . $this->getProperty("entery_date") . "'" : "NULL";
				$Sql .= ")";
				break;
			case "U":
				$Sql = "UPDATE rs_tbl_allergy_list SET ";
				
				if($this->isPropertySet("allergy_title", "K")){
					$Sql .= "$con allergy_title='" . $this->getProperty("allergy_title") . "'";
					$con = ",";
				}
				if($this->isPropertySet("allergy_desc", "K")){
					$Sql .= "$con allergy_desc='" . $this->getProperty("allergy_desc") . "'";
					$con = ",";
				}
				if($this->isPropertySet("isActive", "K")){
					$Sql .= "$con isActive='" . $this->getProperty("isActive") . "'";
					$con = ",";
				}
				
				$Sql .= " WHERE 1=1";
				
				if($this->isPropertySet("allergy_id", "V"))
					$Sql .= " AND allergy_id='" . $this->getProperty("allergy_id") . "'";
					
				break;
			case "D":
				$Sql = "DELETE FROM rs_tbl_allergy_list ";
				
				$Sql .= " WHERE 1=1";
				
				if($this->isPropertySet("allergy_id", "V"))
					$Sql .= " AND allergy_id='" . $this->getProperty("allergy_id") . "'";
				
				if($this->isPropertySet("center_id", "V"))
					$Sql .= " AND center_id='" . $this->getProperty("center_id") . "'";
				
				
				break;
			default:
				break;
		}
		
		return $this->dbQuery($Sql);
	}
	
	/**
	* This method is used to get the new code/id for the table.
	* @author Numan Tahir
	* @Date : 29 Oct, 2018
	*/
	public function genCode($table, $field){
		$Sql = "SELECT 
					MAX(" . $field . ") + 1 AS MaxValueR
				FROM 
					" . $table . "
				WHERE
					1=1";
		$this->dbQuery($Sql);
		$rows = $this->dbFetchArray(1);
		if($rows['MaxValueR'] != NULL && $rows['MaxValueR'] != "")
			return $rows['MaxValueR'];
		else
			return 1;
	}
}
?>