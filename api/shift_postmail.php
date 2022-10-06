<?php
$array = array();
$array['code'] = "TransferCronData";
$array['data'] = $DeviceNumber;
 
$data = json_encode($array);
$ch = curl_init('http://portal.Qayad.com/mycronjob_mix/att_shift_process.php');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                     
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);                   
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
$result = curl_exec($ch);
//echo '<pre>';
//echo $result;
//echo '</pre>';
?>
<script type="text/javascript">window.close();</script>