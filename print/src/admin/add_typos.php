<?php require_once("../includes/connection.php"); ?>
<?php
$state1 = 'links';
$state4 = 'links active';
$state2 = 'links';
$state3 = 'links';

include("menu_admin.php"); ?>

<?php

$message = '<option selected value="0" hidden="hidden"></option>\r\n';
$message1 = '';


if (isset($_POST["add"])) {

    $fullname = htmlspecialchars($_POST['fullname']);

    $result = mysqli_query($link, "INSERT INTO typographers (fullname) VALUES ('" . $fullname . "')");
    if ($result != 0) {
        $message1 = '<span class = "good">Типограф добавлен</span></br>';
    } else {
        $message1 = '<span class = "bad">Ошибка при работе с базой данных ¯\_(ツ)_/¯</span></br>';
        printf("Errormessage: %s\n", mysqli_error($link));
    }
}

if (isset($_POST["find_typo"])) {
    $query_typo = mysqli_query($link, "SELECT * FROM typographers");
    $row = mysqli_fetch_array($query_typo);
    do {
        $message .= "<option value=" . $row['typo_id'] . ">(ID: " . $row['typo_id'] . ") " . $row['fullname'] . "</option>\r\n";
    } while ($row = mysqli_fetch_array($query_typo));
}


if (isset($_POST["delete"])) {

    $typo_id = htmlspecialchars($_POST['typo_id']);

    if ($typo_id != '0') {

    $result = mysqli_query($link, "DELETE FROM typographers WHERE typo_id = '" . $typo_id . "'");

    $query_typo = mysqli_query($link, "SELECT * FROM typographers");
    $row = mysqli_fetch_array($query_typo);
    do {
        $message .= "<option value=" . $row['typo_id'] . ">(ID: " . $row['typo_id'] . ") " . $row['fullname'] . "</option>\r\n";
    } while ($row = mysqli_fetch_array($query_typo));

    if ($result != 0) {
        $message1 = '<span class = "good">Типограф удален</span></br>';
    } else {
        printf("Errormessage: %s\n", mysqli_error($link));
    } }

    else {
        $query_typo = mysqli_query($link, "SELECT * FROM typographers");
        $row = mysqli_fetch_array($query_typo);
        do {
            $message .= "<option value=" . $row['typo_id'] . ">(ID: " . $row['typo_id'] . ") " . $row['fullname'] . "</option>\r\n";
        } while ($row = mysqli_fetch_array($query_typo));
    }

}

?>



<?php include("../includes/header_account.php"); ?>
<div id="csetting" class="content" style="display: block">
    <div class="container settings">
        <center>
            <div id="settings">
                <h1>Список типографов</h1>
                <h2><label>Добавление нового типографа</h2>
                <?php echo $message1; ?>
                <form id="settingsform" method="post" name="settingsform">
                    <table align="center" width="100%" style="table-layout: auto">

                        <tr>
                            <td width="100%" align="center"><label>Полное имя</label></td>
                        </tr>
                        <tr>
                            <td width="100%" align="center"><input class="input" id="fullname" name="fullname"
                                                                   type="text"></td>
                        </tr>
                    </table>

                    <table>
                        <tr>
                            <td width="100%" align="center"><p class="submit"><input class="button" id="add" name="add"
                                                                                     type="submit"
                                                                                     value="      Добавить типографа      ">
                                </p></td>
                        </tr>
                    </table>
                    
                    <br>
                    <hr align="center" width="100%" size="1" />
                    <br>

                    <select class="seltypo" name="typo_id" size="1000" style="font-size: 12pt">
                        <?php echo $message ?>
                    </select>

                    <!--                    <textarea rows="6" style="resize: vertical; width: 100%; min-height: 10%"-->
                    <!--                              readonly>--><?php //echo $message; ?><!--</textarea>-->


                    <table width="100%">
                        <tr>
                            <td width="50%" style="align-content: center"><p class="submit"><input class="button"
                                                                                                   id="find_typo"
                                                                                                   name="find_typo"
                                                                                                   type="submit"
                                                                                                   style="white-space: pre-line"
                                                                                                   value="Вывести Cписок типографов">
                                </p></td>
                            <td width="50%"><p class="submit"><input class="button" id="delete" name="delete"
                                                                     type="submit"
                                                                     style="white-space: pre-line"
                                                                     value="Удалить выбранного типографа"></p></td>
                        </tr>
                    </table>
                </form>
            </div>
        </center>
    </div>
</div>
