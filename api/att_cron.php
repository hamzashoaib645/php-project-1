<?php
require_once("config/config.php");
require_once("zklib/zklib.php");
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
		//echo $DeviceList["device_ip"].'<br>';
		$DeviceNumber[$DeviceList["device_id"]] = $attendance = $zk->getAttendance();
        $zk->enableDevice();
        sleep(1);
        $zk->disconnect();
    endif;
	}

$objQayaddevice->resetProperty();
$objQayaddevice->setProperty("device_id", 1);
$objQayaddevice->setProperty("ORDERBY", 'device_id');
$objQayaddevice->lstDevice();
while($DeviceList = $objQayaddevice->dbFetchArray(1)){
	//echo $DeviceList["device_id"];
	while(list($idx, $attendancedata) = each($DeviceNumber[$DeviceList["device_id"]])):
	
		if(date("a", strtotime($attendancedata[3])) == 'am' && date("h", strtotime($attendancedata[3])) >= '12'){
			$AttendanceDateRec = date('Y-m-d', strtotime("-1 day", strtotime($attendancedata[3])));
			list($AttDay,$AttMonth,$AttYear)= explode('-', $AttendanceDateRec);
			$EnteryDateFormate = $AttYear.'-'.$AttMonth.'-'.$AttDay;
			$GetDateRawFormate = gregoriantojd($AttMonth,$AttDay,$AttYear);
		} else {
			$AttendanceDateRec = trim(date("d-m-Y", strtotime($attendancedata[3])));
			list($AttDay,$AttMonth,$AttYear)= explode('-', $AttendanceDateRec);
			$EnteryDateFormate = $AttYear.'-'.$AttMonth.'-'.$AttDay;
			$GetDateRawFormate = gregoriantojd($AttMonth,$AttDay,$AttYear);
		}
		
		$objQayadCattendance->setProperty("device_id", $DeviceList["device_id"]);
		$objQayadCattendance->setProperty("device_uid", trim($attendancedata[0]));
		$objQayadCattendance->setProperty("att_date", trim($EnteryDateFormate));
		$objQayadCattendance->lstAttendance();
		if($objQayadCattendance->totalRecords() == 0){
			$AttendanceIDGet = $objQayadCattendance->dbFetchArray(1);
			if($AttendanceIDGet["att_out"] == ''){
				//echo 'Case - I '.$EnteryDateFormate.'<br>';
			$objQayadattendance->setProperty("device_uid", trim($attendancedata[0]));
			$objQayadattendance->setProperty("att_in", trim(date("H:i:s", strtotime(trim($attendancedata[3])))));
			$objQayadattendance->setProperty("att_date", trim($EnteryDateFormate));
			$objQayadattendance->setProperty("day_id", GetDayNumber(jddayofweek($GetDateRawFormate,1)));
			$objQayadattendance->setProperty("att_mode", 1);
			$objQayadattendance->setProperty("device_id", $DeviceList["device_id"]);
			$objQayadattendance->setProperty("entery_date", date('Y-m-d H:i:s'));
			$objQayadattendance->actAttendance('I');	
			}
		} else {
			//echo 'Case - U '.$EnteryDateFormate.'<br>';
			$AttendanceIDGet = $objQayadCattendance->dbFetchArray(1);
				if($AttendanceIDGet["att_in"] != date("H:i:s", strtotime($attendancedata[3])) && $AttendanceIDGet["att_mode"] == 1){
				//	if($AttendanceIDGet["att_in"] != ""){
						if($AttendanceIDGet["attendance_id"]!=''){
						$objQayadaUttendance->setProperty("attendance_id", $AttendanceIDGet["attendance_id"]);
						$objQayadaUttendance->setProperty("att_out", date("H:i:s", strtotime($attendancedata[3])));
						$objQayadaUttendance->actAttendance('U');
						}
				}
		}
			
	endwhile;
}
?>
<script type="text/javascript">window.close();</script>