<?php
	//appid 	206643769520724
	//secret 	f9cb91069bdfa2e73a1e1d6cc747f045
	if (isset($_COOKIE['auth'])) {
		
		list($identifier, $token) = explode(':', $_COOKIE['auth']);
		
		$query = 'SELECT userid FROM users WHERE identifier = "'.$identifier.'" and token = "'.$token.'"';
			
		$result = DB::query($LINK, $query);	
		$count = mysqli_num_rows($result);
		if ($count) {
			while ($row = DB::fetchResult($result)) {
				$userid = $row['userid'];
			}
			
			header('Location:'.HOST.'display_user.php?user_id='.$userid);
		}	
	} else if(isset($_SESSION['userid'])) {
		$userid = $_SESSION['userid'];
		header('Location:'.HOST.'display_user.php?user_id='.$userid);
	}

?>