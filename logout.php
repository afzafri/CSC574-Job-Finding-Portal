<?php
ob_start();

//Unset the variables stored in session
unset($_SESSION['USER_ID']);
unset($_SESSION['USER_EMAIL']);
unset($_SESSION['USER_USERNAME']);
unset($_SESSION['USER_LEVEL']);

session_destroy();
header("location: login.php");
exit();

?>
