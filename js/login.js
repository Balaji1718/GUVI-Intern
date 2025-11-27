$(document).ready(function(){
$('#loginForm').on('submit', function(e){
e.preventDefault();
$.ajax({
url: '../php/login.php',
method: 'POST',
data: $(this).serialize(),
dataType: 'json',
success: function(res){
if(res.success){
// redirect to profile
window.location.href = 'profile.html';
} else {
alert(res.message || 'Login failed');
}
},
error: function(){ alert('Server error'); }
});
});
});