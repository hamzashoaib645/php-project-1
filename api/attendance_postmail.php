<?php
require_once("../config/config.php");
require_once("../zklib/zklib.php");
$objCommon 					= new Common;
$objQayaduser 			= new Qayaduser;
$objQayaddevice 			= new Qayaddevice;
$objQayadattendance		= new Qayadattendance;
$objQayadCattendance		= new Qayadattendance;
$objQayadCTattendance	= new Qayadattendance;
$objQayadaUttendance		= new Qayadattendance;

$DeviceNumber = array();
$objQayaddevice->resetProperty();
$objQayaddevice->setProperty("device_id", 1);
$objQayaddevice->setProperty("ORDERBY", 'device_id');
$objQayaddevice->lstDevice();
while($DeviceList = $objQayaddevice->dbFetchArray(1)){
    $zk = new ZKLib(trim($DeviceList["device_ip"]), trim($DeviceList["device_port"]));
    $ret = $zk->connect();
    sleep(1);
    if ( $ret ): 
        $zk->disableDevice();
        sleep(1);
		$DeviceNumber[$DeviceList["device_id"]] = $attendance = $zk->getAttendance();
        $zk->enableDevice();
        sleep(1);
        $zk->disconnect();
    endif;
	}

$array = array();
$array['code'] = "TransferCronData";
$array['data'] = $DeviceNumber;
 
$data = json_encode($array);
$ch = curl_init('http://portal.Qayad.com/mycronjob_mix/att_cron.php');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                     
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);                   
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
$result = curl_exec($ch);
echo '<pre>';
echo $result;
echo '</pre>';
?>
<script type="text/javascript">window.close();</script>