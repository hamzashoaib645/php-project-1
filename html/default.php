<?php 
include_once(ACTION_PATH.'script.php');
if(!isset($_GET['show']) || empty($_GET['show']))
	include_once(HTML_PATH . 'home.php');
else{
	$inc_page = getPage($_GET['show']);
	include_once($inc_page);
}

?>