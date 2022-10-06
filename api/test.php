<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, POST");
header('Access-Control-Max-Age: 86400');
header('content-type: application/json; charset=utf-8');
require_once("../config/config.php");
$objCommon 					= new Common;
$objQayaduser 			= new Qayaduser;
$objQayaddevice 			= new Qayaddevice;
$objQayadattendance		= new Qayadattendance;
$objQayadCattendance		= new Qayadattendance;
$objQayadCTattendance	= new Qayadattendance;
$objQayadaUttendance		= new Qayadattendance;

$fp = fopen('php://input', 'r');
$raw = stream_get_contents($fp);
$data = json_decode($raw,true);
$attendancedata = $data["data"];
if($data["code"] == "numan"){

$objQayaddevice->resetProperty();
$objQayaddevice->setProperty("device_id", 1);
$objQayaddevice->setProperty("ORDERBY", 'device_id');
$objQayaddevice->lstDevice();
while($DeviceList = $objQayaddevice->dbFetchArray(1)){
	//print_r($attendancedata);
	//while(list($idx, $attendancedata) = each($attendancedata[$DeviceList["device_id"]])):
	$CountArrayValue = count($attendancedata[$DeviceList["device_id"]]);
	for($i=0;$i<=$CountArrayValue;$i++){
		
		if(trim($attendancedata[$DeviceList["device_id"]][$i][0]) != "" ){
		//echo $DeviceList["device_id"].' - '.trim($attendancedata[$DeviceList["device_id"]][$i][0]).' - '.date("H:i:s", strtotime($attendancedata[$DeviceList["device_id"]][$i][3])).'<br>';
		
		if(date("a", strtotime(trim($attendancedata[$DeviceList["device_id"]][$i][3]))) == 'am' && date("h", strtotime(trim($attendancedata[$DeviceList["device_id"]][$i][3]))) >= '12'){
			$AttendanceDateRec = date('Y-m-d', strtotime("-1 day", strtotime(trim($attendancedata[$DeviceList["device_id"]][$i][3]))));
			list($AttDay,$AttMonth,$AttYear)= explode('-', $AttendanceDateRec);
			$EnteryDateFormate = $AttYear.'-'.$AttMonth.'-'.$AttDay;
			$GetDateRawFormate = gregoriantojd($AttMonth,$AttDay,$AttYear);
		} else {
			$AttendanceDateRec = trim(date("d-m-Y", strtotime(trim($attendancedata[$DeviceList["device_id"]][$i][3]))));
			list($AttDay,$AttMonth,$AttYear)= explode('-', $AttendanceDateRec);
			$EnteryDateFormate = $AttYear.'-'.$AttMonth.'-'.$AttDay;
			$GetDateRawFormate = gregoriantojd($AttMonth,$AttDay,$AttYear);
		}
		
		$objQayadCattendance->setProperty("device_id", $DeviceList["device_id"]);
		$objQayadCattendance->setProperty("device_uid", trim($attendancedata[$DeviceList["device_id"]][$i][0]));
		$objQayadCattendance->setProperty("att_date", $EnteryDateFormate);
		$objQayadCattendance->lstAttendance();
		if($objQayadCattendance->totalRecords() == 0){
			$AttendanceIDGet = $objQayadCattendance->dbFetchArray(1);
			if($AttendanceIDGet["att_out"] == ''){
				//echo 'Case - I '.$EnteryDateFormate.'<br>';
			$objQayadattendance->setProperty("device_uid", trim($attendancedata[$DeviceList["device_id"]][$i][0]));
			$objQayadattendance->setProperty("att_in", date("H:i:s", strtotime(trim($attendancedata[$DeviceList["device_id"]][$i][3]))));
			$objQayadattendance->setProperty("att_date", $EnteryDateFormate);
			$objQayadattendance->setProperty("day_id", GetDayNumber(jddayofweek($GetDateRawFormate,1)));
			$objQayadattendance->setProperty("att_mode", 1);
			$objQayadattendance->setProperty("device_id", $DeviceList["device_id"]);
			$objQayadattendance->setProperty("entery_date", date('Y-m-d H:i:s'));
			$objQayadattendance->actAttendance('I');	
			}
		} else {
			//echo 'Case - U '.$EnteryDateFormate.'<br>';
			$AttendanceIDGet = $objQayadCattendance->dbFetchArray(1);
				if($AttendanceIDGet["att_in"] != date("H:i:s", strtotime(trim($attendancedata[$DeviceList["device_id"]][$i][3]))) && $AttendanceIDGet["att_mode"] == 1){
				//	if($AttendanceIDGet["att_in"] != ""){
						if($AttendanceIDGet["attendance_id"]!=''){
						$objQayadaUttendance->setProperty("attendance_id", $AttendanceIDGet["attendance_id"]);
						$objQayadaUttendance->setProperty("att_out", date("H:i:s", strtotime(trim($attendancedata[$DeviceList["device_id"]][$i][3]))));
						$objQayadaUttendance->actAttendance('U');
						}
				}
		}
		
		}
	}
}
echo 'Done';
} else {
echo "Error";
}
?>