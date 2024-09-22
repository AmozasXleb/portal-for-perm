<?php 

$newKat = $_POST['newKat'];

require('conn.php');


$stmt = $conn->prepare("INSERT INTO kategories (kategory) VALUES (?)");
$stmt->bind_param("s", $newKat);

if ($stmt->execute()) {
    echo "Категория добавлена";
    echo "<script>window.location.href = '../admin-kab.php';</script>";
} 

$stmt->close();

$conn->close();

?>