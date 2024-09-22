<?php 
session_start();

$_SESSION['user_id'] = "none";

echo "<script>window.location.href = '../index.php';</script>";

?>