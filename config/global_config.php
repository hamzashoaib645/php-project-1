<?php
	$_CONFIG['site_name'] 			= "DayCare Management System";
	$_CONFIG['site_short_name'] 	= "DayCare Management System";
	$_CONFIG['admin_email'] 		= "info@daycare.com";
	$MetaTitle						= "meta_title";
	$MetaDesc						= "meta_desc";
	$MetaKeywords					= "meta_keywords";
	global $SITE_URL;

if($_SERVER['HTTP_HOST'] == "localhost"){# For local

	$_CONFIG['site_url'] 		= $_SERVER['REQUEST_SCHEME']."://localhost/daycare/";
	$_CONFIG['site_path'] 		= $_SERVER['DOCUMENT_ROOT'] . "/daycare/";
	$_CONFIG['client_site_url']	= $_SERVER['REQUEST_SCHEME']."://localhost/daycare/";
	$CallAssetsFolfer = 2;
	$CallMenuBarAndHeader = '_ig';
	
} else { # For Web

//	$_CONFIG['site_url']          = "http://".$_SERVER['SERVER_NAME']."/";
//	$_CONFIG['site_path']         = $_SERVER['DOCUMENT_ROOT'] . "/";
	$_CONFIG['site_url'] 		= $_SERVER['REQUEST_SCHEME']."://".$_SERVER['SERVER_NAME']."/";
	$_CONFIG['site_path'] 		= $_SERVER['DOCUMENT_ROOT'] . "/";
//	$_CONFIG['client_site_url']	= $_SERVER['REQUEST_SCHEME']."://localhost/shrclient/";
	$CallAssetsFolfer = 2;
	$CallMenuBarAndHeader = '_ig';
	
}

$SaltOpt_1 									= "SHRMarketing360";
$SaltOpt_2 									= 'a3f7a3d050ecaf39210582a7c0e747e0';
$_CONFIG['domain_code'] 					= "0";
$_CONFIG['file_ext'] 						= ".html";
$_CONFIG['site_folder'] 					= "/"; //  change this to only / if the site is in LIVE without any folder.
$_CONFIG['html_path'] 						= $_CONFIG['site_path'] . "html/";
$_CONFIG['html_url'] 						= $_CONFIG['site_url'] . "html/";
$_CONFIG['ajax_path'] 						= $_CONFIG['site_path'] . "ajax_html/";
$_CONFIG['ajax_url'] 						= $_CONFIG['site_url'] . "ajax_html/";
$_CONFIG['inc_path'] 						= $_CONFIG['site_path'] . "includes/";
//$_CONFIG['encryption_key'] 		= md5(hash('sha512', $Salt . $Password . $Salt));
$_CONFIG['encryption_key'] 					= md5(hash('sha512', $SaltOpt_1 .  $SaltOpt_2));

// Action pages path
$_CONFIG['action_path'] 					= $_CONFIG['site_path'] . "actions/";
$_CONFIG['action_url'] 						= $_CONFIG['site_url'] . "actions/";

// Classses pages path
$_CONFIG['class_path']   					= $_CONFIG['site_path'] . "classes/";
$_CONFIG['class_url']    					= $_CONFIG['site_url'] . "classes/";

$_CONFIG['images_url'] 						= $_CONFIG['site_url'] . "images/";

// Security/Captcha path
$_CONFIG['sec_path'] 						= $_CONFIG['site_path'] . "security/";
$_CONFIG['sec_url'] 						= $_CONFIG['site_url'] . "security/";

// Editor path
$_CONFIG['editor_path'] 					= $_CONFIG['site_url'] . "jscript/";

// Editor path
$_CONFIG['security_path'] 					= $_CONFIG['site_path'] . "security/";
$_CONFIG['security_url'] 					= $_CONFIG['site_url'] . "security/";

// Template paths
$_CONFIG['template_url'] 					= $_CONFIG['site_url'] . "email_template/";
$_CONFIG['template_path'] 					= $_CONFIG['site_path'] . "email_template/";

// Company Logo Path
$_CONFIG['photo_bank_url'] 					= $_CONFIG['site_url'] . "photo_bank/";
$_CONFIG['photo_bank_path']					= $_CONFIG['site_path'] . "photo_bank/";

//Company Leads
$_CONFIG['company_lead_url'] 				= $_CONFIG['photo_bank_url'] . "company_leads/excl/";
$_CONFIG['company_lead_path']				= $_CONFIG['photo_bank_path'] . "company_leads/excl/";

// Company Logo Path
$_CONFIG['company_log_url'] 				= $_CONFIG['photo_bank_url'] . "company_logo/orig/";
$_CONFIG['company_log_path']				= $_CONFIG['photo_bank_path'] . "company_logo/orig/";
$_CONFIG['company_log_thumb_url'] 			= $_CONFIG['photo_bank_url'] . "company_logo/thumb/";
$_CONFIG['company_log_thumb_path']			= $_CONFIG['photo_bank_path'] . "company_logo/thumb/";

// Company Project Images
$_CONFIG['company_proj_url'] 				= $_CONFIG['photo_bank_url'] . "company_project/orig/";
$_CONFIG['company_proj_path']				= $_CONFIG['photo_bank_path'] . "company_project/orig/";
$_CONFIG['company_proj_thumb_url'] 			= $_CONFIG['photo_bank_url'] . "company_project/thumb/";
$_CONFIG['company_proj_thumb_path']			= $_CONFIG['photo_bank_path'] . "company_project/thumb/";

// Company Property Images
$_CONFIG['company_prop_url'] 				= $_CONFIG['photo_bank_url'] . "company_property/orig/";
$_CONFIG['company_prop_path']				= $_CONFIG['photo_bank_path'] . "company_property/orig/";
$_CONFIG['company_prop_thumb_url'] 			= $_CONFIG['photo_bank_url'] . "company_property/thumb/";
$_CONFIG['company_prop_thumb_path']			= $_CONFIG['photo_bank_path'] . "company_property/thumb/";

// Company User Path
$_CONFIG['company_url']		 				= $_CONFIG['photo_bank_url'] . "company_user/";
$_CONFIG['company_path']					= $_CONFIG['photo_bank_path'] . "company_user/";

// Company User Profile Path
$_CONFIG['user_profile_url'] 				= $_CONFIG['company_url'] . "profile/orig/";
$_CONFIG['user_profile_path']				= $_CONFIG['company_path'] . "profile/orig/";
$_CONFIG['user_profile_200_url'] 			= $_CONFIG['company_url'] . "profile/200/";
$_CONFIG['user_profile_200_path']			= $_CONFIG['company_path'] . "profile/00/";
$_CONFIG['user_profile_thumb_url'] 			= $_CONFIG['company_url'] . "profile/thumb/";
$_CONFIG['user_profile_thumb_path']			= $_CONFIG['company_path'] . "profile/thumb/";

// Company User Signature Path
$_CONFIG['user_signature_url'] 				= $_CONFIG['company_url'] . "signature/orig/";
$_CONFIG['user_signature_path']				= $_CONFIG['company_path'] . "signature/orig/";
$_CONFIG['user_signature_thumb_url'] 		= $_CONFIG['company_url'] . "signature/thumb/";
$_CONFIG['user_signature_thumb_path']		= $_CONFIG['company_path'] . "signature/thumb/";

// Company Customer Path
$_CONFIG['customer_url']	 				= $_CONFIG['photo_bank_url'] . "company_customer/";
$_CONFIG['customer_path']					= $_CONFIG['photo_bank_path'] . "company_customer/";

// Company Customer Profile Path
$_CONFIG['customer_profile_url'] 			= $_CONFIG['customer_url'] . "profile/orig/";
$_CONFIG['customer_profile_path']			= $_CONFIG['customer_path'] . "profile/orig/";
$_CONFIG['customer_profile_200_url'] 		= $_CONFIG['customer_url'] . "profile/200/";
$_CONFIG['customer_profile_200_path']		= $_CONFIG['customer_path'] . "profile/00/";
$_CONFIG['customer_profile_thumb_url'] 		= $_CONFIG['customer_url'] . "profile/thumb/";
$_CONFIG['customer_profile_thumb_path']		= $_CONFIG['customer_path'] . "profile/thumb/";

// Company Customer Signature Path
$_CONFIG['customer_signature_url'] 			= $_CONFIG['customer_url'] . "signature/orig/";
$_CONFIG['customer_signature_path']			= $_CONFIG['customer_path'] . "signature/orig/";
$_CONFIG['customer_signature_thumb_url'] 	= $_CONFIG['customer_url'] . "signature/thumb/";
$_CONFIG['customer_signature_thumb_path']	= $_CONFIG['customer_path'] . "signature/thumb/";

// Company Customer Document Path
$_CONFIG['customer_document_url'] 			= $_CONFIG['customer_url'] . "document/orig/";
$_CONFIG['customer_document_path']			= $_CONFIG['customer_path'] . "document/orig/";
$_CONFIG['customer_document_thumb_url'] 	= $_CONFIG['customer_url'] . "document/thumb/";
$_CONFIG['customer_document_thumb_path']	= $_CONFIG['customer_path'] . "document/thumb/";

// Company User Document Path
$_CONFIG['user_document_url'] 				= $_CONFIG['company_url'] . "document/orig/";
$_CONFIG['user_document_path']				= $_CONFIG['company_path'] . "document/orig/";
$_CONFIG['user_document_thumb_url'] 		= $_CONFIG['company_url'] . "document/thumb/";
$_CONFIG['user_document_thumb_path']		= $_CONFIG['company_path'] . "document/thumb/";

// Buyer Profile Image
$_CONFIG['buyer_img_orig_url'] 				= $_CONFIG['photo_bank_url'] . "buyer_profile_photo/orig/";
$_CONFIG['buyer_img_orig_path']				= $_CONFIG['photo_bank_path'] . "buyer_profile_photo/orig/";
$_CONFIG['buyer_img_100_url'] 				= $_CONFIG['photo_bank_url'] . "buyer_profile_photo/100/";
$_CONFIG['buyer_img_100_path']				= $_CONFIG['photo_bank_path'] . "buyer_profile_photo/100/";
$_CONFIG['buyer_img_150_url'] 				= $_CONFIG['photo_bank_url'] . "buyer_profile_photo/150/";
$_CONFIG['buyer_img_150_path']				= $_CONFIG['photo_bank_path'] . "buyer_profile_photo/150/";
$_CONFIG['buyer_img_200_url'] 				= $_CONFIG['photo_bank_url'] . "buyer_profile_photo/200/";
$_CONFIG['buyer_img_200_path']				= $_CONFIG['photo_bank_path'] . "buyer_profile_photo/200/";
$_CONFIG['buyer_img_500_url'] 				= $_CONFIG['photo_bank_url'] . "buyer_profile_photo/500/";
$_CONFIG['buyer_img_500_path']				= $_CONFIG['photo_bank_path'] . "buyer_profile_photo/500/";

// Profile Image
$_CONFIG['profile_img_url'] 				= $_CONFIG['site_url'] . "profile_img/";
$_CONFIG['profile_img_path']				= $_CONFIG['site_path'] . "profile_img/";
$_CONFIG['profile_thumb_url'] 				= $_CONFIG['profile_img_url'] . "thumb/";
$_CONFIG['profile_thumb_path']				= $_CONFIG['profile_img_path'] . "thumb/";


// Slider Path
$_CONFIG['slider_url'] 						= $_CONFIG['site_url'] . "slider/";
$_CONFIG['slider_path'] 					= $_CONFIG['site_path'] . "slider/";

// Country
$_CONFIG['SITE_COUNTRY']					= $_SESSION['site_country'];

// Date format
$_CONFIG['date_format'] 					= 'Y-m-d'; # should be PHP supported date formats

// Product Image
$_CONFIG['prd_full_image_w'] 				= 340;
$_CONFIG['prd_full_image_h'] 				= 340;
$_CONFIG['prd_thumb_image_w'] 				= 75;
$_CONFIG['prd_thumb_image_h'] 				= 75;
$_CONFIG['prd_admin_image_w'] 				= 150;
$_CONFIG['prd_admin_image_h'] 				= 150;

/*
											if(date("d") >= '01' && date("d") <= '20'){
												//echo 'Case-1';
//Salary Start Date
$_CONFIG['salary_start_date']				= date("Y").'-'.date('m', strtotime('last month')).'-21';
//Salary End Date
$_CONFIG['salary_end_date']					= '2019-'.date('m', strtotime('this month')).'-20';
											} else {
												//echo 'Case-2';
//Salary Start Date
$_CONFIG['salary_start_date']				= '2019-'.date('m', strtotime('this month')).'-21';
//Salary End Date
$_CONFIG['salary_end_date']					= '2019-'.date('m', strtotime(date("Y-m-d"). ' + 1 month')).'-20';
											}
*/
//Salary Start Date
$_CONFIG['salary_start_date']				= date("Y-m").'-01';
//Salary End Date
$_CONFIG['salary_end_date']					= date('Y-m-d', strtotime('last day of this month'));

$_CONFIG['report_start_date']				= date("Y-m").'-01';
$_CONFIG['report_end_date']					= date('Y-m-d', strtotime('last day of this month'));
//Salary Start Date
//$_CONFIG['salary_start_date']				= '2019-'.date('m', strtotime('last month')).'-21';

//Salary End Date
//$_CONFIG['salary_end_date']					= '2019-'.date('m', strtotime('this month')).'-20';


// Facebook config
$_CONFIG['facebook_url']					= '';
$_CONFIG['PAYPAL_URL']						= 'https://www.paypal.com/cgi-bin/webscr';

//Zong SMS API Detail
$ZongSmSAPI									= 'http://cbs.zong.com.pk/reachcwsv2/corporatesms.svc?wsdl';
//$ZongAPI 									= new SoapClient($ZongSmSAPI, array("trace" =>1, "exception" =>0));
//try {
//} catch (SoapFault $fault){
//echo $fault->faultstring;
//}

$ZongSMSAPILoginId							= '923109244351';
$ZongSMSAPIPassword							= '123';

// Action Path
$_CONFIG['action_path'] 		= $_CONFIG['site_path'] . "actions/";
$_CONFIG['action_url'] 			= $_CONFIG['site_url'] . "actions/";

// 
$_CONFIG['lang'] 				= 'EN';
$_CONFIG['site_currency'] 		= 'Rs'; # EUR | GBP | 
$_CONFIG['currency_symbol'] 	= '$'; # EUR | GBP | 
$_CONFIG['code_length'] 		= 6;

$_CONFIG['ProDes_Limit']		= "150";
$_CONFIG['PERPAGE']				= "20";
$_CONFIG['per_page_data'] 		= 24;
$_CONFIG['offset'] 				= 10;
$_CONFIG['TT_DATA']		 		= 10;
$_CONFIG['REPROT_LIMIT'] 		= 5;

// Image
$_CONFIG['d_full_image_max_w'] 	= 340;
$_CONFIG['d_thumb_w'] 			= 340;

// Mode Re-write
$_CONFIG['mod_rewrite'] 		= 'true'; // false | true

//Product Taxes
$_CONFIG['pro_taxes'] 			= 0;
?>