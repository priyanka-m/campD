<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<title>My test Website</title>
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<link href='http://fonts.googleapis.com/css?family=Lato:400,300' rel='stylesheet' type='text/css'>
	<script src="//connect.facebook.net/en_US/all.js"></script>
	<script type="text/javascript" src="js/main.js"></script>
</head>
<body>
	<?php 
		include 'application_top.php';
		include 'index.inc.php';
	?>
	<section id="top">
		<div class="container">
			<div class="big justified">
				<div class="heading">My new website</div>
				<div class="subhead mtop10">For Campus Diaries</div>
			</div>
			<div class="clear"></div>
		</div>
	</section>
	<section id="center" class="mtop20">
		<div class="container">
			<div class="big justified optionBoxes">
				<div id="login_box" class="box box_hover justified alpha">
					<div class="centralized">
						Login
					</div>
				</div>
				<div id="sign_up" class="box box_hover justified">
					<div class="centralized">
						sign up
					</div>
				</div>
				<div id="fb_sign_up" class="box box_hover justified omega">
					<div class="centralized">
						Facebook
					</div>
				</div>
			</div>
			<div class="big justified hidden" id="login_form">
				<div class="form_box justified">
					<div class="centralized form_text" style="margin-top:60px;">
						<form action="#">
							<input type="text" id="username" value="" placeholder="email id"><br>
							<input type="password" id="password" value="" autocomplete="off" maxlength="12" placeholder="password">
							remember me <input type="checkbox" id="remMe"><br/>
						</form>
						<div class="errmsg mtop10"></div>
						<input type="submit" value="Submit" class="buttons" id="submit_login_form" style="margin-top:40px;">
							|
						<input type="button" value="Back" class="buttons" id="back_button">
					</div>
				</div>
			</div>
			<div id="sign_up_form" class="big justified hidden">
				<div class="form_box justified">
					<div class="centralized form_text" style="margin-top:20px;font-size:20px;">
						<form action="#">
							<input type="text" id="uname" placeholder="Username"><br/>
							<input type="password" id="pwd" autocomplete="off" maxlength="12" placeholder="Password"><br/>
							<input type="text" id="emailid" placeholder="email"><br/>
							<input type="text" id="age" placeholder="Age"><br/>
							<label for="male">Male</label>
							<input type="radio" name="sex" id="male" value="male">
							<label for="female">Female</label>
							<input type="radio" name="sex" id="female" value="female">
						</form>
						<div class="errmsg"></div>
						<input type="submit" value="Submit" class="buttons mtop10" id="sign_up_submit">
							|
						<input type="button" value="Back" class="buttons" id="back_button">
					</div>
				</div>
			</div>
			<div id="fb_form" class="big justified hidden">
				<div class="form_box justified">
					<div class="centralized">Facebook</div>
					<div class="centralized form_text" style="margin-top:60px;">
						<div id="fb-root"></div>
						<input id="loginButton" type="button" value="Login" class="buttons">
						|
						<input type="button" value="Back" class="buttons" id="back_button">
					</div>
				</div>
			</div>
			<div class="clear"></div>
		</div>
	</section>
</body>
</html>