<?php
/**
*
* This is a class which is the collection of database related methods
* @version 0.01
* @author Numan Tahir  <numan_tahir1@live.com>
*
**/
class Database extends Property{
	
	protected $dbCon;			/* member variable that holds the database connectivity resource */
	protected $rsResource;	/* member variable that holds the result/resource */
	protected $sql;
	//var @$dbResource;

	/**
	* This is the constructor of the class Database
	* which initializes the database connectivity
	* @author Numan Tahir
	*/
	public function __construct(){
		$this->dbCon = mysqli_connect(HOST, DBUSER, DBPASSWD, DBNAME);
		if(!$this->dbCon)
			die('Could not connect to the server. Check in config.php');
			//die(mysqli_connect_error());
	}

	/**
	* This method is used to execute the query
	* @author Numan Tahir
	* @param : $sql
	*/
	public function dbQuery($sql = ""){
		if(!$sql || $sql == ""){
			die('Empty SQL statement found!');
		}      
		//$result=mysqli_query($this->dbCon,$sql);
		//return mysqli_fetch_array($result,MYSQLI_ASSOC);
        $this->rsResource = mysqli_query($this->dbCon,$sql);
		if(!$this->rsResource){
			
			include_once(dirname(__FILE__) . '/error/index.php');
			die();
			echo '<pre style="color:#FF000;">';
			echo isset($sql);
			echo '</pre>';
			echo '<strong>System generated error:</strong><br>';
			die(mysqli_error($this->dbCon));
			return false;
		}
		else{
			$this->sql = $sql;
			return true;
		}
	}
	
	/**
	* This method is used to execute the query and return the resource
	* @author Numan Tahir
	* @param : $sql
	* @return : resource / result
	*/
	public function dbQueryReturn($sql = ""){
		if(!$sql || $sql == ""){
			die('Empty SQL statement found!');
		}
		$this->rsResource = mysqli_query($this->dbCon, $sql);
		if($this->rsResource){
			$this->sql = $sql;
			return $this->rsResource;
		}
		else{
			return false;
		}
	}
	
	/**
	* This method is used to get the current sql;
	* @author Numan Tahir
	* @return : integer
	*/
	public function getSQL(){
		//if(is_resource($this->rsResource) && $this->sql){
		  if($this->rsResource && $this->sql){
			return $this->sql;
		}
	}
	
	public function SQLTestFunc(){
		  /*if($this->rsResource && $this->sql){
			return $this->sql;
		}*/
		//return mysqli_get_client_info();
		//return mysqli_get_client_stats();
		//return mysqli_get_connection_stats($this->dbCon);
		//return mysqli_info($this->dbCon);
		//return mysqli_thread_id($this->dbCon);
		//mysqli_kill();
	}

	/**
	* This method is used to get the total records of a result
	* @author Numan Tahir
	* @return : integer
	* Modify: is_resource function disable in PHP7
	*/
	public function totalRecords(){
		//if(is_resource($this->rsResource)){
		if($this->rsResource){
			return mysqli_num_rows($this->rsResource);
		}
	}
	
	/**
	* This method is used to fetch the result/resource row as associative array
	* @author Numan Tahir
	* @param : $retType = return array type (1=ASSOC / 2 = NUM / 3 = OBJECT)
	* @param : $dbResource = query resource/result
	* @return : Array
	*/
    
	public function dbFetchArray($retType = 1){
		//if(is_resource(@$dbResource)){
		if(@$dbResources){
			if($retType == 1)
				return mysqli_fetch_array(@$dbResource, MYSQLI_ASSOC);
			else if($retType == 2)
				return mysqli_fetch_assoc(@$dbResource);
			else if($retType == 3)
				return mysqli_fetch_object(@$dbResource);
		}
		//else if(is_resource($this->rsResource)){
	     else if($this->rsResource){
			if($retType == 1)
				return mysqli_fetch_array($this->rsResource, MYSQLI_ASSOC);
			else if($retType == 2)
				return mysqli_fetch_assoc($this->rsResource);
			else if($retType == 3)
				return mysqli_fetch_object($this->rsResource);
		}
		else{
			die('Invalid resource!');
		}
	}
	
    /*public function dbFetchArray($retType = 1){
        if($this->rsResource){
     
			if($retType == 1)
				return mysqli_fetch_array($this->rsResource, MYSQLI_ASSOC);
			else if($retType == 2)
				return mysqli_fetch_assoc($this->rsResource);
			else if($retType == 3)
				return mysqli_fetch_object($this->rsResource);
		}
		else{
			die('Invalid resource!');
		}
	}*/
	/**
	* This method is used to free the database result/resource
	* @author Numan Tahir
	* @return : bool
	*/
	public function dbFree($dbResource){
		//if(is_resource(@$dbResource)){
		if(@$dbResource){
			mysqli_free_result(@$dbResource);
		}
		//else if(is_resource($this->rsResource)){
		else if($this->rsResource){
			mysqli_free_result($this->rsResource);
		}
	}

	/**
	* This method is used to append the limiting sql
	* @author Numan Tahir
	* @return : bool
	*/
	public function appendLimit($perpage){
		$page = isset($_GET['page']) ? trim($_GET['page']) : 1;
		$start = (intval($page) - 1) * $perpage;
		$Sql = " LIMIT $start, $perpage";
		return $Sql;
	}
	
	/*
	* This method is used to append the limiting sql
	* @author Numan Tahir
	* @return : bool
	*/
	public function getTotal($sql){
		$result = mysqli_query($sql) or die(mysqli_error());
		$rows = mysqli_fetch_array($result);
		if(!empty($rows['total_records']) && $rows['total_records'] >= 1){
			return $rows['total_records'];
		}
		else{
			return 0;
		}
	}
	
	public function __destruct() {
		mysqli_close($this->dbCon);
    }
	
}