
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
    <link rel="stylesheet" href="css/lich-kab.css">
    <link rel="shortcut icon" href="img/logo.png" type="image/x-icon">
    <title>В наших руках! - личный кабинет</title>
</head>
<body>
    <div class="header">
        <img src="img/header.png" alt="В наших руках!">
    </div>

    <div class="header-line">
        <span>Личный кабинет</span>
        <div class="air"></div>
        <form action="php-scripts/logout.php" method="post" style="margin: 0;">
            <button type="submit">Выйти</button>
        </form>
    </div>
    <div class="wrapper">
        <div class="menu">
            <button type="button" id="onMake" onclick="onMake()">Создать заявку</button>
            <span> | </span>
            <button type="button" id="onMy" onclick="onMy()">Мои заявки</button>
        </div>

        <div class="main-blocks">

            <div id="my-zav">
                <div class="my-zav">

                    <div class="fin-zav">

                        <span class="head">Решённые проблемы:</span>

                        <div class="blocks">

                            <?php 
                        
                                require("php-scripts/conn.php");

                                session_start();

                                $id = $_SESSION['user_id'];
    
                                $stmt = $conn->prepare("SELECT * FROM problems WHERE isFinished = 1 AND user = ?");
                                $stmt->bind_param("i", $id); 
                                $stmt->execute();
                                
                                $result = $stmt->get_result();

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<div class='block'>
                                            <span class='name'>Название: " . $row['name'] . "</span>
                                            <span class='opis'>Описание: " . $row['description'] . "</span>
                                            <img src=" . $row['imageAfter'] . ">
                                            <span class='kategory'>Категория: " . $row['kategory'] . "</span>
                                            </div>";
                                    }
                                }
                            
                            ?>

                        </div>

                    </div>

                    <div class="in-progress">
                        <span class="head">Проблемы в процессе:</span>

                        <div class="blocks">
                            
                        <?php 
                        
                            require("php-scripts/conn.php");
                            
                            session_start();

                            $id = $_SESSION['user_id'];

                            $stmt = $conn->prepare("SELECT * FROM problems WHERE isFinished = 0 AND user = ?");
                            $stmt->bind_param("i", $id); 
                            $stmt->execute();
                            
                            $result = $stmt->get_result();

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<div class='block'>
                                        <span class='name'>Название: " . $row['name'] . "</span>
                                        <span class='opis'>Описание: " . $row['description'] . "</span>
                                        <img src=" . $row['image'] . ">
                                        <span class='kategory'>Категория: " . $row['kategory'] . "</span>
                                        <form action='php-scripts/whatToDo.php' method='post'><button type='submit' id='id' name='reject' value='" . $row['id'] . "' >Отменить заявку</button></form>
                                        </div>";
                                }
                            }
                        
                        ?>

                        </div>
                    </div>
                </div>
            </div>

            <div id="make-zav" hidden>
                <form class="make-zav" action="php-scripts/makeZav.php" method="post" enctype="multipart/form-data">

                    <div class="dow-foto">
                        <input type="file" name="file" id="">
                        <span>Загрузите фото проблемы, для которой вы хотите сделать заявку</span>
                    </div>

                    <div class="fill-info">
                        <div class="form-info">

                            <span>Название:</span>
                            <input type="text" name="name" required>

                            <span>Опишите свою проблему:</span>
                            <input type="text" name="desc" required>

                            <span>Категория проблемы:</span>
                            <select name="kat" id="" required>
                                
                                <?php 
            
                                    require("php-scripts/conn.php");

                                    $stmt = $conn->prepare("SELECT * FROM kategories");
                                    $stmt->execute();
                                    
                                    $result = $stmt->get_result();

                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<option value='" . $row['kategory'] . "'>" . $row['kategory'] . "</option>";
                                        }
                                    }
                                
                                ?>
                            </select>

                            <button type="submit" name="<?php 
                                                        session_start();

                                                        $id = $_SESSION['user_id'];
                                                        echo $id;
                            ?>">Отправить заявку</button>
                        </div>
                    </div>

                </form>
            </div>

        </div>
    </div>
    <div class="footer">

        <span>В наших руках - сделаем жизнь лучше!</span>
        <span>Разработано Ипановой Дарьей 1-ИС</span>

    </div>
</body>

<script>

    var my = document.getElementById('my-zav');
    var make = document.getElementById('make-zav');

    function onMy() {
        my.hidden = false;
        make.hidden = true;
    }

    function onMake() {
        my.hidden = true;
        make.hidden = false;
    }

</script>

</html>