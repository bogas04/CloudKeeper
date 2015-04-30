var service = {
  signup : function(details, $msg) {
    // TODO : Do js validation for username, pass, first and last name
    console.log(details);
    $.ajax({
      url : 'php/signup.php',
      data : details,
      type : 'post',
      dataType : 'json',
      success : function(r) {
        $msg.html(r.msg);
        $msg.css('display', 'block');
        $msg.removeClass(r.error?'alert-success':'alert-danger');
        $msg.addClass(r.error?'alert-danger':'alert-success');
      }
    });
  },
  login : function(details, $msg) {
    console.log(details);
    // TODO : Do js validation for username, pass
    $.ajax({
      url : 'php/login.php',
      data : details,
      type : 'post',
      dataType : 'json',
      success : function(r) {
        $msg.html(r.msg);
        $msg.css('display', 'block');
        $msg.removeClass(r.error?'alert-success':'alert-danger');
        $msg.addClass(r.error?'alert-danger':'alert-success');
        if(!r.error) { window.location = 'dashboard.php'; }
      }
    });
  }  
};

$(function() {
  $('a[href^=#]').on('click', function(e) {  
    $target = $(e.currentTarget.getAttribute('href'));
    $('html, body').animate({
      scrollTop : $target.offset().top + 150
    }, 250);
    e.isDefaultPrevented = true;
    return false;
  });
  // Bootstrapping
  $('.message').html(); 
  $('.message').css('display', 'none');
  $('#signup-form').on('submit', function() {
    service.signup({
      username : $('#signup-form [name=username]').val(),
      password : $('#signup-form [name=password]').val(),
      first_name : $('#signup-form [name=first_name]').val(),
      last_name : $('#signup-form [name=last_name]').val()
    }, $('#signup-form .message'));
    return false;
  });  
  $('#login-form').on('submit', function() {
    service.login({
      username : $('#login-form [name=username]').val(),
      password : $('#login-form [name=password]').val()
    }, $('#login-form .message'));
    return false;
  });  
});
