<?php
/**
*
* The class Route
* @version 0.01
* @author Numan Tahir  <numantahir1@gmail.com>
*
**/
class Route extends Database{

	/**
	* This is the constructor of the class Route
	* @author Numan Tahir
	*/
	public function __construct(){
		parent::__construct();
	}

	/**
	* This function is used to prepare the url
	* @author Numan Tahir
	*/
	public static function _($url = ''){
		$ret = SITE_URL;
		if(MOD_REWRITE == 'false'){
			if(!empty($url)):
				$ret .= '?' . $url;
			endif;
		}
		else{
			$qs = explode('&', $url);
			$total = count($qs);
			list($page, $show) = explode('=', $qs[0]);
			unset($qs[0]);
			$qstring = $show;
			
			if($qs[1]){
				list($k, $v) = explode('=', $qs[1]);
				if($show == 'news' && $k == 'news_id'){
					unset($qs[1]);
					$objLeagues = new Leagues;
					$objLeagues->setProperty('news_id', $v);
					$objLeagues->lstNewsFeature();
					$row_prd = $objLeagues->dbFetchArray(1);
					$qstring .= '/' . $row_prd['url_link'];
				}
				else if($show == 'profile' && $k == 'profile_id'){
					unset($qs[1]);
					$objCustomer = new Customer;
					$objCustomer->setProperty('customer_id', $v);
					//$objCustomer->setProperty('user_type', 1);
					$objCustomer->lstCustomer();
					$row_prd = $objCustomer->dbFetchArray(1);
					$qstring .= '/' . $row_prd['url_key'];
				}
				else if($show == 'products' && $k == 'category_id'){
					unset($qs[1]);
					$objCategory = new Product;
					$objCategory->setProperty('category_id', $v);
					$objCategory->lstCategory();
					$row_prd = $objCategory->dbFetchArray(1);
					$qstring .= '/' . $row_prd['url_key'];
				}
				else if($show == 'product' && $k == 'product_id'){
					unset($qs[1]);
					$objCategory = new Product;
					$objCategory->setProperty('product_id', $v);
					$objCategory->lstProducts();
					$row_prd = $objCategory->dbFetchArray(1);
					$qstring .= '/' . $row_prd['url_key'];
				}
				else if($show == 'category' && $k == 'category_id'){
					unset($qs[1]);
					$objCategory = new Product;
					$objCategory->setProperty('category_id', $v);
					$objCategory->lstCategory();
					$row_prd = $objCategory->dbFetchArray(1);
					$qstring .= '/' . $row_prd['url_key'];
				}
				else if($show == 'tag' && $k == 'tag_id'){
					unset($qs[1]);
					$objTags = new Product;
					$objTags->setProperty('tags_id', $v);
					$objTags->lstProductTags();
					$row_prd_tags = $objTags->dbFetchArray(1);
					$qstring .= '/' . $row_prd_tags['tag_url'];
				}
				else if($show == 'blog' && $k == 'product_id'){
					unset($qs[1]);
					$objBlogProduct = new Product;
					$objBlogProduct->setProperty('product_id', $v);
					$objBlogProduct->lstProducts();
					$row_blog_prd = $objBlogProduct->dbFetchArray(1);
					$qstring .= '/' . $row_blog_prd['url_key'];
				}
				else if($show == '1' && $k == 'profile_id'){
					unset($qs[1]);
					$objCustomer = new Customer;
					$objCustomer->setProperty('customer_id', $v);
					//$objCustomer->setProperty('user_type', 1);
					$objCustomer->lstCustomer();
					$row_prd = $objCustomer->dbFetchArray(1);
					$qstring .= '/' . $row_prd['url_key'];
				}
				else if($show == 'cms' && $k == 'content'){
					unset($qs[1]);
					$qstring .= '/' . $v;
				}
				else if($show == 'cpanel' && $k == 'callpage'){
					unset($qs[1]);
					$qstring .= '/' . $v;
				}
			}

			if(!empty($url))
				$qstring .= '/';
			
			if(isset($qs[1]))
				$start = 1;
			else if(isset($qs[2]))
				$start = 2;
			if($qs[$start]){
				$qstring .= '?';
				for($i = $start; $i < $total; $i++):
					list($k1, $v1) = explode('=', $qs[$i]);
					$qstring .= $k1 . '=' . $v1 . '&';
				endfor;
			}
			if($show == 'products' && $v == 16){
				//echo $qstring;
			}
			$qstring = preg_replace('/\&$/', '', $qstring);
			$ret .= $qstring;
		}
		return $ret;
	}
	//
	/**
	* This function is used to prepare the category url key
	* @author Numan Tahir
	*/
	public function getUserKey($name, $customer_id = 0){
		$find 		= array(' ', '_', '&', '%', ':', "'", "|", "!", '"', '(', ')', '[', ']', '.', ',', '/', '\\', '=', '+', '*', '#');
		$replace 	= '-';
		$key 		= str_replace($find, $replace, strtolower($name));
		$key		= str_replace('--', $replace, $key);
		$key		= str_replace('--', $replace, $key);
		$key		= preg_replace('/\-$/', '', $key);
		
		// check if already 
		$Sql = "SELECT url_key FROM rs_tbl_customer WHERE url_key LIKE '" . $key . "%'";
		if(!empty($category_id)){
			$Sql .= " AND customer_id!=" . $customer_id;
		}
		$this->dbQuery($Sql);
		if($this->totalRecords() >= 1){
			$key = $key . '-' . $this->totalRecords();
		}
		return $key;
	}
	
	/**
	* This function is used to prepare the category url key
	* @author Numan Tahir
	*/
	public function getCategoryKey($name, $category_id = 0){
		$find 		= array(' ', '_', '&', '%', ':', "'", '"', '(', ')', '[', ']', '.', ',', '/', '\\', '=', '+', '*', '#');
		$replace 	= '-';
		$key 		= str_replace($find, $replace, strtolower($name));
		$key		= str_replace('--', $replace, $key);
		$key		= str_replace('--', $replace, $key);
		$key		= preg_replace('/\-$/', '', $key);
		
		// check if already 
		$Sql = "SELECT url_key FROM rs_tbl_category WHERE url_key LIKE '" . $key . "%'";
		if(!empty($category_id)){
			$Sql .= " AND category_id!=" . $category_id;
		}
		$this->dbQuery($Sql);
		if($this->totalRecords() >= 1){
			$key = $key . '-' . $this->totalRecords();
		}
		return $key;
	}
	
	
	/**
	* This function is used to prepare the News url key
	* @author Numan Tahir
	*/
	public function getNewsKey($name, $news_id = 0){
		$find 		= array(' ', '_', ':', '&', '%', "'", "?", '"', '(', ')', '[', ']', '.', ',', '/', '\\', '=', '+', '*', '#');
		$replace 	= '-';
		$key 		= str_replace($find, $replace, strtolower($name));
		$key		= str_replace('--', $replace, $key);
		$key		= str_replace('--', $replace, $key);
		$key		= preg_replace('/\-$/', '', $key);
		
		// check if already 
		$Sql = "SELECT url_link FROM news_features WHERE url_link LIKE '" . $key . "%'";
		if(!empty($category_cd)){
			$Sql .= " AND news_id!=" . $news_id;
		}
		$this->dbQuery($Sql);
		if($this->totalRecords() >= 1){
			$key = $key . '-' . $this->totalRecords();
		}
		return $key;
	}
	
	/**
	* This function is used to prepare the Content url key
	* @author Numan Tahir
	*/
	public function getContentKey($name, $cms_id = 0){
		$find 		= array(' ', '_', '&', ':', '%', "'", '"', '(', ')', '[', ']', '.', ',', '/', '\\', '=', '+', '*', '#');
		$replace 	= '-';
		$key 		= str_replace($find, $replace, strtolower($name));
		$key		= str_replace('--', $replace, $key);
		$key		= str_replace('--', $replace, $key);
		$key		= preg_replace('/\-$/', '', $key);
		
		// check if already 
		$Sql = "SELECT cms_type FROM rs_tbl_contents WHERE cms_type LIKE '" . $key . "%'";
		if(!empty($cms_cd)){
			$Sql .= " AND cms_id!=" . $cms_id;
		}
		$this->dbQuery($Sql);
		if($this->totalRecords() >= 1){
			$key = $key . '-' . $this->totalRecords();
		}
		return $key;
	}
	
	/**
	* This function is used to prepare the User url key
	* @author Numan Tahir
	*/
	public function getCustomerKey($name, $customer_id = 0){
		$find 		= array(' ', '_', '&', ':', '%', "'", '"', '(', ')', '[', ']', '.', ',', '/', '\\', '=', '+', '*', '#');
		$replace 	= '-';
		$key 		= str_replace($find, $replace, strtolower($name));
		$key		= str_replace('--', $replace, $key);
		$key		= str_replace('--', $replace, $key);
		$key		= preg_replace('/\-$/', '', $key);
		
		// check if already 
		$Sql = "SELECT url_key FROM rs_tbl_customer WHERE url_key LIKE '" . $key . "%'";
		if(!empty($customer_id)){
			$Sql .= " AND customer_id!=" . $customer_id;
		}
		$this->dbQuery($Sql);
		if($this->totalRecords() >= 1){
			$key = $key . '-' . $this->totalRecords();
		}
		return $key;
	}
	
	/**
	* This function is used to prepare the category url key
	* @author Numan Tahir
	*/
	public function getProductKey($name, $product_id = 0){
		$find 		= array(' ', "'", '_', '&', '%', ':', "'", "|", "!", '"', '(', ')', '[', ']', '.', ',', '/', '\\', '=', '+', '*', '#');
		$replace 	= '-';
		$key 		= str_replace($find, $replace, strtolower($name));
		$key		= str_replace('--', $replace, $key);
		$key		= str_replace('--', $replace, $key);
		$key		= preg_replace('/\-$/', '', $key);
		
		// check if already 
		$Sql = "SELECT url_key FROM rs_tbl_products WHERE url_key LIKE '" . $key . "%'";
		if(!empty($product_cd)){
			$Sql .= " AND product_id!='" . $product_id . "'";
		}
		$this->dbQuery($Sql);
		if($this->totalRecords() >= 1){
			$key = $key . '-' . $this->totalRecords();
		}
		return $key;
	}

}
?>