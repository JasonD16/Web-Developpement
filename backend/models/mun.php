<?php

namespace Model;

require_once('model.php');

class mun extends Model{

    public function getMun()
    {
        $stmt = $this->dbHandle->prepare('SELECT name FROM municipality ORDER BY NAME asc');
        $stmt->execute();
        $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $data;
    }

    public function addMun($mun)
    {
        $stmt = $this->dbHandle->prepare('INSERT INTO municipality (name, province, caza, total_voters, population) 
                                        VALUES (:name, :province, :caza, :voters, :population)');
        $stmt->execute(['name'=>$mun['name'],
                        'province'=>$mun['province'],
                        'caza'=>$mun['caza'],
                        'population'=>$mun['population'],
                        'voters'=>$mun['voters']]);
    }

    public function deleteMun($mun)
    {
        $stmt = $this->dbHandle->prepare('DELETE FROM municipality WHERE name = :name');
        $stmt->execute(['name'=>$mun]); 
    }

    public function editMun($mun, $details)
    {
        $id = $this->getMunId($mun);

        $stmt = $this->dbHandle->prepare('UPDATE municipality
        SET name =:name, province =:province , caza=:caza, total_voters=:voters, population=:population WHERE id =:id');
        $stmt->execute(['id'=>$id,
                        'name'=>$details['name'],
                        'province'=>$details['province'],
                        'caza'=>$details['caza'],
                        'population'=>$details['population'],
                        'voters'=>$details['voters']]);
    }

    public function getDetails($name)
    {
        $stmt = $this->dbHandle->prepare('SELECT * FROM municipality WHERE name = :name');
        $stmt->execute(['name'=>$name]);
        $data = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $data; 
    }

    public function getMunId($mun)
    {
        $stmt = $this->dbHandle->prepare('SELECT id FROM municipality WHERE name =:mun');
        $stmt->execute(['mun'=>$mun]);
        $d = $stmt->fetch(\PDO::FETCH_ASSOC);
        $id = $d['id'];
        return $id;
    }

    public function munExist($mun)
    {
        $stmt = $this->dbHandle->prepare('SELECT id, COUNT(id) as count_id FROM municipality WHERE name =:mun');
        $stmt->execute(['mun'=>$mun]);
        $d = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $d;
    }

}

?>