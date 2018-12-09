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

	public function createToken($params)
	{
		try {
			$stmt = $this->db->prepare("INSERT INTO TOKEN (USER_ID, EMAIL,PHONE_NUMBER) VALUES (:userid, :email, :phone);");

			$stmt->bindParam(':userid', $params['userid']);
			$stmt->bindParam(':email', $params['email']);
			$stmt->bindParam(':phone', $params['phone']);

			$stmt->execute();
			return $this->db->lastInsertId();

		} catch (PDOException $e) {
			print "Error!: " . $e->getMessage() . "<br/>";
			die();
		}


	}


}
