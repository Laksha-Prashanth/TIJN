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
