$(document).ready(function () {
  $('#registerForm').on('submit', function (e) {
    e.preventDefault();
    
    // Show loading animation
    $('#registerBtn').prop('disabled', true);
    $('#registerBtnText').text('Registering...');
    $('#registerSpinner').show();

    $.ajax({
      url: '../php/register.php',
      method: 'POST',
      data: $(this).serialize(),
      dataType: 'json',
      success: function (res) {
        if (res.success) {
          $('#registerBtnText').text('Success!');
          $('#registerSpinner').hide();
          alert('Registered successfully. Please login.');
          window.location.href = 'login.html';
        } else {
          alert(res.message || 'Registration failed.');
        }
      },
      error: function (xhr, status, error) {
        alert("Server Error: " + error);
        console.log(xhr.responseText);
      },
      complete: function() {
        // Reset button state
        $('#registerBtn').prop('disabled', false);
        $('#registerBtnText').text('Register');
        $('#registerSpinner').hide();
      }
    });
  });
});
