<?php
class UserGenerator
{
	private $pass_min = 8;
	private $pass_max = 15;
	private $user_min = 7;
	private $user_max = 20;
	private $user_case = TRUE;
	private $salt = '$2a$07$usesomesillystringforsalt$';
	private $users = array();
	public function __construct()
	{
		$this->user = self::generate();
	}

	private function generate(){
			$table = $GLOBALS['prepaid_tbl'];
			$connect = $GLOBALS['server_connect'];
			$log_file = $GLOBALS['log_file'];
			$username = $this->genUsername( $this->user_min, $this->user_max, $this->user_case );
			echo $username;
			$subscribed_sql = "SELECT id FROM $table` WHERE username = :username ";
			try{
				$subscribed = $connect->prepare($subscribed_sql);
				$subscribed->execute(array(':username'=>$username));
			}
			catch(Exception $error){
				$file = fopen($log_file, 'a');
				fwrite($file, "User Detail not handled properly.\n".$error->getMessage());
				fclose($file);
				echo "Request Not Processed";
			}
			if (count($subscribed) == 0 ){
				$password = $this->genPassword( $this->pass_min, $this->pass_max );
				$encrypted = $this->cryptPassword($password);
				$this->users[$username] = array('username' => $username,'password' => md5($encrypted) );
			}else{
				self::generate();
			}
		return $this->users;
	}


	private function cryptPassword( $password )
	{
		return md5(crypt($password, $this->salt));
	}


	private function genUsername($min, $max, $case_sensitive)
	{
		$length = rand($min, $max);
		if ( $case_sensitive )
		{
			$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
		}
		else
		{
			$chars = "abcdefghijklmnopqrstuvwxyz";
		}
		$chars_length = strlen($chars);
		$username = "";

		for ( $i = 0; $i < $length; $i++ )
		{
			$username .= $chars[mt_rand(0, $chars_length-1)];
		}
		return $username;
	}

	private function genPassword( $min, $max)
	{
		$length = rand($min, $max);
		$lower = 'abcdefghijklmnopqrstuvwxyz';
		$upper = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$chars = '123456789@#$%&';
		$lower_length = strlen($lower);
		$upper_length = strlen($upper);
		$chars_length = strlen($chars);
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

	private function isNum( $num )
	{
		if ( is_int( (String) $num ) && ctype_digit((int) $num) && $num > 0 )
		{
			return true;
		}
		return false;
	}
}

 ?>
