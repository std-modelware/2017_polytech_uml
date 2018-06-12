<?php require_once("../includes/connection.php"); ?>
<?php
$state1 = 'links';
$state2 = 'links';
$state5 = 'links';
$state3 = 'links';
$state4 = 'links active';
include("menu_client.php"); ?>

<?php
$username = $_SESSION['session_username'];
$message = '';
$que = '';
$newp = '';
$dbpassword = '';

if (isset($_POST["savepass"])) {

    $oldpass = htmlspecialchars($_POST['oldpass']);
    $newpass = htmlspecialchars($_POST['newpass']);
    $newpass2 = htmlspecialchars($_POST['newpass2']);

    if (!empty($oldpass) && !empty($newpass) && !empty($newpass2)) {

        $que = mysqli_query($link, "SELECT * FROM users WHERE username = '" . $username . "'");
        $numrows = mysqli_num_rows($que);

        if ($numrows != 0) {
            while ($row = mysqli_fetch_assoc($que)) {

                $dbpassword = $row['password'];
            }

            if (password_verify($oldpass, $dbpassword)) {
                if ($newpass == $newpass2) {
                    $newp = password_hash($newpass, PASSWORD_DEFAULT);

                    $sql3 = "UPDATE users SET password = '" . $newp . "' WHERE username = '" . $username . "'";
                    $result3 = mysqli_query($link, $sql3);

                    if ($result3) {
                        $message = '<span class = "good">Пароль успешно изменен</span></br>';

                    } else {
                        $message = '<span class = "bad">Ошибка при работе с базой данных</span></br>';
                    }
                } else {
                    $message = '<span class = "bad">Новые пароли не сопадают</span></br>';
                }

            } else {
                $message = '<span class = "bad">Неверный старый пароль!</span></br>';
            }
        }

    } else {
        $message = '<span class = "bad">Пароль не может быть пустым!</span></br>';
    }
}
?>

<?php include("../includes/header_account.php"); ?>
<div id="chpass" class="content" style="display: block">
    <div class="container msettings">
        <center>
            <div id="chpass">
                <h1>Смена пароля</h1>
                <?php echo $message; ?>
                <form id="chpassform" method="post" name="chpassform">
                    <p><label for="old_pass">Старый пароль<br>
                            <input class="input" id="oldpass" name="oldpass" size="20" type="password" value=""></label>
                    </p>
                    <p><label for="new_pass">Новый пароль<br>
                            <input class="input" id="newpass" name="newpass" size="20" type="password" value=""></label>
                    </p>
                    <p><label for="new_pass">Повторите новый пароль<br>
                            <input class="input" id="newpass2" name="newpass2" size="20" type="password" value=""></label>
                    </p>
                    <p class="submit"><input class="button" id="savepass" name="savepass" type="submit"
                                             value="Сохранить изменения"></p>
                </form>
            </div>
        </center>
    </div>
</div>