<?php

namespace App\Store;

use PDO;


class UserStore
{
	private $username = "laksha";
	private $pass = "laksha";
	private $db;

	function __construct()
	{
		try {
			$dbh = new PDO('mysql:host=127.0.0.1;dbname=tijn', $this->username, $this->pass);
			$this->db = $dbh;
		} catch (PDOException $e) {
			print "Error!: " . $e->getMessage() . "<br/>";
			die();
		}

	}

	public function createUser($params)
	{
		try {
			$stmt = $this->db->prepare("INSERT INTO USERS ( PLAN_ID, FIRST_NAME, LAST_NAME, SSN, BALANCE, IS_CONFIRMED) VALUES (:plan_id, :first_name, :last_name, :ssn, :balance, :isConfirmed);");
			$params['planid'] = 1;
			$params['balance'] = 0;
			$params['confirmed'] = 'N';
			$stmt->bindParam(':plan_id', $params['planid']);
			$stmt->bindParam(':first_name', $params['firstName']);
			$stmt->bindParam(':last_name', $params['lastName']);
			$stmt->bindParam(':ssn', $params['ssn']);
			$stmt->bindParam(':balance', $params['balance']);
			$stmt->bindParam(':isConfirmed', $params['confirmed']);

			$stmt->execute();

			return $this->db->lastInsertId();

		} catch (PDOException $e) {
			print "Error!: " . $e->getMessage() . "<br/>";
			die();
		}


	}


}
