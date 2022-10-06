<?php
/**
*
* This is a class Daycareattendance
* @version 0.01
* @author Numan Tahir <numantahir1@gmail.com>
*
**/
class Daycareattendance extends Database{
	public $attendance_id;

	/**
	* This is the constructor of the class SMS
	* @author Numan Tahir <numantahir1@gmail.com>
	*/
	public function __construct(){
		parent::__construct();
	}
	
	/**
	* This function is used to Attendance
	* @author Numan Tahir
	*/
	public function lstAttendance(){
		$Sql = "SELECT 
					attendance_id,
					user_id,
					center_id,
					att_in,
					att_out,
					att_date,
					day_id,
					day_status,
					att_mode,
					shift_st,
					shift_et,
					shift_process,
					att_process,
					entery_date
					FROM
					rs_tbl_attendance
				WHERE 
					1=1";
		
		if($this->isPropertySet("attendance_id", "V"))
			$Sql .= " AND attendance_id=" . $this->getProperty("attendance_id");
		
		if($this->getProperty("user_id", "V"))
			$Sql .= " AND user_id=" . $this->getProperty("user_id");
		
		if($this->getProperty("center_id", "V"))
			$Sql .= " AND center_id=" . $this->getProperty("center_id");
		
		if($this->getProperty("att_mode", "V"))
			$Sql .= " AND att_mode=" . $this->getProperty("att_mode");
		
		if($this->getProperty("att_process", "V"))
			$Sql .= " AND att_process=" . $this->getProperty("att_process");
		
		if($this->getProperty("day_status", "V"))
			$Sql .= " AND day_status=" . $this->getProperty("day_status");
			
		if($this->getProperty("shift_process", "V"))
			$Sql .= " AND shift_process=" . $this->getProperty("shift_process");
		
		if($this->getProperty("att_date", "V"))
			$Sql .= " AND att_date='" . $this->getProperty("att_date") . "'";
		
		if($this->getProperty("less_att_date", "V"))
			$Sql .= " AND att_date < '" . $this->getProperty("less_att_date") . "'";
			
		if($this->getProperty("outtime_missing", "V"))
			$Sql .= " AND (att_out IS NULL or att_out='00:00:00')";
			
		if($this->isPropertySet("DATEFILTER", "V"))
			$Sql .= " AND att_date BETWEEN '".$this->getProperty("STARTDATE")."' AND '".$this->getProperty("ENDDATE")."'";
			
		if($this->getProperty("att_in_not", "V"))
			$Sql .= " AND att_in!='" . $this->getProperty("att_in_not") . "'";
			
		if($this->isPropertySet("ORDERBY", "V"))
			$Sql .= " ORDER BY " . $this->getProperty("ORDERBY");
		
		if($this->isPropertySet("limit", "V"))
			$Sql .= $this->appendLimit($this->getProperty("limit"));
		
		return $this->dbQuery($Sql);
	}
	
	/**
	* This function is used to ChildAttendance
	* @author Numan Tahir
	*/
	public function lstChildAttendance(){
		$Sql = "SELECT 
					child_attendance_id,
					child_id,
					center_id,
					parent_id,
					teacher_id,
					att_in_parent,
					att_in_dcare,
					att_in_class,
					att_out_class,
					att_out_dcare,
					att_out_parent,
					att_out_reason,
					att_date,
					day_id,
					day_status,
					att_mode,
					shift_st,
					shift_et,
					shift_process,
					child_in_parent,
					child_in_class,
					entery_date
					FROM
					rs_tbl_child_attendance
				WHERE 
					1=1";
		
		if($this->isPropertySet("child_attendance_id", "V"))
			$Sql .= " AND child_attendance_id=" . $this->getProperty("child_attendance_id");
		
		if($this->getProperty("child_id", "V"))
			$Sql .= " AND child_id=" . $this->getProperty("child_id");
		
		if($this->getProperty("center_id", "V"))
			$Sql .= " AND center_id=" . $this->getProperty("center_id");
		
		if($this->getProperty("parent_id", "V"))
			$Sql .= " AND parent_id=" . $this->getProperty("parent_id");
		
		if($this->getProperty("teacher_id", "V"))
			$Sql .= " AND teacher_id=" . $this->getProperty("teacher_id");
		
		if($this->getProperty("day_status", "V"))
			$Sql .= " AND day_status=" . $this->getProperty("day_status");
			
		if($this->getProperty("shift_process", "V"))
			$Sql .= " AND shift_process=" . $this->getProperty("shift_process");
		
		if($this->getProperty("att_date", "V"))
			$Sql .= " AND att_date='" . $this->getProperty("att_date") . "'";
		
		if($this->getProperty("less_att_date", "V"))
			$Sql .= " AND att_date < '" . $this->getProperty("less_att_date") . "'";
			
		if($this->isPropertySet("DATEFILTER", "V"))
			$Sql .= " AND att_date BETWEEN '".$this->getProperty("STARTDATE")."' AND '".$this->getProperty("ENDDATE")."'";
			
		if($this->getProperty("att_in_not", "V"))
			$Sql .= " AND att_in!='" . $this->getProperty("att_in_not") . "'";
			
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
	* This function is Attendance (Delete/Update/Add)
	* @author Numan Tahir
	*/
	public function actAttendance($mode = "I"){
		$mode = strtoupper($mode);
		switch($mode){
			case "I":
				$Sql = "INSERT INTO rs_tbl_attendance(
							user_id,
							att_in,
							att_out,
							att_date,
							day_id,
							att_mode,
							device_id,
							att_process,
							entery_date) 
							VALUES(";
				$Sql .= $this->isPropertySet("user_id", "V") ? $this->getProperty("user_id") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("att_in", "V") ? "'" . $this->getProperty("att_in") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("att_out", "V") ? "'" . $this->getProperty("att_out") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("att_date", "V") ? "'" . $this->getProperty("att_date") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("day_id", "V") ? "'" . $this->getProperty("day_id") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("att_mode", "V") ? "'" . $this->getProperty("att_mode") . "'" : "1";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("device_id", "V") ? "'" . $this->getProperty("device_id") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("att_process", "V") ? "'" . $this->getProperty("att_process") . "'" : "1";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("entery_date", "V") ? "'" . $this->getProperty("entery_date") . "'" : "NULL";
				$Sql .= ")";
				break;
			case "U":
				$Sql = "UPDATE rs_tbl_attendance SET ";
				
				if($this->isPropertySet("att_in", "K")){
					$Sql .= "$con att_in='" . $this->getProperty("att_in") . "'";
					$con = ",";
				}
				if($this->isPropertySet("att_out", "K")){
					$Sql .= "$con att_out='" . $this->getProperty("att_out") . "'";
					$con = ",";
				}
				if($this->isPropertySet("shift_st", "K")){
					$Sql .= "$con shift_st='" . $this->getProperty("shift_st") . "'";
					$con = ",";
				}
				if($this->isPropertySet("shift_et", "K")){
					$Sql .= "$con shift_et='" . $this->getProperty("shift_et") . "'";
					$con = ",";
				}
				if($this->isPropertySet("shift_process", "K")){
					$Sql .= "$con shift_process='" . $this->getProperty("shift_process") . "'";
					$con = ",";
				}
				if($this->isPropertySet("att_mode", "K")){
					$Sql .= "$con att_mode='" . $this->getProperty("att_mode") . "'";
					$con = ",";
				}
				if($this->isPropertySet("att_process", "K")){
					$Sql .= "$con att_process='" . $this->getProperty("att_process") . "'";
					$con = ",";
				}
				if($this->isPropertySet("reason_overtime", "K")){
					$Sql .= "$con reason_overtime='" . $this->getProperty("reason_overtime") . "'";
					$con = ",";
				}
				if($this->isPropertySet("overtime_status", "K")){
					$Sql .= "$con overtime_status='" . $this->getProperty("overtime_status") . "'";
					$con = ",";
				}
				
				if($this->isPropertySet("day_status", "K")){
					$Sql .= "$con day_status='" . $this->getProperty("day_status") . "'";
					$con = ",";
				}
				if($this->isPropertySet("ligt_status", "K")){
					$Sql .= "$con ligt_status='" . $this->getProperty("ligt_status") . "'";
					$con = ",";
				}
				if($this->isPropertySet("eogt_status", "K")){
					$Sql .= "$con eogt_status='" . $this->getProperty("eogt_status") . "'";
					$con = ",";
				}
				
				$Sql .= " WHERE 1=1";
				
				if($this->isPropertySet("attendance_id", "V"))
					$Sql .= " AND attendance_id='" . $this->getProperty("attendance_id") . "'";
					
				break;
			case "D":
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