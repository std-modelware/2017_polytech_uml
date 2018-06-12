<?php require_once("../includes/connection.php"); ?>
<?php
$state1 = 'links active';
$state5 = 'links';
$state2 = 'links';
$state3 = 'links';
$state4 = 'links';
include("menu_operator.php");

$dbname = $link;
$tablename = 'orders';
$message1 = '';
$message2 = '';
?>

<div id="orders" class="content" style="display: block">
    <div class="container_order_history">
        <center>
            <div id="settings">
                <h1>Работа с заказами</h1>

                <script type="text/javascript" src="../rwd/rwd-table.js"></script>

                <?php include("oper_show_table.php");
                include("navigation.php");


                if (isset($_POST['change'])) {


                    $ides = [];
                    $statuses = [];
                    $change_typos = [];

                    // Получение массива измененных статусов
                    foreach ($_POST as $key => $value) {

                        if (substr_count($key, 'status') > 0 and $value != '0') {
                            $order_id = substr($key, 6);
                            $statuses[$order_id] = $value;

                            $dbstatus = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM orders WHERE order_id = '" . $order_id . "'"))['status'];

                            if ($value != $dbstatus) {
                                // Изменение статуса
                                $result1 = mysqli_query($link, "UPDATE orders SET `status` = '" . $value . "' WHERE order_id = '" . $order_id . "'");

                                if ($result1 != 0) {
                                    // Отправка нотификации клиенту
                                    $user_id = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM orders WHERE order_id = '" . $order_id . "'"))['user_id'];
                                    $cstatus = '"' . $value . '"';
                                    $sql1 = "INSERT INTO notifications (user_id, type, text) VALUES ('" . $user_id . "', 'c', 'Статус заказа №$order_id изменен на " . $cstatus . "')";
                                    $result1 = mysqli_query($link, $sql1);

                                    if ($result1 == '0') {
                                        printf("Errormessage: %s\n", mysqli_error($link));
                                        $message2 .= '<span class = "bad">Ошибка при работе с базой данных</span></br>';
                                    } else {
                                        //Отправка нотификации клиенту на почту
                                        $query3 = mysqli_query($link, "SELECT * FROM users WHERE (user_id = '" . $user_id . "')");
                                        $row = mysqli_fetch_assoc($query3);
                                        $dbemail = $row['email'];
                                        $dbfullname = $row['fullname'];

                                        $headers = 'From: print8print@mail.ru';
                                        $mess = "Уважаемый(ая) $dbfullname, статус Вашего заказа №$order_id изменен на " . $cstatus . "\r\n";
                                        $mess .= 'Состояние Ваших заказов Вы можете посмотреть в личном кабинете на нашем сайте в своем ';
                                        $mess .= "<a href=\"http://localhost/print/operator/orders.php\" target=\"_blank\">Личном кабинете.</a>";
                                       // $mail = mail("$dbemail", "Сброс пароля", $mess, $headers);
                                    }

                                } else {
                                    printf("Errormessage: %s\n", mysqli_error($link));
                                    $message2 .= '<span class = "bad">Ошибка при работе с базой данных</span></br>';
                                }
                            }


                        } elseif (substr_count($key, 'typo') > 0 and $value != '0') {
                            $change_typos[substr($key, 4)] = $value;

                            $result2 = mysqli_query($link, "UPDATE orders SET `typo_id` = '" . $value . "' WHERE order_id = '" . substr($key, 4) . "'");

                            if ($result2 == 0) {
                                printf("Errormessage: %s\n", mysqli_error($link));
                                $message2 .= '<span class = "bad">Ошибка при работе с базой данных</span></br>';
                            }
                        }
                    }

                    if ($message2 == '') {
                        $message1 = '<span class = "good">Изменения успешно сохранены</span></br>';
                        include("oper_show_table.php");
                    }

//                    print_r($statuses);
//                    echo '<br>';
//
//                    print_r($change_typos);
//                    echo '<br>';
                }
                ?>
                <span><?php echo $message2; ?></span>
                <span><?php echo $message1; ?></span>

                <?php
                if ($_SESSION['$pagesfdis'] != 3) {
                    $pagesfdis = $_SESSION['$pagesfdis'];
                    $nav = str_replace("<option value='$pagesfdis'", "<option value='$pagesfdis' selected", $nav);
                } ?>


                <table align="center" width="100%" border="0" style="align-content: center">
                    <tr>
                        <td width="15%" style="padding: 0% 0% 0% 1%"><?php echo $nav; ?>

                        </td>
                        <td width="15%" style="vertical-align: top; padding: 0% 0% 0% 1%">Страница <span
                                    id="currentpage">
                <?php echo $_SESSION['session_opage']; ?></span> из
                            <span id="pagelimit"><?php echo $PagesCount; ?></span></td>
                        <td width="33%"
                            align="center"
                            style="vertical-align: top; font-size: large"><?php echo Navigation($_SESSION['session_opage'], $PagesCount); ?>
                        </td>
                        <td width="33%" align="center" style="vertical-align: top; padding: 0% 0% 0% 9%"><input
                                    style='width: 80%; height: 70%' form="change_st"
                                    formaction='orders.php' class='button' name='change'
                                    type='submit' value='Сохранить изменения'></td>
                    </tr>
                </table>

<!--                <div class="table-responsive" data-pattern="priority-columns" data-responsive-table-toolbar="tech">-->
                    <div class='hidden-md hidden-sm hidden-lg'>
                    <?php echo $structure; ?>
                    </div>
<!--                </div>-->

            </div>
        </center>
    </div>
</div>




