<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, POST");
//header('Access-Control-Max-Age: 86400');
header('content-type: application/json; charset=utf-8');

require_once("../config/config.php");
require_once('../lang/' . strtolower(SITE_LANG) . '/rs_lang.website.php');
$objCommon 				= new Common;
$objQayaduser 		= new Qayaduser;
$objQayadProerty 	= new Qayadproperty;
$objQayadProertyPD 	= new Qayadproperty;
$objQayadProertyLegd	= new Qayadaccount;
$objQayadapplication	= new Qayadapplication;
$objQayadCustomer	= new Qayadapplication;
$objQayadPaymentOvVi = new Qayadapplication;
$objValidate 			= new Validate;
$objBF 					= new Crypt_Blowfish('CBC');
$objBF->setKey($cipher_key);
$PropertyObj 			= array();
//echo EncData('mode_3', 2, $objBF);
//die();
$RequestedMethord = trim(DecData($_GET["mode"], 1, $objBF));
	
if($RequestedMethord == 'mode_1'){
// User Login API
////////////////////////////////////////////////////////////////////
/******************************************************************/
////////////////////////////////////////////////////////////////////

	$user_mobile	 		= trim($_GET["user_mobile"]);
	$user_pass	 			= trim($_GET["user_pass"]);

	$objValidate->setArray($_GET);
	$objValidate->setCheckField("user_mobile", _VLD_INVALID_Mobile, "S");
	$objValidate->setCheckField("user_pass", _VLD_PASSWORD, "S");
	$vResult = $objValidate->doValidate();
	// See if any error are not returned
	if(!$vResult){
		$objQayaduser->resetProperty();
		$objQayaduser->setProperty("user_mobile", $user_mobile);
		$objQayaduser->setProperty("user_pass", $objBF->encrypt($user_pass, ENCRYPTION_KEY));
		$objQayaduser->setProperty("login_required", 1);
		$objQayaduser->setProperty("user_type_id", 4);
		$objQayaduser->checkUserLogin();
		if($objQayaduser->totalRecords() >= 1){
			$rows = $objQayaduser->dbFetchArray(1);
			if($rows['isActive'] != 1){
				$vResult['invalid_login'] = _CUST_ACCOUNT_SUSPENDED;
				echo json_encode($vResult);
			}
			else{
				$CreateAccessToken = EncData($rows['user_id'].'-'.$rows['user_mobile'], 1, $objBF);
				$PropertyObj[] = array("login_validation" => "true", "acc_token" => $CreateAccessToken, "fullname" => $rows['fullname'], "profile_img" => USER_PROFILE_URL.$rows['user_profile_img'], "user_designation" => $rows['user_designation']);
				echo json_encode($PropertyObj);
			}
		}
		else{
				$PropertyObj[] = array("login_validation" => "false", "acc_token" => '', "invalid_login" => _LOGIN_INVALID_LOGIN);
				echo json_encode($PropertyObj);
		}
	} else {
		echo json_encode($vResult);
	}

////////////////////////////////////////////////////////////////////
/******************************************************************/
////////////////////////////////////////////////////////////////////
// Get Floor List
} elseif($RequestedMethord == 'mode_2'){ 
	
	$Property_id 		= $_GET["prop_reg_id"];
	
	$objValidate->setArray($_GET);
	$objValidate->setCheckField("prop_reg_id", 'Project Type id missing.', "S");
	$vResult = $objValidate->doValidate();
	// See if any error are not returned
	if(!$vResult){
		$objQayadProerty->resetProperty();
		$objQayadProerty->setProperty("isNot", 3);
		$objQayadProerty->setProperty("project_id", $Property_id);
		$objQayadProerty->setProperty("ORDERBY", 'propety_floor_id');
		$objQayadProerty->lstPropertyFloorPlan();
		while($ListOfFloorPlan = $objQayadProerty->dbFetchArray(1)){
		$PropertyObj[] = array("f_id" => $ListOfFloorPlan["propety_floor_id"], "floor_name" =>$ListOfFloorPlan["floor_name"]);
		}
		echo json_encode($PropertyObj);
	} else {
		echo json_encode($vResult);
	}
	
} elseif($RequestedMethord == 'mode_3'){
// Get List of Properties
	
	$Property_id 		= trim($_GET["prop_reg_id"]);
	$Floor_id 			= trim($_GET["f_id"]);
	
	$objValidate->setArray($_GET);
	$objValidate->setCheckField("prop_reg_id", 'Project Type id missing.', "S");
	$objValidate->setCheckField("f_id", 'Floor id missing.', "S");
	$vResult = $objValidate->doValidate();
	// See if any error are not returned
	if(!$vResult){
		$objQayadProerty->resetProperty();
		$objQayadProerty->setProperty("property_registered_id", $Property_id);
		$objQayadProerty->setProperty("propety_floor_id", $Floor_id);
		$objQayadProerty->setProperty("ORDERBY", 'property_id');
		$objQayadProerty->lstProperties();
		while($ListOfProperties = $objQayadProerty->dbFetchArray(1)){
				
					$objQayadapplication->setProperty("property_id", $ListOfProperties["property_id"]);
					$objQayadapplication->lstApplication();
					$CountApplications = $objQayadapplication->totalRecords();
					if($CountApplications > 0){
						$ApplicationDetail = $objQayadapplication->dbFetchArray(1);
							$objQayadCustomer->setProperty("customer_id", $ApplicationDetail["customer_id"]);
							//$objQayadCustomer->setProperty("customer_type", 1);
							$objQayadCustomer->lstApplicationCustomer();
							$AplicCustomerDetail = $objQayadCustomer->dbFetchArray(1);
						
						//$objQayadapplication->resetProperty();
						$objQayadPaymentOvVi->setProperty("aplic_id", $ApplicationDetail["aplic_id"]);
						$objQayadPaymentOvVi->lstPaymentOverview();
						$AplicPaymentOverView = $objQayadPaymentOvVi->dbFetchArray(1);
						
						//$objQayaduser->resetProperty();
						$objQayaduser->setProperty("user_id", $ApplicationDetail["seller_agent_id"]);
						$objQayaduser->lstUsers();
						$SellerAgentDetail = $objQayaduser->dbFetchArray(1);
					}

					$objQayadProertyPD->setProperty("property_id", $ListOfProperties["property_id"]);
					$objQayadProertyPD->setProperty("isActive", 1);
					$objQayadProertyPD->lstPropertyPaymentDetail();
					$PropertyPaymentDetail = $objQayadProertyPD->dbFetchArray(1);
					
					$objQayadProertyLegd->setProperty("property_id", $ListOfProperties["property_id"]);
					$objQayadProertyLegd->VwPropertyVsLedger();
					$property_vs_ledger = $objQayadProertyLegd->dbFetchArray(1);
					if($CountApplications > 0){
					$PropertyObj[] = array(
					"property_id" => $ListOfProperties["property_id"], 
					"floor_name" =>$ListOfProperties["floor_name"], 
					"property_section" =>$ListOfProperties["property_section"],
					"property_area" =>$ListOfProperties["property_area"],
					"property_image" => COMPANY_PROP_THUMB_URL.$ListOfProperties["property_image"],
					"property_number" =>$ListOfProperties["property_number"],
					"property_img_title" =>$ListOfProperties["property_img_title"],
					"property_img_cord" =>$ListOfProperties["property_img_cord"],
					"poperty_img_shap" =>$ListOfProperties["poperty_img_shap"],
					"property_status" =>$ListOfProperties["property_status"],
					"prop_status" => PropertyStatus($ListOfProperties["property_status"]),
					"book_duration" =>$ListOfProperties["book_duration"],
					"property_desc" =>$ListOfProperties["property_desc"],
					"reg_number" =>$ApplicationDetail["reg_number"],
					"payment_mode" => ApplicationPaymentMode($AplicPaymentOverView["payment_mode"]),
					"total_amount_received" =>$property_vs_ledger["total_amount_received"],
					"customer_id" =>$ApplicationDetail["customer_id"],
					"customer_fname" =>$AplicCustomerDetail["customer_fname"],
					"customer_lname" =>$AplicCustomerDetail["customer_lname"],
					"customer_of" =>$AplicCustomerDetail["customer_of"],
					"customer_father" =>$AplicCustomerDetail["customer_father"],
					"customer_email" =>$AplicCustomerDetail["customer_email"],
					"customer_cnic" =>$AplicCustomerDetail["customer_cnic"],
					"customer_mobile" =>$AplicCustomerDetail["customer_mobile"],
					"down_payment" =>$PropertyPaymentDetail["down_payment"],
					"instalment_per_month" =>$PropertyPaymentDetail["instalment_per_month"],
					"rate_per_sq_ft" =>$PropertyPaymentDetail["rate_per_sq_ft"],
					"property_rent_sqft" =>$ListOfProperties["property_rent_sqft"],
					"seller_agent_name" =>$SellerAgentDetail["fullname"]
					);
					//$objQayadapplication->resetProperty();
					} else {
					$PropertyObj[] = array(
					"property_id" => $ListOfProperties["property_id"], 
					"floor_name" =>$ListOfProperties["floor_name"], 
					"property_section" =>$ListOfProperties["property_section"],
					"property_area" =>$ListOfProperties["property_area"],
					"property_image" => COMPANY_PROP_THUMB_URL.$ListOfProperties["property_image"],
					"property_number" =>$ListOfProperties["property_number"],
					"property_img_title" =>$ListOfProperties["property_img_title"],
					"property_img_cord" =>$ListOfProperties["property_img_cord"],
					"poperty_img_shap" =>$ListOfProperties["poperty_img_shap"],
					"property_status" =>$ListOfProperties["property_status"],
					"prop_status" => PropertyStatus($ListOfProperties["property_status"]),
					"book_duration" =>$ListOfProperties["book_duration"],
					"property_desc" =>$ListOfProperties["property_desc"],
					"reg_number" =>$ApplicationDetail["reg_number"],
					"payment_mode" => ApplicationPaymentMode($AplicPaymentOverView["payment_mode"]),
					"total_amount_received" =>$property_vs_ledger["total_amount_received"],
					"down_payment" =>$PropertyPaymentDetail["down_payment"],
					"instalment_per_month" =>$PropertyPaymentDetail["instalment_per_month"],
					"rate_per_sq_ft" =>$PropertyPaymentDetail["rate_per_sq_ft"],
					"property_rent_sqft" =>$ListOfProperties["property_rent_sqft"]
					);	
					}
		}
		echo json_encode($PropertyObj);
	} else {
		echo json_encode($vResult);
	}

} elseif($RequestedMethord == 'mode_4'){
// Get List of Lock Properties Agent Base
	
	$acc_token		= trim($_GET["acc_token"]);

	$objValidate->setArray($_GET);
	$objValidate->setCheckField("acc_token", 'Access Token is missing.', "S");
	$vResult = $objValidate->doValidate();
	// See if any error are not returned
	if(!$vResult){
		list($UserId,$UserMobileNumber)= explode('-', trim(DecData($acc_token, 1, $objBF)));
		$objQayadProerty->resetProperty();
		$objQayadProerty->setProperty("user_id", $UserId);
		$objQayadProerty->setProperty("ORDERBY", 'temp_lock_id');
		$objQayadProerty->lstPropertyTempLock();
		if($objQayadProerty->totalRecords() > 0){
			while($ListOfProperties = $objQayadProerty->dbFetchArray(1)){
				$PropertyObj[] = array(
						"temp_lock_id" => $ListOfProperties["temp_lock_id"], 
						"property_id" =>$ListOfProperties["property_id"], 
						"customer_fname" =>$ListOfProperties["customer_fname"],
						"customer_lname" =>$ListOfProperties["customer_lname"],
						"customer_father" =>$ListOfProperties["customer_father"],
						"customer_email" =>$ListOfProperties["customer_email"],
						"customer_c_address" =>$ListOfProperties["customer_c_address"],
						"customer_mobile" =>$ListOfProperties["customer_mobile"],
						"received_amount" =>$ListOfProperties["received_amount"],
						"till_lock_duration" =>$ListOfProperties["till_lock_duration"],
						"lock_status" => TempLockedStatus($ListOfProperties["lock_status"])
						);
			}
		} else {
			$PropertyObj[] = array("return" => 'No record found.');
		}
		echo json_encode($PropertyObj);
	} else {
		echo json_encode($vResult);
	}

} elseif($RequestedMethord == 'mode_5'){
	//prop_id 
	$prop_id 		= trim($_GET["prop_id"]);
	
	$objValidate->setArray($_GET);
	$objValidate->setCheckField("prop_id", 'Property id missing.', "S");
	$vResult = $objValidate->doValidate();
	// See if any error are not returned
	if(!$vResult){
		$objQayadProerty->resetProperty();
		$objQayadProerty->setProperty("property_id", $prop_id);
		$objQayadProerty->lstProperties();
		while($ListOfProperties = $objQayadProerty->dbFetchArray(1)){
					$objQayadProertyPD->setProperty("property_id", $ListOfProperties["property_id"]);
					$objQayadProertyPD->setProperty("isActive", 1);
					$objQayadProertyPD->lstPropertyPaymentDetail();
					$PropertyPaymentDetail = $objQayadProertyPD->dbFetchArray(1);
					
					$PropertyObj[] = array(
					"property_id" => $ListOfProperties["property_id"], 
					"floor_name" =>$ListOfProperties["floor_name"], 
					"property_section" =>$ListOfProperties["property_section"],
					"property_area" =>$ListOfProperties["property_area"],
					"property_image" =>$ListOfProperties["property_image"],
					"property_number" =>$ListOfProperties["property_number"],
					"property_img_title" =>$ListOfProperties["property_img_title"],
					"property_img_cord" =>$ListOfProperties["property_img_cord"],
					"poperty_img_shap" =>$ListOfProperties["poperty_img_shap"],
					"property_status" =>$ListOfProperties["property_status"],
					"prop_status" => PropertyStatus($ListOfProperties["property_status"]),
					"book_duration" =>$ListOfProperties["book_duration"],
					"property_desc" =>$ListOfProperties["property_desc"],
					"down_payment" =>$PropertyPaymentDetail["down_payment"],
					"instalment_per_month" =>$PropertyPaymentDetail["instalment_per_month"],
					"rate_per_sq_ft" =>$PropertyPaymentDetail["rate_per_sq_ft"],
					"property_rent_sqft" =>$ListOfProperties["property_rent_sqft"]
					);
		}
		echo json_encode($PropertyObj);
	} else {
		echo json_encode($vResult);
	}

	
} elseif($RequestedMethord == 'mode_6'){
	// Post Property Lock 
	$acc_token				= trim($_GET["acc_token"]);
	$property_id			= trim($_GET["prop_id"]);
	$customer_fname			= trim($_GET['customer_fname']);
	$customer_lname			= trim($_GET['customer_lname']);
	$customer_father		= trim($_GET['customer_father']);
	$customer_cnic			= trim($_GET['customer_cnic']);
	$customer_passport		= trim($_GET['customer_passport']);
	$customer_email			= trim($_GET['customer_email']);
	$customer_c_address		= trim($_GET['customer_c_address']);
	$customer_p_address		= trim($_GET['customer_p_address']);
	$customer_phone			= trim($_GET['customer_phone']);
	$customer_mobile		= trim($_GET['customer_mobile']);
	$customer_mobile_2		= trim($_GET['customer_mobile_2']);
	$received_amount		= trim($_GET['received_amount']);
	$till_lock_duration		= trim($_GET["till_lock_duration"]);
	$customer_old_id		= trim($_GET["customer_old_id"]);
	$isActive				= 1;
	$reg_date				= date('Y-m-d H:i:s');
	
	$objValidate->setArray($_GET);
	$objValidate->setCheckField("acc_token", 'Access Token' . _IS_REQUIRED_FLD, "S");
	$objValidate->setCheckField("prop_id", 'Property ID' . _IS_REQUIRED_FLD, "S");
	$objValidate->setCheckField("customer_fname", _REG_FIRST_NAME . _IS_REQUIRED_FLD, "S");
	$objValidate->setCheckField("customer_lname", _REG_LAST_NAME . _IS_REQUIRED_FLD, "S");
	$objValidate->setCheckField("customer_cnic", _REG_CNIC . _IS_REQUIRED_FLD, "S");
	$objValidate->setCheckField("customer_father", 'Father name' . _IS_REQUIRED_FLD, "S");
	$objValidate->setCheckField("customer_mobile", _REG_MOBILE . _IS_REQUIRED_FLD, "S");
	$objValidate->setCheckField("customer_c_address", 'Customer current address' . _IS_REQUIRED_FLD, "S");
	$objValidate->setCheckField("customer_p_address", 'Customer permanent address' . _IS_REQUIRED_FLD, "S");
	$objValidate->setCheckField("customer_phone", 'Customer phone' . _IS_REQUIRED_FLD, "S");
	$objValidate->setCheckField("till_lock_duration", 'Lock duration' . _IS_REQUIRED_FLD, "S");
	$objValidate->setCheckField("received_amount", 'Token amount' . _IS_REQUIRED_FLD, "S");
	
	$vResult = $objValidate->doValidate();
	// See if any error are not returned
	if(!$vResult){
		
		list($UserId,$UserMobileNumber)= explode('-', trim(DecData($acc_token, 1, $objBF)));
		$objQayadProerty->resetProperty();
		$temp_lock_id = $objQayadProerty->genCode("rs_tbl_property_temp_lock", "temp_lock_id");
		$objQayadProerty->resetProperty();
		$objQayadProerty->setProperty("temp_lock_id", $temp_lock_id);
		$objQayadProerty->setProperty("property_id", $property_id);
		$objQayadProerty->setProperty("user_id", trim($UserId));
		
		$objQayadProerty->setProperty("customer_old_id", $customer_old_id);
		$objQayadProerty->setProperty("customer_fname", $customer_fname);
		$objQayadProerty->setProperty("customer_lname", $customer_lname);
		$objQayadProerty->setProperty("customer_father", $customer_father);
		$objQayadProerty->setProperty("customer_cnic", $customer_cnic);
		$objQayadProerty->setProperty("customer_passport", $customer_passport);
		$objQayadProerty->setProperty("customer_email", $customer_email);
		$objQayadProerty->setProperty("customer_c_address", $customer_c_address);
		$objQayadProerty->setProperty("customer_p_address", $customer_p_address);
		$objQayadProerty->setProperty("customer_phone", $customer_phone);
		$objQayadProerty->setProperty("customer_mobile", $customer_mobile);
		$objQayadProerty->setProperty("customer_mobile_2", $customer_mobile_2);
		$objQayadProerty->setProperty("received_amount", $received_amount);
		$objQayadProerty->setProperty("till_lock_duration", date('Y-m-d', strtotime(date("Y-m-d"). ' + '.$till_lock_duration.' days')));
		$objQayadProerty->setProperty("lock_status", 5);
		$objQayadProerty->setProperty("entery_date", date('Y-m-d H:i:s'));
		if($objQayadProerty->actPropertyTempLock("I")){
		
			$objQayadProerty->resetProperty();
			$objQayadProerty->setProperty("property_id", $property_id);
			$objQayadProerty->setProperty("user_id", trim($UserId));
			$objQayadProerty->setProperty("property_status", 6);
			$objQayadProerty->setProperty("book_duration", $till_lock_duration);
			$objQayadProerty->actProperties("U");
			
				$objQayadProerty->resetProperty();
				$objQayadProerty->setProperty("property_id", $property_id);
				$objQayadProerty->setProperty("user_id", trim($UserId));
				$objQayadProerty->setProperty("entery_date", date('Y-m-d H:i:s'));
				$objQayadProerty->setProperty("log_desc", "Agent has been locked this property for next ".$till_lock_duration." Day's");
				$objQayadProerty->setProperty("isActive", 1);
				$objQayadProerty->actPropertyLog("I");
				
				$PropertyObj[] = array("msg" => _LOCKED_PROPERTY_MSG_SUCCESS, "lock_prop_id" => $$temp_lock_id);
				echo json_encode($vResult);
		}
	} else {
		echo json_encode($vResult);
	}
} elseif($RequestedMethord == 'mode_7'){
	//Check Customer Record.
	$GetCustomerCnic = trim($_GET["customer_cnic"]);
	$objQayadapplication->resetProperty();
	$objQayadapplication->setProperty("customer_cnic", $GetCustomerCnic);
	$objQayadapplication->lstApplicationCustomer();
	if($objQayadapplication->totalRecords() > 0){
	$data = $objQayadapplication->dbFetchArray(1);
	$PropertyObj[] = array("customer_old_id" => $rows["customer_id"], "customer_fname" => $rows['customer_fname'], "customer_lname" => $rows['customer_lname'], "customer_of" => $rows['customer_of'], "customer_father" => $rows['customer_father'], "customer_email" => $rows['customer_email'], "customer_cnic" => $rows['customer_cnic'], "customer_passport" => $rows['customer_passport'], "customer_c_address" => $rows['customer_c_address'], "customer_p_address" => $rows['customer_p_address'], "customer_phone" => $rows['customer_phone'], "customer_mobile" => $rows['customer_mobile'], "customer_mobile_2" => $rows['customer_mobile_2']);
	echo json_encode($PropertyObj);
	} else {
	$PropertyObj[] = array("msg" => 'No record found.');
	}
} elseif($RequestedMethord == 'mode_8'){
	
} else {
	$PropertyObj[] = array("mode" => 'mode id missing.');
	echo json_encode($PropertyObj);
}