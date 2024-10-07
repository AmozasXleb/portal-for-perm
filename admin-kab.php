
<?php 

session_start();

if(!isset($_SESSION['user_id']))
{
    $_SESSION['user_id'] = "none";
    echo "<script>window.location.href = '../index.php';</script>";
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat+Alternates:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/admin-kab.css">
    <link rel="shortcut icon" href="img/logo.png" type="image/x-icon">
    <title>В наших руках! - админ панель</title>
</head>
<body>

    <div class="header">
        <img src="img/header.png" alt="В наших руках!">
    </div>

    <div class="header-line">
        <span>Админ панелька</span>
        <div class="air"></div>
        <form action="php-scripts/logout.php" method="post" style="margin: 0;">
            <button type="submit">Выйти</button>
        </form>
    </div>
    <div class="wrapper">

        <div class="menu">
            <button type="button" id="onZav" onclick="onZav()">Заявки</button>
            <span> | </span>
            <button type="button" id="onKat" onclick="onKat()">Категории</button>
        </div>

        <div class="main-blocks">

        <div id="kat">
            <div class="kategories">

                <form action="php-scripts/addKategory.php" method="post" class="input-kat">
                    <input type="text" name="newKat" id="" placeholder="Имя новой категории..." required>
                    <button type="submit">Добавить категорию</button>
                </form>

                <?php 
            
                    require("php-scripts/conn.php");

                    $stmt = $conn->prepare("SELECT * FROM kategories");
                    $stmt->execute();
                    
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<form action='php-scripts/deleteKategory.php' method='post' class='line-kat'>
                                <span class='name' id='" . $row['id'] . "'>" . $row['kategory'] . "</span>
                                <button type='submit' name='delete' value='" . $row['id'] . "'>Удалить</button>
                                </form>";
                        }
                    }
                
                ?>

            </div>
        </div>

        <div id="zav" hidden>
            <div class="zayavki">
                <div class="blocks">

                    <?php 
                
                        require("php-scripts/conn.php");

                        $stmt = $conn->prepare("SELECT * FROM problems WHERE isFinished = 0 ORDER BY id DESC");
                        $stmt->execute();
                        
                        $result = $stmt->get_result();

                        $dateNow = date('Y-m-d');

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<form action='php-scripts/whatToDo.php' method='post' class='block' enctype='multipart/form-data'>
                                <span class='name'>Название: " . $row['name'] . "</span>
                                <span class='opis'>Описание: " . $row['description'] . "</span>
                                <img src='" . $row['image'] . "'>
                                <span class='kategory'>Категория: " . $row['kategory'] . "</span>
                                <span class='kategory'>Дата: " . $row['date'] . "</span>";
                                if ($row['date']==$dateNow)
                                        {
                                            echo "<span class='kategory' style='color='green''>Новая!</span>";
                                        }
                                echo "<input type='file' name='file'>
                                <div class='buttons'>
                                <button type='submit' name='good' id='good' value='" . $row['id'] . "'>Решено</button>
                                <button type='submit' name='bad' id='bad' value='" . $row['id'] . "'>Отклонена</button>
                                </div>
                                </form>";
                            }
                        }
                    
                    ?>

                </div>
            </div>
        </div>

        </div>
    </div>

    <script>

        var zav = document.getElementById('zav');
        var kat = document.getElementById('kat');

        function onZav() {
            kat.hidden = true;
            zav.hidden = false;
        }

        function onKat() {
            kat.hidden = false;
            zav.hidden = true;
        }

    </script>

</body>
</html>