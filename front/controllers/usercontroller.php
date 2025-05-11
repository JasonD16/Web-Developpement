<?php

namespace Controller;


class user{

    public function home()
    {
        $m = new \Model\user();
        $result = $m->getMun();

        $munView = '';
        foreach($result as $r)
        {
            $name = "{$r['name']}";
            $munView .= <<<HTHT
            <a class="baladiye_Box" href="/Elections/user/mun/{$name}"
            ><img src="/Elections/images/{$name}.jpg" alt="{$name}"/>
            </a>
            HTHT;
        }
        require_once('./front/views/home.php');
        return $view; 
    }

    public function contactus()
    {
        require_once('./front/views/contact_us.php');
        return $view;
    }

    public function mun($mun)
    {
        $m = new \Model\user();
        $result = $m->getMunDetails($mun);
        
        if($result == null)//eza l user 7at esem municipality much mawjoude
        {
            Header('Location: /Elections/user/notfound');
            exit();
        }

        $munName = ucwords($result['name']);
        $province = ucwords($result['province']);
        $caza = ucwords($result['caza']);
        $voters = $result['total_voters'];
        $population = $result['population'];

        $candidates = $m->getCandDetails($mun);

        $candView = '';
        foreach($candidates as $r)
        {
            $name = $r['name'];
            $middle = $r['middle_name'];
            $family = $r['family_name'];

            $candimg = "{$name} {$middle} {$family}";

            $cand = ucwords($candimg);
             
            $votes = $r['votes'];
            $candView .= <<<HTHT
            <div class="candidate">
            <img src="../../images/cand/{$candimg}.jpg" alt="candidate" />
            {$cand}: <span class="details">{$votes} votes</span>
            </div>
            HTHT;
        }

        $data = $m->getBlanks($mun);
        $blanks = isset($data['votes']) ? $data['votes'] : 0;

        $data = $m->getAllVotes($mun);
        $total_votes = $data['total_votes'];
        
        //in case there aren't any details regarding the municipality or candidates so to not throw errors on the screen
        $array = ['name', 'province', 'caza', 'population', 'voters', 'blanks', 'total_voters'];
        foreach($array as $a)
        {
            if(!isset(${$a}))
            {
                ${$a} = null;
            }
        }
        //to print 0 votes
        if(!isset($blanks))
        $blanks = 0;

        require_once('./front/views/municipality_details.php');
        return $view;
    }

    public function notfound()
    {
        require_once('./front/views/notfound.php');
        return $view;
    }

    public function msg()
    {
        //start the session
        session_start();

        $username = $_POST['username'];
        $email = $_POST['email'];
        $phone = $_POST['phone_number'];
        $subject = $_POST['subject'];
        $msg = $_POST['msg'];
        $time = date('Y-m-d H:i:s');

        $array = ['name'=>$username, 'email'=>$email, 'phone'=>$phone, 'subject'=>$subject, 'msg'=>$msg, 'time'=>$time];
        
        $m = new \Model\user();
        $m->msg($array);

        $_SESSION['msg'] = 'Message sent successfully!';

        require_once('./front/views/contact_us.php');
        return $view;

    }
}

?>