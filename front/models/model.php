<?php
namespace Model;

class Model {
	protected $dbHandle = false;

	public function __construct() {
		// parse the configuration file for databases
		$config = parse_ini_file('./config/dbconfig.ini');

		// open a database connection and make sure it is working
		$pdo = new \PDO("{$config['driver']}:host={$config['host']};dbname={$config['schema']}", $config['username'], $config['password']);

		// store the database handle instance so it can be used in child models
		$this->dbHandle = $pdo;
	}
}

?>