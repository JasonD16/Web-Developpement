<?php

namespace Model;

require_once('model.php');

class user extends model{

    public function __construct(){
        parent::__construct();
    }
    
    public function getMunDetails(string $mun){
        $stmt = $this->dbHandle->prepare('SELECT * FROM municipality WHERE name = :name');
        $stmt->execute(['name' => $mun]);
        $data = $stmt->fetch(\PDO::FETCH_ASSOC);    
        return $data;
    }

    public function getCandDetails(string $mun)
    {
        $stmt = $this->dbHandle->prepare('SELECT * FROM candidate WHERE municipality_id IN 
                                        (SELECT id FROM municipality WHERE name = :name) AND name !=:blank');
        $stmt->execute(['blank'=>'blank', 'name' => $mun]);
        $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $data;
    }

    public function getMun()
    {
        $stmt = $this->dbHandle->prepare('SELECT name FROM municipality');
        $stmt->execute();
        $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $data;
    }

    public function getBlanks($mun)
    {
        $stmt = $this->dbHandle->prepare('SELECT votes FROM candidate WHERE name=:n AND municipality_id IN 
                                        (SELECT id FROM municipality WHERE name = :name)');
        $stmt->execute(['n'=>'Blank', 'name' => $mun]);
        $data = $stmt->fetch();
        return $data;
    }

    public function getAllVotes($mun)
    {
        $stmt = $this->dbHandle->prepare('SELECT SUM(votes) as total_votes from candidate WHERE municipality_id IN
                                        (SELECT id FROM municipality WHERE name = :name)');
        $stmt->execute(['name'=>$mun]);
        $data = $stmt->fetch();
        return $data;
    }

    public function msg($array)
    {
        $stmt = $this->dbHandle->prepare('INSERT INTO contact_messages (name, email, phone, subject, message, submitted_at)
                                        VALUES (:name, :email, :phone, :subject, :msg, :time)');
        $stmt->execute(['name'=>$array['name'],
                        'email'=>$array['email'],
                        'phone'=>$array['phone'],
                        'subject'=>$array['subject'],
                        'msg'=>$array['msg'],
                        'time'=>$array['time']
                        ]);
    }
}


?>