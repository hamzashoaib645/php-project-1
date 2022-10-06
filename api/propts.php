<?php
header('Access-Control-Allow-Origin: *');
require_once("../config/config.php");

$objCommon 					= new Common;
$objQayaduser 			= new Qayaduser;
$objQayadProerty 		= new Qayadproperty;
$objQayadApplication		= new Qayadapplication;


$GetFloorId = $_GET["i"];
$ReturnType = $_GET['rt'];
$PropertyObj = array();
$objQayadProerty->setProperty("isNot", 3);
$objQayadProerty->setProperty("propety_floor_id", $GetFloorId);
$objQayadProerty->setProperty("ORDERBY", 'property_id');
$objQayadProerty->lstPropertyDetail();
while($ListOfProperties = $objQayadProerty->dbFetchArray(1)){
		
$objQayadApplication->resetProperty();
$objQayadApplication->setProperty("property_id", $ListOfProperties["property_id"]);
$objQayadApplication->setProperty("isActive", 1);
//$objQayadApplication->setProperty("current_payment_status_not", 1);
$objQayadApplication->lstBasicApplicationInfo();
$PropertyApplicationDetail = $objQayadApplication->dbFetchArray(1);
		//
//$PropertyObj[] = array("prod" => $ListOfProperties, "app"=>$PropertyApplicationDetail);
$PropertyObj[] = array("property_id" => $ListOfProperties["property_id"], "property_registered_id" => $ListOfProperties["property_registered_id"], "floor_name" => $ListOfProperties["floor_name"], "property_section" => $ListOfProperties["property_section"], "property_area" => $ListOfProperties["property_area"], "property_image" => COMPANY_PROP_THUMB_URL.$ListOfProperties["property_image"], "property_type_id" => $ListOfProperties["property_type_id"], "propety_floor_id" => $ListOfProperties["propety_floor_id"], "property_number" => $ListOfProperties["property_number"], "property_img_title" => $ListOfProperties["property_img_title"], "property_img_cord" => $ListOfProperties["property_img_cord"], "poperty_img_shap" => $ListOfProperties["poperty_img_shap"], "property_status" => $ListOfProperties["property_status"], "book_duration" => $ListOfProperties["book_duration"], "property_desc" => $ListOfProperties["property_desc"], "property_rent_sqft" => $ListOfProperties["property_rent_sqft"], "down_payment" => $ListOfProperties["down_payment"], "instalment_per_month" => $ListOfProperties["instalment_per_month"], "rate_per_sq_ft" => $ListOfProperties["rate_per_sq_ft"], "dp_discount" => $ListOfProperties["dp_discount"], "total_discount" => $ListOfProperties["total_discount"], "payback_cutting" => $ListOfProperties["payback_cutting"], "pb_cutting_value" => $ListOfProperties["pb_cutting_value"], "property_transfer_fee" => $ListOfProperties["property_transfer_fee"], "property_rent_value" => $ListOfProperties["property_rent_value"], "aplic_id" => $PropertyApplicationDetail["aplic_id"], "property_id" => $PropertyApplicationDetail["property_id"], "customer_id" => $PropertyApplicationDetail["customer_id"], "seller_agent_id" => $PropertyApplicationDetail["seller_agent_id"], "registration_type" => $PropertyApplicationDetail["registration_type"], "aplic_type" => $PropertyApplicationDetail["aplic_type"], "current_payment_status" => $PropertyApplicationDetail["current_payment_status"], "customer_fname" => $PropertyApplicationDetail["customer_fname"], "customer_lname" => $PropertyApplicationDetail["customer_lname"], "customer_mobile" => $PropertyApplicationDetail["customer_mobile"], "customer_cnic" =>$PropertyApplicationDetail["customer_cnic"], "agent_fname" => $PropertyApplicationDetail["user_fname"], "agent_lname" => $PropertyApplicationDetail["user_lname"], "agent_mobile" => $PropertyApplicationDetail["user_mobile"]);
/*
[aplic_id] => 1
[property_id] => 2
[customer_id] => 3
[seller_agent_id] => 3
[registration_type] => 1
[aplic_type] => 1
[current_payment_status] => 2
[customer_fname] => Numan
[customer_lname] => Applicant Last name
[customer_mobile] => 03214641174
[customer_cnic] => 35202123456
[user_fname] => Uzair
[user_lname] => Uzair
[user_mobile] => 123456
[isActive] => 1
*/



}
if($ReturnType == 1){
echo '<pre>';
print_r($PropertyObj);	
echo '</pre>';
} else {
echo json_encode($PropertyObj);
}