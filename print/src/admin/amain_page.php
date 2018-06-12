<?php require_once("../includes/connection.php"); ?>
<?php
$state1 = 'links active';
$state4 = 'links';
$state2 = 'links';
$state3 = 'links';
include("menu_admin.php"); ?>

<?php
$message = ''; $message1 = '';

if (isset($_POST["register_oper"])) {

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
            $sql = "INSERT INTO users (fullname, email, username, password, tag) VALUES ('" . $fullname . "','" . $email . "', '" . $username . "', '" . $password . "', 'o')";
            $result = mysqli_query($link, $sql);

            if ($result) {
                $message = '<span class = "good">Аккаунт оператора успешно создан!</span></br>';

            } else {
                $message = '<span class = "bad">Ошибка при работе с базой данных</span></br>';
                printf("Errormessage: %s\n", mysqli_error($link));
            }
        }
    } else {
        $message = '<span class = "bad">Все поля обязательны для заполнения!</span></br>';
    }
}

if (isset($_POST["find_oper"])) {
    $query_oper = mysqli_query($link, "SELECT * FROM users WHERE tag = 'o'");
    $row = mysqli_fetch_array($query_oper);
    do {
        $message1 .= "<option value=" . $row['user_id'] . ">(ID: " . $row['user_id'] . ") " . $row['username'] . "</option>" . "\r\n";
    } while ($row = mysqli_fetch_array($query_oper));
}
?>


<?php include("../includes/header_account.php"); ?>
<div id="csetting" class="content" style="display: block">
    <center class="container settings">
        <h1>Создание аккаунта оператора</h1>
        <center><?php echo $message; ?></center>
        <form id="registerform" method="post" name="registerform">
            <p><label for="user_fullname">Полное имя<br>
                    <input class="input" id="fullname" name="fullname" size="32" type="text" value=""></label>
            </p>
            <p><label for="user_email">E-mail<br>
                    <input class="input" id="email" name="email" size="32" type="email" value=""></label></p>
            <p><label for="user_login">Логин<br>
                    <input class="input" id="username" name="username" size="20" type="text" value=""></label>
            </p>
            <p><label for="user_pass">Пароль<br>
                    <input class="input" id="password" name="password" size="32" type="password"
                           value=""></label>
            </p>
            <p class="submit"><input class="button" id="register_oper" name="register_oper" type="submit"
                                     value="Создать"></p>
        </form>
        </br>
        </br>
        
        <hr align="center" width="100%" size="1" />
        </br>
        
        <form method="post">
            <select class="seltypo" name="oper_id" size="3" style="font-size: 12pt; height: 60px">
                <?php echo $message1 ?>
            </select>


            <table width="100%">
                <tr>
                    <td width="50%" style="align-content: center"><p class="submit"><input class="button" id="find_oper"
                                                                                           name="find_oper"
                                                                                           type="submit"
                                                                                           style="white-space: pre-line"
                                                                                           value="Вывести Cписок Операторов">
                        </p></td>
                </tr>
            </table>
        </form>

    </div>
</div>
