<?php

namespace Controller;

class cand{
    public function add()
    {
        $name = strtolower(htmlspecialchars($_POST['name']));
        $middleName = strtolower(htmlspecialchars($_POST['middle_name']));
        $familyName = strtolower(htmlspecialchars($_POST['family_name']));
        $fullName = ['name'=>$name, 'middle'=>$middleName, 'family'=>$familyName];

        $target_path = 'C:\wamp64\www\Elections\images\cand\\' . "{$name} {$middleName} {$familyName}" . '.jpg';
        
        $mun = strtolower($_POST['municipality']);
        //check if municipality exists
        $m = new \Model\mun();
        $x = $m->munExist($mun);
        $munId = $m->getMunId($mun);

        $countId = $x['count_id'];

        session_start();
        $candM = new \Model\cand();

        if($countId == 1 && $candM->candExist($munId, $fullName) == 0)
        {
            $candM->addCand($mun, $munId,$fullName);
            $_SESSION['msg'] ='Candidate added successfully!';
            move_uploaded_file($_FILES["image"]["tmp_name"], $target_path);
        }
        else{
            $_SESSION['msg'] ='No such municipality exist or there is already a candidate with that name!';
        }
        Header("Location: /elections/admin/showAdd");
        exit;
    }

    public function edit()  
    {
        $name = strtolower(htmlspecialchars($_POST['name']));
        $middleName = strtolower(htmlspecialchars($_POST['middle_name']));
        $familyName = strtolower(htmlspecialchars($_POST['family_name']));
        $fullName = ['name'=>$name, 'middle'=>$middleName, 'family'=>$familyName];

        $target_path = 'C:\wamp64\www\Elections\images\cand\\' . "{$name} {$middleName} {$familyName}" . '.jpg';
        
        $mun = strtolower($_POST['municipality']);
        //check if municipality exists
        $m = new \Model\mun();
        $x = $m->munExist($mun);
        $munId = $m->getMunId($mun);

        $countId = $x['count_id'];

        session_start();
        $candM = new \Model\cand();

        if($countId == 1 && $candM->candExist($munId, $fullName) == 1)
        {
            $_SESSION['msg'] ='Changes applied successfully!';
            move_uploaded_file($_FILES["image"]["tmp_name"], $target_path);
        }
        else{
            $_SESSION['msg'] ='No such municipality or candidate exist!';
        }
        Header("Location: /elections/admin/showEdit");
        exit;
        
    }

    public function delete($mun, $cand)
    {
        $m = new \Model\cand();
        $m->deleteCand($cand);
        
        Header("Location: /Elections/admin/showCand/{$mun}");
        exit();
    }
}

?>