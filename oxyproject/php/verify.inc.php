<?php

function redirect($error)
{
	if (isset($_SESSION['userId'])) {
		header("Location: ../dashboard?error=$error");
	} else {
		header("Location: ../login?error=$error");
	}
}

if (isset($_GET['vkey']) && !empty($_GET['vkey'])) {
	$vKey = $_GET['vkey'];
	$email = $_GET['email'];

	include 'dbh.inc.php';

	class VerifyAccount extends Dbh
	{
		protected function verify($email, $vKey)
		{
			$sql = "SELECT `v_key`, `verified` FROM users WHERE `email` = ?;";
			$stmt = $this->connect()->prepare($sql);

			if (!$stmt->execute([$email])) {
				$stmt = null;
				$error = "stmtfailed";
				redirect($error);
				exit();
			}
			if ($stmt->rowCount() == 0) {
				$stmt = null;
				$error = "invalidkey";
				redirect($error);
				exit();
			}
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

			if ($result[0]['verified'] == 1) {
				$stmt = null;
				$error = "alreadyverified";
				redirect($error);
				exit();
			}
			$keyBin = hex2bin($vKey);
			$checkVKey = password_verify($keyBin, $result[0]['v_key']);

			if ($checkVKey === false) {
				$stmt = null;
				$error = "invalidkey";
				redirect($error);
				exit();
			} elseif ($checkVKey === true) {
				$sql = "UPDATE users SET `verified` = 1, `v_key` = 0 WHERE `email` = ?;";
				$stmt = $this->connect()->prepare($sql);

				if (!$stmt->execute([$email])) {
					$stmt = null;
					$error = "stmtfailed";
					redirect($error);
					exit();
				}
				$stmt = null;
				$error = "verified";
				redirect($error);
				exit();
			}
			$stmt = null;
		}
	}

	class VerifyAccountContr extends VerifyAccount
	{
		private $email;
		private $vKey;
		public function __construct($email, $vKey)
		{
			$this->email = $email;
			$this->vKey = $vKey;
		}
		public function verifyUser()
		{
			$this->verify($this->email, $this->vKey);
		}
	}
	$verifyAccount = new VerifyAccountContr($email, $vKey);
	$verifyAccount->verifyUser();
} else {
	header("Location: ../home");
}
