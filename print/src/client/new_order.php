<?php require_once("../includes/connection.php"); ?>
<?php
$state1 = 'links';
$state2 = 'links active';
$state5 = 'links';
$state3 = 'links';
$state4 = 'links';
include("menu_client.php");
?>


<?php

$username = $_SESSION['session_username'];
$message = '';
$message1 = '';
$message2 = '';
$ptypes = '';
$sizes = '';
$papers = '';
$duedates = '';
$end_price = '';
$show_url = '';
$show_count = 0;
$price = 0;
$deadline = '';


// Данные из таблицы Типов продукции (product_type)
$query1 = mysqli_query($link, "SELECT * FROM prodtypes");
$row1 = mysqli_fetch_assoc($query1);
do {
    $ptypes .= '<option value=' . $row1['type'] . '>' . $row1['title'] . '</option>' . "\r\n";
} while ($row1 = mysqli_fetch_array($query1));


// Данные из таблицы Размеров (sizes)
$query2 = mysqli_query($link, "SELECT * FROM sizes");
$row2 = mysqli_fetch_assoc($query2);
do {
    $sizes .= '<option value=' . $row2['size'] . '>' . $row2['title'] . '</option>' . "\r\n";
} while ($row2 = mysqli_fetch_array($query2));


// Данные из таблицы Видов бумаги (papers)
$query3 = mysqli_query($link, "SELECT * FROM papers");
$row3 = mysqli_fetch_assoc($query3);
do {
    $papers .= '<option value=' . $row3['paper'] . '>' . $row3['title'] . '</option>' . "\r\n";
} while ($row3 = mysqli_fetch_array($query3));


// Данные из таблицы Сроков исполнения (duedates)
$query4 = mysqli_query($link, "SELECT * FROM duedates");
$row4 = mysqli_fetch_assoc($query4);
do {
    $duedates .= '<option value=' . $row4['duedate'] . '>' . $row4['title'] . '</option>' . "\r\n";
} while ($row4 = mysqli_fetch_array($query4));


if (isset($_POST["save"])) {

    $ptype = htmlspecialchars($_POST['ptype']);
    $psize = htmlspecialchars($_POST['psize']);
    $ppaper = htmlspecialchars($_POST['ppaper']);
    $pcount = htmlspecialchars($_POST['pcount']);
    $pduedate = htmlspecialchars($_POST['duedate']);
    $imageurl = htmlspecialchars($_POST['imageurl']);

    $rptype = '';
    $rpsize = '';
    $rppaper = '';
    $rpduedate = '';
    $show_count = (int)$pcount;


    //Проверка заполнения полей
    if ($ptype != '') {
        $srow1 = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM prodtypes WHERE type = '" . $ptype . "'"));
        $rptype = $srow1['rate'];
        $ptypes = str_replace('<option value=' . $srow1['type'] . '>' . $srow1['title'] . '</option>', '<option value=' . $srow1['type'] . ' selected>' . $srow1['title'] . '</option>', $ptypes);
    } else {
        $message1 .= '<span class = "bad">Поле "Вид печатной продукции" не заполнено!</span></br>';
    }

    if ($psize != '') {
        $srow2 = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM sizes WHERE size = '" . $psize . "'"));
        $rpsize = $srow2['rate'];
        $sizes = str_replace('<option value=' . $srow2['size'] . '>' . $srow2['title'] . '</option>', '<option value=' . $srow2['size'] . ' selected>' . $srow2['title'] . '</option>', $sizes);
    } else {
        $message1 .= '<span class = "bad">Поле "Формат печати" не заполнено!</span></br>';
    }

    if ($ppaper != '') {
        $srow3 = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM papers WHERE paper = '" . $ppaper . "'"));
        $rppaper = $srow3['rate'];
        $papers = str_replace('<option value=' . $srow3['paper'] . '>' . $srow3['title'] . '</option>', '<option value=' . $srow3['paper'] . ' selected>' . $srow3['title'] . '</option>', $papers);
    } else {
        $message1 .= '<span class = "bad">Поле "Тип бумаги" не заполнено!</span></br>';
    }

    if ($pcount < 1) {
        $message1 .= '<span class = "bad">Количество копий не может быть меньше 1!</span></br>';
    }

    if ($pduedate != '') {
        $srow4 = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM duedates WHERE duedate = '" . $pduedate . "'"));
        $rpduedate = $srow4['rate'];
        $duedates = str_replace('<option value=' . $srow4['duedate'] . '>' . $srow4['title'] . '</option>', '<option value=' . $srow4['duedate'] . ' selected>' . $srow4['title'] . '</option>', $duedates);
    } else {
        $message1 .= '<span class = "bad">Поле "Срок исполнения заказа" не заполнено!</span></br>';
    }

    if ($imageurl != '') {
        $show_url = $imageurl;
    } else {
        $message1 .= '<span class = "bad">Нет ссылки на изображение!</span></br>';
    }


    //Рассчет окончательной цены
    if ($message1 == '') {
        $price = (int)$rptype * (int)$rpsize * (int)$rppaper * (int)$rpduedate * (int)$pcount;
    }


    //Рассчет дедлайна для заказа
    if ($pduedate == 'fivedays') {
        $deadline = date('Y-m-d', strtotime('+6 days'));
    } elseif ($pduedate == 'oneday') {
        $deadline = date('Y-m-d', strtotime('+2 days'));
    }

    $date = date('Y-m-d');

    //Добавление нового заказа в таблицу
    $user_id = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM users WHERE username = '" . $username . "'"))['user_id'];
    $sql = "INSERT INTO orders (user_id, type, material, size, amount, url, cost, deadline, date) VALUES ('" . $user_id . "','" . $srow1['title'] . "', '" . $srow3['title'] . "', '" . $srow2['title'] . "', '" . $pcount . "', '" . $imageurl . "',  '" . $price . "',   '" . $deadline . "',   '" . $date . "')";
    $result = mysqli_query($link, $sql);

    if ($result) {
        $message = '<span class = "good">Заказ успешно создан!</br></span></br>';

//        $order_id = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM orders WHERE user_id = '" . $user_id . "' AND user_id = '" . $user_id . "'"))['order_id'];
        $sql1 = "INSERT INTO notifications (user_id, type, text) VALUES ('" . $user_id . "', 'o', 'Пользователь №" . $user_id . " создал новый заказ')";
        $result1 = mysqli_query($link, $sql1);

        if ($result1) {
            header('Refresh: 2; URL=orders_history.php');
        } else {
            $message2 = '<span class = "bad">Ошибка при работе с базой данных</span></br>';
            printf("Errormessage: %s\n", mysqli_error($link));
        }

    } else {
        $message = '<span class = "bad">Ошибка при работе с базой данных</span></br>';
        printf("Errormessage: %s\n", mysqli_error($link));
    }


}
?>

<?php

if (isset($_POST["price"])) {

    $ptype = htmlspecialchars($_POST['ptype']);
    $psize = htmlspecialchars($_POST['psize']);
    $ppaper = htmlspecialchars($_POST['ppaper']);
    $pcount = htmlspecialchars($_POST['pcount']);
    $pduedate = htmlspecialchars($_POST['duedate']);
    $imageurl = htmlspecialchars($_POST['imageurl']);

    $rptype = '';
    $rpsize = '';
    $rppaper = '';
    $rpduedate = '';
    $show_count = (int)$pcount;


    //Проверка заполнения полей
    if ($ptype != '') {
        $srow1 = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM prodtypes WHERE type = '" . $ptype . "'"));
        $rptype = $srow1['rate'];
        $ptypes = str_replace('<option value=' . $srow1['type'] . '>' . $srow1['title'] . '</option>', '<option value=' . $srow1['type'] . ' selected>' . $srow1['title'] . '</option>', $ptypes);
    } else {
        $message1 .= '<span class = "bad">Поле "Вид печатной продукции" не заполнено!</span></br>';
    }

    if ($psize != '') {
        $srow2 = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM sizes WHERE size = '" . $psize . "'"));
        $rpsize = $srow2['rate'];
        $sizes = str_replace('<option value=' . $srow2['size'] . '>' . $srow2['title'] . '</option>', '<option value=' . $srow2['size'] . ' selected>' . $srow2['title'] . '</option>', $sizes);
    } else {
        $message1 .= '<span class = "bad">Поле "Формат печати" не заполнено!</span></br>';
    }

    if ($ppaper != '') {
        $srow3 = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM papers WHERE paper = '" . $ppaper . "'"));
        $rppaper = $srow3['rate'];
        $papers = str_replace('<option value=' . $srow3['paper'] . '>' . $srow3['title'] . '</option>', '<option value=' . $srow3['paper'] . ' selected>' . $srow3['title'] . '</option>', $papers);
    } else {
        $message1 .= '<span class = "bad">Поле "Тип бумаги" не заполнено!</span></br>';
    }

    if ($pcount < 1) {
        $message1 .= '<span class = "bad">Количество копий не может быть меньше 1!</span></br>';
    }

    if ($pduedate != '') {
        $srow4 = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM duedates WHERE duedate = '" . $pduedate . "'"));
        $rpduedate = $srow4['rate'];
        $duedates = str_replace('<option value=' . $srow4['duedate'] . '>' . $srow4['title'] . '</option>', '<option value=' . $srow4['duedate'] . ' selected>' . $srow4['title'] . '</option>', $duedates);
    } else {
        $message1 .= '<span class = "bad">Поле "Срок исполнения заказа" не заполнено!</span></br>';
    }

    if ($imageurl != '') {
        $show_url = $imageurl;
    } else {
        $message1 .= '<span class = "bad">Нет ссылки на изображение!</span></br>';
    }


    //Рассчет окончательной цены
    if ($message1 == '') {
        $price = (int)$rptype * (int)$rpsize * (int)$rppaper * (int)$rpduedate * (int)$pcount;
    }

}

?>


<?php include("../includes/header_account.php"); ?>
<div id="neworder" class="content" style="display: block">
    <div class="container settings">
        <center>
            <div id="settings">
                <h1>Создание заказа</h1>
                <?php echo $message; ?>
                <?php echo $message1; ?>
                <?php echo $message2; ?>
                <form id="settingsform" method="post" name="settingsform">

                    <table>
                        <tr>
                            <td width=50%>
                                <p><label>Вид продукции
                                        <select class="select" id="ptype" name="ptype">
                                            <option></option>
                                            <?php echo $ptypes ?>

                                        </select></label></p>
                            </td>
                            <td width=50%>
                                <p><label>Формат печати
                                        <select class="select" id="psize" name="psize">
                                            <option></option>
                                            <?php echo $sizes ?>
                                        </select></label></p>
                            </td>
                        </tr>

                        <tr>
                            <td width=50%>
                                <p><label>Тип бумаги
                                        <select class="select" id="ppaper" name="ppaper">
                                            <option></option>
                                            <?php echo $papers ?>
                                        </select></label></p>
                            </td>
                            <td width=50%>
                                <p><label>Cрок исполнения
                                        <select class="select" id="duedate" name="duedate">
                                            <option></option>
                                            <?php echo $duedates ?>
                                        </select></label></p>
                            </td>
                        </tr>
                    </table>

                    <p><label>Количество копий
                            <input class="select" id="pcount" name="pcount" type="number"
                                   value='<?php echo $show_count; ?>' required/ ></label></p>


                    <p><label>Ссылка на изображение (URL)<br>
                            <input class="input" id="imageurl" name="imageurl" type="url"
                                   value="<?php echo $show_url; ?>"></label></p>

                    <table>
                        <tr>
                            <td width="70%" align="left"><p class="submit" style="float: left"><input class="button"
                                                                                                      id="price"
                                                                                                      name="price"
                                                                                                      type="submit"
                                                                                                      value="Рассчитать стоимость">
                            </td>
                            <td width="30%" align="right"><span
                                        style="font-weight: bolder; font-size: large; color: darkgreen"><?php echo $price; ?>
                                    ₽</span></td>
                        </tr>
                        <tr>
                            <td width="50%" align="left"><span style="font-size: small; font-weight: bolder">Не забудьте рассчитать окончательную цену,<br> перед отправкой заказа</span>
                            </td>
                            <td width="50%" align="right"><p class="submit"><input class="button" id="save" name="save"
                                                                                   type="submit"
                                                                                   value="Создать заказ"></p></td>
                        </tr>
                    </table>
                </form>
            </div>
        </center>
    </div>
</div>