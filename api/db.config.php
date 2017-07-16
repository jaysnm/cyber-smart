<?php
$host = "127.23.57.6";
$user = "jason";
$password = "jason@smart_cyber";
$database = "cyber_smart";
$prepaid_tbl = "prepaid_clients";
$log_file = 'error_logs.file';
try{
	$server_connect = new PDO("mysql:host=$host; dbname=$database",$user,$password);
	$server_connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $err){
  $file = fopen($log_file, 'a+');
  fwrite($file, "\n".$err->getMessage());
  fclose($file);
	die("<div class='failed'>Service Requested currently unsupported </div>");
}
 ?>
