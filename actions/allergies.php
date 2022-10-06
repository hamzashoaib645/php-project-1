<?php
/*$mode = 'I';
if($_SERVER['REQUEST_METHOD'] == "POST"){

	$objRoute 			= new Route;
	$objQayadProerty->resetProperty();

	$project_id				= trim($_POST['project_id']);
	$project_name			= trim($_POST['project_name']);
	$project_description	= trim($_POST['project_description']);
	$project_location		= trim($_POST['project_location']);
	$project_contact_number	= trim($_POST['project_contact_number']);
	$project_type			= trim($_POST['project_type']);
	$mode 					= trim($_POST['mode']);
	$isActive				= trim($_POST["isActive"]);
	$entery_datetime		= date('Y-m-d H:i:s');
	
	$objValidate->setArray($_POST);
	$objValidate->setCheckField("project_name", _PROJECT_NAME . _IS_REQUIRED_FLD, "S");
	$objValidate->setCheckField("project_location", _PROJECT_LOCATION . _IS_REQUIRED_FLD, "S");
	$vResult = $objValidate->doValidate();
	// See if any error are not returned
	if(!$vResult){
				
				$objQayadProerty->resetProperty();
				$project_id = ($_POST['mode'] == "U") ? trim($objBF->decrypt($_POST['project_id'], 1, ENCRYPTION_KEY)) : $objQayadProerty->genCode("rs_tbl_projects", "project_id");
				
				$objQayadProerty->resetProperty();
				$objQayadProerty->setProperty("project_id", $project_id);
				$objQayadProerty->setProperty("project_name", $project_name);
				$objQayadProerty->setProperty("project_description", $project_description);
				$objQayadProerty->setProperty("project_location", $project_location);
				$objQayadProerty->setProperty("project_contact_number", $project_contact_number);
				$objQayadProerty->setProperty("project_type", $project_type);
				$objQayadProerty->setProperty("entery_datetime", $entery_datetime);
				$objQayadProerty->setProperty("isActive", $isActive);
				if($objQayadProerty->actProjects($mode)){
						
				$objQayadProerty->resetProperty();
				$objQayadProerty->setProperty("user_id", trim($objBF->decrypt($objQayaduser->user_id, 1, ENCRYPTION_KEY)));
				$objQayadProerty->setProperty("property_id", $project_id);
				$objQayadProerty->setProperty("entery_date", date('Y-m-d H:i:s'));
				if($mode == 'I'){
				$objQayadProerty->setProperty("log_desc", "Add New Project Detail -> (Name". $project_name .")");
				} else {
				$objQayadProerty->setProperty("log_desc", "Admin Edit Project Detail -> (Name". $project_name .")");
				}
				$objQayadProerty->actPropertyLog("I");
						
						$link = Route::_('show=projects');
						redirect($link);
				}
				
			}
	} else {
			
if(isset($_GET['i']) && !empty($_GET['i']))
		$project_id = $_GET['i'];
	else if(isset($_POST['project_id']) && !empty($_POST['project_id']))
		$project_id = $_POST['project_id'];
	if(isset($project_id) && !empty($project_id)){
		$objQayadProerty->setProperty("project_id", trim($objBF->decrypt($project_id, 1, ENCRYPTION_KEY)));
		$objQayadProerty->lstProjects();
		$data = $objQayadProerty->dbFetchArray(1);
		$mode	= "U";
		extract($data);	
	}
}*/