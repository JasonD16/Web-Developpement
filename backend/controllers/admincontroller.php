<?php

namespace Controller;

require_once('authcontroller.php');

class admin{

	public function login() {
		session_start();
		require_once('./backend/views/admin/login.php');
		return $view;
	}

	public function dologin()
	{
		$email = $_POST['email'];
		$password = $_POST['password'];
		// require_once('./controllers/authcontroller.php');

		$auth = new \Controller\auth();
		$res = $auth->authenticate($email, $password);
		if ($res) {
			// user is authenticated
			header("Location: /Elections/admin/home");
		} else {
			// credentials are wrong
			 header("Location: /Elections/admin/login");
		}
		exit();
	}

	public function logout()
	{
		$auth = new \Controller\auth();
		$auth->destroy();
	}

	public function showchangepass()
	{
		session_start();
		require_once('backend\views\admin\changepassword.php');
		return $view;
	}

	public function changepass()
	{
		$a = new \Controller\auth();
		if(!$a->authorize())
		{
			header("Location: /Elections/admin/login");
		}

		$email = $_SESSION['email'];
		$oldpass = $_POST['oldpass'];
		$newpass1 = $_POST['newpass1'];
		$newpass2 = $_POST['newpass2'];
		if($newpass1 != $newpass2)
		{
			$_SESSION['msg'] = 'New password and Confirm Password are different!';
			Header('Location: /Elections/admin/showchangepass');
			exit();
		}

		$authm = new \Model\auth();
		$data = $authm->getByEmail($email);
		$pass = $data['password'];
		
		$oldpass = htmlspecialchars($oldpass);
		$hash = sha1($email.$oldpass);
		
		if($pass != $hash)
		{
			$_SESSION['msg'] = 'WRONG OLD PASSWORD!';
			Header('Location: /Elections/admin/showchangepass');
			exit();
		}

		$newpass1 = sha1($email . $newpass1);
		
		$m = new \Model\admin();
		$m->changepass($email, $newpass1);
		Header('Location: /elections/admin/logout');
	}

	public function home()
	{
		$a = new \Controller\auth();
		if(!$a->authorize())
		{
			header("Location: /Elections/admin/login");
		}

		$m = new \Model\mun();
		$names = $m->getMun();
		$mun = '';
		$name = '';
		require_once('backend\views\admin\munMaking.php');

		require_once('./backend/views/admin/home.php');
		return $view;
	}

	public function blocked()
	{
		$auth = new \Controller\auth();
		$view = $auth->blocked();
		return $view;
	}

	public function mun($name)
	{
		$a = new \Controller\auth();
		if(!$a->authorize())
		{
			header("Location: /Elections/admin/login");
		}

		require_once('backend\views\admin\addmun.php');
		return $view;
	}
	
	public function edit($name)
	{
		$a = new \Controller\auth();
		if(!$a->authorize())
		{
			header("Location: /Elections/admin/login");
		}		$m = new \Model\mun();

		$data = $m->getdetails($name);

		$name = $data['name'];
        $province = $data['province'];
        $caza = $data['caza'];
        $voters = $data['total_voters'];
        $population = $data['population'];

		require_once('backend\views\admin\editmun.php');
		return $view;
	}

	public function showCand($mun)
	{

		$a = new \Controller\auth();
		if(!$a->authorize())
		{
			header("Location: /Elections/admin/login");
		}

		$m = new \Model\cand();
		$names = $m->getCand($mun);

		$name = '';
		require_once('backend\views\admin\candMaking.php');

		require_once('backend\views\admin\cand.php');
		return $view;
	}

	public function showAdd($mun)
	{
		$a = new \Controller\auth();
		if(!$a->authorize())
		{
			header("Location: /Elections/admin/login");
		}
		require_once('backend\views\admin\addcand.php');
		return $view;
	}

	public function showEdit()
	{
		$a = new \Controller\auth();
		if(!$a->authorize())
		{
			header("Location: /Elections/admin/login");
		}
		require_once('backend\views\admin\editcand.php');
		return $view;
	}

	public function ballot($mun)
	{
		$a = new \Controller\auth();
		if(!$a->authorize())
		{
			header("Location: /Elections/admin/login");
		}
		require_once('addballot.php');
		return $view;
	}
}

?>