<?php

// common code to be executed BEFORE any other code goes here
function myAutoLoader($className){
    
	$className = strtolower($className);
	$parts = explode('\\', $className);

	$fileName = '';
	if($parts[1] == 'user')
	{
		if($parts[0] == 'controller')
			$fileName = './front/'. $parts[0] .'s' .'/'. $parts[1] . $parts[0] . '.php';
		else//model
			$fileName = './front/'. $parts[0] .'s/'. $parts[1] . '.php';
	}
	else
	{
		if($parts[0] == 'controller')
			$fileName = './backend/'. $parts[0].'s/' . $parts[1] . $parts[0] . '.php';
		else//model
			$fileName = './backend/'. $parts[0] .'s/'. $parts[1] . '.php';
	}
	
	
	require_once($fileName);
}
spl_autoload_register('myAutoLoader');

?>