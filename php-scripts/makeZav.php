<?php 

$name = $_POST['name'];
$desc = $_POST['desc'];
$kat = $_POST['kat'];
$approved = false;
$finished = false;

session_start();

$id = $_SESSION['user_id'];

$targetDir = "../img/foto-before/"; 

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

$date = date('Y-m-d');

$stmt = $conn->prepare("INSERT INTO problems (name, description, kategory, image, isFinished, date, user) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssbsi", $name, $desc, $kat, $targetFilePath, $finished, $date, $id);

if ($stmt->execute()) {
    echo "заявка добавлена";
    echo "<script>window.location.href = '../lich-kab.php';</script>";
} 

$stmt->close();

$conn->close();


?>