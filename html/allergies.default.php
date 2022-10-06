<?php
if($_SERVER['REQUEST_METHOD'] == "POST"){
	$mode				= 'I';
	$objRoute 			= new Route;
	$objDaycaregeneral->resetProperty();

	$allergy_id				= trim($_POST['id']);
	$center_id				= trim($_POST['centerid']);
	$user_id				= trim($_POST['userid']);
	$allergy_title			= trim($_POST['title']);
	$allergy_desc			= trim($_POST['desc']);
	$isActive				= trim($_POST['status']);
	$mode 					= trim($_POST['mode']);
	$entery_date			= date('Y-m-d H:i:s');
	
	$objValidate->setArray($_POST);
	$objValidate->setCheckField("title", 'Title is required' . _IS_REQUIRED_FLD, "S");
	$vResult = $objValidate->doValidate();
	// See if any error are not returned
	if(!$vResult){
				
				$objDaycaregeneral->resetProperty();
				$allergy_id = ($_POST['mode'] == "U") ? trim($_POST['id']) : $objDaycaregeneral->genCode("rs_tbl_allergy_list", "allergy_id");
				
				$objDaycaregeneral->resetProperty();
				$objDaycaregeneral->setProperty("allergy_id", $allergy_id);
				$objDaycaregeneral->setProperty("center_id", $center_id);
				$objDaycaregeneral->setProperty("user_id", $user_id);
				$objDaycaregeneral->setProperty("allergy_title", $allergy_title);
				$objDaycaregeneral->setProperty("allergy_desc", $allergy_desc);
				$objDaycaregeneral->setProperty("isActive", $isActive);
				$objDaycaregeneral->setProperty("entery_date", $entery_date);
				if($objDaycaregeneral->actAllergyList($mode)){
						
					echo json_encode(array('status'=> true, 'id'=>$allergy_id));
				}
				
			} else {
				echo json_encode($vResult);	
			}
			
			
			
} else {
$AllergyListArray = array();
$objDaycaregeneral->setProperty("isActive", 1);
$objDaycaregeneral->setProperty("ORDERBY", 'allergy_id');
$objDaycaregeneral->lstAllergyList();
while($ListAllergyList = $objDaycaregeneral->dbFetchArray(1)){

$AllergyListArray[] = array('id'=>$ListAllergyList["allergy_id"], 'centerid'=>$ListAllergyList["center_id"], 'userid'=>$ListAllergyList["user_id"], 'title'=>$ListAllergyList["allergy_title"], 'desc'=>$ListAllergyList["allergy_desc"], 'status'=>$ListAllergyList["isActive"]);
}
echo json_encode($AllergyListArray, true);
}
?>