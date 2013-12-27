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
				$this->fbid = $user['fbid'];
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
						$this->fbid = $row['fbid'];
 					}
 					$user = array('userid' => $this->userid, 'username' => $this->username, 'age' => $this->age, 'gender' => $this->gender, 'email' => $this->email, 'fb_login' => $this->fb_login, 'fbid'=>$this->fbid);
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

		public function saveFBpicture($fbid) {
			$img = file_get_contents('https://graph.facebook.com/'.$fbid.'/picture?type=large');
			$file = dirname(__file__).'/../images/'.$fbid.'.jpg';
			file_put_contents($file, $img);
			$img = new Imagick($file); 
		    $img->setImageResolution(72,72);
		    $img->resampleImage(72,72,imagick::FILTER_UNDEFINED,1);
		    $img->scaleImage(250,0);
		    $d = $img->getImageGeometry();
		    $h = $d['height'];
		    if($h > 250) {
			    $img->scaleImage(0,250);
			    $img->writeImage($file);
		    } else {
		    	$img->writeImage($file);
		    }
		    $img->destroy(); 
			
		}
		public function passwordNotSet($LINK) {
			$userid = $this->userid;
			$query = 'SELECT password from users WHERE userid = '.$userid;
			$res = DB::query($LINK, $query);

			if ($res) {
				$row = DB::fetchResult($res);
				$pass = $row['password'];
				if ($pass == '')
					return true;
				else
					return false;
			}

		}
	}
?>