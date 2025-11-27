$(document).ready(function(){
function loadProfile(){
$.ajax({
url: '../php/profile.php',
method: 'GET',
dataType: 'json',
success: function(res){
if(res.success){
var u = res.user;
var html = '<p><strong>Name:</strong> '+(u.name||'')+'</p>'+
'<p><strong>Email:</strong> '+(u.email||'')+'</p>'+
'<p><strong>Joined:</strong> '+(u.created_at||'')+'</p>';
$('#profileArea').html(html);
} else {
// not logged in -> go to login
window.location.href = 'login.html';
}
},
error: function(){ alert('Server error'); }
});
}
$('#logoutBtn').on('click', function(){
$.ajax({url:'../php/logout.php', method:'POST', success:function(){ window.location.href='login.html'; }});
});
loadProfile();
});