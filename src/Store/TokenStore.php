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
			$dbh = new PDO('mysql:host=127.0.0.1;dbname=TIJN', $this->username, $this->pass);
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
			$stmt->bindParam(':phone', $params['email']);
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

	public function getDetailsForTokenId($tokenId)
	{
		try{
			$stmt = $this->db->prepare("SELECT * FROM TOKEN WHERE TOKEN_ID=:tokenId");

			$stmt->bindParam(':tokenId', $tokenId);


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

	public function getUserIdForEmailPhone($email, $phone)
	{
		try{
			$stmt = $this->db->prepare("SELECT USER_ID FROM TOKEN WHERE EMAIL=:email OR PHONE=:phone");

			$stmt->bindParam(':email', $email);
			$stmt->bindParam(':phone', $phone);


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

	public function verifyToken($tokenId)
	{
		try {
			$stmt = $this->db->prepare("UPDATE TOKEN SET IS_VERIFIED_TOKEN='Y' WHERE TOKEN_ID=:tokenId");

			$stmt->bindParam(':tokenId', $tokenId);

			$stmt->execute();
			return $this->db->lastInsertId();

		} catch (PDOException $e) {
			print "Error!: " . $e->getMessage() . "<br/>";
			die();
		}


	}

	public function createToken($params)
	{
		try {
			$stmt = $this->db->prepare("INSERT INTO TOKEN (USER_ID, EMAIL,PHONE, IS_VERIFIED_TOKEN, PASSWORD) VALUES (:userid, :email, :phone, :isVerified, :password);");

			$params['isVerified'] = 'N';
			$stmt->bindParam(':userid', $params['userid']);
			$stmt->bindParam(':isVerified', $params['isVerified']);
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
