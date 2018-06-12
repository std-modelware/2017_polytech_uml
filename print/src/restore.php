<?php require_once("includes/connection.php"); ?>
<?php include("includes/header.php"); ?>

<?php

$message = 'Введите Ваше имя и адрес электронной почты';

if (isset($_POST["restore"])) {
    $fullname = htmlspecialchars($_POST['fullname']);
    $email = htmlspecialchars($_POST['email']);

    if (!empty($fullname) && !empty($email)) {
        $query1 = mysqli_query($link, "SELECT * FROM users WHERE (fullname = '" . $fullname . "' AND email = '" . $email . "')");
        $numrows1 = mysqli_num_rows($query1);

//        $password = uniqid(rand(), true);

        // Функция генерации пароля
        function generate_password($number)
        {
            $arr = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'v', 'x', 'y', 'z',
                'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'V', 'X', 'Y', 'Z',
                '1', '2', '3', '4', '5', '6', '7', '8', '9', '0', '.', ',', '(', ')', '[', ']', '!', '?', '&', '^', '%', '@', '*', '$',
                '<', '>', '/', '|', '+', '-', '{', '}', '`', '~');
            // Генерируем пароль
            $pass = "";
            for ($i = 0; $i < $number; $i++) {
                // Вычисляем случайный индекс массива
                $index = rand(0, count($arr) - 1);
                $pass .= $arr[$index];
            }
            return $pass;
        }

        $password = generate_password(20);
        $headers = 'From: print8print@mail.ru';
        mail($email, "Сброс пароля",
            "Уважаемый(ая) $fullname, Вы сделали запрос на получение забытого пароля на сайте Print.\r\nВаш новый пароль: $password\r\nПри входе в систему обязательно смените пароль!",
            $headers);

        $password = password_hash($password, PASSWORD_DEFAULT);
        $sql1 = "UPDATE users SET password = '" . $password . "' WHERE email = '" . $email . "'";
        $result1 = mysqli_query($link, $sql1);

        if ($result1) {
            $message = '<span class = "good">Новый пароль выслан вам на почту!</span></br>';

        } else {
            $message = '<span class = "bad">Ошибка при работе с базой данных</span></br>';
            printf("Errormessage: %s\n", mysqli_error($link));
        }
    } else {
        $message = "Все поля обязательны для заполнения!";
    }
}
?>

<body>
<div class="container mregister">
    <div id="login">
        <h1>Восстановление пароля</h1>
        <center><?php echo $message; ?></center>
        <form action="restore.php" id="registerform" method="post" name="registerform">
            <p><label for="user_login">Полное имя<br>
                    <input class="input" id="fullname" name="fullname" size="32" type="text" value=""></label></p>
            <p><label for="user_pass">E-mail<br>
                    <input class="input" id="email" name="email" size="32" type="email" value=""></label></p>
            <p class="submit"><input class="button" id="restore" name="restore" type="submit"
                                     value="Восстановить пароль"></p>
            <p class="regtext">Вспомнили пароль? </br> <a href="login.php">Скорее жмите сюда!</a></p>
            <!--            <p class="regtext">Еще не зарегистрированы? <br><a href="register.php">Регистрация!</a></p>-->
        </form>
    </div>
</div>
</body>

<?php include("includes/footer.php"); ?>
