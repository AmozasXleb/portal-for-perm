
<?php 

session_start();

if(!isset($_SESSION['user_id']))
{
    $_SESSION['user_id'] = "none";
}

if ($_SESSION["user_id"] == "admin")
{
    echo "<script>window.location.href = '../admin-kab.php';</script>";
}

if (!($_SESSION['user_id'] == '') and !($_SESSION['user_id'] == 'none'))
{
    echo "<script>window.location.href = '../lich-kab.php';</script>";
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
    <link rel="stylesheet" href="css/index.css">
    <link rel="shortcut icon" href="img/logo.png" type="image/x-icon">
    <title>В наших руках! - главная</title>
</head>
<body>
    <div class="wrapper">
        <div class="header">
                <img src="img/header.png" alt="В наших руках!">
        </div>
        <div class="counter">
            <div class="counter-wrapper">
                <span class="reg-text">Мы решили уже</span>
                <span class="counter-text" id="counter">32132</span>
                <span class="reg-text">проблем по всему краю!</span>
                <span class="red-text">И не планируем останавливаться!</span>
            </div>
        </div>

        <script>
    var intCounter = document.getElementById('counter');

    function updateCounter() {
        fetch('php-scripts/getData.php')
        .then(response => response.json())
        .then(data => {
            console.log(data); 
            intCounter.textContent = data;
        })
        .catch(error => console.error('Error:', error));
    }

    updateCounter();


    setInterval(updateCounter, 5000);
</script>


        <div class="about-us">
            <div class="text-part">
                <div class="text-block">
                    <span class="head-text">Кто мы такие?</span>
                    <span class="bottom-text">“В наших руках” - краевая организация,  которая борется за более легкую и приятную жизнь сограждан по всему краю.</span>
                </div>

                <div class="text-block">
                    <span class="head-text">Как мы решаем проблемы?</span>
                    <span class="bottom-text">Благодаря нашим связям и голосам у нас получается напрямую отправлять важные заявки в правительство, а если у нас есть возможность самостоятельно решить проблему - привлекаем волонтёров!</span>
                </div>

                <div class="text-block">
                    <span class="head-text">Как вы находите проблемы?</span>
                    <span class="bottom-text">Через наш портал, на котором вы находитесь!
                        Регистрируйтесь на нашем портале, оставляйте заявки с описанием и фото проблемы - и будьте уверены, вас услышат!</span>
                </div>
            </div>
            <div class="logo-part">
                <img src="img/logo.png" alt="Наш логотип">
            </div>
        </div>
        <div class="gallery-block">
            <span class="zag">Совсем недавно <br>мы помогли с:</span>
            <div class="gallery">

                    <?php 
                        
                        require("php-scripts/conn.php");

                        $stmt = $conn->prepare("SELECT * FROM problems WHERE isFinished=1 ORDER BY id DESC LIMIT 4");
                        $stmt->execute();
                        
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<div class='foto-block'>
                                            <img class='foto-bef' src='" . $row['image'] . "'>
                                            <img class='foto-aft' src='" . $row['imageAfter'] . "' hidden>
                                            <div class='text'>
                                                <span id='name'>" . $row['name'] . "</span>
                                                <span id='date'>" . $row['date'] . "</span>
                                                <span id='type-of'>" . $row['kategory'] . "</span>
                                            </div>
                                        </div>";
                            }
                        }
                    
                    ?>

            </div>
        </div>
        
        <div class="reg-avto">

            <span class="reg-text">Хотите сообщить о проблеме?</span>
            <span class="reg-text">Или стать волотёром?</span>
            <span class="big-text">Заполните форму регистрации или авторизируйтесь:</span>

            <div class="forms" id="forms">

                <form class="reg" action="php-scripts/registration.php" method="post">
                    <span>Регистрация</span>
                    <input type="text" name="fio" id="" placeholder="ФИО...">
                    <input type="text" name="login" id="" placeholder="Логин...">
                    <input type="email" name="email" id="" placeholder="Электронная почта...">
                    <input type="password" name="password" id="" placeholder="Пароль..." minlength="8">
                    <input type="password" name="password2" id="" placeholder="Повтор пароля..." minlength="8">
                    <div class="checkbox">
                        <input type="checkbox" name="isAgreed" id=""> Согласие на обработку данных
                    </div>
                    <button type="submit" class="submit">Зарегестрироваться</button>
                </form>

                <form class="avto" action="php-scripts/avtorization.php" method="post">
                    <span>Авторизация</span>
                    <input type="text" name="login" id="" placeholder="Логин...">
                    <input type="password" name="password" id="" placeholder="Пароль...">
                    <button type="submit" class="submit">Войти</button>
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
    var fotoBlocks = document.querySelectorAll('.foto-block');

    fotoBlocks.forEach(function(block) {
        var imageBef = block.querySelector('.foto-bef');
        var imageAft = block.querySelector('.foto-aft');

        block.addEventListener('mouseover', function() {
            imageBef.hidden = true; 
            imageAft.hidden = false; 
        });

        block.addEventListener('mouseout', function() {
            imageBef.hidden = false;
            imageAft.hidden = true;
        });
    });
</script>

</html>

