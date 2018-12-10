<?php

namespace App\Store;

use PDO;


class RequestPaymentStore
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

	public function recordRequest($params)
	{
		try{
			$stmt = $this->db->prepare("INSERT INTO REQUEST_PAYMENT(FROM_USERID, TO_USERID, AMOUNT, MEMO) VALUES(:fromUserId, :toUserId, :amount, :memo)");


			$stmt->bindParam(':fromUserId', $params['fromUserid']);
			$stmt->bindParam(':toUserId', $params['toUserid']);
			$stmt->bindParam(':amount', $params['amount']);
			$stmt->bindParam(':memo', $params['memo']);

			$stmt->execute();
			return $this->db->lastInsertId();

		} catch (PDOException $e) {
			print "Error!: " . $e->getMessage() . "<br/>";
			die();
		}

		return false;

	}

	public function completeRequest($requestId)
	{
		try{
			$stmt = $this->db->prepare("UPDATE REQUEST_PAYMENT SET COMPLETED='Y' WHERE REQUEST_ID=:requestId");


			$stmt->bindParam(':requestId', $requestId);

			$stmt->execute();
			return $this->db->lastInsertId();

		} catch (PDOException $e) {
			print "Error!: " . $e->getMessage() . "<br/>";
			die();
		}

		return false;

	}

	public function getRequestsForUserId($userId)
	{
		try{
			$stmt = $this->db->prepare("SELECT * FROM REQUEST_PAYMENT WHERE TO_USERID = :userId AND COMPLETED='N'");

			$stmt->bindParam(':userId', $userId);

			if ($stmt->execute()) {
				$row = $stmt->fetchAll();
				return $row;
			}

		} catch (PDOException $e) {
			print "Error!: " . $e->getMessage() . "<br/>";
			die();
		}

		return false;

	}

	public function recordPayment($params)
	{
		try{
			$stmt = $this->db->prepare("INSERT INTO SEND_PAYMENT (TO_USERID, FROM_TOKEN_ID, AMOUNT, MEMO, IS_CANCELLED) values(:userId, :tokenId, :amount, :memo, :isCancelled)");

			$params['isCancelled'] = 'N';

			$stmt->bindParam(':userId', $params['userid']);
			$stmt->bindParam(':tokenId', $params['fromTokenid']);
			$stmt->bindParam(':amount', $params['amount']);
			$stmt->bindParam(':memo', $params['memo']);
			$stmt->bindParam(':isCancelled', $params['isCancelled']);

			$stmt->execute();
			return $this->db->lastInsertId();

		} catch (PDOException $e) {
			print "Error!: " . $e->getMessage() . "<br/>";
			die();
		}

		return false;

	}

}
