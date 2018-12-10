<?php

namespace App\Store;

use PDO;


class BankStore
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

	public function getDetailsForUserId($userId)
	{
		try{
			$stmt = $this->db->prepare("SELECT * FROM BANK_ACCOUNT WHERE USER_ID = :userId");

			$stmt->bindParam(':userId', $userId);


			if ($stmt->execute()) {
				$row = $stmt->fetchAll();
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

	public function setPrimary($params)
	{
		try {
			$stmt = $this->db->prepare("UPDATE BANK_ACCOUNT SET IS_PRIMARY ='Y' WHERE USER_ID=:userId AND ACCOUNT_NUMBER=:acnumber");

			$stmt->bindParam(':acnumber', $params['acnumber']);
			$stmt->bindParam(':userId', $params['userid']);

			$stmt->execute();

			return $this->db->lastInsertId();

		} catch (PDOException $e) {
			print "Error!: " . $e->getMessage() . "<br/>";
			die();
		}


	}
	public function createAccount($params)
	{
		try {
			$stmt = $this->db->prepare("INSERT INTO BANK_ACCOUNT (ACCOUNT_NUMBER, USER_ID, IS_PRIMARY, IS_VERIFIED) VALUES (:acnumber, :userId, :primary, :verified);");

			$params['verified'] = 'N';
			$stmt->bindParam(':acnumber', $params['acnumber']);
			$stmt->bindParam(':userId', $params['userid']);
			$stmt->bindParam(':primary', $params['primary']);
			$stmt->bindParam(':verified', $params['verified']);

			$stmt->execute();

			return $this->db->lastInsertId();

		} catch (PDOException $e) {
			print "Error!: " . $e->getMessage() . "<br/>";
			die();
		}


	}

}
