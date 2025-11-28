$(document).ready(function(){
function loadProfile(){
// Check if user is logged in
var token = localStorage.getItem('sessionToken');
if (!token) {
window.location.href = 'login.html';
return;
}

$.ajax({
url: '../php/profile.php',
method: 'GET',
data: {token: token},
dataType: 'json',
success: function(res){
if(res.success){
var u = res.user;
var html = '<div class="row">' +
'<div class="col-md-6">' +
'<p><strong>Name:</strong> '+(u.name||'N/A')+'</p>' +
'<p><strong>Email:</strong> '+(u.email||'N/A')+'</p>' +
'<p><strong>Age:</strong> '+(u.age||'N/A')+'</p>' +
'<p><strong>Date of Birth:</strong> '+(u.dob||'N/A')+'</p>' +
'</div>' +
'<div class="col-md-6">' +
'<p><strong>Phone:</strong> '+(u.phone||'N/A')+'</p>' +
'<p><strong>Address:</strong> '+(u.address||'N/A')+'</p>' +
'<p><strong>Gender:</strong> '+(u.gender||'N/A')+'</p>' +
'<p><strong>Joined:</strong> '+(u.created_at||'N/A')+'</p>' +
'</div>' +
'</div>';
$('#profileArea').html(html);

// Populate edit form
$('#editName').val(u.name||'');
$('#editEmail').val(u.email||'');
$('#editAge').val(u.age||'');
$('#editDob').val(u.dob||'');
$('#editPhone').val(u.phone||'');
$('#editAddress').val(u.address||'');
$('#editGender').val(u.gender||'');
} else {
// not logged in -> go to login
window.location.href = 'login.html';
}
},
error: function(){ alert('Server error'); }
});
}
$('#logoutBtn').on('click', function(){
var token = localStorage.getItem('sessionToken');
$.ajax({
url:'../php/logout.php', 
method:'POST', 
data: {token: token},
success:function(){ 
localStorage.removeItem('sessionToken');
window.location.href='login.html'; 
}
});
});

// Edit profile functionality
$('#editProfileBtn').on('click', function(){
$('#profileArea').hide();
$('#editProfileArea').show();
$(this).hide();
});

$('#cancelEditBtn').on('click', function(){
$('#editProfileArea').hide();
$('#profileArea').show();
$('#editProfileBtn').show();
});

$('#editProfileForm').on('submit', function(e){
e.preventDefault();
var token = localStorage.getItem('sessionToken');
if (!token) {
window.location.href = 'login.html';
return;
}

$.ajax({
url: '../php/profile.php',
method: 'POST',
data: $(this).serialize() + '&action=update&token=' + token,
dataType: 'json',
success: function(res){
if(res.success){
alert('Profile updated successfully!');
$('#editProfileArea').hide();
$('#profileArea').show();
$('#editProfileBtn').show();
loadProfile(); // Reload profile data
} else {
alert(res.message || 'Update failed');
}
},
error: function(){
alert('Server error during update');
}
});
});

loadProfile();
});