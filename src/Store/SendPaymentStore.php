<?php

namespace App\Store;

use PDO;


class SendPaymentStore
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

	public function getStatementForMonth($params)
	{
		try{
			$stmt = $this->db->prepare("SELECT * FROM SEND_PAYMENT WHERE (PAYMENT_TIME < :end and PAYMENT_TIME > :start) AND (FROM_USERID = :userId OR TO_USERID = :userId)");


			$stmt->bindParam(':start', $params['start']);
			$stmt->bindParam(':end', $params['end']);
			$stmt->bindParam(':userId', $params['userId']);

			if ($stmt->execute()) {
				return $row = $stmt->fetchAll();
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
			$stmt = $this->db->prepare("INSERT INTO SEND_PAYMENT (TO_USERID, FROM_USERID, AMOUNT, MEMO, IS_CANCELLED) values(:toUserId, :fromUserId, :amount, :memo, :isCancelled)");

			$params['isCancelled'] = 'N';

			$stmt->bindParam(':fromUserId', $params['fromUserid']);
			$stmt->bindParam(':toUserId', $params['userid']);
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
