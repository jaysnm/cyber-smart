<html>
<head>
<title>Smart Cyber</title>
<meta author="jaysnmury@gmail.com" content="jason Muriki" />
<link rel="stylesheet" href="css/postpaid.css" />
</head>
<body>
<h3><i>Welcome To DeKUT <small>Smart Cyber</small></i></h3>
<form action="api/user_login.php" method="post" id="user-form">
<label>UserName: </label>
<input name="username" id="username" type="text" /></br>
<label>Passcode: </label>
<input name="passcode" id="passcode" type="password" /></br>
<input type="submit" value="Submit Form" name="user-login"/>
</form>
<form action="api/user_login.php" method="post" id="user-form">
<label>pre paid cyber services subscription: </label>
<input name="amount" id="amount" type="text" placeholder="Ksh..."/></br>
<label>subscription Phone Number: </label>
<input name="phone" id="phone" type="text" placeholder="eg... +2547...."/></br>
<input type="submit" value="Pay Bill To Cyber Smart" name="payment"/>
</form>
</body>
<script src="js/jQuery-2.1.4.min.js"></script>
<script src="js/fingerprint.js"></script>
</html>
