<?php

namespace App\Store;

use PDO;


class TokenStore
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

	public function login($params)
	{
		try{
			$stmt = $this->db->prepare("SELECT * FROM TOKEN WHERE (EMAIL=:email OR PHONE=:phone) AND PASSWORD=:password");

			$stmt->bindParam(':email', $params['email']);
			$stmt->bindParam(':phone', $params['phone']);
			$stmt->bindParam(':password', $params['password']);


			if ($stmt->execute()) {
				$row = $stmt->fetch();
				if ($row) {
					return $row;
				}
			}
			else
			{
			}

		} catch (PDOException $e) {
			print "Error!: " . $e->getMessage() . "<br/>";
			die();
		}

		return false;

	}

	public function createToken($params)
	{
		try {
			$stmt = $this->db->prepare("INSERT INTO TOKEN (USER_ID, EMAIL,PHONE_NUMBER, PASSWORD) VALUES (:userid, :email, :phone, :password);");

			$stmt->bindParam(':userid', $params['userid']);
			$stmt->bindParam(':email', $params['email']);
			$stmt->bindParam(':phone', $params['phone']);
			$stmt->bindParam(':password', $params['password']);

			$stmt->execute();
			return $this->db->lastInsertId();

		} catch (PDOException $e) {
			print "Error!: " . $e->getMessage() . "<br/>";
			die();
		}


	}


}
