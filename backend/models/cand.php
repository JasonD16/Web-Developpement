<?php

namespace Model;

require_once('model.php');

class cand extends model{

    public function getCand($mun)
    {
        //getting the municipality id
        $stmt = $this->dbHandle->prepare('SELECT id FROM municipality WHERE name =:mun');
        $stmt->execute(['mun'=>$mun]);
        $d = $stmt->fetch(\PDO::FETCH_ASSOC);

        $id = isset($d['id'])? $d['id'] : null;    

        $stmt = $this->dbHandle->prepare('SELECT name, middle_name, family_name, municipality 
                                        FROM candidate 
                                        WHERE municipality_id =:id 
                                        AND name != "Blank"
                                        ORDER BY name, middle_name, family_name asc ');
        $stmt->execute(['id'=>$id]);
        $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $data;
    }

    public function getCandId($cand)
    {   
        $fullName = explode('%20', $cand);
        $name = $fullName[0];
        $middle = $fullName[1];
        $family = $fullName[2];

        $cand = strtolower(htmlspecialchars($cand));
        $stmt = $this->dbHandle->prepare('SELECT id FROM candidate 
                                        WHERE name =:name
                                        AND middle_name =:middle
                                        AND family_name =:family');
        $stmt->execute(['name'=>$name, 'middle'=>$middle, 'family'=>$family]);
        $id = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $id['id'];
    }

    public function deleteCand($cand)
    {
        $id = $this->getCandId($cand);
        $stmt = $this->dbHandle->prepare('DELETE FROM candidate WHERE id =:id');
        $stmt->execute(['id'=>$id]);
    }

    public function addCand($mun, $munId,$fullName)
    {
        $stmt = $this->dbHandle->prepare('INSERT INTO candidate(name, middle_name, family_name, votes, municipality, municipality_id) 
                                        VALUES (:name, :middle, :family, 0, :mun, :mun_id)');
        $stmt->execute(['name'=>$fullName['name'],
                        'middle'=>$fullName['middle'],
                        'family'=>$fullName['family'],
                        'mun'=>$mun,
                        'mun_id'=>$munId]);
    }

    public function candExist($munId, $fullName)
    {   
        $name = $fullName['name'];
        $middleName = $fullName['middle'];
        $familyName = $fullName['family'];

        $stmt = $this->dbHandle->prepare('SELECT COUNT(id) as count_id 
                                        FROM CANDIDATE 
                                        WHERE name =:name 
                                            AND middle_name=:middle
                                            AND family_name=:family
                                            AND municipality_id =:munId'
                                        );

        $stmt->execute(['name'=>$name, 'middle'=>$middleName, 'family'=>$familyName, 'munId'=>$munId]);
        $d = $stmt->fetch(\PDO::FETCH_ASSOC);
        $id = $d['count_id'];
        return $id;
    }
    
    public function deleteAllCand($munId)
    {

        $stmt = $this->dbHandle->prepare('DELETE FROM candidate WHERE municipality_id =:munId');
        $stmt->execute(['munId'=>$munId]);
    }

    public function addBallot($munId, $result)
    {
        // print_r($result);die;
        foreach($result as $fullName=>$votes)
        {
            $v = (int)$votes;
            $fullName = explode(' ', $fullName);
            $name = strtolower(isset($fullName[0]) ? $fullName[0] : 'blank');
            $middle = strtolower(isset($fullName[1]) ? $fullName[1] : 'blank');
            $family = strtolower(isset($fullName[2]) ? $fullName[2] : 'blank');
            $i = 3;
            while(isset($fullName[$i]))
            {
                $family .= ' ' . $fullName[$i];
                $i++;
            }
            // print  $name . '    '. $middle . '  '. $family;
            // print $votes;
            // print "<br>";

            $stmt = $this->dbHandle->prepare('UPDATE candidate SET votes=:votes 
                                            WHERE name=:name 
                                            AND middle_name=:middle 
                                            AND family_name=:family
                                            AND municipality_id=:munId');
            $stmt->execute(['name'=>$name, 'middle'=>$middle, 'family'=>$family, 'votes'=>$v, 'munId'=>$munId]);
            // print_r($this->dbHandle->errorInfo());
            echo $stmt->rowcount() . "<br>";
        }
        // die;
    }

}

?>