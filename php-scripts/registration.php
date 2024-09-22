
<?php 

$conn = new mysqli("localhost", "root", "", "PortalForGood");
if($conn->connect_error){
    die("Ошибка: " . $conn->connect_error);
}

$fio = $conn->real_escape_string($_POST["fio"]);
$login = $conn->real_escape_string($_POST["login"]);
$email = $conn->real_escape_string($_POST["email"]);
$password = $conn->real_escape_string($_POST["password"]);
$password2 = $conn->real_escape_string($_POST["password2"]);
$isAgreed = $_POST["isAgreed"];

if ($password == $password2 && $isAgreed == true) {
    $stmt = $conn->prepare("INSERT INTO users (fio, login, email, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $fio, $login, $email, $password);

    if ($stmt->execute()) {
        
        $sql = "SELECT * FROM users ORDER BY id DESC LIMIT 1";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            session_start();
            $_SESSION['user_id'] = $row['id'];
        } else {

        }
        echo "Юзер добавлен";
        echo "<script>window.location.href = '../lich-kab.php';</script>";
    } 

    $stmt->close();
} else {
    echo "<script>alert('Мне кажется, вы что-то забыли.');</script>";
    echo "<script>window.location.href = '../index.php#forms';</script>";
}

$conn->close();

?>
