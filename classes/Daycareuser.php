<?php
/**
*
* This is a class Daycareuser
* @version 0.01
* @author Numan Tahir <numantahir1@gmail.com>
*
**/
class Daycareuser extends Database{
	public $user_login;
	public $user_id;
	public $user_mobile;
	public $fullname;
	public $user_fname;
	public $login_time;
	public $ProTmpID;
	public $user_type;
	public $profile_img;
	public $location_id;
	public $center_id;
	public $sd_code;

	/**
	* This is the constructor of the class User
	* @author Numan Tahir <numantahir1@gmail.com>
	*/
	public function __construct(){
		parent::__construct();

		if($_SESSION['user_login']){
			$this->gen_fir		 	= $_SESSION['gen_fir'];
			$this->user_login 		= $_SESSION['user_login'];
			$this->user_id			= $_SESSION['user_id'];
			$this->user_mobile 		= $_SESSION['user_mobile'];
			$this->fullname			= $_SESSION['fullname'];
			$this->login_time		= $_SESSION['login_time'];
			$this->user_fname		= $_SESSION['user_fname'];
			$this->user_type		= $_SESSION['user_type'];
			$this->profile_img		= $_SESSION['profile_img'];
			$this->location_id		= $_SESSION['location_id'];
			$this->center_id		= $_SESSION['center_id'];
			$this->sd_code			= $_SESSION['sd_code'];
		}
		if($_SESSION['ProTmpID']){
			$this->ProTmpID			= $_SESSION['ProTmpID'];
		}
	}

	/**
	* This is the function to Generate Unique Code for session.
	* @author Numan Tahir
	*/
	function generate_fingerprint()  {
		//We don't use the ip-adress, because it is subject to change in most cases
		foreach(array('HTTP_HOST', 'HTTP_ACCEPT', 'SERVER_NAME', 'HTTP_USER_AGENT') as $name) {
			$key[] = empty($_SERVER[$name]) ? NULL : $_SERVER[$name];
		}
		
		if($this->user_id != ''){
		$key[] = '/'.SITE_NAME.'/'.SITE_URL.'/'.session_id().'/'.date("Ymd").'/'.$this->user_id;
		} else {
		$key[] = '/'.SITE_NAME.'/'.SITE_URL.'/'.session_id().'/'.date("Ymd").'/'.$this->getProperty("user_id");	
		}
		//Create an MD5 has and return it
		return md5(implode("\0", $key));
	}

	/**
	* This is the function to set the customer logged in
	* @author Numan Tahir
	*/
	public function setLogin(){
		
		$_SESSION['gen_fir'] 		= $this->generate_fingerprint();
		
		$_SESSION['user_login'] 	= true;
		
		# Logged in customer's member code
		if($this->isPropertySet("user_id", "V"))
			$_SESSION['user_id'] = $this->getProperty("user_id");
		
		# Logged in customer's email
		if($this->isPropertySet("user_mobile", "V"))
			$_SESSION['user_mobile'] = $this->getProperty("user_mobile");
		
		# Logged in customer's logged in time
		if($this->isPropertySet("login_time", "V"))
			$_SESSION['login_time'] 	= $this->getProperty("login_time");
		
		# Logged in customer's fullname
		if($this->isPropertySet("fullname", "V"))
			$_SESSION['fullname'] = $this->getProperty("fullname");
		
		# Logged in customer's first name
		if($this->isPropertySet("user_fname", "V"))
			$_SESSION['user_fname'] = $this->getProperty("user_fname");
			
		# Logged in customer's Type
		if($this->isPropertySet("user_type", "V"))
			$_SESSION['user_type'] = $this->getProperty("user_type");
		
		# Logged in User Profile
		if($this->isPropertySet("profile_img", "V"))
			$_SESSION['profile_img'] = $this->getProperty("profile_img");
		
		# Logged in User Location
		if($this->isPropertySet("location_id", "V"))
			$_SESSION['location_id'] = $this->getProperty("location_id");
		
		# Logged in User SD Code
		if($this->isPropertySet("center_id", "V"))
			$_SESSION['center_id'] = $this->getProperty("center_id");
			
		# Logged in User Center DEtail Panel
		$_SESSION['center_id'] = "false";
	}
	
	/**
	* This is the function to set the customer logged in
	* @author Numan Tahir
	*/
	public function setSecurityCode(){
		
		$_SESSION['center_id'] 	= "true";
		
		# Logged in User SD Code
		if($this->isPropertySet("center_id", "V"))
			$_SESSION['center_id'] = $this->getProperty("center_id");
			
	}
	/**
	* This function is used to check whether the customer has been logged in or not.
	* @author Numan Tahir
	*/
	public function checkLogin(){
		if($this->user_login && $this->gen_fir==$this->generate_fingerprint()){
			return true;
		}
		else{
			return false;
		}
	}
	
	
	/**
	* This method is used to get image extension
	* @author Numan Tahir
	* @Date : 27 Oct, 2018
	* @return : bool
	*/
	function getExtention($type){
		if($type == "image/jpeg" || $type == "image/jpg" || $type == "image/pjpeg")
			return "jpg";
		elseif($type == "image/png")
			return "png";
		elseif($type == "image/gif")
			return "gif";
	}
	
	/**
 	* Product::getImagename()	
	* This method is used to get image name
	* @author Numan Tahir
	* @Date : 27 Oct, 2018
	* @return : bool
	*/

	public function getImagename($type, $user_id = ''){
		$md5 		= md5(time());
		$filename 	=  substr($md5, rand(5, 25), 5);
		if($user_id != ''){
			$filename = $filename . '-' . $user_id . "." . $this->getExtention($type);
		}
		else{
			$filename = $filename . "." . $this->getExtention($type);
		}
		return $filename;
	}
	
	/**
 	* Product::getDocumentName()	
	* This method is used to get image name
	* @author Numan Tahir
	* @Date : 27 Oct, 2018
	* @return : bool
	*/

	public function getDocumentName($filanname, $user_id = ''){
		$md5 		= md5(time());
		$filename 	=  substr($md5, rand(5, 25), 5);
		if($user_id != ''){
			$filename = $filename . '-' . $user_id . "." . end(explode('.', $filanname));
		}
		else{
			$filename = $filename . "." . end(explode('.', $filanname));
		}
		return $filename;
	}
	
	/**
 	* Product::getImagename()	
	* This method is used to Check Image Extention
	* @author Numan Tahir
	* @Date : 27 Oct, 2018
	* @return : bool
	*/
	public function getExtentionValidate($type){
		if($type == "image/jpeg" || $type == "image/jpg" || $type == "image/pjpeg" || $type=="image/png" || $type=="image/gif")
			return 1;
		else
			return 0;
	}
	
	/**
	* This function is used to prepare the Month List
	* @author Numan Tahir
	*/
	public function MonthList($Month_id){
			$MonthList = '';
			if($Month_id==1){
			$MonthList .= '<option value="1" selected>Jan</option>';
			} else {
			$MonthList .= '<option value="1">Jan</option>';
			}
			if($Month_id==2){
			$MonthList .= '<option value="2" selected>Feb</option>';
			} else {
			$MonthList .= '<option value="2">Feb</option>';
			}
			if($Month_id==3){
			$MonthList .= '<option value="3" selected>Mar</option>';
			} else {
			$MonthList .= '<option value="3">Mar</option>';
			}
			if($Month_id==4){
			$MonthList .= '<option value="4" selected>Apr</option>';
			} else {
			$MonthList .= '<option value="4">Apr</option>';
			}
			if($Month_id==5){
			$MonthList .= '<option value="5" selected>May</option>';
			} else {
			$MonthList .= '<option value="5">May</option>';
			}
			if($Month_id==6){
			$MonthList .= '<option value="6" selected>Jun</option>';
			} else {
			$MonthList .= '<option value="6">Jun</option>';
			}
			if($Month_id==7){
			$MonthList .= '<option value="7" selected>Jul</option>';
			} else {
			$MonthList .= '<option value="7">Jul</option>';
			}
			if($Month_id==8){
			$MonthList .= '<option value="8" selected>Aug</option>';
			} else {
			$MonthList .= '<option value="8">Aug</option>';
			}
			if($Month_id==9){
			$MonthList .= '<option value="9" selected>Sep</option>';
			} else {
			$MonthList .= '<option value="9">Sep</option>';
			}
			if($Month_id==10){
			$MonthList .= '<option value="10" selected>Oct</option>';
			} else {
			$MonthList .= '<option value="10">Oct</option>';
			}
			if($Month_id==11){
			$MonthList .= '<option value="11" selected>Nov</option>';
			} else {
			$MonthList .= '<option value="11">Nov</option>';
			}
			if($Month_id==12){
			$MonthList .= '<option value="12" selected>Dec</option>';
			} else {
			$MonthList .= '<option value="12">Dec</option>';
			}
		return $MonthList;	
	}
	
	/**
	* This function is used to prepare the Days List
	* @author Numan Tahir
	*/
	public function DayList($Day_id){
			$Day_list = '';
			for($i=1; $i<=31; $i++){
			if($i == $Day_id){
			$Day_list .= '<option value="' . $i . '" selected>' . $i . '</option>';
			} else {
			$Day_list .= '<option value="' . $i . '">' . $i . '</option>';
			}
			}
		return $Day_list;
	}
	
	/**
	* This function is used to prepare the Year List
	* @author Numan Tahir
	*/
	public function YearList($Year_id){
			$Year_list = '';
			
			for($y=1905; $y<=2011; $y++){
			if($y == $Year_id){
			$Year_list .= '<option value="' . $y . '" selected>' . $y . '</option>';
			} else {
			$Year_list .= '<option value="' . $y . '">' . $y . '</option>';
			}
			}
		return $Year_list;
	}
	
	/**
	* This is the function to set the Temp Request Register
	* @author Numan Tahir
	*/
	public function settmpReg(){
		
		# Register Product ID
		if($this->isPropertySet("ProTmpID", "V"))
			$_SESSION['ProTmpID'] 		= $this->getProperty("ProTmpID");
	}
	
	/**
	* This is the function to set the Temp Request Un-Register
	* @author Numan Tahir
	*/
	public function UnRegTmp(){
		unset($_SESSION['ProTmpID']);
	}
	
	/**
	* This is the function to the Check User Email Address
	* @author Numan Tahir
	*/
	public function CheckUserEmail(){
		$Sql = "SELECT 
					user_id,
					user_email
				FROM
					rs_tbl_users
				WHERE 
					1=1";
		if($this->isPropertySet("user_email", "V"))
			$Sql .= " AND user_email='" . $this->getProperty("user_email") . "'";
		
		return $this->dbQuery($Sql);
	}
	
	/**
	* This is the function to the Check User Mobile Number
	* @author Numan Tahir
	*/
	public function CheckUserMobile(){
		$Sql = "SELECT 
					user_id,
					user_mobile
				FROM
					rs_tbl_users
				WHERE 
					1=1";
		if($this->isPropertySet("user_mobile", "V"))
			$Sql .= " AND user_mobile='" . $this->getProperty("user_mobile") . "'";
		
		return $this->dbQuery($Sql);
	}
	
	/**
	* This function is used to check the user login
	* @author Numan Tahir
	*/
	public function checkUserLogin(){
		$Sql = "SELECT 
					user_id,
					center_id,
					user_email,
					user_mobile,
					user_pass,
					user_fname,
					user_lname,
					CONCAT(user_fname,' ',user_lname) AS fullname,
					user_type_id,
					isActive,
					login_required,
					user_profile_img,
					sms_verification,
					short_code,
					location_id
				FROM
					rs_tbl_users
				WHERE 
					1=1";
		if($this->isPropertySet("user_email", "V"))
			$Sql .= " AND user_email='" . $this->getProperty("user_email") . "'";
		
		if($this->isPropertySet("user_mobile", "V"))
			$Sql .= " AND user_mobile='" . $this->getProperty("user_mobile") . "'";
		
		if($this->isPropertySet("short_code", "V"))
			$Sql .= " AND short_code='" . $this->getProperty("short_code") . "'";
		
		if($this->isPropertySet("login_required", "V"))
			$Sql .= " AND login_required='" . $this->getProperty("login_required") . "'";
				
		if($this->isPropertySet("user_type_id", "V"))
			$Sql .= " AND user_type_id=" . $this->getProperty("user_type_id");
			
		if($this->isPropertySet("user_pass", "V"))
			$Sql .= " AND user_pass='" . $this->getProperty("user_pass") . "'";
		
		//echo $Sql;
		return $this->dbQuery($Sql);
	}
	
	/**
	* This function is used to Activate user account
	* @author Numan Tahir
	*/
	public function UserActivate(){
		$Sql = "UPDATE rs_tbl_users SET
					isActive=1
				WHERE 
					1=1";
					
		if($this->isPropertySet("user_id", "V"))
			$Sql .= " AND user_id=" . $this->getProperty("user_id");
		
		return $this->dbQuery($Sql);
	}
	
	/**
	* This method is used to the user's combo
	* @author Numan Tahir
	*/
	public function customerCombo($sel = ""){
		$opt = "";
		$Sql = "SELECT 
					user_id,
					CONCAT(user_fname, ' ', user_lname) as fullname
				FROM
					rs_tbl_users
				WHERE
					1=1 
					AND isActive=1 ORDER BY user_fname";
		$this->dbQuery($Sql);
		while($rows = $this->dbFetchArray(1)){
			if($rows['user_id'] == $sel)
				$opt .= "<option value=\"" . $rows['user_id'] . "\" selected>" . $rows['fullname'] . "</option>\n";
			else
				$opt .= "<option value=\"" . $rows['user_id'] . "\">" . $rows['fullname'] . "</option>\n";
		}
		return $opt;
	}
	
	/**
	* This method is used to the user's combo
	* @author Numan Tahir
	*/
	public function EmployeeCombo($sel = ""){
		$opt = "";
		$Sql = "SELECT 
					user_id,
					CONCAT(user_fname, ' ', user_lname) as fullname
				FROM
					rs_tbl_users
				WHERE
					1=1 
					AND isActive=1 AND user_type_id=1 ORDER BY user_fname";
		$this->dbQuery($Sql);
		while($rows = $this->dbFetchArray(1)){
			if($rows['user_id'] == $sel)
				$opt .= "<option value=\"" . $rows['user_id'] . "\" selected>" . $rows['fullname'] . "</option>\n";
			else
				$opt .= "<option value=\"" . $rows['user_id'] . "\">" . $rows['fullname'] . "</option>\n";
		}
		return $opt;
	}
	
	/**
	* This method is used to the Shift Combo
	* @author Numan Tahir
	*/
	public function ShiftCombo($sel = ""){
		$opt = "";
		$Sql = "SELECT 
					shift_id,
					center_id,
					shift_name
				FROM
					rs_tbl_shifts
				WHERE
					1=1 
					AND isActive=1";
		$this->dbQuery($Sql);
		while($rows = $this->dbFetchArray(1)){
			if($rows['shift_id'] == $sel)
				$opt .= "<option value=\"" . $rows['shift_id'] . "\" selected>" . $rows['shift_name'] . "</option>\n";
			else
				$opt .= "<option value=\"" . $rows['shift_id'] . "\">" . $rows['shift_name'] . "</option>\n";
		}
			if($sel != '' && $sel==0){
				$opt .= "<option value=\"0\" selected>Off Day  ".$sel."</option>";
			} else {
				$opt .= "<option value=\"0\">Off Day ".$sel."</option>";
			}
		return $opt;
	}
	
	/**
	* This method is used to the Shift Combo
	* @author Numan Tahir
	*/
	public function GetShiftName($shifid){
		$opt = "";
		$Sql = "SELECT
					shift_id,
					center_id,
					shift_name
				FROM
					rs_tbl_shifts
				WHERE
					1=1 
					AND isActive=1 AND shift_id='".$shifid."'";
		$this->dbQuery($Sql);
		$rows = $this->dbFetchArray(1);
		return $rows['shift_name'];
	}	
	
	/**
	* This method is used to the Agent's combo
	* @author Numan Tahir
	*/
	public function AgentCombo($center_id,$not_user_type_id){
		$opt = "";
		$Sql = "SELECT 
					user_id,
					CONCAT(user_fname, ' ', user_lname) as fullname,
					user_type_id
				FROM
					rs_tbl_users
				WHERE
					1=1 
					AND isActive=1 AND center_id='".$center_id."' AND (user_type_id!='".$not_user_type_id."' and user_type_id!=1)";
		$this->dbQuery($Sql);
		while($rows = $this->dbFetchArray(1)){
			if($rows['user_id'] == $sel)
				$opt .= "<option value=\"" . $rows['user_id'] . "\" selected>" . $rows['fullname'] . ' => [' . UserType($rows['user_type_id']) . "]</option>\n";
			else
				$opt .= "<option value=\"" . $rows['user_id'] . "\">" . $rows['fullname'] . ' => [' . UserType($rows['user_type_id']) . "]</option>\n";
		}
		return $opt;
	}
	
	/**
	* This method is used to the Company combo
	* @author Numan Tahir
	*/
	public function CenterCombo($sel = ""){
		$opt = "";
		$Sql = "SELECT
					center_id,
					center_name
				FROM
					rs_tbl_center_detail
				WHERE
					1=1 
					AND isActive=1";
		$this->dbQuery($Sql);
		while($rows = $this->dbFetchArray(1)){
			if($rows['company_id'] == $sel)
				$opt .= "<option value=\"" . $rows['center_id'] . "\" selected>" . $rows['center_name'] . "</option>\n";
			else
				$opt .= "<option value=\"" . $rows['center_id'] . "\">" . $rows['center_name'] . "</option>\n";
		}
		return $opt;
	}
	
	/**
	* This method is used to the Job Title Combo
	* @author Numan Tahir
	*/
	public function JobTitleCombo($sel = ""){
		$opt = "";
		$Sql = "SELECT
					job_title_id,
					center_id,
					job_title
				FROM
					rs_tbl_job_title
				WHERE
					1=1 
					AND isActive=1";
		$this->dbQuery($Sql);
		while($rows = $this->dbFetchArray(1)){
			if($rows['job_title_id'] == $sel)
				$opt .= "<option value=\"" . $rows['job_title_id'] . "\" selected>" . $rows['job_title'] . "</option>\n";
			else
				$opt .= "<option value=\"" . $rows['job_title_id'] . "\">" . $rows['job_title'] . "</option>\n";
		}
		return $opt;
	}
	
	/**
	* This method is used to the Department
	* @author Numan Tahir
	*/
	public function DepartmentCombo($sel = ""){
		$opt = "";
		$Sql = "SELECT
					dp.department_id,
					dp.center_id,
					dp.user_id,
					dp.company_id,
					dp.department_name,
					dp.isActive,
					cp.company_name
				FROM
					rs_tbl_department as dp
					INNER JOIN rs_tbl_center_detail cp
						ON (dp.center_id = cp.center_id)
				WHERE
					1=1 
					AND dp.isActive=1";
		$this->dbQuery($Sql);
		while($rows = $this->dbFetchArray(1)){
			if($rows['department_id'] == $sel)
				$opt .= "<option value=\"" . $rows['department_id'] . "\" selected>" . $rows['center_name'] . ' -> ' . $rows['department_name'] . "</option>\n";
			else
				$opt .= "<option value=\"" . $rows['department_id'] . "\">" . $rows['center_name'] . ' -> ' . $rows['department_name'] . "</option>\n";
		}
		return $opt;
	}
	
	/**
	* This method is used to the Get Company & Department Name
	* @author Numan Tahir
	*/
	public function GetComDeptInfo($department_id){
		$Sql = "SELECT
					dept.department_id,
					dept.department_name,
					dept.isActive,
					comp.company_name
				FROM
					rs_tbl_department as dept
					INNER JOIN rs_tbl_center_detail as comp
						ON (dept.center_id = comp.center_id)
				WHERE
					1=1 
					AND dept.isActive=1 AND dept.department_id='".$department_id."'";
		$this->dbQuery($Sql);
			$rows = $this->dbFetchArray(1);
		return $rows['center_name'].'/'.$rows['department_name'];
	}
	
	/**
	* This method is used to the Get User fullname
	* @author Numan Tahir
	*/
	public function GetUserFullName($user_id){
		$Sql = "SELECT 
					user_id,
					CONCAT(user_fname,' ',user_lname) AS fullname
				FROM
					rs_tbl_users
				WHERE
					1=1 
					 AND user_id='".$user_id."'";
		$this->dbQuery($Sql);
			$rows = $this->dbFetchArray(1);
		return $rows['fullname'];
	}
		
	
	/**
	* This function is used to list the users
	* @author Numan Tahir
	*/
	public function lstUsers(){
		$Sql = "SELECT 
					user_id,
					center_id,
					enter_user_id,
					user_email,
					user_mobile,
					user_pass,
					user_fname,
					user_lname,
					CONCAT(user_fname,' ',user_lname) AS fullname,
					user_address,
					user_phone,
					usre_idcard_no,
					user_type_id,
					user_designation,
					user_signature,
					user_profile_img,
					sms_verification,
					short_code,
					location_id,
					login_required,
					isActive,
					reg_date,
					user_code,
					user_gender,
					user_dob,
					user_marital_status,
					center_oe_option,
					DATE_FORMAT(user_dob, '%m-%d') AS upcoming_dob
				FROM
					rs_tbl_users 
				WHERE 
					1=1";
		
		if($this->isPropertySet("user_id", "V"))
			$Sql .= " AND user_id=" . $this->getProperty("user_id");
		
		if($this->isPropertySet("enter_user_id", "V"))
			$Sql .= " AND enter_user_id=" . $this->getProperty("enter_user_id");
		
		if($this->isPropertySet("user_id_not", "V"))
			$Sql .= " AND user_id!=" . $this->getProperty("user_id_not");
			
		if($this->isPropertySet("search_user", "V")){
			$Sql .= " AND (LOWER(user_fname) LIKE '%" . $this->getProperty("search_user") . "%' OR LOWER(user_lname) LIKE '%" . $this->getProperty("search_user") . "%')";
		}
		if($this->isPropertySet("user_email", "V"))
			$Sql .= " AND user_email='" . $this->getProperty("user_email") . "'";
		
		if($this->getProperty("user_type_id", "V"))
			$Sql .= " AND user_type_id='" . $this->getProperty("user_type_id") ."'";
		
		if($this->getProperty("user_type_id_not", "V"))
			$Sql .= " AND user_type_id!='" . $this->getProperty("user_type_id_not") ."'";
			
		if($this->getProperty("isActive", "V"))
			$Sql .= " AND isActive='" . $this->getProperty("isActive") ."'";
		
		if($this->getProperty("user_mobile", "V"))
			$Sql .= " AND user_mobile='" . $this->getProperty("user_mobile") ."'";
		
		if($this->getProperty("short_code", "V"))
			$Sql .= " AND short_code='" . $this->getProperty("short_code") ."'";
		
		if($this->getProperty("sms_verification", "V"))
			$Sql .= " AND sms_verification='" . $this->getProperty("sms_verification") ."'";
		
		if($this->getProperty("login_required", "V"))
			$Sql .= " AND login_required='" . $this->getProperty("login_required") ."'";
		
		if($this->getProperty("location_id", "V"))
			$Sql .= " AND location_id='" . $this->getProperty("location_id") ."'";
		
		if($this->getProperty("user_dob_up", "V"))
			$Sql .= " AND DATE_FORMAT(user_dob, '%m-%d') >= '" . $this->getProperty("user_dob_up") ."'";

		if($this->getProperty("isNot", "V"))
			$Sql .= " AND isActive!='" . $this->getProperty("isNot") ."'";
		
		if($this->getProperty("user_type_id_array", "V"))
			$Sql .= " AND user_type_id IN (".$this->getProperty("user_type_id_array"). ")";
		
		if($this->getProperty("isActive", "V"))
			$Sql .= " AND isActive='" . $this->getProperty("isActive") . "'";
							
		if($this->isPropertySet("ORDERBY", "V"))
			$Sql .= " ORDER BY " . $this->getProperty("ORDERBY");
		
		if($this->isPropertySet("limit", "V"))
			$Sql .= $this->appendLimit($this->getProperty("limit"));
		
		return $this->dbQuery($Sql);
	}
	
	/**
	* This function is used to list the User Log
	* @author Numan Tahir
	*/
	public function lstUserLog(){
		$Sql = "SELECT 
					log_id,
					user_id,
					center_id,
					activity_detail,
					location_id,
					isActive,
					entery_date
				FROM
					rs_tbl_user_log 
				WHERE 
					1=1";
		
		if($this->getProperty("user_id", "V"))
			$Sql .= " AND user_id='" . $this->getProperty("user_id") ."'";
		
		if($this->getProperty("isActive", "V"))
			$Sql .= " AND isActive='" . $this->getProperty("isActive") ."'";
		
		if($this->getProperty("location_id", "V"))
			$Sql .= " AND location_id='" . $this->getProperty("location_id") ."'";
				
		if($this->isPropertySet("stat_date", "V"))
			$Sql .= " AND entery_date >='" . $this->getProperty("stat_date") . "'";	

		if($this->isPropertySet("end_date", "V"))
			$Sql .= " AND entery_date <='" . $this->getProperty("end_date") . "'";	
			
		if($this->isPropertySet("ORDERBY", "V"))
			$Sql .= " ORDER BY " . $this->getProperty("ORDERBY");
		
		if($this->isPropertySet("limit", "V"))
			$Sql .= $this->appendLimit($this->getProperty("limit"));
			
		return $this->dbQuery($Sql);
	}
	
	/**
	* This function is used to list the User Deivce List
	* @author Numan Tahir
	*/
	public function lstUserDeviceList(){
		$Sql = "SELECT 
					verification_id,
					device_id,
					user_id,
					center_id,
					security_code,
					mobile_status,
					verification_date,
					entery_date,
					isActive
				FROM
					rs_tbl_user_device_list
				WHERE 
					1=1";
		
		if($this->getProperty("verification_id", "V"))
			$Sql .= " AND verification_id='" . $this->getProperty("verification_id") ."'";
		
		if($this->getProperty("device_id", "V"))
			$Sql .= " AND device_id='" . $this->getProperty("device_id") ."'";
		
		if($this->getProperty("center_id", "V"))
			$Sql .= " AND center_id='" . $this->getProperty("center_id") ."'";
			
		if($this->getProperty("user_id", "V"))
			$Sql .= " AND user_id='" . $this->getProperty("user_id") ."'";
		
		if($this->getProperty("security_code", "V"))
			$Sql .= " AND security_code='" . $this->getProperty("security_code") ."'";
		
		if($this->getProperty("mobile_status", "V"))
			$Sql .= " AND mobile_status='" . $this->getProperty("mobile_status") ."'";
		
		if($this->isPropertySet("ORDERBY", "V"))
			$Sql .= " ORDER BY " . $this->getProperty("ORDERBY");
		
		if($this->isPropertySet("limit", "V"))
			$Sql .= $this->appendLimit($this->getProperty("limit"));
			
		return $this->dbQuery($Sql);
	}
	
	/**
	* This function is User Messages List
	* @author Numan Tahir
	*/
	public function lstMailbox(){
		$Sql = "SELECT 
					mail_id,
					center_id,
					sender_id,
					receiver_id,
					mail_subject,
					mail_detail,
					mail_isfile,
					is_read,
					read_date,
					sender_del,
					receiver_del,
					is_draft,
					entery_date
				FROM
					rs_tbl_mailbox
				WHERE 
					1=1";
		
		if($this->isPropertySet("mail_id", "V"))
			$Sql .= " AND mail_id=" . $this->getProperty("mail_id");
		
		if($this->isPropertySet("sender_id", "V"))
			$Sql .= " AND sender_id=" . $this->getProperty("sender_id");
		
		if($this->isPropertySet("receiver_id", "V"))
			$Sql .= " AND receiver_id=" . $this->getProperty("receiver_id");
		
		if($this->isPropertySet("mail_isfile", "V"))
			$Sql .= " AND mail_isfile=" . $this->getProperty("mail_isfile");
		
		if($this->isPropertySet("is_read", "V"))
			$Sql .= " AND is_read=" . $this->getProperty("is_read");
		
		if($this->isPropertySet("sender_del", "V"))
			$Sql .= " AND sender_del=" . $this->getProperty("sender_del");
			
		if($this->isPropertySet("receiver_del", "V"))
			$Sql .= " AND receiver_del=" . $this->getProperty("receiver_del");
		
		if($this->isPropertySet("is_draft", "V"))
			$Sql .= " AND is_draft=" . $this->getProperty("is_draft");
			
		if($this->isPropertySet("ORDERBY", "V"))
			$Sql .= " ORDER BY " . $this->getProperty("ORDERBY");
		
		if($this->isPropertySet("limit", "V"))
			$Sql .= $this->appendLimit($this->getProperty("limit"));
			
		return $this->dbQuery($Sql);
	}
	
	/**
	* This function is User Messages Files
	* @author Numan Tahir
	*/
	public function lstMailboxFiles(){
		$Sql = "SELECT 
					mail_file_id,
					mail_id,
					mail_filetype,
					mail_filename,
					isActive,
					entery_date
				FROM
					rs_tbl_mailbox_file
				WHERE 
					1=1";
		
		if($this->isPropertySet("mail_file_id", "V"))
			$Sql .= " AND mail_file_id=" . $this->getProperty("mail_file_id");
		
		if($this->isPropertySet("mail_id", "V"))
			$Sql .= " AND mail_id=" . $this->getProperty("mail_id");
		
		if($this->isPropertySet("mail_filetype", "V"))
			$Sql .= " AND mail_filetype='" . $this->getProperty("mail_filetype") . "'";
		
		if($this->isPropertySet("isActive", "V"))
			$Sql .= " AND isActive='" . $this->getProperty("isActive") . "'";
		
		if($this->isPropertySet("ORDERBY", "V"))
			$Sql .= " ORDER BY " . $this->getProperty("ORDERBY");
		
		if($this->isPropertySet("limit", "V"))
			$Sql .= $this->appendLimit($this->getProperty("limit"));
			
		return $this->dbQuery($Sql);
	}
	
	/**
	* This function is Customer Messages file type 
	* @author Numan Tahir
	*/
	public function lstMailboxFileType(){
		$Sql = "SELECT 
					filetype_id,
					user_id,
					type_name,
					type_icon,
					isActive,
					entery_date
				FROM
					rs_tbl_mailbox_file_type
				WHERE 
					1=1";
		
		if($this->isPropertySet("filetype_id", "V"))
			$Sql .= " AND filetype_id=" . $this->getProperty("filetype_id");
		
		if($this->isPropertySet("user_id", "V"))
			$Sql .= " AND user_id=" . $this->getProperty("user_id");
		
		if($this->isPropertySet("isActive", "V"))
			$Sql .= " AND isActive='" . $this->getProperty("isActive") . "'";
		
		if($this->isPropertySet("ORDERBY", "V"))
			$Sql .= " ORDER BY " . $this->getProperty("ORDERBY");
		
		if($this->isPropertySet("limit", "V"))
			$Sql .= $this->appendLimit($this->getProperty("limit"));

		return $this->dbQuery($Sql);
	}
	
	/**
	* This function is used to check the email address already exists or not.
	* @author Numan Tahir
	*/
	public function emailExists(){
		$Sql = "SELECT 
					user_id,
					user_email
				FROM
					rs_tbl_users
				WHERE 
					1=1";
		if($this->isPropertySet("user_email", "V"))
			$Sql .= " AND user_email='" . $this->getProperty("user_email") . "'";
			
		if($this->isPropertySet("user_type_id", "V"))
			$Sql .= " AND user_type_id=" . $this->getProperty("user_type_id");
			
		if($this->isPropertySet("user_id", "V"))
			$Sql .= " AND user_id!=" . $this->getProperty("user_id");
		
		return $this->dbQuery($Sql);
	}
	
	/**
	* This function is used to check the mobile number already exists or not.
	* @author Numan Tahir
	*/
	public function MobileExists(){
		$Sql = "SELECT 
					user_id,
					user_mobile
				FROM
					rs_tbl_users
				WHERE 
					1=1";
		if($this->isPropertySet("user_mobile", "V"))
			$Sql .= " AND user_mobile='" . $this->getProperty("user_mobile") . "'";
			
		if($this->isPropertySet("user_type_id", "V"))
			$Sql .= " AND user_type_id=" . $this->getProperty("user_type_id");
			
		if($this->isPropertySet("user_id", "V"))
			$Sql .= " AND user_id!=" . $this->getProperty("user_id");
		
		return $this->dbQuery($Sql);
	}
	
	/**
	* This function is used to check current password in change password
	* @author Numan Tahir
	*/
	public function checkPassword(){
		$Sql = "SELECT
					user_id
				FROM
					rs_tbl_users 
				WHERE 
					1=1";
		$Sql .= " AND user_id='" . $this->getProperty("user_id") . "'";
		
		$Sql .= " AND user_pass='" . $this->getProperty("user_pass") . "'";
		
		$this->dbQuery($Sql);
		if($this->totalRecords() >= 1)
			return true;
		else
			return false;
	}
	
	/**
	* This function is user for Companies
	* @author Numan Tahir
	*/
	public function lstCenters(){
		$Sql = "SELECT 
					center_id,
					center_name,
					center_phone,
					center_address,
					center_emergency_contact,
					entery_date,
					isActive
				FROM
					rs_tbl_center_detail
				WHERE 
					1=1";
		
		if($this->isPropertySet("center_id", "V"))
			$Sql .= " AND center_id=" . $this->getProperty("center_id");
		
		if($this->isPropertySet("isActive", "V"))
			$Sql .= " AND isActive=" . $this->getProperty("isActive");
		
		if($this->isPropertySet("ORDERBY", "V"))
			$Sql .= " ORDER BY " . $this->getProperty("ORDERBY");
		
		if($this->isPropertySet("limit", "V"))
			$Sql .= $this->appendLimit($this->getProperty("limit"));

		return $this->dbQuery($Sql);
	}
	
	/**
	* This function is user for Departments
	* @author Numan Tahir
	*/
	public function lstDepartments(){
		$Sql = "SELECT
					dp.department_id,
					dp.user_id,
					dp.center_id,
					dp.department_name,
					dp.isActive,
					cp.company_name
				FROM
					rs_tbl_department as dp
					INNER JOIN rs_tbl_center_detail cp
						ON (dp.center_id = cp.center_id)
				WHERE 
					1=1";
		
		if($this->isPropertySet("department_id", "V"))
			$Sql .= " AND dp.department_id=" . $this->getProperty("department_id");
		
		if($this->isPropertySet("center_id", "V"))
			$Sql .= " AND dp.center_id=" . $this->getProperty("center_id");
			
		if($this->isPropertySet("user_id", "V"))
			$Sql .= " AND dp.user_id=" . $this->getProperty("user_id");
		
		if($this->isPropertySet("isActive", "V"))
			$Sql .= " AND dp.isActive=" . $this->getProperty("isActive");
		
		if($this->isPropertySet("ORDERBY", "V"))
			$Sql .= " ORDER BY " . $this->getProperty("ORDERBY");
		
		if($this->isPropertySet("limit", "V"))
			$Sql .= $this->appendLimit($this->getProperty("limit"));

		return $this->dbQuery($Sql);
	}
	
	/**
	* This function is user for Job Title
	* @author Numan Tahir
	*/
	public function lstJobTitle(){
		$Sql = "SELECT 
					job_title_id,
					center_id,
					user_id,
					job_title,
					entery_date,
					isActive
				FROM
					rs_tbl_job_title
				WHERE 
					1=1";
		
		if($this->isPropertySet("job_title_id", "V"))
			$Sql .= " AND job_title_id=" . $this->getProperty("job_title_id");
		
		if($this->isPropertySet("center_id", "V"))
			$Sql .= " AND center_id=" . $this->getProperty("center_id");
			
		if($this->isPropertySet("user_id", "V"))
			$Sql .= " AND user_id=" . $this->getProperty("user_id");
		
		if($this->isPropertySet("isActive", "V"))
			$Sql .= " AND isActive=" . $this->getProperty("isActive");
		
		if($this->isPropertySet("ORDERBY", "V"))
			$Sql .= " ORDER BY " . $this->getProperty("ORDERBY");
		
		if($this->isPropertySet("limit", "V"))
			$Sql .= $this->appendLimit($this->getProperty("limit"));

		return $this->dbQuery($Sql);
	}
	
	/**
	* This function is user for Shifts
	* @author Numan Tahir
	*/
	public function lstShifts(){
		$Sql = "SELECT 
					shift_id,
					user_id,
					center_id,
					shift_name,
					shift_st,
					shift_et,
					shift_date,
					entery_date,
					isActive
				FROM
					rs_tbl_shifts
				WHERE 
					1=1";
		
		if($this->isPropertySet("shift_id", "V"))
			$Sql .= " AND shift_id=" . $this->getProperty("shift_id");
		
		if($this->isPropertySet("user_id", "V"))
			$Sql .= " AND user_id=" . $this->getProperty("user_id");
		
		if($this->isPropertySet("isActive", "V"))
			$Sql .= " AND isActive=" . $this->getProperty("isActive");
		
		if($this->isPropertySet("ORDERBY", "V"))
			$Sql .= " ORDER BY " . $this->getProperty("ORDERBY");
		
		if($this->isPropertySet("limit", "V"))
			$Sql .= $this->appendLimit($this->getProperty("limit"));

		return $this->dbQuery($Sql);
	}
	
	/**
	* This function is user for User Emergency Contact Detail
	* @author Numan Tahir
	*/
	public function lstUserEmergency(){
		$Sql = "SELECT 
					user_emergency_id,
					user_id,
					center_id,
					person_name,
					contact_number,
					isActive
				FROM
					rs_tbl_user_emergency
				WHERE 
					1=1";
		
		if($this->isPropertySet("user_emergency_id", "V"))
			$Sql .= " AND user_emergency_id=" . $this->getProperty("user_emergency_id");
		
		if($this->isPropertySet("user_id", "V"))
			$Sql .= " AND user_id=" . $this->getProperty("user_id");
		
		if($this->isPropertySet("center_id", "V"))
			$Sql .= " AND center_id=" . $this->getProperty("center_id");
			
		if($this->isPropertySet("isActive", "V"))
			$Sql .= " AND isActive=" . $this->getProperty("isActive");
			
		if($this->isPropertySet("ORDERBY", "V"))
			$Sql .= " ORDER BY " . $this->getProperty("ORDERBY");
		
		if($this->isPropertySet("limit", "V"))
			$Sql .= $this->appendLimit($this->getProperty("limit"));

		return $this->dbQuery($Sql);
	}
	
	/**
	* This function is user for User Emloyment History
	* @author Numan Tahir
	*/
	public function lstUserEmploymentHistory(){
		$Sql = "SELECT 
					user_employment_id,
					user_id,
					center_id,
					company_name,
					job_title,
					from_date,
					end_date,
					isActive
				FROM
					rs_tbl_user_employment
				WHERE 
					1=1";
		
		if($this->isPropertySet("user_employment_id", "V"))
			$Sql .= " AND user_employment_id=" . $this->getProperty("user_employment_id");
		
		if($this->isPropertySet("user_id", "V"))
			$Sql .= " AND user_id=" . $this->getProperty("user_id");
		
		if($this->isPropertySet("isActive", "V"))
			$Sql .= " AND isActive=" . $this->getProperty("isActive");
			
		if($this->isPropertySet("ORDERBY", "V"))
			$Sql .= " ORDER BY " . $this->getProperty("ORDERBY");
		
		if($this->isPropertySet("limit", "V"))
			$Sql .= $this->appendLimit($this->getProperty("limit"));

		return $this->dbQuery($Sql);
	}
	
	/**
	* This function is user for User Job Detail
	* @author Numan Tahir
	*/
	public function lstUserJobDetail(){
		$Sql = "SELECT 
					user_job_detail_id,
					user_id,
					center_id,
					job_title_id,
					job_description,
					company_id,
					department_id,
					joined_date,
					service_end_date,
					job_type,
					probation_period_end_date,
					probation_period_status
				FROM
					rs_tbl_user_job_detail
				WHERE 
					1=1";
		
		if($this->isPropertySet("user_job_detail_id", "V"))
			$Sql .= " AND user_job_detail_id=" . $this->getProperty("user_job_detail_id");
		
		if($this->isPropertySet("user_id", "V"))
			$Sql .= " AND user_id=" . $this->getProperty("user_id");
		
		if($this->isPropertySet("job_title_id", "V"))
			$Sql .= " AND job_title_id=" . $this->getProperty("job_title_id");
		
		if($this->isPropertySet("company_id", "V"))
			$Sql .= " AND company_id=" . $this->getProperty("company_id");
			
		if($this->isPropertySet("department_id", "V"))
			$Sql .= " AND department_id=" . $this->getProperty("department_id");
		
		if($this->isPropertySet("job_type", "V"))
			$Sql .= " AND job_type=" . $this->getProperty("job_type");
		
		if($this->isPropertySet("probation_period_end_date", "V"))
			$Sql .= " AND probation_period_end_date='" . $this->getProperty("probation_period_end_date") . "'";
		
		if($this->isPropertySet("probation_period_status", "V"))
			$Sql .= " AND probation_period_status='" . $this->getProperty("probation_period_status") . "'";
					
		if($this->isPropertySet("ORDERBY", "V"))
			$Sql .= " ORDER BY " . $this->getProperty("ORDERBY");
		
		if($this->isPropertySet("limit", "V"))
			$Sql .= $this->appendLimit($this->getProperty("limit"));

		return $this->dbQuery($Sql);
	}
	
	/**
	* This function is user for User Reference Detail
	* @author Numan Tahir
	*/
	public function lstUserReference(){
		$Sql = "SELECT 
					user_reference_id,
					user_id,
					center_id,
					person_name,
					contact_no,
					company_name,
					isActive
				FROM
					rs_tbl_user_reference
				WHERE 
					1=1";
		
		if($this->isPropertySet("user_reference_id", "V"))
			$Sql .= " AND user_reference_id=" . $this->getProperty("user_reference_id");
		
		if($this->isPropertySet("user_id", "V"))
			$Sql .= " AND user_id=" . $this->getProperty("user_id");
		
		if($this->isPropertySet("isActive", "V"))
			$Sql .= " AND isActive=" . $this->getProperty("isActive");
			
		if($this->isPropertySet("ORDERBY", "V"))
			$Sql .= " ORDER BY " . $this->getProperty("ORDERBY");
		
		if($this->isPropertySet("limit", "V"))
			$Sql .= $this->appendLimit($this->getProperty("limit"));

		return $this->dbQuery($Sql);
	}
	
	/**
	* This function is user for User Education Detail
	* @author Numan Tahir
	*/
	public function lstUserEducationDetail(){
		$Sql = "SELECT 
					user_education_id,
					user_id,
					center_id,
					institute_name,
					major,
					start_date,
					end_date,
					document_file_name,
					document_file,
					other_note,
					isAcitve
				FROM
					rs_tbl_user_education
				WHERE 
					1=1";
		
		if($this->isPropertySet("user_education_id", "V"))
			$Sql .= " AND user_education_id=" . $this->getProperty("user_education_id");
		
		if($this->isPropertySet("user_id", "V"))
			$Sql .= " AND user_id=" . $this->getProperty("user_id");

		if($this->isPropertySet("isActive", "V"))
			$Sql .= " AND isActive=" . $this->getProperty("isActive");
		
		if($this->isPropertySet("ORDERBY", "V"))
			$Sql .= " ORDER BY " . $this->getProperty("ORDERBY");
		
		if($this->isPropertySet("limit", "V"))
			$Sql .= $this->appendLimit($this->getProperty("limit"));

		return $this->dbQuery($Sql);
	}
	
	/**
	* This function is User Bank Account Detail
	* @author Numan Tahir
	*/
	public function lstUserBankAccountDetail(){
		$Sql = "SELECT 
						employee_bank_id,
						user_id,
						center_id,
						bank_id,
						account_no,
						account_title,
						entery_date,
						isActive
					FROM
						rs_tbl_user_bank_account_detail
					WHERE 
						1=1";
		
		if($this->isPropertySet("employee_bank_id", "V"))
			$Sql .= " AND employee_bank_id=" . $this->getProperty("employee_bank_id");
		
		if($this->isPropertySet("user_id", "V"))
			$Sql .= " AND user_id=" . $this->getProperty("user_id");
		
		if($this->isPropertySet("center_id", "V"))
			$Sql .= " AND center_id=" . $this->getProperty("center_id");
			
		if($this->isPropertySet("bank_id", "V"))
			$Sql .= " AND bank_id='" . $this->getProperty("bank_id") . "'";
		
		if($this->isPropertySet("isActive", "V"))
			$Sql .= " AND isActive='" . $this->getProperty("isActive") . "'";
			
		if($this->isPropertySet("ORDERBY", "V"))
			$Sql .= " ORDER BY " . $this->getProperty("ORDERBY");
		
		if($this->isPropertySet("GROUPBY", "V"))
			$Sql .= " GROUP BY " . $this->getProperty("GROUPBY");
			
		if($this->isPropertySet("limit", "V"))
			$Sql .= $this->appendLimit($this->getProperty("limit"));

		return $this->dbQuery($Sql);
	}
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	/*******************************************************************************************************/
	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	/*******************************************************************************************************/
	/////////////////////////////////////////////////////////////////////////////////////////////////////////


	/**
	* This function is User to perform DML (Delete/Update/Add)
	* @author Numan Tahir
	*/
	public function actUser($mode = "I"){
		$mode = strtoupper($mode);
		switch($mode){
			case "I":
				$Sql = "INSERT INTO rs_tbl_users(
						user_id,
						center_id,
						enter_user_id,
						device_uid,
						user_email,
						user_mobile,
						user_pass,
						user_fname,
						user_lname,
						user_address,
						user_phone,
						user_cnic,
						user_type_id,
						user_designation,
						user_signature,
						user_profile_img,
						sms_verification,
						short_code,
						location_id,
						login_required,
						isActive,
						reg_date,
						user_code,
						user_gender,
						user_dob,
						user_marital_status,
						blood_group,
						cnic_front_side,
						cnic_back_side,
						user_cv,
						teamlead_status) 
						VALUES(";
				$Sql .= $this->isPropertySet("user_id", "V") ? $this->getProperty("user_id") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("center_id", "V") ? $this->getProperty("center_id") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("enter_user_id", "V") ? $this->getProperty("enter_user_id") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("user_email", "V") ? "'" . $this->getProperty("user_email") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("user_mobile", "V") ? "'" . $this->getProperty("user_mobile") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("user_pass", "V") ? "'" . $this->getProperty("user_pass") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("user_fname", "V") ? "'" . $this->getProperty("user_fname") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("user_lname", "V") ? "'" . $this->getProperty("user_lname") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("user_address", "V") ? "'" . $this->getProperty("user_address") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("user_phone", "V") ? "'" . $this->getProperty("user_phone") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("user_cnic", "V") ? "'" . $this->getProperty("user_cnic") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("user_type_id", "V") ? "'" . $this->getProperty("user_type_id") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("user_designation", "V") ? "'" . $this->getProperty("user_designation") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("user_signature", "V") ? "'" . $this->getProperty("user_signature") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("user_profile_img", "V") ? "'" . $this->getProperty("user_profile_img") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("sms_verification", "V") ? "'" . $this->getProperty("sms_verification") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("short_code", "V") ? "'" . $this->getProperty("short_code") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("location_id", "V") ? "'" . $this->getProperty("location_id") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("login_required", "V") ? "'" . $this->getProperty("login_required") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("isActive", "V") ? "'" . $this->getProperty("isActive") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("reg_date", "V") ? "'" . $this->getProperty("reg_date") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("user_code", "V") ? "'" . $this->getProperty("user_code") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("user_gender", "V") ? "'" . $this->getProperty("user_gender") . "'" : "1";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("user_dob", "V") ? "'" . $this->getProperty("user_dob") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("user_marital_status", "V") ? "'" . $this->getProperty("user_marital_status") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("blood_group", "V") ? "'" . $this->getProperty("blood_group") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("cnic_front_side", "V") ? "'" . $this->getProperty("cnic_front_side") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("cnic_back_side", "V") ? "'" . $this->getProperty("cnic_back_side") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("user_cv", "V") ? "'" . $this->getProperty("user_cv") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("teamlead_status", "V") ? "'" . $this->getProperty("teamlead_status") . "'" : "1";
				$Sql .= ")";
				break;
			case "U":
				$Sql = "UPDATE rs_tbl_users SET ";
				if($this->isPropertySet("user_email", "K")){
					$Sql .= "$con user_email='" . $this->getProperty("user_email") . "'";
					$con = ",";
				}
				if($this->isPropertySet("user_pass", "K")){
					$Sql .= "$con user_pass='" . $this->getProperty("user_pass") . "'";
					$con = ",";
				}
				if($this->isPropertySet("user_fname", "K")){
					$Sql .= "$con user_fname='" . $this->getProperty("user_fname") . "'";
					$con = ",";
				}
				if($this->isPropertySet("user_lname", "K")){
					$Sql .= "$con user_lname='" . $this->getProperty("user_lname") . "'";
					$con = ",";
				}
				if($this->isPropertySet("user_address", "K")){
					$Sql .= "$con user_address='" . $this->getProperty("user_address") . "'";
					$con = ",";
				}
				if($this->isPropertySet("user_phone", "K")){
					$Sql .= "$con user_phone='" . $this->getProperty("user_phone") . "'";
					$con = ",";
				}
				if($this->isPropertySet("usre_idcard_no", "K")){
					$Sql .= "$con usre_idcard_no='" . $this->getProperty("usre_idcard_no") . "'";
					$con = ",";
				}
				if($this->isPropertySet("user_type_id", "K")){
					$Sql .= "$con user_type_id='" . $this->getProperty("user_type_id") . "'";
					$con = ",";
				}
				if($this->isPropertySet("user_designation", "K")){
					$Sql .= "$con user_designation='" . $this->getProperty("user_designation") . "'";
					$con = ",";
				}
				if($this->isPropertySet("user_signature", "K")){
					$Sql .= "$con user_signature='" . $this->getProperty("user_signature") . "'";
					$con = ",";
				}
				if($this->isPropertySet("user_profile_img", "K")){
					$Sql .= "$con user_profile_img='" . $this->getProperty("user_profile_img") . "'";
					$con = ",";
				}
				if($this->isPropertySet("sms_verification", "K")){
					$Sql .= "$con sms_verification='" . $this->getProperty("sms_verification") . "'";
					$con = ",";
				}
				if($this->isPropertySet("short_code", "K")){
					$Sql .= "$con short_code='" . $this->getProperty("short_code") . "'";
					$con = ",";
				}
				if($this->isPropertySet("location_id", "K")){
					$Sql .= "$con location_id='" . $this->getProperty("location_id") . "'";
					$con = ",";
				}
				if($this->isPropertySet("login_required", "K")){
					$Sql .= "$con login_required='" . $this->getProperty("login_required") . "'";
					$con = ",";
				}
				if($this->isPropertySet("isActive", "K")){
					$Sql .= "$con isActive=" . $this->getProperty("isActive");
					$con = ",";
				}
				if($this->isPropertySet("user_code", "K")){
					$Sql .= "$con user_code='" . $this->getProperty("user_code") . "'";
					$con = ",";
				}
				if($this->isPropertySet("user_gender", "K")){
					$Sql .= "$con user_gender='" . $this->getProperty("user_gender") . "'";
					$con = ",";
				}
				if($this->isPropertySet("user_dob", "K")){
					$Sql .= "$con user_dob='" . $this->getProperty("user_dob") . "'";
					$con = ",";
				}
				if($this->isPropertySet("user_marital_status", "K")){
					$Sql .= "$con user_marital_status='" . $this->getProperty("user_marital_status") . "'";
					$con = ",";
				}
				
				$Sql .= " WHERE 1=1";
				
				if($this->isPropertySet("user_mobile", "V"))
					$Sql .= " AND user_mobile='" . $this->getProperty("user_mobile") . "'";
				else
					$Sql .= " AND user_id=" . $this->getProperty("user_id");
				break;

			/** ** ** Inactive User ** ** **/
			case "IAU":
				$Sql = "UPDATE rs_tbl_users SET 
							isActive=2
						WHERE
							1=1";
				$Sql .= " AND user_id=" . $this->getProperty("user_id");
				break;
			/** ** ** Active User ** ** **/
			case "AU":
				$Sql = "UPDATE rs_tbl_users SET 
							isActive=1
						WHERE
							1=1";
				$Sql .= " AND user_id=" . $this->getProperty("user_id");
				break;
			/** ** ** Delete User ** ** **/
			case "DEL":
				$Sql = "UPDATE rs_tbl_users SET 
							isActive=3
						WHERE
							1=1";
				$Sql .= " AND user_id=" . $this->getProperty("user_id");
				break;
			default:
				break;
		}
		
		return $this->dbQuery($Sql);
	}
	
	
	/**
	* This function is User Log (Delete/Update/Add)
	* @author Numan Tahir
	*/
	public function actUserLog($mode = "I"){
		$mode = strtoupper($mode);
		switch($mode){
			case "I":
				$Sql = "INSERT INTO rs_tbl_user_log(
						user_id,
						center_id,
						activity_detail,
						isActive,
						entery_date,
						location_id) 
						VALUES(";
				$Sql .= $this->isPropertySet("user_id", "V") ? $this->getProperty("user_id") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("center_id", "V") ? $this->getProperty("center_id") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("activity_detail", "V") ? "'" . $this->getProperty("activity_detail") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("isActive", "V") ? "'" . $this->getProperty("isActive") . "'" : "1";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("entery_date", "V") ? "'" . $this->getProperty("entery_date") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("location_id", "V") ? "'" . $this->getProperty("location_id") . "'" : "NULL";
				$Sql .= ")";
				break;
			/** ** ** InActive User Activities ** ** **/
			case "AU":
				$Sql = "UPDATE rs_tbl_user_log SET 
							isActive=2
						WHERE
							1=1";
				$Sql .= " AND user_id=" . $this->getProperty("user_id");
				break;
			/** ** ** Delete User Activities ** ** **/
			case "DEL":
				$Sql = "UPDATE rs_tbl_user_log SET 
							isActive=3
						WHERE
							1=1";
				$Sql .= " AND user_id=" . $this->getProperty("user_id");
				break;
			default:
				break;
		}
		
		return $this->dbQuery($Sql);
	}
	
	/**
	* This function is User MailBox (Delete/Update/Add)
	* @author Numan Tahir
	*/
	public function actMailBox($mode = "I"){
		$mode = strtoupper($mode);
		switch($mode){
			case "I":
				$Sql = "INSERT INTO rs_tbl_mailbox(
						mail_id,
						center_id,
						sender_id,
						receiver_id,
						mail_subject,
						mail_detail,
						mail_isfile,
						is_read,
						read_date,
						sender_del,
						receiver_del,
						is_draft,
						entery_date) 
						VALUES(";
				$Sql .= $this->isPropertySet("mail_id", "V") ? $this->getProperty("mail_id") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("center_id", "V") ? $this->getProperty("center_id") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("sender_id", "V") ? $this->getProperty("sender_id") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("receiver_id", "V") ? $this->getProperty("receiver_id") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("mail_subject", "V") ? "'" . $this->getProperty("mail_subject") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("mail_detail", "V") ? "'" . $this->getProperty("mail_detail") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("mail_isfile", "V") ? $this->getProperty("mail_isfile") : "2";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("is_read", "V") ? $this->getProperty("is_read") : "2";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("read_date", "V") ? "'" . $this->getProperty("read_date") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("sender_del", "V") ? $this->getProperty("sender_del") : "2";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("receiver_del", "V") ? $this->getProperty("receiver_del") : "2";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("is_draft", "V") ? $this->getProperty("is_draft") : "2";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("entery_date", "V") ? "'" . $this->getProperty("entery_date") . "'" : "NULL";
				$Sql .= ")";
				break;
			case "U":
				$Sql = "UPDATE rs_tbl_mailbox SET ";
				
				if($this->isPropertySet("is_read", "K")){
					$Sql .= "$con is_read='" . $this->getProperty("is_read") . "'";
					$con = ",";
				}
				if($this->isPropertySet("read_date", "K")){
					$Sql .= "$con read_date='" . $this->getProperty("read_date") . "'";
					$con = ",";
				}
				if($this->isPropertySet("sender_del", "K")){
					$Sql .= "$con sender_del=" . $this->getProperty("sender_del");
					$con = ",";
				}
				if($this->isPropertySet("receiver_del", "K")){
					$Sql .= "$con receiver_del=" . $this->getProperty("receiver_del");
					$con = ",";
				}
				if($this->isPropertySet("is_draft", "K")){
					$Sql .= "$con is_draft=" . $this->getProperty("is_draft");
					$con = ",";
				}
				$Sql .= " WHERE 1=1";
				
				if($this->isPropertySet("mail_id", "V"))
					$Sql .= " AND mail_id=" . $this->getProperty("mail_id");
				
				break;
			default:
				break;
		}
		
		return $this->dbQuery($Sql);
	}
	
	/**
	* This function is User Mailbox Files (Delete/Update/Add)
	* @author Numan Tahir
	*/
	public function actMailBoxFile($mode = "I"){
		$mode = strtoupper($mode);
		switch($mode){
			case "I":
				$Sql = "INSERT INTO rs_tbl_mailbox_file(
						mail_file_id,
						mail_id,
						mail_filetype,
						mail_filename,
						isActive,
						entery_date) 
						VALUES(";
				$Sql .= $this->isPropertySet("mail_file_id", "V") ? $this->getProperty("mail_file_id") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("mail_id", "V") ? $this->getProperty("mail_id") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("mail_filetype", "V") ? $this->getProperty("mail_filetype") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("mail_filename", "V") ? "'" . $this->getProperty("mail_filename") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("isActive", "V") ? "'" . $this->getProperty("isActive") . "'" : "1";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("entery_date", "V") ? "'" . $this->getProperty("entery_date") . "'" : "NULL";
				$Sql .= ")";
				break;
			case "U":
				$Sql = "UPDATE rs_tbl_mailbox_file SET ";
				
				if($this->isPropertySet("isActive", "K")){
					$Sql .= "$con isActive=" . $this->getProperty("isActive");
					$con = ",";
				}
				
				$Sql .= " WHERE 1=1";
				
				if($this->isPropertySet("mail_id", "V"))
					$Sql .= " AND mail_id=" . $this->getProperty("mail_id");
				
				if($this->isPropertySet("mail_file_id", "V"))
					$Sql .= " AND mail_file_id=" . $this->getProperty("mail_file_id");
					
				break;
			default:
				break;
		}
		
		return $this->dbQuery($Sql);
	}
	
	/**
	* This function is User Mailbox File Type (Delete/Update/Add)
	* @author Numan Tahir
	*/
	public function actMailBoxFileType($mode = "I"){
		$mode = strtoupper($mode);
		switch($mode){
			case "I":
				$Sql = "INSERT INTO rs_tbl_mailbox_file_type(
						filetype_id,
						user_id,
						type_name,
						type_icon,
						isActive,
						entery_date)
						VALUES(";
				$Sql .= $this->isPropertySet("filetype_id", "V") ? $this->getProperty("filetype_id") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("user_id", "V") ? $this->getProperty("user_id") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("type_name", "V") ? "'" . $this->getProperty("type_name") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("type_icon", "V") ? "'" . $this->getProperty("type_icon") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("isActive", "V") ? $this->getProperty("isActive") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("entery_date", "V") ? "'" . $this->getProperty("entery_date") . "'" : "NULL";
				$Sql .= ")";
				break;
			case "U":
				$Sql = "UPDATE rs_tbl_mailbox_file_type SET ";
				
				if($this->isPropertySet("type_name", "K")){
					$Sql .= "$con type_name='" . $this->getProperty("type_name") . "'";
					$con = ",";
				}
				if($this->isPropertySet("type_icon", "K")){
					$Sql .= "$con type_icon='" . $this->getProperty("type_icon") . "'";
					$con = ",";
				}
				if($this->isPropertySet("isActive", "K")){
					$Sql .= "$con isActive='" . $this->getProperty("isActive") . "'";
					$con = ",";
				}
					
				$Sql .= " WHERE 1=1";
				
				if($this->isPropertySet("filetype_id", "V"))
					$Sql .= " AND filetype_id=" . $this->getProperty("filetype_id");
					
				break;
			case "D":
				break;
			default:
				break;
		}
		
		return $this->dbQuery($Sql);
	}
	
	
	/**
	* This function is Companies (Delete/Update/Add)
	* @author Numan Tahir
	*/
	public function actCompanies($mode = "I"){
		$mode = strtoupper($mode);
		switch($mode){
			case "I":
				$Sql = "INSERT INTO rs_tbl_center_detail(
						center_id,
						center_name,
						center_phone,
						center_address,
						center_emergency_contact,
						entery_date,
						isActive)
						VALUES(";
				$Sql .= $this->isPropertySet("center_id", "V") ? $this->getProperty("center_id") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("center_name", "V") ? "'" . $this->getProperty("center_name") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("center_phone", "V") ? "'" . $this->getProperty("center_phone") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("center_address", "V") ? "'" . $this->getProperty("center_address") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("center_emergency_contact", "V") ? "'" . $this->getProperty("center_emergency_contact") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("entery_date", "V") ? "'" . $this->getProperty("entery_date") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("isActive", "V") ? "'" . $this->getProperty("isActive") . "'" : "1";
				$Sql .= ")";
				break;
			case "U":
				$Sql = "UPDATE rs_tbl_center_detail SET ";
				
				if($this->isPropertySet("center_name", "K")){
					$Sql .= "$con center_name='" . $this->getProperty("center_name") . "'";
					$con = ",";
				}
				if($this->isPropertySet("center_phone", "K")){
					$Sql .= "$con center_phone='" . $this->getProperty("center_phone") . "'";
					$con = ",";
				}
				if($this->isPropertySet("center_address", "K")){
					$Sql .= "$con center_address='" . $this->getProperty("center_address") . "'";
					$con = ",";
				}
				if($this->isPropertySet("center_emergency_contact", "K")){
					$Sql .= "$con center_emergency_contact='" . $this->getProperty("center_emergency_contact") . "'";
					$con = ",";
				}
				if($this->isPropertySet("isActive", "K")){
					$Sql .= "$con isActive='" . $this->getProperty("isActive") . "'";
					$con = ",";
				}
					
				$Sql .= " WHERE 1=1";
				
				if($this->isPropertySet("center_id", "V"))
					$Sql .= " AND center_id=" . $this->getProperty("center_id");
					
				break;
			case "DEL":
				$Sql = "UPDATE rs_tbl_center_detail SET 
							isActive=3
						WHERE
							1=1";
				$Sql .= " AND center_id=" . $this->getProperty("center_id");
				break;
			default:
				break;
		}
		
		return $this->dbQuery($Sql);
	}
	
	/**
	* This function is Departments (Delete/Update/Add)
	* @author Numan Tahir
	*/
	public function actDepartments($mode = "I"){
		$mode = strtoupper($mode);
		switch($mode){
			case "I":
				$Sql = "INSERT INTO rs_tbl_department(
						department_id,
						user_id,
						center_id,
						department_name,
						entery_date,
						isActive)
						VALUES(";
				$Sql .= $this->isPropertySet("department_id", "V") ? $this->getProperty("department_id") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("user_id", "V") ? $this->getProperty("user_id") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("center_id", "V") ? $this->getProperty("center_id") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("department_name", "V") ? "'" . $this->getProperty("department_name") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("entery_date", "V") ? "'" . $this->getProperty("entery_date") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("isActive", "V") ? "'" . $this->getProperty("isActive") . "'" : "1";
				$Sql .= ")";
				break;
			case "U":
				$Sql = "UPDATE rs_tbl_department SET ";
				
				if($this->isPropertySet("department_name", "K")){
					$Sql .= "$con department_name='" . $this->getProperty("department_name") . "'";
					$con = ",";
				}
				if($this->isPropertySet("company_id", "K")){
					$Sql .= "$con company_id='" . $this->getProperty("company_id") . "'";
					$con = ",";
				}
				if($this->isPropertySet("isActive", "K")){
					$Sql .= "$con isActive='" . $this->getProperty("isActive") . "'";
					$con = ",";
				}
					
				$Sql .= " WHERE 1=1";
				
				if($this->isPropertySet("department_id", "V"))
					$Sql .= " AND department_id=" . $this->getProperty("department_id");
					
				break;
			case "DEL":
				$Sql = "UPDATE rs_tbl_department SET 
							isActive=3
						WHERE
							1=1";
				$Sql .= " AND department_id=" . $this->getProperty("department_id");
				break;
			default:
				break;
		}
		
		return $this->dbQuery($Sql);
	}
	
	/**
	* This function is Job Title (Delete/Update/Add)
	* @author Numan Tahir
	*/
	public function actJobTitle($mode = "I"){
		$mode = strtoupper($mode);
		switch($mode){
			case "I":
				$Sql = "INSERT INTO rs_tbl_job_title(
						job_title_id,
						user_id,
						center_id,
						job_title,
						entery_date,
						isActive)
						VALUES(";
				$Sql .= $this->isPropertySet("job_title_id", "V") ? $this->getProperty("job_title_id") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("user_id", "V") ? $this->getProperty("user_id") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("center_id", "V") ? $this->getProperty("center_id") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("job_title", "V") ? "'" . $this->getProperty("job_title") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("entery_date", "V") ? "'" . $this->getProperty("entery_date") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("isActive", "V") ? "'" . $this->getProperty("isActive") . "'" : "1";
				$Sql .= ")";
				break;
			case "U":
				$Sql = "UPDATE rs_tbl_job_title SET ";
				
				if($this->isPropertySet("job_title", "K")){
					$Sql .= "$con job_title='" . $this->getProperty("job_title") . "'";
					$con = ",";
				}
				if($this->isPropertySet("isActive", "K")){
					$Sql .= "$con isActive='" . $this->getProperty("isActive") . "'";
					$con = ",";
				}
					
				$Sql .= " WHERE 1=1";
				
				if($this->isPropertySet("job_title_id", "V"))
					$Sql .= " AND job_title_id=" . $this->getProperty("job_title_id");
					
				break;
			case "DEL":
				$Sql = "UPDATE rs_tbl_job_title SET 
							isActive=3
						WHERE
							1=1";
				$Sql .= " AND job_title_id=" . $this->getProperty("job_title_id");
				break;
			default:
				break;
		}
		
		return $this->dbQuery($Sql);
	}
	
	/**
	* This function is Shifts (Delete/Update/Add)
	* @author Numan Tahir
	*/
	public function actShifts($mode = "I"){
		$mode = strtoupper($mode);
		switch($mode){
			case "I":
				$Sql = "INSERT INTO rs_tbl_shifts(
						shift_id,
						user_id,
						center_id,
						shift_name,
						shift_st,
						shift_et,
						shift_date,
						entery_date,
						isActive)
						VALUES(";
				$Sql .= $this->isPropertySet("shift_id", "V") ? $this->getProperty("shift_id") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("user_id", "V") ? $this->getProperty("user_id") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("shift_name", "V") ? "'" . $this->getProperty("shift_name") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("shift_st", "V") ? "'" . $this->getProperty("shift_st") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("shift_et", "V") ? "'" . $this->getProperty("shift_et") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("shift_date", "V") ? "'" . $this->getProperty("shift_date") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("entery_date", "V") ? "'" . $this->getProperty("entery_date") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("isActive", "V") ? "'" . $this->getProperty("isActive") . "'" : "1";
				$Sql .= ")";
				break;
			case "U":
				$Sql = "UPDATE rs_tbl_shifts SET ";
				
				if($this->isPropertySet("shift_name", "K")){
					$Sql .= "$con shift_name='" . $this->getProperty("shift_name") . "'";
					$con = ",";
				}
				if($this->isPropertySet("job_title", "K")){
					$Sql .= "$con job_title='" . $this->getProperty("job_title") . "'";
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
								
				if($this->isPropertySet("isActive", "K")){
					$Sql .= "$con isActive='" . $this->getProperty("isActive") . "'";
					$con = ",";
				}
					
				$Sql .= " WHERE 1=1";
				
				if($this->isPropertySet("shift_id", "V"))
					$Sql .= " AND shift_id=" . $this->getProperty("shift_id");
					
				break;
			case "DEL":
				$Sql = "UPDATE rs_tbl_shifts SET 
							isActive=3
						WHERE
							1=1";
				$Sql .= " AND shift_id=" . $this->getProperty("shift_id");
				break;
			default:
				break;
		}
		
		return $this->dbQuery($Sql);
	}
	
	
	/**
	* This function is User Emergency Number (Delete/Update/Add)
	* @author Numan Tahir
	*/
	public function actUserEmergencyNumber($mode = "I"){
		$mode = strtoupper($mode);
		switch($mode){
			case "I":
				$Sql = "INSERT INTO rs_tbl_user_emergency(
						user_emergency_id,
						user_id,
						center_id,
						person_name,
						contact_number,
						isActive)
						VALUES(";
				$Sql .= $this->isPropertySet("user_emergency_id", "V") ? $this->getProperty("user_emergency_id") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("user_id", "V") ? $this->getProperty("user_id") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("center_id", "V") ? $this->getProperty("center_id") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("person_name", "V") ? "'" . $this->getProperty("person_name") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("contact_number", "V") ? "'" . $this->getProperty("contact_number") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("isActive", "V") ? "'" . $this->getProperty("isActive") . "'" : "1";
				$Sql .= ")";
				break;
			case "U":
				$Sql = "UPDATE rs_tbl_user_emergency SET ";
				
				if($this->isPropertySet("person_name", "K")){
					$Sql .= "$con person_name='" . $this->getProperty("person_name") . "'";
					$con = ",";
				}
				if($this->isPropertySet("contact_number", "K")){
					$Sql .= "$con contact_number='" . $this->getProperty("contact_number") . "'";
					$con = ",";
				}
				if($this->isPropertySet("isActive", "K")){
					$Sql .= "$con isActive='" . $this->getProperty("isActive") . "'";
					$con = ",";
				}
					
				$Sql .= " WHERE 1=1";
				
				if($this->isPropertySet("user_emergency_id", "V"))
					$Sql .= " AND user_emergency_id=" . $this->getProperty("user_emergency_id");
					
				break;
			case "DEL":
				$Sql = "UPDATE rs_tbl_user_emergency SET 
							isActive=3
						WHERE
							1=1";
				$Sql .= " AND user_emergency_id=" . $this->getProperty("user_emergency_id");
				break;
			default:
				break;
		}
		
		return $this->dbQuery($Sql);
	}
	
	/**
	* This function is User Job Detail (Delete/Update/Add)
	* @author Numan Tahir
	*/
	public function actUserJobDetail($mode = "I"){
		$mode = strtoupper($mode);
		switch($mode){
			case "I":
				$Sql = "INSERT INTO rs_tbl_user_job_detail(
						user_job_detail_id,
						user_id,
						center_id,
						job_title_id,
						job_description,
						company_id,
						department_id,
						joined_date,
						service_end_date,
						job_type,
						probation_period_end_date,
						probation_period_status)
						VALUES(";
				$Sql .= $this->isPropertySet("user_job_detail_id", "V") ? $this->getProperty("user_job_detail_id") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("user_id", "V") ? $this->getProperty("user_id") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("job_title_id", "V") ? "'" . $this->getProperty("job_title_id") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("job_description", "V") ? "'" . $this->getProperty("job_description") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("company_id", "V") ? "'" . $this->getProperty("company_id") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("department_id", "V") ? "'" . $this->getProperty("department_id") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("joined_date", "V") ? "'" . $this->getProperty("joined_date") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("service_end_date", "V") ? "'" . $this->getProperty("service_end_date") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("job_type", "V") ? "'" . $this->getProperty("job_type") . "'" : "1";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("probation_period_end_date", "V") ? "'" . $this->getProperty("probation_period_end_date") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("probation_period_status", "V") ? "'" . $this->getProperty("probation_period_status") . "'" : "NULL";
				$Sql .= ")";
				break;
			case "U":
				$Sql = "UPDATE rs_tbl_user_job_detail SET ";
				
				if($this->isPropertySet("job_title_id", "K")){
					$Sql .= "$con job_title_id='" . $this->getProperty("job_title_id") . "'";
					$con = ",";
				}
				if($this->isPropertySet("company_id", "K")){
					$Sql .= "$con company_id='" . $this->getProperty("company_id") . "'";
					$con = ",";
				}
				if($this->isPropertySet("department_id", "K")){
					$Sql .= "$con department_id='" . $this->getProperty("department_id") . "'";
					$con = ",";
				}
				if($this->isPropertySet("job_description", "K")){
					$Sql .= "$con job_description='" . $this->getProperty("job_description") . "'";
					$con = ",";
				}
				if($this->isPropertySet("joined_date", "K")){
					$Sql .= "$con joined_date='" . $this->getProperty("joined_date") . "'";
					$con = ",";
				}
				if($this->isPropertySet("service_end_date", "K")){
					$Sql .= "$con service_end_date='" . $this->getProperty("service_end_date") . "'";
					$con = ",";
				}
				if($this->isPropertySet("probation_period_status", "K")){
					$Sql .= "$con probation_period_status='" . $this->getProperty("probation_period_status") . "'";
					$con = ",";
				}
				if($this->isPropertySet("job_type", "K")){
					$Sql .= "$con job_type='" . $this->getProperty("job_type") . "'";
					$con = ",";
				}
				if($this->isPropertySet("probation_period_end_date", "K")){
					$Sql .= "$con probation_period_end_date='" . $this->getProperty("probation_period_end_date") . "'";
					$con = ",";
				}
					
				$Sql .= " WHERE 1=1";
				
				if($this->isPropertySet("user_job_detail_id", "V"))
					$Sql .= " AND user_job_detail_id=" . $this->getProperty("user_job_detail_id");
					
				break;
			case "DEL":
			default:
				break;
		}
		//echo $Sql;
		return $this->dbQuery($Sql);
	}
	
	/**
	* This function is User Reference Detail (Delete/Update/Add)
	* @author Numan Tahir
	*/
	public function actUserReference($mode = "I"){
		$mode = strtoupper($mode);
		switch($mode){
			case "I":
				$Sql = "INSERT INTO rs_tbl_user_reference(
						user_reference_id,
						user_id,
						center_id,
						person_name,
						contact_no,
						company_name,
						isActive)
						VALUES(";
				$Sql .= $this->isPropertySet("user_reference_id", "V") ? $this->getProperty("user_reference_id") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("user_id", "V") ? $this->getProperty("user_id") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("center_id", "V") ? $this->getProperty("center_id") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("person_name", "V") ? "'" . $this->getProperty("person_name") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("contact_no", "V") ? "'" . $this->getProperty("contact_no") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("company_name", "V") ? "'" . $this->getProperty("company_name") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("isActive", "V") ? "'" . $this->getProperty("isActive") . "'" : "1";
				$Sql .= ")";
				break;
			case "U":
				$Sql = "UPDATE rs_tbl_user_reference SET ";
				
				if($this->isPropertySet("person_name", "K")){
					$Sql .= "$con person_name='" . $this->getProperty("person_name") . "'";
					$con = ",";
				}
				if($this->isPropertySet("contact_no", "K")){
					$Sql .= "$con contact_no='" . $this->getProperty("contact_no") . "'";
					$con = ",";
				}
				if($this->isPropertySet("company_name", "K")){
					$Sql .= "$con company_name='" . $this->getProperty("company_name") . "'";
					$con = ",";
				}
				if($this->isPropertySet("isActive", "K")){
					$Sql .= "$con isActive='" . $this->getProperty("isActive") . "'";
					$con = ",";
				}
					
				$Sql .= " WHERE 1=1";
				
				if($this->isPropertySet("user_reference_id", "V"))
					$Sql .= " AND user_reference_id=" . $this->getProperty("user_reference_id");
					
				break;
			case "DEL":
				$Sql = "UPDATE rs_tbl_user_reference SET 
							isActive=3
						WHERE
							1=1";
				$Sql .= " AND user_reference_id=" . $this->getProperty("user_reference_id");
				break;
			default:
				break;
		}
		
		return $this->dbQuery($Sql);
	}
	
	
	/**
	* This function is User Shifts Detail (Delete/Update/Add)
	* @author Numan Tahir
	*/
	public function actUserShifts($mode = "I"){
		$mode = strtoupper($mode);
		switch($mode){
			case "I":
				$Sql = "INSERT INTO rs_tbl_user_shifts(
						user_shift_id,
						user_id,
						center_id,
						shift_id,
						day_id,
						day_status,
						isActive)
						VALUES(";
				$Sql .= $this->isPropertySet("user_shift_id", "V") ? $this->getProperty("user_shift_id") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("user_id", "V") ? $this->getProperty("user_id") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("center_id", "V") ? $this->getProperty("center_id") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("shift_id", "V") ? "'" . $this->getProperty("shift_id") . "'" : "0";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("day_id", "V") ? "'" . $this->getProperty("day_id") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("day_status", "V") ? "'" . $this->getProperty("day_status") . "'" : "1";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("isActive", "V") ? "'" . $this->getProperty("isActive") . "'" : "1";
				$Sql .= ")";
				break;
			case "U":
				$Sql = "UPDATE rs_tbl_user_shifts SET ";
				
				if($this->isPropertySet("shift_id", "K")){
					$Sql .= "$con shift_id='" . $this->getProperty("shift_id") . "'";
					$con = ",";
				}
				if($this->isPropertySet("day_id", "K")){
					$Sql .= "$con day_id='" . $this->getProperty("day_id") . "'";
					$con = ",";
				}
				if($this->isPropertySet("day_status", "K")){
					$Sql .= "$con day_status='" . $this->getProperty("day_status") . "'";
					$con = ",";
				}
				if($this->isPropertySet("isActive", "K")){
					$Sql .= "$con isActive='" . $this->getProperty("isActive") . "'";
					$con = ",";
				}
					
				$Sql .= " WHERE 1=1";
				
				if($this->isPropertySet("user_shift_id", "V"))
					$Sql .= " AND user_shift_id=" . $this->getProperty("user_shift_id");
					
				break;
			case "DEL":
				break;
			default:
				break;
		}
		//echo $Sql;
		return $this->dbQuery($Sql);
	}
	
	/**
	* This function is User Education Detail (Delete/Update/Add)
	* @author Numan Tahir
	*/
	public function actUserEducation($mode = "I"){
		$mode = strtoupper($mode);
		switch($mode){
			case "I":
				$Sql = "INSERT INTO rs_tbl_user_education(
						user_education_id,
						user_id,
						center_id,
						institute_name,
						major,
						start_date,
						end_date,
						document_file_name,
						document_file,
						other_note,
						isAcitve)
						VALUES(";
				$Sql .= $this->isPropertySet("user_education_id", "V") ? $this->getProperty("user_education_id") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("user_id", "V") ? $this->getProperty("user_id") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("center_id", "V") ? $this->getProperty("center_id") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("institute_name", "V") ? "'" . $this->getProperty("institute_name") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("major", "V") ? "'" . $this->getProperty("major") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("start_date", "V") ? "'" . $this->getProperty("start_date") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("end_date", "V") ? "'" . $this->getProperty("end_date") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("document_file_name", "V") ? "'" . $this->getProperty("document_file_name") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("document_file", "V") ? "'" . $this->getProperty("document_file") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("other_note", "V") ? "'" . $this->getProperty("other_note") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("isAcitve", "V") ? "'" . $this->getProperty("isAcitve") . "'" : "1";
				$Sql .= ")";
				break;
			case "U":
				$Sql = "UPDATE rs_tbl_user_education SET ";
				
				if($this->isPropertySet("institute_name", "K")){
					$Sql .= "$con institute_name='" . $this->getProperty("institute_name") . "'";
					$con = ",";
				}
				if($this->isPropertySet("major", "K")){
					$Sql .= "$con major='" . $this->getProperty("major") . "'";
					$con = ",";
				}
				if($this->isPropertySet("start_date", "K")){
					$Sql .= "$con start_date='" . $this->getProperty("start_date") . "'";
					$con = ",";
				}
				if($this->isPropertySet("end_date", "K")){
					$Sql .= "$con end_date='" . $this->getProperty("end_date") . "'";
					$con = ",";
				}
				if($this->isPropertySet("document_file_name", "K")){
					$Sql .= "$con document_file_name='" . $this->getProperty("document_file_name") . "'";
					$con = ",";
				}
				if($this->isPropertySet("document_file", "K")){
					$Sql .= "$con document_file='" . $this->getProperty("document_file") . "'";
					$con = ",";
				}
				if($this->isPropertySet("isAcitve", "K")){
					$Sql .= "$con isAcitve='" . $this->getProperty("isAcitve") . "'";
					$con = ",";
				}
					
				$Sql .= " WHERE 1=1";
				
				if($this->isPropertySet("user_education_id", "V"))
					$Sql .= " AND user_education_id=" . $this->getProperty("user_education_id");
					
				break;
			case "DEL":
				$Sql = "UPDATE rs_tbl_user_education SET 
							isActive=3
						WHERE
							1=1";
				$Sql .= " AND user_education_id=" . $this->getProperty("user_education_id");
				break;
			default:
				break;
		}
		
		return $this->dbQuery($Sql);
	}
	
	/**
	* This function is User Employment Detail (Delete/Update/Add)
	* @author Numan Tahir
	*/
	public function actUserEmployment($mode = "I"){
		$mode = strtoupper($mode);
		switch($mode){
			case "I":
				$Sql = "INSERT INTO rs_tbl_user_employment(
						user_employment_id,
						user_id,
						company_name,
						job_title,
						from_date,
						end_date,
						isActive)
						VALUES(";
				$Sql .= $this->isPropertySet("user_employment_id", "V") ? $this->getProperty("user_employment_id") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("user_id", "V") ? $this->getProperty("user_id") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("company_name", "V") ? "'" . $this->getProperty("company_name") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("job_title", "V") ? "'" . $this->getProperty("job_title") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("from_date", "V") ? "'" . $this->getProperty("from_date") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("end_date", "V") ? "'" . $this->getProperty("end_date") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("isAcitve", "V") ? "'" . $this->getProperty("isAcitve") . "'" : "1";
				$Sql .= ")";
				break;
			case "U":
				$Sql = "UPDATE rs_tbl_user_employment SET ";
				
				if($this->isPropertySet("company_name", "K")){
					$Sql .= "$con company_name='" . $this->getProperty("company_name") . "'";
					$con = ",";
				}
				if($this->isPropertySet("job_title", "K")){
					$Sql .= "$con job_title='" . $this->getProperty("job_title") . "'";
					$con = ",";
				}
				if($this->isPropertySet("from_date", "K")){
					$Sql .= "$con from_date='" . $this->getProperty("from_date") . "'";
					$con = ",";
				}
				if($this->isPropertySet("end_date", "K")){
					$Sql .= "$con end_date='" . $this->getProperty("end_date") . "'";
					$con = ",";
				}
				if($this->isPropertySet("isAcitve", "K")){
					$Sql .= "$con isAcitve='" . $this->getProperty("isAcitve") . "'";
					$con = ",";
				}
					
				$Sql .= " WHERE 1=1";
				
				if($this->isPropertySet("user_employment_id", "V"))
					$Sql .= " AND user_employment_id=" . $this->getProperty("user_employment_id");
					
				break;
			case "DEL":
				$Sql = "UPDATE rs_tbl_user_employment SET 
							isActive=3
						WHERE
							1=1";
				$Sql .= " AND user_employment_id=" . $this->getProperty("user_employment_id");
				break;
			default:
				break;
		}
		
		return $this->dbQuery($Sql);
	}
	
	/**
	* This function is User Bank Detail (Delete/Update/Add)
	* @author Numan Tahir
	*/
	public function actUserBankDetail($mode = "I"){
		$mode = strtoupper($mode);
		switch($mode){
			case "I":
				$Sql = "INSERT INTO rs_tbl_user_bank_account_detail(
							employee_bank_id,
							user_id,
							center_id,
							bank_id,
							account_no,
							account_title,
							entery_date,
							isActive)
						VALUES(";
				$Sql .= $this->isPropertySet("employee_bank_id", "V") ? $this->getProperty("employee_bank_id") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("user_id", "V") ? "'" . $this->getProperty("user_id") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("center_id", "V") ? "'" . $this->getProperty("center_id") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("bank_id", "V") ? "'" . $this->getProperty("bank_id") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("account_no", "V") ? "'" . $this->getProperty("account_no") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("account_title", "V") ? "'" . $this->getProperty("account_title") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("entery_date", "V") ? "'" . $this->getProperty("entery_date") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("isActive", "V") ? "'" . $this->getProperty("isActive") . "'" : "1";
				$Sql .= ")";
				break;
			case "U":
				$Sql = "UPDATE rs_tbl_user_bank_account_detail SET ";
				
				if($this->isPropertySet("account_no", "K")){
					$Sql .= "$con account_no='" . $this->getProperty("account_no") . "'";
					$con = ",";
				}
				if($this->isPropertySet("account_title", "K")){
					$Sql .= "$con account_title='" . $this->getProperty("account_title") . "'";
					$con = ",";
				}
				if($this->isPropertySet("isActive", "K")){
					$Sql .= "$con isActive='" . $this->getProperty("isActive") . "'";
					$con = ",";
				}
									
				$Sql .= " WHERE 1=1";
				
				if($this->isPropertySet("employee_bank_id", "V"))
					$Sql .= " AND employee_bank_id=" . $this->getProperty("employee_bank_id");
					
				break;
			case "DEL":
				$Sql = "UPDATE rs_tbl_user_bank_account_detail SET 
							isActive=3
						WHERE
							1=1";
				$Sql .= " AND employee_bank_id=" . $this->getProperty("employee_bank_id");
				break;
			default:
				break;
		}
		
		return $this->dbQuery($Sql);
	}
	
	/**
	* This function is User DEvice List(Delete/Update/Add)
	* @author Numan Tahir
	*/
	public function actUserDeviceList($mode = "I"){
		$mode = strtoupper($mode);
		switch($mode){
			case "I":
				$Sql = "INSERT INTO rs_tbl_user_device_list(
							verification_id,
							device_id,
							user_id,
							center_id,
							security_code,
							mobile_status,
							verification_date,
							entery_date,
							isActive)
						VALUES(";
				$Sql .= $this->isPropertySet("verification_id", "V") ? $this->getProperty("verification_id") : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("device_id", "V") ? "'" . $this->getProperty("device_id") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("user_id", "V") ? "'" . $this->getProperty("user_id") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("center_id", "V") ? "'" . $this->getProperty("center_id") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("security_code", "V") ? "'" . $this->getProperty("security_code") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("mobile_status", "V") ? "'" . $this->getProperty("mobile_status") . "'" : "3";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("verification_date", "V") ? "'" . $this->getProperty("verification_date") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("entery_date", "V") ? "'" . $this->getProperty("entery_date") . "'" : "NULL";
				$Sql .= ",";
				$Sql .= $this->isPropertySet("isActive", "V") ? "'" . $this->getProperty("isActive") . "'" : "1";
				$Sql .= ")";
				break;
			case "U":
				$Sql = "UPDATE rs_tbl_user_device_list SET ";
				
				if($this->isPropertySet("security_code", "K")){
					$Sql .= "$con security_code='" . $this->getProperty("security_code") . "'";
					$con = ",";
				}
				if($this->isPropertySet("mobile_status", "K")){
					$Sql .= "$con mobile_status='" . $this->getProperty("mobile_status") . "'";
					$con = ",";
				}
				if($this->isPropertySet("verification_date", "K")){
					$Sql .= "$con verification_date='" . $this->getProperty("verification_date") . "'";
					$con = ",";
				}
									
				$Sql .= " WHERE 1=1";
				
				if($this->isPropertySet("verification_id", "V"))
					$Sql .= " AND verification_id=" . $this->getProperty("verification_id");
					
				break;
			case "DEL":
				$Sql = "UPDATE rs_tbl_user_device_list SET 
							isActive=3
						WHERE
							1=1";
				if($this->isPropertySet("verification_id", "K")){
					$Sql .= " AND verification_id='" . $this->getProperty("verification_id") . "'";
				}
				break;
			default:
				break;
		}

		return $this->dbQuery($Sql);
	}
	
	/**
	* This function is used to change the password
	* @author Numan Tahir
	*/
	public function changePassword(){
		$Sql = "UPDATE rs_tbl_users SET
					user_pass='" . $this->getProperty("user_pass") . "' 
				WHERE 
					1=1";
		$Sql .= " AND user_id='" . $this->getProperty("user_id") . "'";

		return $this->dbQuery($Sql);
	}
	
	/**
	* This method is used to get the new code/id for the table.
	* @author Numan Tahir
	* @Date : 18 July, 2012
	* @modified :  18 July, 2012 by Numan Tahir
	* @return : bool
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