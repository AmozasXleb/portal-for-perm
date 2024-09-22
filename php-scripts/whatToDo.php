<?php 

require('conn.php');

if (isset($_POST['good'])) {

    $id = $_POST['good'];

    $targetDir = "../img/foto-after/"; 

    $fileName = basename($_FILES["file"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $targetFilePath = str_replace(' ', '', $targetFilePath);
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    $check = getimagesize($_FILES["file"]["tmp_name"]);
    if ($check !== false) {
        if (file_exists($targetFilePath)) {
            echo "Извините, файл уже существует.";
        } else {
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
                echo "Файл " . $fileName . " был загружен.";
            } else {
                echo "Извините, произошла ошибка при загрузке вашего файла.";
            }
        }
    } else {
        echo "Файл не является изображением.";
    }

    require("conn.php");

    $sql = "UPDATE problems SET isFinished = 1, imageAfter = ? WHERE id = ?";
    $stmt = $conn->prepare($sql); 
    $stmt->bind_param("si", $targetFilePath, $id); 

    if ($stmt->execute()) {

        echo "<script>window.location.href = '../admin-kab.php';</script>";
    } else {
        echo "<script>alert('Ошибка!');</script>";
        echo "<script>window.location.href = '../admin-kab.php';</script>";
    }

    $stmt->close();

    $conn->close();
    
} elseif (isset($_POST['bad'])) {

    $id = $_POST['bad'];

    $sql = "DELETE FROM problems WHERE id = ?";
    $stmt = $conn->prepare($sql); 
    $stmt->bind_param("i", $id); 

    if ($stmt->execute()) {
        echo "<script>window.location.href = '../admin-kab.php';</script>";
    } else {
        echo "<script>alert('Удаление не получилось :(.');</script>";
        echo "<script>window.location.href = '../admin-kab.php';</script>";
    }

    $stmt->close();

    $conn->close();  
} elseif (isset($_POST['reject'])) {

    $id = $_POST['reject'];

    $sql = "DELETE FROM problems WHERE id = ?";
    $stmt = $conn->prepare($sql); 
    $stmt->bind_param("i", $id); 

    if ($stmt->execute()) {
        echo "<script>window.location.href = '../lich-kab.php';</script>";
    } else {
        echo "<script>alert('Удаление не получилось :(.');</script>";
        echo "<script>window.location.href = '../lich-kab.php';</script>";
    }

    $stmt->close();

    $conn->close();  
}



?>