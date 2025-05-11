<?php

// require_once('model.php');

namespace Model;

class admin extends model{
    public function __construct()
    {
        parent::__construct();
    }

    ///////Municipality
    
    public function changepass($email, $newpass)
    {
        $stmt = $this->dbHandle->prepare('UPDATE administrators SET password =:password WHERE email =:email');
        $stmt->execute(['password'=>$newpass, 'email'=>$email]);
    }

}