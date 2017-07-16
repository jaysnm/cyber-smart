<?php
if(isset($_POST['user-login'])){
require_once('db.config.php');
$username = $_POST['username'];
$passcode = $_POST['passcode'];
$encryptedPass = cryptPassword($passcode);
$client_ip =  unix_os();
if(!$client_ip){
  $client_ip = win_os();
}
$table = $GLOBALS['prepaid_tbl'];
$connect = $GLOBALS['server_connect'];
$log_file = $GLOBALS['log_file'];
$auth_sql = "SELECT id FROM $table WHERE username = :username AND passcode = :passcode";
try{
  $prepare = $connect->prepare($auth_sql);
  $prepare->execute(array(':username'=>$username, ':passcode'=>$encryptedPass));
}
catch(Exception $error){
  $file = fopen($log_file, 'a');
  fwrite($file, "User Authentication Failed.\n".$error->getMessage());
  fclose($file);
  echo json_encode(array('resp'=>"<div class='failed'>User Authentication Failed. Try again later</div>"));
}
if($prepare->rowCount() == 1){
  $insertSql = "UPDATE $table SET mac_address = :mac_address, ip_address=:ip_address WHERE username = :username";
  $insert_array = array(':mac_address'=>$client_ip['mac_add'], ':ip_address'=>$client_ip['ip_add'], ':username'=>$username);
  try{
    $prepare = $connect->prepare($insertSql);
    $prepare->execute($insert_array);
  }
  catch(Exception $error){
    $file = fopen($log_file, 'a');
    fwrite($file, "User mac_address authentication Failed.\n".$error->getMessage());
    fclose($file);
    echo "<div class='failed'>User mac_address authentication Failed.</div>";
  }
    echo json_encode(array('resp'=>"index.php", 'message'=>"<div class='success'>User Allowed to Use WIFI.</div>"));
}else{
  echo json_encode(array('resp'=>"index.php", 'message'=>"<div class='failed'>User Not Authorised to use the service. Check that details given are correct. </div>"));
}

}
else if(isset($_POST['simulate'])){
  require_once('db.config.php');
  $amount = $_POST['amount'];
  $phone = $_POST['phone'];
  $username = genUsername(7, 14, True);
  $password = genPassword(8, 12);
  $encPass = cryptPassword($password);
  $table = $GLOBALS['prepaid_tbl'];
  $connect = $GLOBALS['server_connect'];
  $log_file = $GLOBALS['log_file'];
  $subscribed_sql = "SELECT id FROM $table WHERE username = :username ";
  try{
    $subscribed = $connect->prepare($subscribed_sql);
    $subscribed->execute(array(':username'=>$username));
  }
  catch(Exception $error){
    $file = fopen($log_file, 'a');
    fwrite($file, "User Detail not handled properly.\n".$error->getMessage());
    fclose($file);
    echo json_encode(array('resp'=>"<div class='failed'>Request Not Processed</div>"));
  }
  if($subscribed->rowCount() == 0){
    $airtime = $amount*2;
    $hrs = intval($airtime/60);
    $mins = intval($airtime - ($hrs*60));
    $insertSql = "INSERT INTO $table (username, passcode, phone, amount, airtime_hrs, airtime_mins)
    values (:username, :passcode, :phone, :amount, :airtime_hrs, :airtime_mins)";
    $insert_array = array(':username'=>$username, ':passcode'=>$encPass, ':phone'=>substr($phone, 1), ':amount'=>$amount, ':airtime_hrs'=>$hrs, ':airtime_mins'=>$mins);
    try{
      $prepare = $connect->prepare($insertSql);
      $prepare->execute($insert_array);
    }
    catch(Exception $error){
      $file = fopen($log_file, 'a');
      fwrite($file, "User Details not inserted into database.\n".$error->getMessage());
      fclose($file);
      echo json_encode(array('resp'=>"<div class='failed'>User Registration Failed</div>"));
    }
    sendUserText($phone, $amount, $username, $password);
  else{
    $num = $subscribed->rowCount();
    echo json_encode(array('resp'=>"<div class='failed'>$num users found to be rigistered by provided username</div>"));
  }
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

function win_os(){
    ob_start();
    system('ipconfig-a');
    $mycom=ob_get_contents();
    file_put_contents('ob_get_contents.json', $mycom);
    $str = substr($mycom, strpos($mycom, "wlp2s0"));
    $mac = string_between($str, 'HWaddr', ' inet');
    $ip_addr = string_between($str, 'addr:', ' Bcast:');
    $client = get_client_ip();
    $identifiers = array('mac_add'=>$mac, 'ip_add'=>$ip_addr, 'client-ip'=>$client);
    return $identifiers;
   }

   function unix_os(){
    ob_start();
    system('ifconfig -a');
    $mycom = ob_get_contents();
    ob_clean();
    file_put_contents('ob_get_contents.json', $mycom);
    $str = substr($mycom, strpos($mycom, "wlp2s0"));
    $mac = string_between($str, 'HWaddr', ' inet');
    $ip_addr = string_between($str, 'addr:', ' Bcast:');
    $client = get_client_ip();
    $identifiers = array('mac_add'=>$mac, 'ip_add'=>$ip_addr, 'client-ip'=>$client);
    return $identifiers;
    }

    function string_between($string, $start, $end){
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
  }

function genUsername($min, $max, $case_sensitive)
	{
		$length = rand($min, $max)-1;
		if ( $case_sensitive )
		{
			$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
		}
		else
		{
			$chars = "abcdefghijklmnopqrstuvwxyz";
		}
		$chars_length = strlen($chars)-1;
		$username = "";

		for ( $i = 0; $i < $length; $i++ )
		{
			$username .= $chars[mt_rand(0, $chars_length)];
		}

		return $username;
	}

  function genPassword( $min, $max)
	{
		$length = rand($min, $max);
		$lower = 'abcdefghijklmnopqrstuvwxyz';
		$upper = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$chars = '123456789@#$%&';
		$lower_length = strlen($lower)-1;
		$upper_length = strlen($upper)-1;
		$chars_length = strlen($chars)-1;
		$password = '';
		$alt = time() % 2;
		for ($i = 0; $i < $length; $i++)
		{
			if ($alt == 0)
			{
				$password .= $lower[mt_rand(0, $lower_length)]; $alt = 1;
			}
			if ($alt == 1)
			{
				$password .= $upper[mt_rand(0, $upper_length)]; $alt = 2;
			}
			else
			{
				$password .= $chars[mt_rand(0, $chars_length)]; $alt = 0;
			}
		}
		return $password;
	}

  function cryptPassword( $password )
	{
    $salt = '$2a$07$usesomesillystringforsalt$';
		return md5(crypt($password, $salt));
	}

  function sendUserText($phone, $amount, $username, $passcode){
    $time_hrs = intval(($amount*2)/60);
    $time_mins = intval(($amount*2)-($time_hrs*60));
    $message = "You can now access WIFI at cyber_smart for $time_hrs hrs & $time_mins mins after having bought Ksh$amount vocher";
    $message .= "Your username is $username and password is $passcode";
    require_once('AfricasTalkingGateway.php');
    $username   = "jsoft.jason";
    $apikey     ="c6fc68217e22c20da256ec566a2c301a00e440b0a530e40813eb46a7d872fdcd";
    $gateway  = new AfricaStalkingGateway($username, $apikey);
    try
      {
        $results = $gateway->sendMessage($phone, $message);
        foreach($results as $result) {
          echo " Number: " .$result->number;
          echo " Status: " .$result->status;
          echo " MessageId: " .$result->messageId;
          echo " Cost: "   .$result->cost."\n";
        }
      }
      catch ( AfricasTalkingGatewayException $e )
      {
        echo "Encountered an error while sending: ".$e->getMessage();
      }
      fetchSmsMessage($gateway);
  }


function fetchSmsMessage($gateway){
require_once('AfricasTalkingGateway.php');
try
{
  $lastReceivedId = 0;
  do {

    $results = $gateway->fetchMessages($lastReceivedId);
    foreach($results as $result) {

      echo " From: " .$result->from;
      echo " To: " .$result->to;
      echo " Message: ".$result->text;
      echo " Date Sent: " .$result->date;
      echo " LinkId: " .$result->linkId;
      echo " id: ".$result->id;
      echo "\n";
      $lastReceivedId = $result->id;

    }
  } while ( count($results) > 0 );

  echo json_encode(array('resp'=>'index.php', 'message'=>"<div class='success'>Africas</div>"));
}
catch ( AfricasTalkingGatewayException $e )
{
  echo json_encode(array('resp'=>"Message sending failure</br>Encountered an error: ".$e->getMessage()));
}

}


?>
