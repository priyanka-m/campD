<?php
	Class User {
		public $userid = null;
		public $username = null;
		public $age = null;
		public $gender = null;
		public $email = null;
		public $fb_login = null;

		public function __construct($userid = null, $LINK) {
			$cache = new Cache();
			$user = $cache->get($userid);
			if (isset($user) && $user) {
				$this->userid = $user['userid'];
				$this->username = $user['username'];
				$this->age = $user['age'];
				$this->gender = $user['gender'];
				$this->email = $user['email'];
				$this->fb_login = $user['fb_login'];
			} else {
				$result = DB::query($LINK, 'SELECT * FROM users WHERE userid = "'.$userid.'"');
				$count = mysqli_num_rows($result);
				if ($count) {
					while ($row = DB::fetchResult($result)) {
						$this->userid = $row['userid'];
						$this->username = $row['username'];
						$this->age = $row['age'];
						$this->gender = $row['gender'];
						$this->email = $row['email'];
						$this->fb_login = $row['fb_login'];
 					}
 					$user = array('userid' => $this->userid, 'username' => $this->username, 'age' => $this->age, 'gender' => $this->gender, 'email' => $this->email, 'fb_login' => $this->fb_login);
					$cache->set($userid, $user);
				} 
			}
		}

		public function setPersistentLoginCookie($userid, $LINK) {
			$identifier = sha1(sha1($userid));
			$token = sha1(uniqid(mt_rand(), true));
			$set = setcookie('auth', $identifier.':'.$token, time()+604800,'/');
			setcookie('work', '', time()+604800,'/');
			$_COOKIE['auth'] = $identifier.':'.$token;
			$res = false;
			if ($set) 
				$res = $this->setPersistentLogin($identifier, $token, $LINK);
			return $res;
		}

		public function setPersistentLogin($identifier, $token, $LINK) {
			$query = 'UPDATE users SET identifier = "'.$identifier.'", token = "'.$token.'", timeout = DATE_ADD(NOW(), INTERVAL 7 DAY) WHERE userid = '.$this->userid;
			$res = DB::query($LINK, $query);
			return $res;
		}
	}
?>