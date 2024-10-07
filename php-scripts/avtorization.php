
<?php 

$conn = new mysqli("localhost", "root", "", "PortalForGood");
if($conn->connect_error){
    die("Ошибка: " . $conn->connect_error);
}


$login = $conn->real_escape_string($_POST["login"]);
$password = $conn->real_escape_string($_POST["password"]);

if ($login != "admin" && $password != "adminWSR")
{
    $stmt = $conn->prepare("SELECT * FROM users WHERE login = ? AND password = ?");
    $stmt->bind_param("ss", $login, $password);
    $stmt->execute();
    
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        session_start();
        $_SESSION['user_id'] = $user['id'];
        echo "<script>window.location.href = '../lich-kab.php';</script>";
    
    } else {
        echo "<script>alert('Пароль или логин не верны.');</script>";
        echo "<script>window.location.href = '../index.php#forms';</script>";
    }
}
else
{
    session_start();
    $_SESSION["user_id"] = "admin";
    echo "<script>window.location.href = '../admin-kab.php';</script>";
}

$conn->close();

?>
