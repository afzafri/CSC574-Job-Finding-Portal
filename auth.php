<?php
	//Start session
	session_start();
	//Check whether the session variable SESS_MEMBER_ID is present or not
	if(!isset($_SESSION['USER_ID']) || (trim($_SESSION['USER_ID']) == ''))
	{
		echo "<script>alert('Wrong username and password')</script>";
		header("location: ../login.php");
		exit();
	}
?>
