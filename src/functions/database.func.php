<?php

/**
 * ================================
 * DATABASE
 * ================================
 */


/**
 * Create new SQLITE connection
 */
function db_sqlite_connect(): ?PDO
{
	try {
		$pdo = new PDO('sqlite:'.SQLITE_PATH);
		$pdo->setAttribute(
			PDO::ATTR_DEFAULT_FETCH_MODE, 
			PDO::FETCH_ASSOC
		);
		$pdo->setAttribute(
			PDO::ATTR_ERRMODE, 
			PDO::ERRMODE_SILENT
		);
		return $pdo;
	} catch(PDOException $ex) {
		return null;
	}
}


/**
 * Create new MYSQL connection
 */
function db_mysql_connect(): ?PDO
{
	try {
		$dsn = 'mysql:host='.MYSQL_HOST.':'.MYSQL_PORT.';dbname='.MYSQL_NAME;
		$pdo = new PDO($dsn, MYSQL_USER, MYSQL_PASSWD);
		$pdo->setAttribute(
			PDO::ATTR_DEFAULT_FETCH_MODE, 
			PDO::FETCH_ASSOC
		);
		$pdo->setAttribute(
			PDO::ATTR_ERRMODE, 
			PDO::ERRMODE_SILENT
		);
		return $pdo;
	} catch(PDOException $ex) {
		return null;
	}
}

