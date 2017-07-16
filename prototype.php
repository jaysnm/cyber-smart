<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Prototype</title>
<link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="css/prepaid.css" />
<script type="text/javascript">
//auto expand textarea
function adjust_textarea(h) {
    h.style.height = "45px";
    h.style.height = (h.scrollHeight)+"px";
}
</script>
</head>

<body>

<div class="form-style-5">
  <h2>System Admin Prototyping Page</h2>
  <form>
    <input type="text" name="amount" placeholder="Amount in Ksh eg... 700" required/>
    <input type="text" name="phone" placeholder="Phone number eg 07.... or +2547....." required/>
    <center> <input  type="submit" value="Simulate" id="simulate" name='simulate'/></center>
    <div class="errror-status"></div>
  </form>
</div>

</body>
<script src="js/jQuery-2.1.4.min.js"></script>
<script src="js/forms.validate.js"></script>
</html>
