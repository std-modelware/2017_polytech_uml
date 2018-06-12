<?php require_once("../includes/connection.php"); ?>

<?php
$state1 = 'links';
$state5 = 'links';
$state2 = 'links active';
$state3 = 'links';
$state4 = 'links';
include("menu_operator.php");
$_SESSION['session_opage'] = 1;?>

<?php include("../includes/header_account.php"); ?>
<div id="orders" class="content" style="display: block">
    <div class="container_order_history">
        <center>
            <div id="settings">
                <h1>Нотификации</h1>

                <?php

                $structure = '';
                $res = mysqli_query($link, "SHOW COLUMNS FROM notifications");
                $colnames = '';
                while ($col = mysqli_fetch_row($res)) {
                    if ($col[0] != 'user_id' and $col[0] != 'type' and $col[0] != 'id') {
                        $colnames .= $col[0] . ',';
                    }
                }
                $colnames = substr($colnames, 0, -1);

                $ruscolnames = 'Время,Уведомление';
                $ruscolnames = explode(',', $ruscolnames);

                $query = "SELECT $colnames FROM notifications WHERE type = 'o'";
                $result = mysqli_query($link, $query);

                $total_rows = mysqli_num_rows($result);

                if (!$total_rows) {
                    $structure .= "<HTML><BODY><h2>У вас нет уведомлений</h2></BODY></HTML>\r\n";
                    return;
                }

                $row = mysqli_fetch_row($result);
                $total_cols = count($row);


                //Формируем название таблицы
                $structure .= "<table id='table' width='100%' border='0' cellspacing='0' cellpadding='2' style='table-layout: auto; overflow: scroll'>\r\n";


                //Формируем шапку таблицы
                $structure .= "<thead style='font-weight: 600'>\r\n<tr>\r\n";

                $i = 0;
                while ($i < count($ruscolnames)) {
                    $structure .= "<td>$ruscolnames[$i]</td>\r\n";
                    $i++;
                }
                $structure .= "<td height='40px'></td>\r\n";
                $structure .= "</tr>\r\n</thead>\r\n";


                //Формируем содержимое таблицы
                $structure .= "<tbody>\r\n<tr>\r\n";
                $i = 0;
                while ($i < $total_cols) {

                    $structure .= "<td>$row[$i]</td>\r\n";
                    $i++;
                }

                $structure .= "<td height='40px'></td>\r\n";
                $structure .= "</tr>\r\n";


                while ($row = mysqli_fetch_row($result)) {
                    $i = 0;
                    $structure .= "<tr>";

                    while ($i < $total_cols) {

                        $structure .= "<td>$row[$i]</td>\r\n";
                        $i++;
                    }
                    $structure .= "<td height='40px'></td>\r\n";
                    $structure .= "</tr>\r\n";
                }
                $structure .= "</tbody>\r\n";


                echo $structure;

                ?>

            </div>
        </center>
    </div>
</div>