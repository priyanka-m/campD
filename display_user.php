<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<title>User Profile</title>
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script src="//connect.facebook.net/en_US/all.js"></script>
	<link href='http://fonts.googleapis.com/css?family=Lato:400,300' rel='stylesheet' type='text/css'>
	<script type="text/javascript" src="js/main.js"></script>
</head>
<body>
	<section id="top">
		<div class="container">
			<div class="big justified">
				<div class="heading">My new website</div>
				<div class="subhead mtop10">For Campus Diaries</div>
			</div>
			<div class="clear"></div>
		</div>
	</section>
	<?php 
		include 'application_top.php';
		
		$userid = $_GET['user_id'];
		$loggedin_user_id = $_SESSION['userid'];
		
		if ($loggedin_user_id == NULL) 
			header('Location:'.HOST.'index.php');
		else if ($loggedin_user_id == $userid) {
			
			$query = 'SELECT * FROM users WHERE userid = '.$userid;
			$user = new User($loggedin_user_id, $LINK);
			$username = $user->username; ?>
			
			<section id="center" class="mtop20">
				<div class="container">
					<div class="big justified optionBoxes">
						<div class="box box_hover justified alpha">
							<div class="centralized" style="margin-top:30px;">
								<?php if ($user->fbid) { ?>
									<img src="images/<?php echo $user->fbid; ?>.jpg"/>
								<?php } else {?>
									<div style="font-size:40px;">sign up with facebook to fetch your picture</div>
								<?php }?>
							</div>
						</div>
						<div class="box box_hover justified">
							<div class="centralized" style="margin-top:20px;">
								User-info
								<div class="info" style="font-size:20px;margin-top:30px;">
									User Id: <?php echo $user->userid; ?><br/>
									Username: <?php echo $user->username; ?><br/>
									Email: <?php echo $user->email; ?><br/>
									Gender: <?php echo $user->gender; ?><br/>
									Integrated with facebook: <?php echo $user->fb_login == 1 ? 'Yes' : 'No'; ?><br/>
								</div>
							</div>
						</div>
						<div class="box box_hover justified omega">
							<div class="centralized">
								<a href="#" id="logout" data-userid="<?php echo $userid;?>" style="text-decoration:none;color:#ffffff;">Logout</a>
								<?php if($user->passwordNotSet($LINK)): ?>
									<div class="passInfo mtop20" style="font-size:20px;" data-user-id="<?php echo $userid; ?>">
										To be able to use normal login, <span style="cursor:pointer" id="fbPass"><u>Set Password</u></span> 
										<form id="fbPass_form" style="margin-top:10px;"><input type="password" id="pswrd" value="" autocomplete="off" placeholder="password" style="display:none"></form>
									</div>
								<?php endif; ?>
							</div>
						</div>
					</div>
					<div class="clear"></div>
				</div>
			</section>
  <?php } else { ?>
  				<section id="center" class="mtop20">
					<div class="container">
						<div class="big justified optionBoxes">
							<div class="box box_hover justified alpha">
								<div class="centralized" style="margin-top:75px;">
									I know what you did there!
										<!-- <img src="//graph.facebook.com/<?php echo $username;?>/picture?type=large"/> -->
								</div>
							</div>
							<div class="box box_hover justified">
								<div class="centralized" style="margin-top:20px;">
									
								</div>
							</div>
							<div class="box box_hover justified omega">
								<div class="centralized">
									<a href="<?php echo HOST; ?>display_user.php?user_id=<?php echo $loggedin_user_id;?>" data-userid="<?php echo $userid;?>" style="text-decoration:none;color:#ffffff;">Go Back</a>
								</div>
							</div>
						</div>
						<div class="clear"></div>
					</div>
				</section>
  		<?php } 
  	?>
</body>
</html>
