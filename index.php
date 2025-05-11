<?php

// boot the gateway up
require_once('./bootstrap.php');

// get the request url
$url = $_SERVER['REQUEST_URI'];
$url = trim($url, '/');
$parts = explode('/', $url);


if(count($parts) < 1)
	{die('Invalid Request!');}

// parse and determine which controller action to execute

$directory = $parts[0];
if(strtolower($directory) != 'elections')
{
	die('Page not found!');
}


if(count($parts) == 1)
{
	$parts[1] = 'user';
}

$controller = $parts[1];
// print "{$controller}" . "<br>";

if($controller == 'user')
{
	// if we only provided the controller name,
	// use home as the name of the action by default
	$action = (count($parts) == 2) ? 'home' : $parts[2];
	// print "{$action}" . "<br>";

	// load the controller and execute the action
	$controllerFile = './front/controllers/' . strtolower($controller) . 'controller.php';

}
else if($controller == 'admin' 
		|| $controller == 'ballot' 
		|| $controller == 'mun' 
		|| $controller == 'cand')
{
	// if we only provided the controller name,
	// use login as the name of the action by default
	$action = (count($parts) == 2) ? 'login' : $parts[2];
	// print "{$action}" . "<br>";

	// load the controller and execute the action
	$controllerFile = './backend/controllers/' . strtolower($controller) . 'controller.php';

}
else
{
	die('Invalid Controller');
}

// check if the controller file exists before requiring it. If not, die.
if (!file_exists($controllerFile)) {
	die('Invalid Controller');
}


// require_once($controllerFile);
$controllerClass = "\\Controller\\{$controller}";
$c = new $controllerClass();


// check if action function exists. If not, die
if (!method_exists($c, $action)) {
	die('Invalid action');
}


$param1 = isset($parts[3]) ? $parts[3] : null;
$param2 = isset($parts[4]) ? $parts[4] : null;
$response = $c->$action($param1, $param2);
print $response;
