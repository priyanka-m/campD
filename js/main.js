var campDiaries = {};

campDiaries.HOST = 'http://localhost/cd/';
campDiaries.bindEvents = function() {
	$('#login_box').click(function(){
		$('.box').each(function(){
			$(this).removeClass('box_hover');
			$(this).addClass('moveLeft');
		});
		setTimeout(function(){
			$('.box').each(function(){
				$(this).hide();
			});
			$('#login_form').show();
			setTimeout(function(){
				$('#login_form').children('.form_box').addClass('form_box_show');
			}, 150);
		},450);
	});
	$('#sign_up').click(function(){
		$('.box').each(function(){
			$(this).removeClass('box_hover');
			$(this).addClass('moveLeft');
		});
		setTimeout(function(){
			$('.box').each(function(){
				$(this).hide();
			});
			$('#sign_up_form').show();
			setTimeout(function(){
				$('#sign_up_form').children('.form_box').addClass('form_box_show');
			}, 150);
		},450);
	});
	$('#fb_sign_up').click(function(){
		$('.box').each(function(){
			$(this).removeClass('box_hover');
			$(this).addClass('moveLeft');
		});
		setTimeout(function(){
			$('.box').each(function(){
				$(this).hide();
			});
			$('#fb_form').show();
			setTimeout(function(){
				$('#fb_form').children('.form_box').addClass('form_box_show');
			}, 150);
		},450);
	});

	$('#login_form').on('click', '#back_button', function() {
		$('#username').val('');
		$('#password').val('');
		$('#uname').val('');
		$('#pwd').val('');
		$('#age').val('');
		$('.errmsg').empty();
		$(this).parents('#login_form').hide();
		$(this).parents('#sign_up_form').hide();
		$('.box').each(function(){
			$(this).addClass('box_hover');
			$(this).removeClass('moveLeft');
			$(this).show();
		});
	});
	$('#sign_up_form').on('click', '#back_button', function() {
		$('#uname').val('');
		$('#pwd').val('');
		$('#age').val('');
		$('#male').removeAttr('checked');
		$('#female').removeAttr('checked');
		$('.errmsg').empty();
		$(this).parents('#sign_up_form').hide();
		$('.box').each(function(){
			$(this).addClass('box_hover');
			$(this).removeClass('moveLeft');
			$(this).show();
		});
	});
	$('#fb_form').on('click', '#back_button', function() {
		$(this).parents('#fb_form').hide();
		$('.box').each(function(){
			$(this).addClass('box_hover');
			$(this).removeClass('moveLeft');
			$(this).show();
		});
	});
}
campDiaries.FacebookLogin = function() {
	$('#fb_form').on('click','#loginButton', function(){
		campDiaries.authUser();
	}) 
}
campDiaries.bindFormHandlers = function() {
	campDiaries.bindSignUpForm();
	campDiaries.bindLoginForm();
	campDiaries.FacebookLogin();
}
campDiaries.bindSignUpForm = function() {
	$('#sign_up_form').on('click', '#sign_up_submit', function(event){
		event.preventDefault();
		$('.errmsg').empty();
		var username = $('#uname').val();
		var password = $('#pwd').val();
		var age = $('#age').val();
		var male = $('#male:checked').length;
		var female = $( "#female:checked" ).length;
		var gender = female == 1 ? 'female' : male == 1 ? 'male' : 0;
		var validate = new Array();
		validate['username'] = username;
		validate['password'] = password;
		validate['age'] = age;
		validate['gender'] = gender;
		var errmsg = campDiaries.formValidation(validate);
		if (!errmsg) {
			$.ajax ({
				type:'POST',
				data:{username:username, password:password, age:age, gender:gender},
				dataType:'JSON',
				url: 'php/submit_form.php?type=sign_up_form',
				success: function(response) {
					if(response.status == 'failed') {
						$('.errmsg').text(response.message);
					} else {
						window.location.replace(campDiaries.HOST+'display_user.php?user_id='+response.userid);
					}
				}
			});
		} else {
			$('.errmsg').text(errmsg);
		}
	})
}
campDiaries.bindLoginForm = function() {
	$('#login_form').on('click', '#submit_login_form', function(event){
		event.preventDefault();
		var username = $('#username').val();
		var password = $('#password').val();
		var remMe = $('#remMe:checked').length;
		var validate = new Array();
		validate['username'] = username
		validate['password'] = password;
		$.ajax ({
			type:'POST',
			data:{username:username, password:password, remMe:remMe},
			dataType:'JSON',
			url: 'php/submit_form.php?type=login',
			success:function(response) {
				if(response.status == 'failed') {
					var message = response.message;
					$('.errmsg').text(message);
				} else if (response.status == 'success'){
					window.location.replace(campDiaries.HOST+'display_user.php?user_id='+response.userid);
				}
			}
		});
	});
}
campDiaries.formValidation = function(validate) {
	var errmsg = 0;
	for (var parameter in validate) {
		if (parameter == 'username' ) {
			if(validate['username'].length < 8 || validate['username'].length > 50) {
				errmsg = 'Username length Insufficeint';
				return errmsg;
			} 
		} else if (parameter == 'password') {
			if(validate['password'].length < 6 || validate['password'].length > 50) {
				errmsg = 'Password length Insufficeint';
				return errmsg;
			}	
		} else if (parameter == 'age') {
			if (isNaN(parseInt(validate['age'])) && !isFinite(validate['age'])) {
				errmsg = 'Incorrect Age';
				return errmsg;
			} 
		} else if (parameter == 'gender') {
				if(validate['gender'] == 0)
					errmsg = 'Gender not specified';
			return errmsg;
		}
	}
	return errmsg;
}
campDiaries.logOut = function() {
	$('#logout').click(function(event){
		event.preventDefault();
		var userid = $(this).data('userid');
		$.ajax ({
			type:'POST',
			data:{userid:userid},
			dataType:'JSON',
			url: 'php/submit_form.php?type=logout',
			success: function(response) {
				if (response.status == 'success'){
				 	window.location.replace(campDiaries.HOST+'index.php?logout=1');
				}
			}
		});
	});
}

FB.init({
appId      : '206643769520724',
status     : true, // check login status
cookie     : true, // enable cookies to allow the server to access the session
xfbml      : true  // parse XFBML
});

// Check if the current user is logged in and has authorized the app
// var url = window.location.href;
// if (url === 'http://localhost/cd/index.php')
// 	FB.getLoginStatus(checkLoginStatus);

// Login in the current user via Facebook and ask for email permission
campDiaries.authUser = function() {
	FB.login(checkLoginStatus, {scope:'email'});
}

// Check the result of the user status and display login button if necessary
function checkLoginStatus(response) {
	if(response && response.status == 'connected') {
		campDiaries.loadFacebookCredentials();
	} else {
		//alert('User is not authorized');
	}
}

campDiaries.loadFacebookCredentials = function() {
	FB.api('/me', function(response) {
		var username = response.username;
		var gender = response.gender;
		var password = 'facebookLogin';
		$.ajax ({
			type:'POST',
			data:{username:username, password:password, gender:gender},
			dataType:'JSON',
			url: 'php/submit_form.php?type=fb_login',
			success: function(response) {
				if(response.status == 'failed') {
					var message = response.message;
					$('.errmsg').text(message);
				} else if (response.status == 'success'){
					window.location.replace(campDiaries.HOST+'display_user.php?user_id='+response.userid);
				}
			}
		});
	});
}

$(document).ready(function(){
	campDiaries.bindEvents();
	campDiaries.bindFormHandlers();
	campDiaries.logOut();
});