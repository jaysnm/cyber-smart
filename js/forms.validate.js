$(document).ready(function(){
$('#user-login').on('click', function(){
  var username = $('input[name=username]').val();
  var passcode = $('input[name=passcode]').val();
  if($.trim(username).length == 0 || username.length < 7 || $.trim(passcode).length == 0 || passcode.length < 8){
    $('.errror-status').html("<span class='failed'>Username &&/Or Passcode doesn't meet required standards.</span>");
  }
  else{
  $.ajax({
    url: 'api/user_login.php',
    dataType: "json",
    data: {'user-login': true, 'username': username, 'passcode': passcode},
    method: "POST",
    success: function(data){
      console.log(data);
      var response = data.resp;
      var message = data.message;
      if (response.match(".php$")){
        $(location).attr('href',response);
      }else{
        $('.errror-status').html(response+message);
      }
    },
    fail: function(data){
      alert("Data sending failed.");
    }
  });
  }
  return false;
});

$('#simulate').click(function(){
  var amount = $('input[name=amount]').val();
  var phone = $('input[name=phone]').val();
  if($.trim(amount).length == 0 || $.trim(phone).length == 0 || phone.length < 10){
    $('.errror-status').html("<span class='failed'>Amount &&/Or Phone Number doesn't meet required standards.</span>");
  }
  else{
  $.ajax({
    url: 'api/user_login.php',
    dataType: "json",
    data: {'simulate': true, 'amount': amount, 'phone': phone},
    method: "POST",
    success: function(data){
      console.log(data);
      var message = data.message;
      var response = data.resp;
      if (response.match(".php$")){
        $(location).attr('href',response);
      }else{
        $('.errror-status').html(response+message);
      }
    },
    fail: function(data){
      alert("Data sending failed.");
    }
  });
  }
  return false;
});

});
