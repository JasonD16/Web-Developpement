<?php

namespace Controller;

class ballot{
    public function add()
    {
        $ballot = $_POST['ballot'];
        // print_r($ballot);

      
        $mun = strtolower($_POST['mun']);
        $munM = new \Model\mun();
        $munId = $munM->getMunId($mun);

        $m = new \Model\cand();
        $cand = $m->getCand($mun);
        if($cand != null)
        {
            //getting the candidates
            $candidates = [];

            foreach($cand as $c)
            {
                $candidates[] = "{$c['name']} {$c['middle_name']} {$c['family_name']}";
            }
            // print_r($candidates);die;

            //getting the votes
            //ex ['Jason'=>100];
            $i = 0;
            $result = [];
            foreach($ballot as $b)
            {
                $result[isset($candidates[$i])? $candidates[$i] : 'blank blank blank'] = $b;
                $i++;
            }
        }
        else{
            $result['blank blank blank'] = $ballot[0];
        }
            // print_r($result);die;

        $m->addBallot($munId, $result);
        Header("Location: /Elections/admin/showCand/{$mun}");
        exit();
    }
}

?>