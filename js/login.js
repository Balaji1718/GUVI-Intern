$(document).ready(function(){
  $('#loginForm').on('submit', function(e){
    e.preventDefault();
    
    // Show loading animation
    $('#loginBtn').prop('disabled', true);
    $('#loginBtnText').text('Logging in...');
    $('#loginSpinner').show();
    
    $.ajax({
      url: '../php/login.php',
      method: 'POST',
      data: $(this).serialize(),
      dataType: 'json',
      success: function(res){
        if(res.success){
          $('#loginBtnText').text('Success!');
          $('#loginSpinner').hide();
          // Store session token in localStorage
          localStorage.setItem('sessionToken', res.token);
          // redirect to profile
          window.location.href = 'profile.html';
        } else {
          alert(res.message || 'Login failed');
        }
      },
      error: function(){ 
        alert('Server error'); 
      },
      complete: function() {
        // Reset button state if not redirecting
        setTimeout(function() {
          $('#loginBtn').prop('disabled', false);
          $('#loginBtnText').text('Login');
          $('#loginSpinner').hide();
        }, 1000);
      }
    });
  });
});