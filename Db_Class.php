<?php

class Db {

	private $db;

	public function __construct() {
		try {
			$this->db = new PDO('mysql:host=localhost;dbname=test', 'root', 'kaktus');
			$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch(Exception $e) {
			echo 'Connection failed: ' . $e->getMessage();
		}
	}

	public function dbExecute($sql, $params = []) {
		$result = false;

		$result = $this->db->prepare($sql);
		foreach ($params as $key => $value) {
			$result->bindParam($key, $params[$key], PDO::PARAM_STR);
		}
		$result->execute();
		return $result;
	}
}