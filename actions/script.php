<?php
$objCommon 				= new Common;
$objMail 				= new Mail;
$objValidate 			= new Validate;
$objDaycaregeneral		= new Daycaregeneral;
$objBF 					= new Crypt_Blowfish('CBC');
$EmployeeMenu 			= '';

$objBF->setKey($cipher_key);

if($_GET["show"] == 'allergies'){
include_once(ACTION_PATH.'allergies.php');
/******************************************************************************/
////////////////////////////////////////////////////////////////////////////////
/******************************************************************************/
}
?>