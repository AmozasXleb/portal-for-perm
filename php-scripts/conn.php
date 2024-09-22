<?php 

$conn = new mysqli("localhost", "root", "", "PortalForGood");
if($conn->connect_error){
    die("Ошибка: " . $conn->connect_error);
}


?>