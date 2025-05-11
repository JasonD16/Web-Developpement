<?php

// require_once('./backend/models/model.php');

namespace Model;

class auth extends model{

    public function __construct()
    {
        parent::__construct();
    }

    public function getByEmail($email=false) {
		if ($email === false) {
			return [];
		}

		// use the protected $dbHandle to access the database
		// get the record whose email is $email and return it as an array
		$stmt = $this->dbHandle->prepare('select email, password from administrators where email = :email');
		$stmt->execute(['email' => $email]);
		$data = $stmt->fetch(\PDO::FETCH_ASSOC);
		return $data;
	}

    public function blockCheck($ip)
    {
        $stmt = $this->dbHandle->prepare('SELECT COUNT(id) AS ip_count FROM banned_ips WHERE ip_address = :ip');
        $stmt->execute(['ip'=>$ip]);
        $data = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $data;
    }

    public function resetTriesLeft($ip)
    {
        $stmt = $this->dbHandle->prepare('UPDATE login_attempts SET tries_left = 5 WHERE ip = :ip');
        $stmt->execute(['ip'=>$ip]);
        //returns nothing
    }

    public function checkTriesLeft($ip)
    {
        $stmt = $this->dbHandle->prepare('SELECT tries_left FROM login_attempts WHERE ip =:ip');
        $stmt->execute(['ip'=>$ip]);
        $data = $stmt->fetch();
        return $data;
    }

    public function ban($ip, $email)
    {
        $time = date('Y-m-d H:i:s');

        $stmt = $this->dbHandle->prepare('INSERT INTO banned_ips(ip_address, username,banned_at) 
                                          VALUES (:ip, :email,:time)');
        $stmt->execute(['ip'=> $ip, 'email'=> $email, 'time'=>$time]);
        
    }

    public function decrementTries($tries, $ip)
    {
        $stmt = $this->dbHandle->prepare('UPDATE login_attempts SET tries_left = :tries WHERE ip = :ip');
        $stmt->execute(['tries'=>$tries, 'ip'=>$ip]);
    }

    public function addlogin($ip, $tries)
    {
        $stmt = $this->dbHandle->prepare('INSERT INTO login_attempts (ip, attempt_time, tries_left)
                                        VALUES (:ip, NOW(), :tries);');
        $stmt->execute(['ip'=>$ip, 'tries'=>$tries]);
    }

    public function checkloginattempt($ip)
    {
        $stmt= $this->dbHandle->prepare('SELECT COUNT(id) AS count FROM login_attempts WHERE ip = :ip');
        $stmt->execute(['ip'=>$ip]);
        $data = $stmt->fetch();
        return $data;
    }
}

?>