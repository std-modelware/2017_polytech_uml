<?php require_once("../includes/connection.php"); ?>
<?php
$state1 = 'links';
$state2 = 'links';
$state5 = 'links';
$state3 = 'links active';
$state4 = 'links';
include("menu_client.php"); ?>

<?php
$username = $_SESSION['session_username'];
$message1 = '';
$message2 = '';
$message3 = '';

$q = mysqli_query($link, "SELECT * FROM users WHERE username = '" . $username . "'");
$n = mysqli_num_rows($q);
$row = mysqli_fetch_assoc($q);

$dbfullname = $row['fullname'];
$dbphone = $row['phone'];
$dbemail = $row['email'];
$dbdate = $row['date'];


/*= Изменение настроек */
if (isset($_POST["save"])) {


    $fullname = htmlspecialchars($_POST['fullname']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);

    if (!empty($email)) {

        if ($email != $dbemail) {

            $query = '';
            $query = mysqli_query($link, "SELECT * FROM users WHERE email = '" . $email . "'");
            $numrows2 = mysqli_num_rows($query);

            if ($numrows2 != 0) {
                $message1 = '<span class = "bad">Такой email уже зарегистрирован в системе!</span></br>';

            } else {
                $sql1 = "UPDATE users SET email = '" . $email . "' WHERE username = '" . $username . "'";
                $result1 = mysqli_query($link, $sql1);

                if ($result1) {
                    $message1 = '<span class = "good">Новый email сохранен</span></br>';
                } else {
                    $message2 = '<span class = "bad">Ошибка при работе с базой данных</span></br>';
                    printf("Errormessage: %s\n", mysqli_error($link));
                }
            }
        }

    } else {
        $message1 = '<span class = "bad">Поле E-mail не может быть пустым!</span></br>';
    }

    if (!empty($fullname)) {

        if ($fullname != $dbfullname) {

            $sql2 = "UPDATE users SET fullname = '" . $fullname . "' WHERE username = '" . $username . "'";
            $result2 = mysqli_query($link, $sql2);

            if ($result2) {
                $message2 = '<span class = "good">Новое имя сохранено</span></br>';

            } else {

                $message2 = '<span class = "bad">Ошибка при работе с базой данных</span></br>';
                printf("Errormessage: %s\n", mysqli_error($link));
            }
        }
    } else {
        $message2 = '<span class = "bad">Поле Имя не может быть пустым!</span></br>';
    }

    if ($phone != $dbphone) {
        $sql3 = "UPDATE users SET phone = '" . $phone . "' WHERE username = '" . $username . "'";
        $result3 = mysqli_query($link, $sql3);

        if ($result3) {
            $message3 = '<span class = "good">Новый телефон сохранен</span></br>';

        } else {

            $message3 = '<span class = "bad">Ошибка при работе с базой данных</span></br>';
            printf("Errormessage: %s\n", mysqli_error($link));
        }
    }

    $q = mysqli_query($link, "SELECT * FROM users WHERE username = '" . $username . "'");
    $n = mysqli_num_rows($q);
    $row = mysqli_fetch_assoc($q);

    $dbfullname = $row['fullname'];
    $dbphone = $row['phone'];
    $dbemail = $row['email'];
    $dbdate = $row['date'];
} ?>


<?php include("../includes/header_account.php"); ?>
<div id="csetting" class="content" style="display: block">
    <div class="container settings">
        <center>
            <div id="settings">
                <h1>Настройки</h1>
                <?php echo $message1; ?>
                <?php echo $message2; ?>
                <?php echo $message3; ?>
                <form id="settingsform" method="post" name="settingsform">
                    <p><label>Логин для входа:</p>
                    <p>
                        <span style="font-weight: 500; font-size: x-large;"><?php echo $_SESSION['session_username']; ?></span>
                    </p>
                    <p><label>Дата регистрации:</p>
                    <p><span style="font-weight: 500; font-size: x-large"><?php echo $dbdate; ?></span></p>
                    <p><label>Полное имя<br>
                            <input class="input" id="fullname" name="fullname" size="32" type="text"
                                   value="<?php echo $dbfullname; ?>"></label></p>
                    <p><label>Телефон<br>
                            <input class="input" id="phone" name="phone" placeholder="8**********" size="32" type="text"
                                   value="<?php echo $dbphone; ?>"></label></p>
                    <p><label>E-mail<br>
                            <input class="input" id="email" name="email" size="32" type="email"
                                   value='<?php echo $dbemail; ?>'></label></p>
                    <p class="submit"><input class="button" id="save" name="save" type="submit"
                                             value="Сохранить изменения"></p>
                </form>
            </div>
        </center>
    </div>
</div>
