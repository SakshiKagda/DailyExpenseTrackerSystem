<?php
session_start();
$_SESSION = array();
session_destroy();
echo "<script>alert('Are you sure you want to log out?'); window.location.href = 'login.php';</script>";
exit();
?>
