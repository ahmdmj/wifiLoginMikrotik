<?php
require("routeros_api.class.php");
$API = new routeros_api();
$API->debug = false;
$user_mikrotik = "";
$password_mikrotik = "";
$ip_mikrotik = "10.20.30.1";

if ($API->connect($ip_mikrotik, $user_mikrotik, $password_mikrotik)) {
	$username = $_POST['username'];
	$password = $_POST['password'];
	$password2 = $_POST['password2'];
	try {
		$cekuserpass = $API->comm(
			'/ip/hotspot/user/print',
			array(
				"?name" => $username,
				"?password" => $password,
			)
		);
		$cekuser = $API->comm(
			'/ip/hotspot/user/print',
			array(
				"?name" => $username,
			)
		);
		if (count($cekuserpass) > 0) {
			$API->comm(
				"/ip/hotspot/user/set",
				array(
					".id" => $username,
					"password" => $password2,
				)
			);
			echo "<script>window.location='../sukses.html'</script>";
		} elseif (count($cekuser) == 0) {
			echo "<script>window.location='../usernotfound.html'</script>";
		} else {
			echo "<script>window.location='../gagalpassword.html'</script>";
		}
		$API->disconnect();
	} catch (Exception $ex) {
		echo "Caught exception from router: " . $ex->getMessage() . "\n";
	}

} else {
	echo " Router Not Connected";
}
?>