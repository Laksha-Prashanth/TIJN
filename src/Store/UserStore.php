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
			$dbh = new PDO('mysql:host=127.0.0.1;dbname=TIJN', $this->username, $this->pass);
			$this->db = $dbh;
		} catch (PDOException $e) {
			print "Error!: " . $e->getMessage() . "<br/>";
			die();
		}

	}

	public function increaseBalanceForUserId($userId, $balance)
	{
		try{
			$stmt = $this->db->prepare("UPDATE USERS SET BALANCE = BALANCE + :balance WHERE USER_ID = :userId");

			$stmt->bindParam(':userId', $userId);
			$stmt->bindParam(':balance', $balance);


			if ($stmt->execute()) {
			}

		} catch (PDOException $e) {
			print "Error!: " . $e->getMessage() . "<br/>";
			die();
		}

		return false;

	}
	public function setBalanceForUserId($userId, $balance)
	{
		try{
			$stmt = $this->db->prepare("UPDATE USERS SET BALANCE = :balance WHERE USER_ID = :userId");

			$stmt->bindParam(':userId', $userId);
			$stmt->bindParam(':balance', $balance);


			if ($stmt->execute()) {
			}

		} catch (PDOException $e) {
			print "Error!: " . $e->getMessage() . "<br/>";
			die();
		}

		return false;

	}

	public function getDetailsForUserId($userId)
	{
		try{
			$stmt = $this->db->prepare("SELECT * FROM USERS WHERE USER_ID = :userId");

			$stmt->bindParam(':userId', $userId);


			if ($stmt->execute()) {
				$row = $stmt->fetch();
				if ($row) {
					return $row;
				}
			}

		} catch (PDOException $e) {
			print "Error!: " . $e->getMessage() . "<br/>";
			die();
		}

		return false;

	}
	public function createDummyUser()
	{
		try {
			$stmt = $this->db->prepare("INSERT INTO USERS ( PLAN_ID,  IS_CONFIRMED) VALUES (:plan_id, :isConfirmed);");

			$params['planid'] = 1;
			$params['confirmed'] = 'N';
			$stmt->bindParam(':plan_id', $params['planid']);
			$stmt->bindParam(':isConfirmed', $params['confirmed']);

			$stmt->execute();

			return $this->db->lastInsertId();

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
