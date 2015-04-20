var service = {
  signup : function(details, $msglast_name) {
    console.log(details);
    $.ajax({
      url : 'php/signup.php',
      data : details,
      type : 'post',
      dataType : 'json',
      success : function(r) {
        console.log(r);
      }
    });
  },
  login : function(details, $msg) {
    console.log(details);
    $.ajax({
      url : 'php/login.php',
      data : details,
      type : 'post',
      dataType : 'json',
      success : function(r) {
        console.log(r);
      }
    });
  }  
};

$(function() {
  $('#signup-form').on('submit', function() {
    service.signup({
      username : $('#signup-form input[name=username]').val(),
      password : $('#signup-form input[name=password]').val(),
      first_name : $('#signup-form input[name=first_name]').val(),
      last_name : $('#signup-form input[name=last_name]').val()
    });
    return false;
  });  
  $('#login-form').on('submit', function() {
    service.login({
      username : $('#login-form input[name=username]').val(),
      password : $('#login-form input[name=password]').val()
    });
    return false;
  });  
});
