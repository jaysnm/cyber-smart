<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Prepaid</title>
<link rel="stylesheet" href="css/styles.css" />
<link rel="stylesheet" href="css/prepaid.css" />
<script type="text/javascript">
//auto expand textarea
function adjust_textarea(h) {
    h.style.height = "20px";
    h.style.height = (h.scrollHeight)+"px";
}
</script>
</head>
<body>

<form method="post"  class="form-style-5">
<h1>PRE-PAID</h1>
<ul>
<li>
    <label for="name">Username* </label>
    <input type="text" name="username" placeholder="Enter username sent to your phone">
</li>
<li>
    <label for="id">Passcode* </label>
    <input type="password" name="passcode" placeholder="Enter passcode sent to your phone number">
</li>

<li>
  <input  type="submit" id="user-login" value="LOGIN TO SYSTEM" name="user-login">
</li>

</ul>
<div class="errror-status"></div>
</form>

<script src="js/jQuery-2.1.4.min.js"></script>
<script src="js/forms.validate.js"></script>
</body>
</html>
