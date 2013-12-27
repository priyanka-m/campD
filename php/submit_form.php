<?php
	session_start();
	include('../application_top.php');
	function respondJSON($output) {
		echo json_encode($output);
	}

	$type = $_GET['type'];
	$output = array();

	if ($type == 'sign_up_form') {
		$username = $_POST['username'];
		$password = $_POST['password'];
		$age = $_POST['age'];
		$gender = $_POST['gender'];
		$email = $_POST['emailid'];

		$hash_of_pwd = md5($password);
		$query = 'SELECT * FROM users WHERE username = "'.$username.'"';
		$result = DB::query($LINK, $query);
		$count = mysqli_num_rows($result);
		if ($count) {
			$output['status'] = 'failed';
			$output['message'] = 'Username already exists';
			respondJSON($output);
		} 

		$query = 'SELECT * FROM users WHERE email = "'.$email.'"';
		$result = DB::query($LINK, $query);
		$count = mysqli_num_rows($result);
		if ($count) {
			$output['status'] = 'failed';
			$output['message'] = 'Email Id already registered';
			respondJSON($output);
		}
		else {
			$query = 'INSERT INTO users(username, password, age, gender, fb_login) VALUES("'.$username.'","'.$hash_of_pwd.'","'.$age.'","'.$gender.'", 0)';
			$result = DB::query($LINK, $query);

			if(!$result) {
				$output['status'] = 'failed';
				$output['message'] = 'Failed to register new user';
			} else {
				$output['status'] = 'success';
				$output['message'] = 'new user registered';
				$output['userid'] = mysqli_insert_id($LINK);
				$_SESSION['userid'] = $output['userid'];
			}
			respondJSON($output);
		}
	} elseif ($type == 'login') {
		$email = $_POST['email'];
		$password = $_POST['password'];
		$remMe = $_POST['remMe'];

		$hash_of_pwd = md5($password);
		$query = 'SELECT userid FROM users WHERE password = "'.$hash_of_pwd.'" AND email = "'.$email.'"';
		
		$result = DB::query($LINK, $query);
		$count = mysqli_num_rows($result);
		if ($count) {
			$output['status'] = 'success';
			$output['message'] = 'User Found';

			while ($row = DB::fetchResult($result)) {
				$userid = $row['userid'];
			}
			$output['userid'] = $userid;
			$_SESSION['userid'] = $userid;

			$user =  new User($userid, $LINK);
			if ($remMe) {
				$res = $user->setPersistentLoginCookie($userid, $LINK);
			}
			respondJSON($output);
		} else {
			$output['status'] = 'failed';
			$output['message'] = 'Incorrect username/password combination';
			respondJSON($output);
		}
	} elseif ($type == 'fb_login') {
		$username = isset($_POST['username']) ? $_POST['username'] : '';
		$password = isset($_POST['password']) ? $_POST['password'] : 0;
		$gender = isset($_POST['gender']) ? $_POST['gender'] : 0;
		$fbid = isset($_POST['fbid']) ? $_POST['fbid'] : 0;
		$email = isset($_POST['email']) ? $_POST['email'] : '';

		$query = 'SELECT * FROM users WHERE email = "'.$email.'"';
		$result = DB::query($LINK, $query);
		$count = mysqli_num_rows($result);
		if ($count) {
			while ($row = DB::fetchResult($result)) {
				$output['userid'] = $row['userid'];
			}
			$output['status'] = 'success';
			$output['message'] = 'User Found';
			$_SESSION['userid'] = $output['userid'];
			respondJSON($output);
		} else {
			$hash_of_pwd = '';
			$query = 'INSERT INTO users(username, password, age, gender, fb_login, email, fbid) VALUES("'.$username.'","'.$hash_of_pwd.'",0,"'.$gender.'", 1, "'.$email.'","'.$fbid.'")';
			$result = DB::query($LINK, $query);

			if(!$result) {
				$output['status'] = 'failed';
				$output['message'] = 'Failed to register new user';
			} else {
				$output['status'] = 'success';
				$output['message'] = 'new user registered';
				$output['userid'] = mysqli_insert_id($LINK);
				$_SESSION['userid'] = $output['userid'];

				$user = new User($output['userid'], $LINK);
				$user->saveFBpicture($fbid);
			}
			respondJSON($output);
		}
	} else if ($type == 'logout' ){
		
		if (isset($_COOKIE['auth'])) {
			setcookie('auth', false, time() + 60 * 60 * 24 * 7, '/', '', true);
		}
		
		$output['status'] = 'success';
		$output['message'] = 'successfully logged out!';

		session_unset();
		
		respondJSON($output);
	} else if ($type == 'setFBPass') {
		$password = $_POST['password'];
		$userid = $_POST['userid'];

		$hash_of_pwd = md5($password);
		$query = 'UPDATE users SET password = "'.$hash_of_pwd.'" WHERE userid = '.$userid;
		$result = DB::query($LINK, $query);

		if(!$result) {
			$output['status'] = 'failed';
			$output['message'] = 'Failed to set Password';
		} else {
			$output['status'] = 'success';
			$output['message'] = 'Password Set';
		}
		respondJSON($output);
	}
?>