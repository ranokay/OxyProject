<?php

if (isset($_POST['submit'])) {
	$username = $_POST['username'];
	$password = $_POST['password'];

	include "dbh.inc.php";

	class Login extends Dbh
	{
		protected function getUser($username, $password)
		{
			$sql = "SELECT `password` FROM users WHERE `username` = ? OR `email` = ?;";
			$stmt = $this->connect()->prepare($sql);

			if (!$stmt->execute([$username, $username])) {
				$stmt = null;
				header("Location: ../login?error=stmtfailed");
				exit();
			}
			if ($stmt->rowCount() == 0) {
				$stmt = null;
				header("Location: ../login?error=usernotfound");
				exit();
			}
			$passwordHashed = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$checkPassword = password_verify($password, $passwordHashed[0]['password']);

			if ($checkPassword === false) {
				$stmt = null;
				header("Location: ../login?error=usernotfound");
				exit();
			} elseif ($checkPassword === true) {
				$sql = "SELECT * FROM users WHERE (`username` = ? OR `email` = ?) AND `password` = ?;";
				$stmt = $this->connect()->prepare($sql);

				if (!$stmt->execute([$username, $username, $passwordHashed[0]['password']])) {
					$stmt = null;
					header("Location: ../login?error=stmtfailed");
					exit();
				}
				if ($stmt->rowCount() == 0) {
					$stmt = null;
					header("Location: ../login?error=usernotfound");
					exit();
				}
				$user = $stmt->fetchAll(PDO::FETCH_ASSOC);

				session_start();
				$_SESSION['userId'] = $user[0]['id'];
				$_SESSION['user'] = $user[0]['username'];
				$_SESSION['userType'] = $user[0]['user_type'];
				$_SESSION['userVerified'] = $user[0]['verified'];
				$stmt = null;
			}
		}
	}
	class LoginContr extends Login
	{
		private $username;
		private $password;

		public function __construct($username, $password)
		{
			$this->username = $username;
			$this->password = $password;
		}
		public function loginUser()
		{
			if ($this->emptyFields() == false) {
				header("Location: ../login?error=emptyfields");
				exit();
			}
			$this->getUser($this->username, $this->password);
		}
		private function emptyFields()
		{
			if (empty($this->username) || empty($this->password)) {
				$result = false;
			} else {
				$result = true;
			}
			return $result;
		}
	}
	$login = new LoginContr($username, $password);
	$login->loginUser();

	header("Location: ../dashboard?login=success");
} else {
	header("Location: ../home");
}
