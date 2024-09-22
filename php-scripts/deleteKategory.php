<?php 

$id = $_POST['delete'];
echo $id;

require('conn.php');

$sql = "DELETE FROM kategories WHERE id = ?";
$stmt = $conn->prepare($sql); 
$stmt->bind_param("i", $id); 

if ($stmt->execute()) {
    echo "<script>window.location.href = '../admin-kab.php';</script>";
} else {
    echo "<script>alert('Удаление не получилось :(.');</script>";
    echo "<script>window.location.href = '../lich-kab.php';</script>";
}

$stmt->close();

$conn->close();  

?>