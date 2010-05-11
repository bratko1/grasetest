<?

function rand_password($len)
{
	$c = "bcdfghjklmnprstvwz";
	$v = "aeiou";
	$password = "";

	#change 4 to how many sylabols
	for($i=0;$i < ($len/3); $i++){
	    if(!rand(0,1))
	    {
            	
		    $password.= $c[rand(0, strlen($c)-1)];
		    $password.= $v[rand(0, strlen($v)-1)];
		    $password.= $c[rand(0, strlen($c)-1)];
		    if($i+1 < ($len/3)) $password.=rand(1,9);
		    if($i+1 < ($len/3)) $password.=rand(1,9);		
		}else{
//		    if($i+1 < ($len/3)) $password.=rand(1,9);
//		    if($i+1 < ($len/3)) $password.=rand(1,9);				
		    $password.= $c[rand(0, strlen($c)-1)];
		    $password.= $v[rand(0, strlen($v)-1)];
		    $password.= $c[rand(0, strlen($c)-1)];
		}
	}
    if(strlen($password) < $len + 2) $password.=rand(1,9);
    if(strlen($password) < $len + 2) $password.=rand(1,9);				
	
	return $password;
}

function rand_username($len)
{
	$c = "bcdfghjklmnprstvwz";
	$v = "aeiou";
	$password = "";

	#change 4 to how many sylabols
	for($i=0;$i < ($len/2); $i++){
	    if(rand(0,1))
	    {
		    if($i+1 < ($len/2)) $password.=rand(1,9);	    
		    $password.= $c[rand(0, strlen($c)-1)];
		    $password.= $v[rand(0, strlen($v)-1)];	    
	    }else
	    {	    
    //		$password.= $c[rand(0, strlen($c)-1)];
		    $password.= $v[rand(0, strlen($v)-1)];
		    $password.= $c[rand(0, strlen($c)-1)];
		    if($i+1 < ($len/2)) $password.=rand(1,9);
        }		
	}
	return $password;
}

function expiration_date_format($date)
{
	list($year, $month, $day) = split("-", $date);
	if($year && $month && $day) 	return date("F d Y H:i:s", makeTimeStamp($year, $month, $day));
	if(!$year && !$month && !$day) return "";
	die("Problem With expiration Date Format");
	//	return date("F d Y H:i:s", makeTimeStamp($year, $month, $day));
}

function expiration_to_timestamp($date)
{
	return strtotime($date);
	list($year, $month, $day) = split("-", $date);
	return l($year, $month, $day);
}

function makeTimeStamp($year='', $month='', $day='')
{
   if(empty($year))
   {
       $year = strftime('%Y');
   }
   if(empty($month))
   {
       $month = strftime('%m');
   }
   if(empty($day)) 
   {
       $day = strftime('%d');
   }

   return mktime(0, 0, 0, $month, $day, $year);
}

/*function formatSec($seconds = 0)
{
	$minutes = intval($seconds / 60 % 60);
	$hours = intval($seconds / 3600 % 24);
	$days = intval($seconds / 86400);
	$seconds = intval($seconds % 60);
	if($days < 1) return sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);
	if($days == 1) return sprintf("%d day %02d:%02d:%02d", $days, $hours, $minutes, $seconds);
	return sprintf("%d days %02d:%02d:%02d", $days, $hours, $minutes, $seconds);
}*/

/*function formatBytes($bytes = 0)
{
	if(!$bytes)$bytes=0;
	$kbytes = round($bytes / 1000,2);
	$mbytes = round($kbytes / 1000,2) ;
	$gbytes = round($mbytes / 1000,2);
	   
	if(($kbytes < 1)) return "$bytes b";
	if(($mbytes < 1)) return "$kbytes Kb";
	if(($gbytes < 1)) return "$mbytes Mb";
	return "$gbytes Gb";
	/*    return bytes + ' bytes';*/
//}

/*function formatsecold($sec)
{
	$hour = '00'; $day = '00';
	$min = floor($sec/60);
	$sec = $sec - $min * 60;
	if($min > 60)
	{
		$hour = floor($min / 60);
		$min = $min - $hour * 60;
	}
/*	if($hour > 24)
	{
		$day = floor($hour / 24);
		$hour = $hour - $day * 24;
	}*//*
	$hour = str_pad($hour, 2, "0", STR_PAD_LEFT);
	$min = str_pad($min, 2, "0", STR_PAD_LEFT);
	$sec = str_pad($sec, 2, "0", STR_PAD_LEFT);		
	return "$hour:$min:$sec";
}*/


// Validation functions
function validate_post_expirydate()
{
	$error='';
	$expirydate ="${_POST['Expirydate_Year']}-${_POST['Expirydate_Month']}-${_POST['Expirydate_Day']}";
	if ( ! $_POST['Expirydate_Day'] &&
		 ! $_POST['Expirydate_Month'] &&
		 ! $_POST['Expirydate_Year'])
	{
		$expirydate='';/* No Expiry */ 
	}
	
	if ($expirydate &&
	 	! (	$_POST['Expirydate_Day'] &&
	 		$_POST['Expirydate_Month'] &&
	 		$_POST['Expirydate_Year'])
	 	)
	{
	 	/* Invalid date */
	 	$error.="Invalid Expiry Date<br/>";
	}
	
	if( $expirydate &&
		makeTimeStamp(
			$_POST['Expirydate_Year'],
			$_POST['Expirydate_Month'],
			$_POST['Expirydate_Day'] ) < time()
		)
	{
		$error.="Expiry Date in the past<br/>";
	}
	return array($error,$expirydate);
}

function validate_datalimit($limit)
{
	if ($limit && ! is_numeric($limit) ) return "Invalid value '$limit' for Data Limit<br/>";
	// TODO Return what?
}

function validate_timelimit($limit)
{
	if ($limit && ! is_numeric($limit) ) return "Invalid value '$limit' for Time Limit<br/>";
	// TODO Return what?
}

function validate_int($number)
{
	if ($number && is_numeric($number) && trim($number) != "") return "";
    return "Invalid number '$number' (Must be whole number)<br/>";
	// TODO Return what?
}

function validate_group($username, $group)
{
	global $Usergroups;
	if(isset($Usergroups[$group]))
	{
		if($group == MACHINE_GROUP_NAME && strpos($username, "-dev") === false) return "Only Machines can be in the Machine group<br/>"; // TODO Internationalsation of all strings
		return "";
	}else
	{
		return "Invalid Group<br/>";
	}
}

function expiry_for_group($group)
{
	global $Expiry;
	if(isset($Expiry[$group]) && $Expiry[$group] != '--') return date('Y-m-d', strtotime($Expiry[$group]));
	if(isset($Expiry[$group]) && $Expiry[$group] == '--') return "--";
	return date('Y-m-d', strtotime($Expiry[DEFAULT_GROUP_NAME]));
}

function user_account_status($Userdata)
{
	if(isset($Userdata['ExpirationTimestamp']) && $Userdata['ExpirationTimestamp'] < time())
	{
	    $status = EXPIRED_ACCOUNT;
	}
	elseif(isset($Userdata['Max-Octets']) && ($Userdata['Max-Octets'] - $Userdata['AcctTotalOctets']) <= 0 )
	{
	    $status = LOCKED_ACCOUNT;
	}
	elseif(isset($Userdata['Max-Octets']) && ($Userdata['Max-Octets'] - $Userdata['AcctTotalOctets']) <= 1024*1024*2 )
	{
	    $status = LOWDATA_ACCOUNT;
	}
	elseif($Userdata['Group'] == MACHINE_GROUP_NAME)
	{
	    $status = MACHINE_ACCOUNT; 
	}
	elseif($Userdata['Group'] != "")
	{
	    $status = NORMAL_ACCOUNT;
	}
	else
	{
	    $status = NOGROUP_ACCOUNT;
	}
	return $status;
}

function sort_users_into_groups($users)
{
	$users_group = array();
	foreach($users as $user)
	{
		if(isset($user['Group']) && $user['Group'] != '')
		{
			$users_group[$user['Group']][] = $user;
		}else
		{
			$users_group['Nogroup'][] = $user;
		}
	}
	return $users_group;
}

function clean_text($text)
{

	$text = strip_tags($text);
	$text = str_replace("<", "", $text);
	$text = str_replace(">", "", $text);

#	$text = htmlspecialchars($text, ENT_NOQUOTES);
#	$text = mysql_real_escape_string($text);

	return $text;
}


function file_upload_error_message($error_code)
{
    switch ($error_code)
    {
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
		case 2:
            return 'Uploaded Image was too big';
            
        case UPLOAD_ERR_PARTIAL:
            return 'Error In Uploading';
            
        case UPLOAD_ERR_NO_FILE:
            return 'No file was uploaded';
            
        case UPLOAD_ERR_NO_TMP_DIR:
            return 'Missing a temporary folder';
            
        case UPLOAD_ERR_CANT_WRITE:
            return 'Failed to write file to disk';
            
        case UPLOAD_ERR_EXTENSION:
            return 'File upload stopped by extension';
            
        default:
            return 'Unknown upload error';
    }
}

function sha1salt($plainText, $salt = null) 
    {
        $SALT_LENGTH = 9;
        if ($salt === null) 
        {
            $salt = substr(md5(uniqid(rand() , true)) , 0, $SALT_LENGTH);
        }
        else
        {
            $salt = substr($salt, 0, $SALT_LENGTH);
        }
        
        return $salt . sha1($salt . $plainText);
    }

?>