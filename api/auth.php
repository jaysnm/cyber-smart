<?php
ob_start();
session_start();
if(isset($_SESSION['username'])){
  $username = $_SESSION['username'];
  $passcode = $_SESSION['passcode'];
  $message = $_SESSION['message'];
  $message .= '<p>You can also change your passcode and username to something you will easily remember</p>';
echo "<script language='javascript' type='javascript'>bootbox.alert('Username: '+$username+'</br>Passcode: '+$passcode+'</br>Message: '+$message);</script>";
}
else if(isset($_SESSION['Number'])){

}





 ?>
