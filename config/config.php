<?php
	ini_set('session.gc_probability', 1);
	ini_set('session.gc_divisor', 100);
	ini_set('session.gc_maxlifetime', 1000);
	ini_set('zlib.output_compression_level', 4);
	ini_set('max_execution_time', 2000);
	date_default_timezone_set("Asia/Karachi");
	error_reporting(E_ALL);
	ob_start('fatal_error_handler');
	ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
	session_cache_expire(20000);
	set_time_limit(0);
	session_start();
	ob_end_flush();
	
	$dbCfg = array();
	include_once(dirname(__FILE__) . '/global_config.php');
	// database configuration
	if($_SERVER['HTTP_HOST'] == "localhost"){
		$dbCfg['host']			= "localhost";
		$dbCfg['db_user']		= "root";
		$dbCfg['db_passwd']		= "";
		$dbCfg['db_name']		= "childcare_db";
	}
	else{
		$dbCfg['host']			= "localhost";
		$dbCfg['db_user']		= "softsourcesoluti_daycare";
		$dbCfg['db_passwd']		= "ellight!@@!";
		$dbCfg['db_name']		= "softsourcesoluti_daycaredb";
	}
	
	/************************/
	
	/**
	 * import()
	 *
	 * @param mixed $className
	 * @return
	 */
	function import($className){
		if($className && $className != ""){
			$className = "classes/class." . $className . ".php";
			if(file_exists(SITE_PATH . $className)){
				require_once(SITE_PATH . $className);
			}
		}
	}
	
	/**
	 * getImage()
	 *
	 * @param string $imagename
	 * @param string $ext
	 * @return
	 */
	function getimage($imagename, $ext){
		return $imagename . '_' . strtolower(SITE_LANG) . '.' . $ext;
	}
	
	/**
	 * importJs()
	 *
	 * @param mixed $jsFile
	 * @return
	 */
	function importJs($jsFile){
		if($jsFile && $jsFile != ""){
			$jsFile = "jscript/Js" . $jsFile . ".js";
			if(file_exists(SITE_PATH . $jsFile)){
				echo "<script language=\"javascript\" type=\"text/javascript\" src=\"" . SITE_URL . $jsFile . "\"></script>\n";
			}
		}
	}
	
	/**
	 * printArray()
	 *
	 * @param array $arr
	 * @return
	 */
	function printPre($str, $exit = false){
		echo '<pre style="text-align:left;">' . $str . '</pre>';
		if($exit){
			exit();
		}
	}
	
	/**
	 * printArray()
	 *
	 * @param array $arr
	 * @return
	 */
	function printArray($arr, $exit = false){
		echo '<pre style="text-align:left;">';
		print_r($arr);
		echo '</pre>';
		if($exit){
			exit();
		}
	}
	
	/**
	 * importCss()
	 *
	 * @param mixed $cssFile
	 * @return
	 */
	function importCss($cssFile){
		if($cssFile && $cssFile != ""){
			$cssFile = "css/Css" . $cssFile . ".css";
			if(file_exists(SITE_PATH . $cssFile)){
				echo "<link href=\"" . SITE_URL . $cssFile . "\" rel=\"stylesheet\" type=\"text/css\" />\n";
			}
		}
	}
	
	/**
	 * buildUrl()
	 *
	 * @param string $url
	 * @param integer $refSecond
	 * @return
	 */
	function buildUrl($url = ""){
		header("Location:" . $url);
		die();
	}
	
	/**
	 * redirect()
	 *
	 * @param string $url
	 * @param integer $refSecond
	 * @return
	 */
	function redirect($url = "", $refSecond = 0){
		header("Location:" . $url);
		die();
	}
	
	/**
	 * doDefine()
	 *
	 * @param mixed $configs
	 * @return
	 */
	function doDefine($configs){
		$str = "";
		if($configs){
			foreach($configs as $key=>$value){
				$str .= "define(\"" . strtoupper($key) . "\",\"" . $value . "\");\n";
			}
		}
		return $str;
	}
	
	/*********** Define the values *********/
	$defines = doDefine($_CONFIG);
	echo eval($defines);
	
	/**
	 * __autoload()
	 *
	 * @param string $class_name
	 * @return
	 */
	//function __autoload($class_name){
	  function class_list($class_name){
		// class directories
		
		$dirs = array(
			'classes/',
			'classes/core/',
			'classes/Crypt/',
			'classes/utfexport/'
		);
		
		// for each directory
		foreach($dirs as $dir){
			// see if the file exsists
			if(file_exists(SITE_PATH . $dir . $class_name . '.php')){
				require_once(SITE_PATH . $dir . $class_name . '.php');
				// only require the class once, so quit after to save effort (if you got more, then name them something else
			return;
			}
		}
	}
	spl_autoload_register('class_list');
	/**
	 * getPage()
	 *
	 * @param string $log_module
	 * @return
	 */
	function getPage($page){
		if(isset($page) && !empty($page)){
			$filename = HTML_PATH . ($page) . '.default' . '.php';
			if(file_exists($filename))
				return HTML_PATH . ($page) . '.default' . '.php';
			else
				return HTML_PATH . '404' . '.php';
		}
		else{
			return HTML_PATH . 'default.php';
		}
	}
	
	function getDomain(){
		$host = $_SERVER["HTTP_HOST"];
		$host = str_replace('www.', '', $host);
		return '.' . $host;
	}
	
	function GetEncptBKL(){
		$Back_Link = $_SERVER['HTTP_REFERER'];
		$En_BKLINK = base64_encode($Back_Link);
		return $En_BKLINK;
	}
	
	function GetDecptBKL($BLK){
		$De_BKLINK = base64_decode($BLK);
		return $De_BKLINK;
	}
	
	function MonthList($Month){
		if($Month==1){
			$MonthM = 'Jan';
			} elseif($Month==2){
				$MonthM = 'Feb';
				} elseif($Month==3){
					$MonthM = 'Mar';
					} elseif($Month==4){
						$MonthM = 'Apr';
						} elseif($Month==5){
							$MonthM = 'May';
							} elseif($Month==6){
								$MonthM = 'Jun';
								} elseif($Month==7){
									$MonthM = 'Jul';
									} elseif($Month==8){
										$MonthM = 'Aug';
										} elseif($Month==9){
											$MonthM = 'Sep';
											 } elseif($Month==10){
												  $MonthM = 'Oct';
												   } elseif($Month==11){
													   $MonthM = 'Nov';
													    } elseif($Month==12){
															$MonthM = 'Dec';
															}
		return $MonthM;	
	}
	
	function dateFormate($GetDate){
	list($Year,$Month,$Day)= explode('-', $GetDate);
	$FinalDate = $Day .'/'. $Month;
		return $FinalDate;	
	}
	
	function dateFormate_2($GetDate){
	list($Year,$Month,$Day)= explode('-', $GetDate);
	$FinalDate = $Day .' / '. $Month .' <br> '. $Year;
		return $FinalDate;	
	}
	
	function dateFormate_3($GetDate){
	list($Year,$Month,$Day)= explode('-', $GetDate);
	$FinalDate = $Day .'/'. $Month .'/'. $Year;
		return $FinalDate;	
	}
	
	function dateFormate_4($GetDate){
	list($GTDate,$GTTime)= explode(' ', $GetDate);
	list($Year,$Month,$Day)= explode('-', $GTDate);
	$FinalDate = $Day .'/'. $Month .'/'. $Year;
		return $FinalDate;	
	}
	
	function dateFormate_7($GetDate){
	list($GTDate,$GTTime)= explode(' ', $GetDate);
	list($Year,$Month,$Day)= explode('-', $GTDate);
	$FinalDate = $Day .'/'. $Month .'/'. substr($Year,2,4);
		return $FinalDate;	
	}
	
	function dateFormate_6($GetDate){
	list($Year,$Month,$Day)= explode('-', $GetDate);
	$FinalDate = date("M") .'-'. $Day;
		return $FinalDate;	
	}
	
	function dateFormate_8($GetDate){
	list($Year,$Month,$Day)= explode('-', $GetDate);
		if($Month==1){
			$MonthM = 'Jan';
			} elseif($Month==2){
				$MonthM = 'Feb';
				} elseif($Month==3){
					$MonthM = 'Mar';
					} elseif($Month==4){
						$MonthM = 'Apr';
						} elseif($Month==5){
							$MonthM = 'May';
							} elseif($Month==6){
								$MonthM = 'Jun';
								} elseif($Month==7){
									$MonthM = 'Jul';
									} elseif($Month==8){
										$MonthM = 'Aug';
										} elseif($Month==9){
											$MonthM = 'Sep';
											 } elseif($Month==10){
												  $MonthM = 'Oct';
												   } elseif($Month==11){
													   $MonthM = 'Nov';
													    } elseif($Month==12){
															$MonthM = 'Dec';
															}
	$FinalDate = $MonthM .' '. $Day.', '. $Year;
		return $FinalDate;	
	}
	
	function dateFormate_9($GetDate){
	list($GTDate,$GTTime)= explode(' ', $GetDate);
	list($Year,$Month,$Day)= explode('-', $GTDate);
	$FinalDate = $Day .'-'. $Month .'-'. $Year .' / '. $GTTime;
		return $FinalDate;	
	}
	
	function dateFormate_10($GetDate){
	list($Month,$Day,$Year)= explode('/', $GetDate);
	$FinalDate = $Year . '-' . $Month .'-'. $Day;
		return $FinalDate;	
	}
	
	function dateFormate_11($GetDate){
	list($Year,$Month,$Day)= explode('-', $GetDate);
	$FinalDate = $Month . '/' . $Day .'/'. $Year;
		return $FinalDate;	
	}
	
	function dateFormate_12($GetDate){
	list($Year,$Month,$Day)= explode('-', $GetDate);
	$FinalDate = $Day;
		return $FinalDate;	
	}
	
	function relativeTime($dt,$precision=2){
	$times=array(	365*24*60*60	=> "year",
					30*24*60*60		=> "month",
					7*24*60*60		=> "week",
					24*60*60		=> "day",
					60*60			=> "hour",
					60				=> "minute",
					1				=> "second");
	
	$passed=time()-$dt;
	
	if($passed<5)
	{
		$output='less than 5 seconds ago';
	}
	else
	{
		$output=array();
		$exit=0;
		
		foreach($times as $period=>$name)
		{
			if($exit>=$precision || ($exit>0 && $period<60)) break;
			
			$result = floor($passed/$period);
			if($result>0)
			{
				$output[]=$result.' '.$name.($result==1?'':'s');
				$passed-=$result*$period;
				$exit++;
			}
			else if($exit>0) $exit++;
		}
				
		$output=implode(' and ',$output).' ago';
	}
	
	return $output;
	}
	
	/*
	function EncData($Data){
		$stp_1 = base64_encode($Data);
			$stp_2 = base64_encode($stp_1);
				$stp_3 = base64_encode($stp_2);
					$stp_4 = base64_encode($stp_3);
						$stp_5 = base64_encode($stp_4);
		return $stp_5;
	}
	
	function DecData($Data){
		$stp_1 = base64_decode($Data);
			$stp_2 = base64_decode($stp_1);
				$stp_3 = base64_decode($stp_2);
					$stp_4 = base64_decode($stp_3);
						$stp_5 = base64_decode($stp_4);
		return $stp_5;
	} */
	
	function EncData($value, $passtype, $objBF){
		if($value != ''){
		if($passtype == 1){
			return $objBF->encrypt($value, ENCRYPTION_KEY);	
			} else {
				return urlencode($objBF->encrypt($value, ENCRYPTION_KEY));
			}
		}
	}
	
	function DecData($value, $passtype, $objBF){
		if($value != ''){
		if($passtype == 1){
			return $objBF->decrypt($value, ENCRYPTION_KEY);
			} else {
				return $objBF->encrypt(urldecode($value), ENCRYPTION_KEY);
			}
		}
	}

	function StatusName($StatusID){
		if($StatusID==0){
			$BackStatus = 'InActive';
			} elseif($StatusID==1){
				$BackStatus = 'Active';
				} elseif($StatusID==2){
					$BackStatus = 'InActive';
					} elseif($StatusID==3){
						$BackStatus = 'Delete';
						}
		return $BackStatus;
	}
	
	function LeadStatus($StatusID){
		if($StatusID==1){
			$BackStatus = 'No Action';
			} elseif($StatusID==2){
				$BackStatus = 'Hot';
				} elseif($StatusID==3){
					$BackStatus = 'Cold';
					}
		return $BackStatus;
	}
	
	function HourPlus($HP){
		$GetHourBack = date("h:i:s", strtotime("-".$HP." hour"));
		return $GetHourBack;
	}
	
	function UserType($user_type_id){
		if($user_type_id==1){
			$UserType = 'Admin';
			} elseif($user_type_id==2){
				$UserType = 'Front-Desk';
				} elseif($user_type_id==3){
					$UserType = 'Finance';
					} elseif($user_type_id==4){
						$UserType = 'Agent';
						} elseif($user_type_id==5){
							$UserType = 'Sales';
							} elseif($user_type_id==6){
								$UserType = 'SMS Management';
								} elseif($user_type_id==7){
									$UserType = 'Director Management';
									} elseif($user_type_id==8){
										$UserType = 'Creative Director Management';
										} elseif($user_type_id==9){
											$UserType = 'HR Management';
											} elseif($user_type_id==10){
												$UserType = 'Employee';
												} elseif($user_type_id==11){
													$UserType = 'Team Lead';
													} elseif($user_type_id==12){
														$UserType = 'Digital Media Manager';
														} elseif($user_type_id==13){
															$UserType = 'Regional Manager';
															} elseif($user_type_id==14){
																$UserType = 'Fintial Team Lead';
																} elseif($user_type_id==15){
																	$UserType = 'JCI CEO';
																	} elseif($user_type_id==16){
																		$UserType = 'HR WOUT-S';
																		} elseif($user_type_id==17){
																			$UserType = 'Support Staff';
																			} elseif($user_type_id==18){
																				$UserType = 'Finance Assistant';
																			} elseif($user_type_id==19){
																		$UserType = 'Senior Finance';
																		} elseif($user_type_id==20){
																	$UserType = 'Junior Finance';
																	} elseif($user_type_id==21){
																$UserType = 'CPML IN-Bound Sales Team';
																} elseif($user_type_id==22){
															$UserType = 'CPML IN-Bound Customer Service';
															} elseif($user_type_id==23){
														$UserType = 'CPML OUT-Bound Sales Team';
														} elseif($user_type_id==24){
													$UserType = 'CPML OUT-Bound Customer Service';
													} elseif($user_type_id==25){
												$UserType = 'OUT-Bound Churn Department';
												} elseif($user_type_id==26){
											$UserType = 'CPML Data Entry Leads Management';
											} elseif($user_type_id==27){
										$UserType = 'CPML Quality Controller';
							}
		return $UserType;
	}
	//1=>Under Construction Project, 2=>Complete Project
	function ProjectType($ProjectType){
		if($ProjectType==1){
			$ReturnName = 'Under Construction'; //6
			} elseif($ProjectType==2){
				$ReturnName = 'Complete';
				}
		return $ReturnName;
	}
	
	//1=>Office, 2=>Shop, 3=>Standard Room, 4=>Deluxe Room, 5=>Executive Room, 6=>Executive Suites, 7=>Presidential Suite, 8=>Food Court, 9=>Kiosk, 10=>Theme Park
	function PropertyType($PropertyType){
		if($PropertyType==1){
			$ReturnType = 'Office';
			} elseif($PropertyType==2){
				$ReturnType = 'Shop';
				} elseif($PropertyType==3){
					$ReturnType = 'Standard Room';
					} elseif($PropertyType==4){
						$ReturnType = 'Deluxe Room';
						} elseif($PropertyType==5){
							$ReturnType = 'Executive Room';
							} elseif($PropertyType==6){
								$ReturnType = 'Executive Suite';
								} elseif($PropertyType==7){
									$ReturnType = 'Presidential Suite';
									} elseif($PropertyType==8){
										$ReturnType = 'Food Court';
										} elseif($PropertyType==9){
											$ReturnType = 'Kiosk';
											} elseif($PropertyType==10){
												$ReturnType = 'Theme Park';
											}
		return $ReturnType;
	}
	
	function PropertyStatus($PropertyStatus){
		if($PropertyStatus==1){
			$ReturnStatus = 'Available';
			} elseif($PropertyStatus==2){
				$ReturnStatus = 'Sold';
				} elseif($PropertyStatus==3){
					$ReturnStatus = 'Resale';
					} elseif($PropertyStatus==4){
						$ReturnStatus = 'Book';
						} elseif($PropertyStatus==5){
							$ReturnStatus = 'Under Process';
							} elseif($PropertyStatus==6){
								$ReturnStatus = 'Lock Under Process';
								} elseif($PropertyStatus==7){
									$ReturnStatus = 'UnLock Under Process';
						} 
		return $ReturnStatus;
	}
	
	function RegisterProject($RegisterProject){
		if($RegisterProject==1){
			$ReturnName = 'Apartment';
			} elseif($RegisterProject==2){
				$ReturnName = 'Shop';
				} elseif($RegisterProject==3){
					$ReturnName = 'Food Court';
					} elseif($RegisterProject==4){
						$ReturnName = 'Offices';
						} elseif($RegisterProject==5){
							$ReturnName = 'Suites';
							} elseif($RegisterProject==6){
								$ReturnName = 'Kids Area';
					} 
		return $ReturnName;
	}
	
	function AreaShareCalculation($AreaType, $AreaSize, $TextShow){
		if($AreaType == 1){
			if($TextShow == 1){ $ReturnNoOfShares = $AreaSize / 120 .' <small>[A/120]</small>';
				} else { $ReturnNoOfShares = $AreaSize / 120; }
			} elseif($AreaType == 2){
				if($TextShow == 1){ $ReturnNoOfShares = $AreaSize / 20 .' <small>[A/20]</small>';
					} else { $ReturnNoOfShares = $AreaSize / 20; }
				} elseif($AreaType == 3){
					if($TextShow == 1){ $ReturnNoOfShares = $AreaSize / 20 .' <small>[A/20]</small>';
						} else { $ReturnNoOfShares = $AreaSize / 20; }
					} elseif($AreaType == 4){
						if($TextShow == 1){ $ReturnNoOfShares = $AreaSize / 120 .' <small>[A/120]</small>';
							} else { $ReturnNoOfShares = $AreaSize / 120; }
					}
		return $ReturnNoOfShares;
	}
	
	function ProjectTypeOptionList($SelectedOption){
		$OptionArrayList = '';
		$OptionArrayList .= '<option value="2" '.StaticDDSelection(2, $SelectedOption).'>Shops</option>';
		$OptionArrayList .= '<option value="3" '.StaticDDSelection(3, $SelectedOption).'>Food Court</option>';
		$OptionArrayList .= '<option value="6" '.StaticDDSelection(6, $SelectedOption).'>Kids Area</option>';
		$OptionArrayList .= '<option value="4" '.StaticDDSelection(4, $SelectedOption).'>Offices</option>';
		$OptionArrayList .= '<option value="1" '.StaticDDSelection(1, $SelectedOption).'>Apartments</option>';
		$OptionArrayList .= '<option value="5" '.StaticDDSelection(5, $SelectedOption).'>Suites</option>';
		
		
		
		return $OptionArrayList;
	}
	
	function RegistrationType($RegistrationType){
		if($RegistrationType==1){
			$ReturnName = 'First Alottee';
			} elseif($RegistrationType==2){
				$ReturnName = 'Transfer Certificate';
				} elseif($RegistrationType==3){
					$ReturnName = 'Open Certificate';
					} elseif($RegistrationType==4){
						$ReturnName = 'Locked';
						} 
		return $ReturnName;
	}
	
	function PaymentMode($ModeID){
		if($ModeID==1){
			$ReturnMode = 'Cash';
			} elseif($ModeID==2){
				$ReturnMode = 'Payorder';
				} elseif($ModeID=3){
					$ReturnMode = 'Cheque';
					}  elseif($ModeID=4){
						$ReturnMode = 'Adjustment';
						}
		return $ReturnMode;
	}
	
	function PaymentOption($optid){
	//1=>Cash, 2=>Cheque. 3=>Pay Order, 4=>Bank Transfer, 5=>Demand Draft, 6=>Online
		if($optid == 1){
			$ReturnValue = 'Cash';
			} elseif($optid == 2){
				$ReturnValue = 'Cheque';
				} elseif($optid == 3){
					$ReturnValue = 'Pay Order';
					} elseif($optid == 4){
						$ReturnValue = 'Bank Transfer';
						} elseif($optid == 5){
							$ReturnValue = 'Demand Draft';
							} elseif($optid == 6){
								$ReturnValue = 'Online';
								} elseif($optid == 7){
									$ReturnValue = 'Opening Balance';
									} elseif($optid == 8){
										$ReturnValue = 'Transfer to Down Payment';
					} 
		return $ReturnValue;
	}
	
	function PaymentType($PaymentType){
		if($PaymentType==1){
			$ReturnType = 'Down Payment';
			} elseif($PaymentType==2){
				$ReturnType = 'Installment';
				} elseif($PaymentType==3){
					$ReturnType = 'Adjustment';
					} elseif($PaymentType==4){
						$ReturnType = 'Full Payment';
						} elseif($PaymentType==5){
							$ReturnType = 'Token Amount';
							} elseif($PaymentType==6){
								$ReturnType = 'Return Token Amount';
							}
		return $ReturnType;
	}
	
	function SMSVerificationStatus($sms_verification){
		if($sms_verification==1){
			$Returnstatus = 'Required';
				} elseif($sms_verification==2){
					$Returnstatus = 'Not Required';
					}
		return $Returnstatus;
	}
	
	function ApplicBookingFrom($RegId){
		if($RegId==1){
			$Returnstatus = 'InHouse';
				} elseif($RegId==2){
					$Returnstatus = 'By Agent';
					}
		return $Returnstatus;
	}
	
	function InstalmentStatus($IntStatus){
		if($IntStatus==1){
			$Returnstatus = 'Paid';
				} elseif($IntStatus==2){
					$Returnstatus = 'Pending';
					}
		return $Returnstatus;
	}
	
	function CustomerTypes($IntStatus){
		if($IntStatus==1){
			$ReturnType = 'Main Customer';
			} elseif($IntStatus==2){
				$ReturnType = 'Nominee';
				}  elseif($IntStatus==3){
					$ReturnType = 'Joint';
					}  elseif($IntStatus==4){
						$ReturnType = 'Witness';
						}  elseif($IntStatus==5){
							$ReturnType = 'Joint Nominee';
					} 
		return $ReturnType;
	}
	
	function PropertyArea($area_id){
		if($area_id==1){
			$ReturnArea = '1-315';
			} elseif($area_id==2){
				$ReturnArea = '1-450';
				} elseif($area_id==3){
					$ReturnArea = '1-530';
					} elseif($area_id==4){
						$ReturnArea = '1-850';
						} elseif($area_id==5){
							$ReturnArea = '1-2000';
							} elseif($area_id==6){
								$ReturnArea = '2-288';
								} elseif($area_id==7){
									$ReturnArea = '2-348';
									} elseif($area_id==8){
										$ReturnArea = '2-324';
										} elseif($area_id==9){
											$ReturnArea = '2-348';
											} elseif($area_id==10){
												$ReturnArea = '2-405';
												} elseif($area_id==11){
													$ReturnArea = '2-408';
													} elseif($area_id==12){
														$ReturnArea = '2-901';
														} elseif($area_id==13){
															$ReturnArea = '2-2703';
															} elseif($area_id==14){
																$ReturnArea = '2-576';
															}
		return $ReturnArea;
	}
	
	function ProfileImgChecker($ProfileImg){
		if($ProfileImg!=''){
			$ReturnProfileImg = $ProfileImg;
			} else {
				$ReturnProfileImg = 'default-avatar.png';
				}
		return $ReturnProfileImg;
	}
	
	function SignatureChecker($SignatureV){
		if($SignatureV!=''){
			$ReturnSignature = $SignatureV;
			} else {
				$ReturnSignature = 'default-signature.png';
				}
		return $ReturnSignature;
	}
	
	function DocumentChecker($DocumentV){
		if($DocumentV!=''){
			$ReturnDocument = $DocumentV;
			} else {
				$ReturnDocument = 'default-doc.png';
				}
		return $ReturnDocument;
	}
	
	function StaticDDSelection($StaticValue,$ActiveValue){
		if($StaticValue == $ActiveValue){
			$ReturnSelectedVal = ' selected';
			} else {
				$ReturnSelectedVal = '';
				}
		return $ReturnSelectedVal;
	}
	
	function StaticRadioChecked($StaticValue,$ActiveValue){
		if($StaticValue == $ActiveValue){
			$ReturnRadioVal = ' checked="true"';
			} else {
				$ReturnRadioVal = '';
				}
		return $ReturnRadioVal;
	}
	
	function checkvalue($GetValue, $Type){
		//1=>Email, 2=>Text, 3=>WebSite URl
		if($GetValue==''){
			$ReturnValue = 'Null';
			} else {
				if($Type==1){
					$ReturnValue = '<a href="mailto:'.$GetValue.'">'.$GetValue.'</a>';
				} elseif($Type==2){
						$ReturnValue = $GetValue;
					} elseif($Type==3){
							$ReturnValue = '<a href="http://'.$GetValue.'" target="_new">'.$GetValue.'</a>';
						}
			}
		return $ReturnValue;
	}
	
	function CnicFormat($cnic_number){
		return substr($cnic_number,0,5).'-'.substr($cnic_number,5,7).'-'.substr($cnic_number,12,1);
	}
	
	function GetOptionStatus($value_id){
		if($value_id==1){
			$StatusTitle = 'Enable';
			} elseif($value_id==2){
				$StatusTitle = 'Disable';
				}
		return $StatusTitle;
	}
	
	function GetOptionLimit($value_id){
		if($value_id==1){
			$StatusTitle = 'Limited';
			} elseif($value_id==2){
				$StatusTitle = 'Unlimited';
				}
		return $StatusTitle;
	}
	
	function is_form_error($ErrorVar,$CurrentStage){
		if($ErrorVar[$CurrentStage] != ''){
			$AddErrorClass = ' has-error';
			} else {
				$AddErrorClass = '';
				}
		return $AddErrorClass;
	}
	
	function NotRequired($mode,$this_mode){
		if($mode==$this_mode){
			$ReturnRequired = '';
			} else {
				$ReturnRequired = 'requireds';
				}
	}
	
	function GetTimeTitle($value_id){
		if($value_id==1){
			$TimeName = 'Day';
			} elseif($value_id==2){
				$TimeName = 'Quarter';
				} elseif($value_id==3){
					$TimeName = 'Week';
					} elseif($value_id==4){
						$TimeName = 'Month';
						} elseif($value_id==5){
							$TimeName = 'Year';
							}
		return $TimeName;
	}
	
	function SetFormPageTitle($Text, $mode){
		if($mode == 'I'){
			 $ReturnText = 'Add New '.$Text;
			} else {
				$ReturnText = 'Edit '.$Text;
				}
		return $ReturnText;
	}
	
	function MenuActivation($menuname, $currentmenu, $mode){
		if($mode == 1){
			if($menuname == $currentmenu){
				$ReturnMenuActive = '  class="active"';
				} else {
					$ReturnMenuActive = '';
					}
			} elseif($mode == 2){
				if($menuname == $currentmenu){
					$ReturnMenuActive = '  in';
					} else {
						$ReturnMenuActive = '';
						}			
			} elseif($mode == 3){
				if($menuname == $currentmenu){
					$ReturnMenuActive = 'tempcheck';
					} else {
						$ReturnMenuActive = 'tempuncheck';
						}			
			}
		return $ReturnMenuActive;
	}
	
	function Numberformt($Value){
		return SITE_CURRENCY.'.'.number_format($Value).'/-';
	}
	
	function Numberformt_second($Value){
		return SITE_CURRENCY.'.'.number_format($Value);
	}
	
	function Salaryformt($Value){
		return SITE_CURRENCY.'. '.number_format((float)$Value, 2, '.', '');
	}
	
	function PayBackCuttingMode($Value){
		if($Value == 1){
			$ReturnVal = '% Base';
			} else {
				$ReturnVal = 'Fix Amount';
				}
		return $ReturnVal;
	}
	
	function GenderSelection($Pass){
		if($Pass == 1){
			$ReturnVal = 'Male';
			} else {
				$ReturnVal = 'Female';
				}
		return $ReturnVal;
	}
	
	function TempLockedStatus($Value){
		if($Value == 1){
			$ReturnVal = 'Locked';
			} elseif($Value == 2){
				$ReturnVal = 'Expire';
				} elseif($Value == 3){
					$ReturnVal = 'Delete';
					} elseif($Value == 4){
						$ReturnVal = 'Booked';
						} elseif($Value == 5){
							$ReturnVal = 'Approval Pending';
							} elseif($Value == 6){
								$ReturnVal = 'Adjustment';
								} elseif($Value == 7){
									$ReturnVal = 'Unlock Request';
					}
		return $ReturnVal;
	}
	
	function UpdateFieldArray($MainArrayData,$ArrayKeyName,$ArrayKeyNewValue){
		$DummyArray = array();
		if(array_key_exists($ArrayKeyName, $MainArrayData)){
			$ChangeNewValue = array($ArrayKeyName => $ArrayKeyNewValue);
			$ApplicationDoc = array_replace($DummyArray, $MainArrayData, $ChangeNewValue);
		} else {
			$ApplicationDoc[$ArrayKeyName] = $ArrayKeyNewValue;	
		}	
		return $ApplicationDoc;
	}
	
	function CreateInvoiceNumber($ApplicantId){
		return 'QYD-'.date("mdy").'-'.$ApplicantId;
	}
	
	function CreateRecepitNumber($PaymentId,$InstallmentId){
		return 'QYD-'.$InstallmentId.'-'.date("md").'-'.$PaymentId;
	}
	
	function CreateTransactionNumber($TransactionId){
		return 'QD-'.str_pad($TransactionId, 6, '0', STR_PAD_LEFT);
	}
	
	function ApplicationPaymentMode($ModeId){
		if($ModeId == 1){
			$ReturnVal = 'Instalment';
			} elseif($ModeId == 2){
				$ReturnVal = 'Full Payment';
				} elseif($ModeId == 3){
					$ReturnVal = 'Customize';
					}
		return $ReturnVal;
	}
	
	function MakeInstalmentDate($StartingDate, $DateFormate = 1, $NumberofMonth){
		if($DateFormate == 1){ $ApplyDateFormat = 'Y-m-d'; } else { $ApplyDateFormat = 'd M, Y'; }
			$instalment_date = date('Y-m-d', strtotime($StartingDate. ' + '.$NumberofMonth.' month'));
			if(date('D', strtotime($instalment_date)) == 'Sat'){
				$instalment_date = date('Y-m-d', strtotime($instalment_date. ' + 2 days'));
				} elseif(date('D', strtotime($instalment_date)) == 'Sun'){
					$instalment_date = date('Y-m-d', strtotime($instalment_date. ' + 1 days'));
					} else {
					$instalment_date;
			}
				if($DateFormate == 1){ 
					return $instalment_date; 
					} else { 
						return date("jS F, Y", strtotime($instalment_date)); 
				}	
	}
	
	function AccountHeadType($HeadTypeId){
		if($HeadTypeId == 1){
			$ReturnVal = 'General';
			} elseif($HeadTypeId == 2){
				$ReturnVal = 'Cash';
				} elseif($HeadTypeId == 3){
					$ReturnVal = 'Bank Account';
					} elseif($HeadTypeId == 4){
						$ReturnVal = 'Property';
					}
		return $ReturnVal;
	}

	function TransactionType($TransType){
		if($TransType == 1){
			$ReturnVal = 'Application';
			} elseif($TransType == 2){
				$ReturnVal = 'Item';
				} elseif($TransType == 3){
					$ReturnVal = 'Employee';
					} elseif($TransType == 4){
						$ReturnVal = 'Head Base';
						} elseif($TransType == 5){
							$ReturnVal = 'Cash Transfer to Bank';
							} elseif($TransType == 6){
								$ReturnVal = 'Bank to Bank Transfer';
								} elseif($TransType == 7){
									$ReturnVal = 'Back to Cash';
									} elseif($TransType == 8){
										$ReturnVal = 'Opening Balance';
										} elseif($TransType == 9){
											$ReturnVal = 'Token Amount';
					}
		return $ReturnVal;
	}
	
	function TransactionMode($TransMode){
		if($TransMode == 1){
			$ReturnVal = 'Debit';
			} elseif($TransMode == 2){
				$ReturnVal = 'Credit';
		}
		return $ReturnVal;
	}
	
	function PageCheckerOpt($GetShow,$CPGName,$AllowType,$objCheckLogin){
			if($GetShow == $CPGName && in_array($objCheckLogin->user_type, $AllowType)){
				return 1;
			} else {
				//return 0;
				redirect(Route::_('show=logout'));
			}
	}
	
	function ReadOnlyField($Opt){
		if($Opt == 1){
			return ' readonly';	
		} else {
			return '';
		}
	}
	
	function MobileNumberChecker($MobileNumber){
		if(trim(substr($MobileNumber,0,1)) == 0){
			$ReturnNumber = trim(substr($MobileNumber,1, 13));
		} elseif(trim(substr($MobileNumber,0,3)) == '920'){
			$ReturnNumber = trim(substr($MobileNumber,3, 13));
		} elseif(trim(substr($MobileNumber,0,2)) == '92'){
			$ReturnNumber = trim(substr($MobileNumber,2, 13));
		} else {
			$ReturnNumber = $MobileNumber;
		}
		return $ReturnNumber;
	}
	
	function SMSTemplateType($SMSType){
		if($SMSType == 1){
			$ReturnVal = 'Welcome SMS';
			} elseif($SMSType == 2){
				$ReturnVal = 'First Payment SMS';
				} elseif($SMSType == 3){
					$ReturnVal = 'Upcoming Installment SMS';
					} elseif($SMSType == 4){
						$ReturnVal = 'Late Installment SMS';
						} elseif($SMSType == 5){
							$ReturnVal = 'On Payment SMS';
							} elseif($SMSType == 6){
								$ReturnVal = 'Token Amount SMS';
								} elseif($SMSType == 7){
									$ReturnVal = 'Marketing SMS';
									} elseif($SMSType == 8){
										$ReturnVal = 'General Notification SMS';
										} elseif($SMSType == 9){
											$ReturnVal = 'Assign Leads Notification SMS';
			}
		return $ReturnVal;
	}
	
	function PaymentModeType($ModeType){
		if($ModeType == 1){
			$ReturnVal = 'Online Bank Transfer';
			} elseif($ModeType == 2){
				$ReturnVal = 'Cheque Deposit';
				} elseif($ModeType == 3){
					$ReturnVal = 'MoneyGram';
					} elseif($ModeType == 4){
						$ReturnVal = 'Western Union';
						} elseif($ModeType == 5){
							$ReturnVal = 'Remit';
							} elseif($ModeType == 6){
								$ReturnVal = 'XE Money Transfer';
					}
		return $ReturnVal;
	}
	
	function PaymentTransferStatus($TransferStatus){
		if($TransferStatus == 1){
			$ReturnVal = 'Pending';
			} elseif($TransferStatus == 2){
				$ReturnVal = 'In-Process';
				} elseif($TransferStatus == 3){
					$ReturnVal = 'Approved';
					} elseif($TransferStatus == 4){
						$ReturnVal = 'Rejected';
					}
		return $ReturnVal;
	}
	
	function ApplicationStatus($aplic_stage_id){
		if($aplic_stage_id == 1){
			$ReturnVal = 'Front Desk';
			} elseif($aplic_stage_id == 2){
				$ReturnVal = 'Fwd to Finance Dept';
				} elseif($aplic_stage_id == 3){
					$ReturnVal = 'Approved';
					} elseif($aplic_stage_id == 4){
						$ReturnVal = 'Fwd to Document Dept';
					}
		return $ReturnVal;
	}
	
	function SMSSendingOption($option_id){
		if($option_id == 1){
			$ReturnVal = 'All';
			} elseif($option_id== 2){
				$ReturnVal = 'Agent Base';
				} elseif($option_id == 3){
					$ReturnVal = 'Selected Customers';
					}
		return $ReturnVal;
	}
	
	function SMSSendingRequestStatus($status_id){
		if($status_id == 1){
			$ReturnVal = 'Waiting & Pending';
			} elseif($status_id == 2){
				$ReturnVal = 'Data Processing';
				} elseif($status_id == 3){
					$ReturnVal = 'Sending in Que';
					} elseif($status_id == 4){
						$ReturnVal = 'Send';
					}
		return $ReturnVal;
	}
	
	function addOrdinalNumberSuffix($num) {
		if (!in_array(($num % 100),array(11,12,13))){
		  switch ($num % 10) {
			case 1:  return $num.'st';
			case 2:  return $num.'nd';
			case 3:  return $num.'rd';
		  }
		}
    	return $num.'th';
	}
	
	function GetDaysList(){
		$WeekDays = array();
			$WeekDays[]= array('day_id'=>'1', 'day_name'=>'Monday');
				$WeekDays[]= array('day_id'=>'2', 'day_name'=>'Tuesday');
					$WeekDays[]= array('day_id'=>'3', 'day_name'=>'Wednesday');
						$WeekDays[]= array('day_id'=>'4', 'day_name'=>'Thursday');
							$WeekDays[]= array('day_id'=>'5', 'day_name'=>'Friday');
								$WeekDays[]= array('day_id'=>'6', 'day_name'=>'Saturday');
									$WeekDays[]= array('day_id'=>'7', 'day_name'=>'Sunday');
		return $WeekDays;
	}
	
	function GetDayNumber($Dayname){
		if($Dayname == 'Monday'){
			$ReturnDayNumber = 1;
			} elseif($Dayname == 'Tuesday'){
				$ReturnDayNumber = 2;
				} elseif($Dayname == 'Wednesday'){
					$ReturnDayNumber = 3;
					} elseif($Dayname == 'Thursday'){
						$ReturnDayNumber = 4;
						} elseif($Dayname == 'Friday'){
							$ReturnDayNumber = 5;
							} elseif($Dayname == 'Saturday'){
								$ReturnDayNumber = 6;
								} elseif($Dayname == 'Sunday'){
									$ReturnDayNumber = 7;
								}
		return $ReturnDayNumber;	
	}
	
	function GetDayName($DayNumber){
		if($DayNumber == 1){
			$ReturnDayName = 'Monday';
			} elseif($DayNumber == 2){
				$ReturnDayName = 'Tuesday';
				} elseif($DayNumber == 3){
					$ReturnDayName = 'Wednesday';
					} elseif($DayNumber == 4){
						$ReturnDayName = 'Thursday';
						} elseif($DayNumber == 5){
							$ReturnDayName = 'Friday';
							} elseif($DayNumber == 6){
								$ReturnDayName = 'Saturday';
								} elseif($DayNumber == 7){
									$ReturnDayName = 'Sunday';
								}
		return $ReturnDayName;	
	}
	
	function GetCurrentDayName($PassValue,$ReturnOpt = 1){
		
			list($RtYear,$RTMonth,$RTDay)= explode('-',$PassValue);
			
			if($ReturnOpt == 1){
				return jddayofweek(gregoriantojd($RTMonth,$RTDay,$RtYear),1);	
			} else {
				return jddayofweek(gregoriantojd($RTMonth,$RTDay,$RtYear));
			}
	}
	
	function RemoveLastDig($Passval, $NumberofRemove){
			return substr($Passval,0,-$NumberofRemove);
	}
	
	function GetTimeCal($PassDate, $AttIn, $AttOut){
			$StartTimefromCal = new DateTime($PassDate.' '.$AttIn);
		return $StartTimefromCal->diff(new DateTime($PassDate.' '.$AttOut));	
	}
	
	function AddMinInTime($CurrentTime,$AddMin){
		return date("H:i:s", strtotime('+'.$AddMin.' minutes', $CurrentTime));	
	}
	
	function RemaingMinutes($StartMinutes,$EndMinutes){
		return trim($StartMinutes) - trim($EndMinutes);	
	}
	
	function CountTimeMinutes($StartDateTime,$EndDateTime){
		return round(abs(strtotime($EndDateTime) - strtotime($StartDateTime)) / 60,2);
	}
	
	function MinutesConvertHours($minutes){
			$init = $minutes * 60;
			$hours = floor($init / 3600);
			$minutes = floor(($init / 60) % 60);
			$seconds = $init % 60;
		return "{$hours}H/{$minutes}M";
		//return date('H:i', mktime(0,$minutes));	
	}
	
	function ReturnRemainintMinutes($minutes){
			$init = $minutes * 60;
			$hours = floor($init / 3600);
			$minutes = floor(($init / 60) % 60);
			$seconds = $init % 60;
		return "{$minutes}";
		//return date('H:i', mktime(0,$minutes));	
	}
	
	function GetLeadAssignTime($StartDateTime, $EndDateTime){
			$StartTimefromCal = new DateTime($StartDateTime);
		return $StartTimefromCal->diff(new DateTime($EndDateTime));	
	}
	
	function BloodGroup($opt){
		if($opt == 1){
			$Returnvalue = 'A+';
			} elseif($opt == 2){
				$Returnvalue = 'A-';
				} elseif($opt == 3){
					$Returnvalue = 'B+';
					} elseif($opt == 4){
						$Returnvalue = 'B-';
						} elseif($opt == 5){
							$Returnvalue = 'O+';
							} elseif($opt == 6){
								$Returnvalue = 'O-';
								} elseif($opt == 7){
									$Returnvalue = 'AB+';
									} elseif($opt == 8){
										$Returnvalue = 'AB-';
									}
		return $Returnvalue;
	}
	
	function BloodGroupCombo($opt){
		$Combo = '';
		//if($opt==1){ echo ''; } else { echo '';}
		$Combo .= '<option value="1"'.StaticDDSelection(1, $opt).'>A+</option>';
		$Combo .= '<option value="2"'.StaticDDSelection(2, $opt).'>A-</option>';
		$Combo .= '<option value="3"'.StaticDDSelection(3, $opt).'>B+</option>';
		$Combo .= '<option value="4"'.StaticDDSelection(4, $opt).'>B-</option>';
		$Combo .= '<option value="5"'.StaticDDSelection(5, $opt).'>O+</option>';
		$Combo .= '<option value="6"'.StaticDDSelection(6, $opt).'>O-</option>';
		$Combo .= '<option value="7"'.StaticDDSelection(7, $opt).'>AB+</option>';
		$Combo .= '<option value="8"'.StaticDDSelection(8, $opt).'>AB-</option>';
		return $Combo;
	}
	
	function AssignAgentLeadStatus($StatusId){
		if($StatusId == 1){
			$ReturnStatus = 'No Action';
			} elseif($StatusId == 2){
				$ReturnStatus = 'Follow up';
				} elseif($StatusId == 3){
					$ReturnStatus = 'Not Responding';
					} elseif($StatusId == 4){
						$ReturnStatus = 'Interested';
						} elseif($StatusId == 5){
							$ReturnStatus = 'Not Interested';
							} elseif($StatusId == 6){
								$ReturnStatus = 'Converted';
							}
		return $ReturnStatus;
	}
	
	function RMAssignLeadStatus($StatusId){
		if($StatusId == 1){
			$ReturnStatus = 'No Action';
			} elseif($StatusId == 2){
				$ReturnStatus = 'Forward';
				}
		return $ReturnStatus;
	}
	
	function UserMaritalStatus($StatusId){
		if($StatusId == 1){
			$ReturnStatus = 'Single';
			} elseif($StatusId == 2){
				$ReturnStatus = 'Married';
				}
		return $ReturnStatus;
	}
	
	function LeadAssignBy($StatusId){
		if($StatusId == 1){
			$ReturnStatus = 'Team Lead';
			} elseif($StatusId == 2){
				$ReturnStatus = 'Regional Manager  ';
				}
		return $ReturnStatus;
	}
	
	function SalaryType($Type){
		if($Type == 1){
			$ReturnType = 'Basic Salary';
			} elseif($Type == 2){
				$ReturnType = 'Increment';
				}
		return $ReturnType;
	}
	
	function SalaryMode($Mode){
		if($Mode == 1){
			$ReturnMode = 'Monthly';
			} elseif($Mode == 2){
				$ReturnMode = 'One Time';
				}
		return $ReturnMode;
	}
	
	function BonusStatus($Status){
		if($Status == 1){
			$ReturnMode = 'Pending';
			} elseif($Status == 2){
				$ReturnMode = 'Done';
				}
		return $ReturnMode;
	}
	
	function LeaveOf($Status){
		if($Status == 1){
			$ReturnMode = 'Full Day';
			} elseif($Status == 2){
				$ReturnMode = 'Half Day (First Half)';
				} elseif($Status == 3){
					$ReturnMode = 'Half Day (Second Half)';
					}
		return $ReturnMode;
	}
	
	function OverTimeRequestStatus($StatusID){
		if($StatusID == 1){
			$ReturnStatus = 'Pending';	
			} elseif($StatusID == 2){
				$ReturnStatus = 'Request Submit';	
				} elseif($StatusID == 3){
					$ReturnStatus = 'Approved';	
					} elseif($StatusID == 4){
						$ReturnStatus = 'Reject';	
					}
		return $ReturnStatus;		
	}
	
	function LeaveStatus($StatusID){
		if($StatusID == 1){
			$ReturnStatus = 'Pending';	
			} elseif($StatusID == 2){
				$ReturnStatus = 'Approved';	
				} elseif($StatusID == 3){
					$ReturnStatus = 'Reject';	
					}
		return $ReturnStatus;		
	}
	
	function ForwardDirectorStatus($StatusID){
		if($StatusID == 1){
			$ReturnStatus = 'Forward to Director';	
			} elseif($StatusID == 2){
				$ReturnStatus = 'Director Approved';	
				} elseif($StatusID == 3){
					$ReturnStatus = 'Director Reject';
					}
		return $ReturnStatus;		
	}
	//1=>General, 2=>Medical, 3=>Casual, 4=>Sick
	function YearlyLeaveType($Status){
		if($Status == 1){
			$ReturnMode = 'General';
			} elseif($Status == 2){
				$ReturnMode = 'Medical';
				} elseif($Status == 3){
					$ReturnMode = 'Casual';
					} elseif($Status == 4){
						$ReturnMode = 'Sick';
				}
		return $ReturnMode;
	}
	
	function TimerChecker($PassTime){
		if($PassTime == ''){
			$ReturnValue = '0:00';	
		} else {
			$ReturnValue = $PassTime;
		}
		return $ReturnValue;
	}
	
	function ProspectFromId($PfI){
		if($PfI == 1){
			$ReturnValue = 'Apartment Page';
			} elseif($PfI == 2){
				$ReturnValue = 'Shop Page';
				} elseif($PfI == 3){
					$ReturnValue = 'Apartment & Shop';
					} elseif($PfI == 4){
						$ReturnValue = 'Contact Page';
						}
		return $ReturnValue;
	}
	
	function fiften_mint_dvd($PassMint){
		
			if($PassMint <= 15){
				if($PassMint <= 6.9){
					$returntime = 0;
				} else {
					$returntime = 1;
				}
			} else {
				$GetFifTen = $PassMint / 15;
				list($Section_one,$Section_two)= explode('.', $GetFifTen);
				$Count_fif_mint = $Section_one * 15;
				$RemaingMints = $PassMint - $Count_fif_mint;	
				if($RemaingMints <= 6.9){
					$returntime = 0 + $Section_one;
				} else {
					$returntime = 1 + $Section_one;
				}
			}
		return $returntime;
	}
	
	function AttValueChecker($PassVal){
			if($PassVal == ''){
				$ReturnValue = '0';	
			} else {
				$ReturnValue = $PassVal;
			}
		return $ReturnValue;
	}
	
	function LeaveModes($ModeId){
		if($ModeId == 1){
			$ReturnValue = 'Late-In';
			} elseif($ModeId == 2){
				$ReturnValue = 'Short-Time';
				} elseif($ModeId == 3){
					$ReturnValue = 'Absent';
					} elseif($ModeId == 4){
						$ReturnValue = 'Late-In & Short-Time';
						} elseif($ModeId == 5){
							$ReturnValue = 'Out Time Missing';
					}
		return $ReturnValue;
	}
	
	//1=>LI(0.25), 2=>LI(0.50), 3=>LI(1), 4=>EOUT(0.10), 5=>EOUT(0.25), 6=>EOUT(0.50), 7=>EOUT(1), 8=>Absent(1)
	function LeaveIntValueLabel($PassId){
		if($PassId == "1.00"){
			$ReturnValuePass = '0.25';
			} elseif($PassId == "2.00"){
				$ReturnValuePass = '0.50';
				} elseif($PassId == "3.00"){
					$ReturnValuePass = '1.00';
					} elseif($PassId == "4.00"){
						$ReturnValuePass = '0.10';
						} elseif($PassId == "5.00"){
							$ReturnValuePass = '0.25';
							} elseif($PassId == "6.00"){
								$ReturnValuePass = '0.50';
								} elseif($PassId == "7.00"){
									$ReturnValuePass = '1.00';
									} elseif($PassId == "8.00"){
										$ReturnValuePass = '1.00';
									}
			return $ReturnValuePass;
	}
	
	function JobTypeDetail($PassId){
		if($PassId == 1){
			$ReturnValue = 'Permanent';
			} elseif($PassId == 2){
				$ReturnValue = 'Contract';
				} elseif($PassId == 3){
					$ReturnValue = 'Temporary';
					} elseif($PassId == 4){
						$ReturnValue = 'Part-Time';
					}
		return $ReturnValue;
	}
	
	function YesNo($PassId){
		if($PassId == 1){
			$ReturnValue = 'Yes';
			} elseif($PassId == 2){
				$ReturnValue = 'No';
			}
		return $ReturnValue;
	}
	
	function OnOff($PassId){
		if($PassId == 1){
			$ReturnValue = 'On';
			} elseif($PassId == 2){
				$ReturnValue = 'Off';
			}
		return $ReturnValue;
	}
	
	function AdvancePayBackMode($PayBackMode){
		if($PayBackMode == 1){
			$ReturnValue = 'One Time';
			} elseif($PayBackMode == 2){
				$ReturnValue = 'Monthly Bases';
			}
		return $ReturnValue;
	}
	
	function RequestFlowType($RequestId){
		if($RequestId == 1){
			$ReturnValue = 'Department Base';
			} elseif($RequestId == 2){
				$ReturnValue = 'Employee Base';
			}
		return $ReturnValue;
	}
	
	function OverTimeRateCounter($RateId){
		if($RateId == 1){
			$ReturnValue = '1x';
			} elseif($RateId == 2){
				$ReturnValue = '1.5x';
				} elseif($RateId == 3){
					$ReturnValue = '2x';
					}
		return $ReturnValue;
	}
	
	function RequestedLeadsTitle($TypeId){
		if($TypeId == 1){
			$ReturnType = 'No. of New Leads';
			} elseif($TypeId == 2){
				$ReturnType = 'No. of Follow up Leads';
				} elseif($TypeId == 3){
					$ReturnType = 'No. of Not Responding';
					} elseif($TypeId == 4){
						$ReturnType = 'No. of Interested Leads';
						} elseif($TypeId == 5){
							$ReturnType = 'No. of Not Interested Leads';
							} elseif($TypeId == 6){
								$ReturnType = 'No. of Converted Leads';
								} elseif($TypeId == 7){
									$ReturnType = 'No. of Hot Leads';
									} elseif($TypeId == 8){
										$ReturnType = 'No. of Cold Leads';
										} elseif($TypeId == 9){
											$ReturnType = 'No. of Zameen Leads';
											} elseif($TypeId == 10){
												$ReturnType = 'No. of OLX Leads';
												} elseif($TypeId == 11){
													$ReturnType = 'No. of Social Media Leads';
													} elseif($TypeId == 12){
														$ReturnType = 'No. of Other Leads';
										
								}
		return $ReturnType;
	}
	
	function fatal_error_handler($buffer){
		$error=error_get_last();
		if($error['type'] == 1){
			// type, message, file, line
			$newBuffer='<div class="content-page">
					<!-- Start content -->
					<div class="content">
						<div class="container">
							<div class="wrapper-page">
								<div class="ex-page-content text-center">
									<div class="text-error">
										<span class="text-primary">4</span><i class="ti-face-sad text-pink"></i><span class="text-info">4</span>
									</div>
									<h2>Who0ps! Page not found</h2>
									<br>
									<p class="text-muted">
										This page cannot found or is missing.
									</p>
									<p class="text-muted">
										Use the navigation above or the button below to get back and track.
									</p>
									<br>
									<a class="btn btn-default waves-effect waves-light" href="'.SITE_URL.'"> Return Home</a>
								</div>
							</div>
							<!-- end wrapper page -->
						</div> <!-- container -->
					</div> <!-- content -->
					<footer class="footer">
					   <?php echo ADMIN_FOOTER;?>
					</footer>
				</div>';
			return $newBuffer;
		}
		return $buffer;
	}
	
	function get_client_ip() {
		$ipaddress = '';
			if (getenv('HTTP_CLIENT_IP'))
				$ipaddress = getenv('HTTP_CLIENT_IP');
			else if(getenv('HTTP_X_FORWARDED_FOR'))
				$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
			else if(getenv('HTTP_X_FORWARDED'))
				$ipaddress = getenv('HTTP_X_FORWARDED');
			else if(getenv('HTTP_FORWARDED_FOR'))
				$ipaddress = getenv('HTTP_FORWARDED_FOR');
			else if(getenv('HTTP_FORWARDED'))
			   $ipaddress = getenv('HTTP_FORWARDED');
			else if(getenv('REMOTE_ADDR'))
				$ipaddress = getenv('REMOTE_ADDR');
			else
				$ipaddress = 'UNKNOWN';
	
		return $ipaddress;
	}
	
	function IncomeTaxCalculation($EmployeeSalary){
		
			$YearlyEmpSalary 	= $EmployeeSalary * 12;
			$amountexceeded 	= 0;
			$percentage 		= 0;
			$interest 			= 0;
		
			if($YearlyEmpSalary > 600000 && $YearlyEmpSalary <= 1200000){
				$amountexceeded = $YearlyEmpSalary - 600000;
				$percentage = 0.05;
			}
	
			if($YearlyEmpSalary > 1200000 && $YearlyEmpSalary <= 1800000){
				$amountexceeded = $YearlyEmpSalary - 1200000;
				$interest = 30000;
				$percentage = 0.1;
			}
	
			if($YearlyEmpSalary > 1800000 && $YearlyEmpSalary <= 2500000){
				$amountexceeded = $YearlyEmpSalary - 1800000;
				$percentage = 0.15;
				$interest = 90000;
			}
	
			if($YearlyEmpSalary > 2500000 && $YearlyEmpSalary <= 3500000){
				$amountexceeded = $YearlyEmpSalary - 2500000;
				$percentage = 0.175;
				$interest = 195000;
			}
	
			if($YearlyEmpSalary > 3500000 && $YearlyEmpSalary <= 5000000){
				$amountexceeded = $YearlyEmpSalary - 3500000;
				$percentage = 0.20;
				$interest = 370000;
			}
	
			if($YearlyEmpSalary > 5000000 && $YearlyEmpSalary <= 8000000){
				$amountexceeded = $YearlyEmpSalary - 5000000;
				$percentage = 0.225;
				$interest = 670000;
			}
	
			if($YearlyEmpSalary > 8000000 && $YearlyEmpSalary <= 12000000){
				$amountexceeded = $YearlyEmpSalary - 8000000;
				$percentage = 0.25;
				$interest = 1345000;
			}
	
			if($YearlyEmpSalary > 12000000 && $YearlyEmpSalary <= 30000000){
				$amountexceeded = $YearlyEmpSalary - 12000000;
				$percentage = 0.275;
				$interest = 2345000 ;
			}
	
			if($YearlyEmpSalary > 30000000 && $YearlyEmpSalary <= 50000000){
				$amountexceeded = $YearlyEmpSalary - 30000000;
				$percentage = 0.30;
				$interest = 7295000;
			}
	
			if($YearlyEmpSalary > 50000000 && $YearlyEmpSalary <= 75000000){
				$amountexceeded = $YearlyEmpSalary - 50000000;
				$percentage = 0.325;
				$interest = 13295000;
			}
	
			if($YearlyEmpSalary > 75000000 ){
				$amountexceeded = $YearlyEmpSalary - 8000000;
				$percentage = 0.35;
				$interest = 21420000;
			}
		
			$yTax = $amountexceeded * $percentage + $interest;
			$mTax = $yTax / 12;
		return round($mTax,2);
	}
	
	// see if language is changed.
	if($_SESSION['allsite_lang']==''){
		$_SESSION['allsite_lang'] = $_CONFIG['lang'];
		$_CONFIG['lang'] = 'EN';
		setcookie('allsite_lang', $_CONFIG['lang'], time() + 31536000); // store the language in cookie for 1 year (365 days)
	} elseif($_REQUEST['C']=='LNG'){
		$_CONFIG['lang'] = $_REQUEST['lang'];
		$_SESSION['allsite_lang'] = $_REQUEST['lang'];
		setcookie('allsite_lang', $_CONFIG['lang'], time() + 31536000); // store the language in cookie for 1 year (365 days)
		$link = $_SERVER["HTTP_REFERER"];
		redirect($link);
	}
	
	define('SITE_LANG', $_SESSION['allsite_lang']);
	//define("PERPAGE", 50);
	/*********** Define the values *********/
	define("HOST", $dbCfg['host']);
	define("DBUSER", $dbCfg['db_user']);
	define("DBPASSWD", $dbCfg['db_passwd']);
	define("DBNAME", $dbCfg['db_name']);
	define("SITE_URL", '');
?>