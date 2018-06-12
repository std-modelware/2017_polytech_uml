<?php require_once("includes/connection.php"); ?>

<?php
$message = '';
$query1 = '';
$query2 = '';
$result = '';

if (isset($_POST["register"])) {

    $fullname = htmlspecialchars($_POST['fullname']);
    $email = htmlspecialchars($_POST['email']);
    $username = htmlspecialchars($_POST['username']);
    $password = password_hash(htmlspecialchars($_POST['password']), PASSWORD_DEFAULT);

    if (!empty($fullname) && !empty($email) && !empty($username) && !empty($password)) {

        $query1 = mysqli_query($link, "SELECT * FROM users WHERE username = '" . $username . "'");
        $numrows1 = mysqli_num_rows($query1);

        $query2 = mysqli_query($link, "SELECT * FROM users WHERE email = '" . $email . "'");
        $numrows2 = mysqli_num_rows($query2);

        if ($numrows2 != 0) {
            $message = '<span class = "bad">Такой email уже зарегистрирован в системе!</span></br>';
        } elseif ($numrows1 != 0) {
            $message = '<span class = "bad">Имя пользователя уже занято!</span></br>';

        } else {
            $sql = "INSERT INTO users (fullname, email, username, password) VALUES ('" . $fullname . "','" . $email . "', '" . $username . "', '" . $password . "')";
            $result = mysqli_query($link, $sql);

            if ($result) {
                $message = '<span class = "good">Аккаунт успешно создан!</br> Для авторизации используйте свой логин и пароль на странице входа</span></br>';
                // echo "<script>document.location.href='login.php';</script>";

            } else {
                $message = '<span class = "bad">Ошибка при работе с базой данных</span></br>';
                printf("Errormessage: %s\n", mysqli_error($link));
            }
        }
    } else {
        $message = '<span class = "bad">Все поля обязательны для заполнения!</span></br>';
    }
}
?>


<?php include("includes/header.php"); ?>
    <body>
    <div class="container mregister">
        <div id="login">
            <h1>Регистрация</h1>
            <center><?php echo $message; ?></center>
            <form id="registerform" method="post" name="registerform">
                <p><label for="user_fullname">Полное имя<br>
                        <input class="input" id="fullname" name="fullname" size="32" type="text" value=""></label></p>
                <p><label for="user_email">E-mail<br>
                        <input class="input" id="email" name="email" size="32" type="email" value=""></label></p>
                <p><label for="user_login">Логин<br>
                        <input class="input" id="username" name="username" size="20" type="text" value=""></label></p>
                <p><label for="user_pass">Пароль<br>
                        <input class="input" id="password" name="password" size="32" type="password" value=""></label>
                </p>
                <p class="submit"><input class="button" id="register" name="register" type="submit"
                                         value="Зарегистрироваться"></p>
                <p class="regtext">Уже зарегистрированы? <a href="login.php">Вход!</a></p>
            </form>
        </div>
    </div>
    </body>
<?php include("includes/footer.php"); ?>