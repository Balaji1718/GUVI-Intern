$(document).ready(function () {
  $('#registerForm').on('submit', function (e) {
    e.preventDefault();

    $.ajax({
      url: '/Login_page/php/register.php',
      method: 'POST',
      data: $(this).serialize(),
      dataType: 'json',
      success: function (res) {
        if (res.success) {
          alert('Registered successfully. Please login.');
          window.location.href = 'login.html';
        } else {
          alert(res.message || 'Registration failed.');
        }
      },
      error: function (xhr, status, error) {
        alert("Server Error: " + error);
        console.log(xhr.responseText);
      }
    });
  });
});
