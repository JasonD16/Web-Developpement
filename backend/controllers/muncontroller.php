<?php

namespace Controller;

class mun {

    public function add()
    {
        $name = strtolower($_POST['mun_name']);
        $province = strtolower($_POST['province']);
        $caza = strtolower($_POST['caza']);
        $voters = $_POST['total_voters'];
        $population = $_POST['population'];

        $target_path = 'C:\wamp64\www\Elections\images\\' . $name . '.jpg';


        $mun = ['name'=>$name, 'province'=>$province, 'caza'=>$caza, 'voters'=>$voters, 'population'=>$population];
        $m = new \Model\mun();
        $names = $m->getmun();
        foreach($names as $n)
        {
            if($n['name'] == $name)
            {
                $_SESSION['msg'] = 'Municipality name already exists!';
                require_once('backend\views\admin\addmun.php');  
                return $view;
            }
        }

        $m->addMun($mun);
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_path);
        $_SESSION['msg'] = 'Municipality added successfully!';
        
        //when adding a municipality we automatically add a blank candidate
        $munId = $m->getMunId($mun['name']);
        $candM = new \Model\cand();

        $blankCand = ['name'=>'Blank', 'middle'=>'Blank', 'family'=>'Blank'];
        $candM->addCand($mun['name'], $munId, $blankCand);

        require_once('backend\views\admin\addmun.php');  
        return $view;
    }

    public function edit($mun)
    {
        session_start();

        $name = $_POST['mun_name'];
        $province = $_POST['province'];
        $caza = $_POST['caza'];
        $voters = $_POST['total_voters'];
        $population = $_POST['population'];
        $details = ['name'=>$name, 'province'=>$province, 'caza'=>$caza, 'voters'=>$voters, 'population'=>$population];

        $m = new \Model\mun();
        $m->editMun($mun, $details);
        
        $_SESSION['msg'] = "Municipality edited successfully!";
        
        Header("Location: /Elections/admin/edit/{$name}");
    }

    public function delete($mun)
    {
        $m = new \Model\mun();
        $munId = $m->getMunId($mun);

        $candM = new \Model\cand();
        $candM->deleteAllCand($munId);

        $m->deleteMun($mun);
        $mun = ['name'=>$mun];

        Header('Location: /elections/admin/home');
    }
}

?>