<?php

namespace Controller;

class auth {

	// public function __construct() {
	// 	session_start();
	// }

	public function authenticate($email="", $password="") : bool {
		session_start();
		// get user ip
		$userIp = $_SERVER['REMOTE_ADDR'];
		// check if userIp is blocked. If yes, print blocked message and exit
        $m = new \Model\auth();
        $blocked = $m->blockCheck($userIp);
		
		if($blocked['ip_count'] == 1)
        {
			Header('Location: /Elections/admin/blocked');
			exit();
			return false;
        }

        //check if the user has attempted to login previously
        // if he didnt then we add his ip to the 'login_attempts' table and give him 5 tries to log in
		$t = $m->checkloginattempt($userIp);
		if($t['count'] == 0)
		{
			$m->addlogin($userIp, 5); 
		}

		// sanitize email and password
		$password = htmlspecialchars($password);
		$email = filter_var($email, FILTER_SANITIZE_EMAIL);

		$creds = $m->getByEmail($email);

		// if email does not exist, an empty array will be returned
		if (empty($creds)) {
			$_SESSION['errormsg'] = 'Invalid email address specified';
			return false;
		}
		
		// hash provided credentials + salting
		$hash = sha1($email . $password);
		
		// compare hashed credentials
		if ($hash === $creds['password']) {
			// if all is good, return true
			$_SESSION['loggedin'] = 1;
			$_SESSION['lastactiontimestamp'] = time();
			$_SESSION['email'] = $email;

			// reset number of attempts for user IP to zero
            $m->resetTriesLeft($userIp);
			
			return true;

		} else {

			// check if IP exceeded X attempts
            $tries = $m->checkTriesLeft($userIp);
			
            // if yes, add it to blocked IP list
            if($tries['tries_left'] == 0)
            {
                $this->ban($userIp, $email);
                Header("Location: /Elections/admin/blocked");
                exit();
                return false;
            }
            // if no, decrement number of attempts for IP by 1
            else {
                $this->decrementTries($tries['tries_left'], $userIp);
                // else return false
                $_SESSION['errormsg'] = 'Invalid Password provided';
                return false;
            }
		}
	}

	
	public function blocked()
	{
		require_once('./backend/views/blocked.php');
		return $view;
	}

    public function decrementTries($tries, $ip)
    {
        $tries--;	
        $m = new \Model\auth();
        $m->decrementTries($tries, $ip);

    }

    public function ban($ip, $email)
	{
		$m = new \Model\auth();
		$m->ban($ip, $email);

		Header('Location: /Elections/admin/blocked');
        exit();
	}
	
	public function authorize() {
		session_start();
		$allGood = true;

		// check if user is logged in
		if (!isset($_SESSION['loggedin'])) $allGood = false;

		// check if session timestamp is still valid
		$timeNow = time();
		$lastAction = isset($_SESSION['lastactiontimestamp']) ? $_SESSION['lastactiontimestamp'] : 0;
		if (($timeNow - $lastAction ) > 3600) $allGood = false;

		// if not, redirect user to login
		if (!$allGood) {
			// unset loggedin
			unset($_SESSION['loggedin']);
			// unset lastacxtiontimestamp
			unset($_SESSION['lastactiontimestamp']);
			// unset email
			unset($_SESSION['email']);
			unset($_SESSION['msg']);
			// redirect the user to login
			$_SESSION['errormsg'] = 'Your session expired or you are not logged in. Please login to continue';
			header("Location: /Elections/admin/login");
			exit;
			return false;
		} else {
			// update lastactiontimestamp
			$_SESSION['lastactiontimestamp'] = time();
			return true;
		}
	}

	public function destroy() {
		session_start();
		// unset loggedin
		unset($_SESSION['loggedin']);
		// unset lastacxtiontimestamp
		unset($_SESSION['lastactiontimestamp']);
		// unset email
		unset($_SESSION['email']);
		unset($_SESSION['msg']);
		// redirect the user to login
		$_SESSION['errormsg'] = 'You have logged out successfully!';
		header("Location: /Elections/admin/login");
		exit;
	}
        
}

?>