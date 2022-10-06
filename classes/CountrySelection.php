<?php
/**
*
* This is a class Customer
* @version 0.01
* @author Numan Tahir <numantahir1@gmail.com>
*
**/
class CountrySel extends Database{
	public $site_country;
	public $country_status;

	/**
	* This is the constructor of the class Customer
	* @author Numan Tahir <numantahir1@gmail.com>
	*/
	public function __construct(){
		parent::__construct();

			$this->site_country 	= $_SESSION['site_country'];
			$this->country_status	= $_SESSION['country_status'];
	}

	/**
	* This is the function to set the customer logged in
	* @author Numan Tahir
	*/
	public function setCountryMake(){
	
		# Logged in customer's member code
		if($this->isPropertySet("site_country", "V"))
			$_SESSION['site_country'] 		= $this->getProperty("site_country");
		
		# Logged in customer's email
		if($this->isPropertySet("country_status", "V"))
			$_SESSION['country_status'] = $this->getProperty("country_status");
		
	}
	
}
?>