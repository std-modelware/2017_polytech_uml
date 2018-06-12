<?php


$structure = '';

if (isset($_GET['page'])) {
    $_SESSION['session_opage'] = $_GET['page'];
}

$nav = "<form method='post' name='pagedis' id='pagedis'><select class='select' id='showpages' name='showpages' form='pagedis' style='align-content: center; width: 100%' onchange='this.form.submit()'>\r\n";
$nav .= "<option value='3'>3</option>\r\n";
$nav .= "<option value='5'>5</option>\r\n";
$nav .= "<option value='10'>10</option>\r\n";
$nav .= "<option value='20'>20</option>\r\n</select></form>";

if (isset($_POST["showpages"])) {
    $_SESSION['$pagesfdis'] = $_POST["showpages"];
    $pagesfdis = $_SESSION['$pagesfdis'];
    $_SESSION['session_opage'] = 1;
    header("Location: orders.php");
}

//$pagesfdis = (isset($_POST["showpages"]))?$_POST["showpages"]:3;

$res = mysqli_query($dbname, "SHOW COLUMNS FROM $tablename");
$colnames = '';
while ($col = mysqli_fetch_row($res)) {
    $colnames .= $col[0] . ',';
}

$colnames = substr($colnames, 0, -1);

$query = "SELECT * FROM $tablename WHERE status NOT LIKE 'Отменен' AND status NOT LIKE 'Закрыт'";
$result = mysqli_query($dbname, $query);

$total_rows = mysqli_num_rows($result);

$colnames = explode(',', $colnames);

$ruscolnames = '№ Заказа,ID клиента,Тип,Бумага,Формат,Кол-во,Дата <br>создания,Срок <br>исполнения,URL,Цена (₽),ID Типографа,Статус';
$ruscolnames = explode(',', $ruscolnames);


if (!$total_rows) {
    $structure .= "<HTML><BODY><h2>Не создано ни одного заказа</h2></BODY></HTML>\r\n";
    return;
}

$row_all = mysqli_fetch_row($result);
$total_cols = count($row_all);

$urlindex = array_search('url', $colnames);
$statusindex = array_search('status', $colnames);
$costindex = array_search('cost', $colnames);
$user_idindex = array_search('user_id', $colnames);
$order_idindex = array_search('order_id', $colnames);
$countindex = array_search('amount', $colnames);
$deadlineindex = array_search('deadline', $colnames);
$typoindex = array_search('typo_id', $colnames);

$dborderid = '';
$dbstatus = '';
$orderid = '';
$typographers = '<option value="0"></option>\r\n';
$width_title = $total_cols + 1;


// Данные из таблицы Типографы
$query1 = mysqli_query($link, "SELECT * FROM typographers");
$row1 = mysqli_fetch_assoc($query1);
do {
    $typographers .= '<option value=' . $row1['typo_id'] . '>' . $row1['typo_id'] . '</option>' . "\r\n";
} while ($row1 = mysqli_fetch_array($query1));


//Формируем название таблицы
$structure .= "<form method='post' id='change_st'>";
$structure .= "";
$structure .= "<table id='tech' class='table table-small-font table-bordered table-striped' width='100%' border='1' cellspacing='1' cellpadding='1' align='center' style='table-layout: auto; overflow: scroll'>\r\n";
//$structure .= "<tr><td colspan=$width_title align=center style='font-weight: bold'>Ваши заказы</td></tr>" . "\r\n";


//Формируем шапку таблицы
$structure .= "<thead style='font-weight: 600'>\r\n<tr>\r\n";

$i = 0;
while ($i < count($ruscolnames)) {
    $structure .= "<th class='hidden-md' onclick=\"showDiv('th$i')\" id=\"th$i\" data-priority='1'  align='center' style='font-size: smaller'>$ruscolnames[$i]</th>\r\n";
    $i++;
}

$structure .= "<th id=\"th$i\" data-priority='1' class='nosort' align='center' style='font-size: smaller'>Изменить статус</th>\r\n";
$structure .= "</tr>\r\n</thead>\r\n";


// $page = (isset($_GET["page"]))?$_GET["page"]:1; //Задаем номер открытой страницы


$result1 = mysqli_query($link, "SELECT COUNT(*) FROM orders WHERE status NOT LIKE 'Отменен' AND status NOT LIKE 'Закрыт'");
$b = mysqli_fetch_array($result1);
$ResultCount = $b[0]; //Получаем число записей
//$PagesCount = intval(($ResultCount - 1) / 2) + 1; //Узнаем число страниц
$PagesCount = ceil($ResultCount / $_SESSION['$pagesfdis']);
$sql = "SELECT * FROM orders WHERE status NOT LIKE 'Отменен' AND status NOT LIKE 'Закрыт' ORDER BY deadline ASC, order_id ASC LIMIT " . ($_SESSION['session_opage'] * $_SESSION['$pagesfdis'] - $_SESSION['$pagesfdis']) . ", " . $_SESSION['$pagesfdis']; //Запрос записей, которые необходимо вывести на странице с активным номером
//echo $sql;
$rows = mysqli_query($link, $sql);

$structure .= "<tbody>\r\n<tr id='th$i'>\r\n";

while ($row = mysqli_fetch_row($rows)) {

    $i = 0;

    while ($i < $total_cols) {

        if ($i == $urlindex) {
            $structure .= "<td id='th$i' align='center'><a href=$row[$i]>URL</a></td>\r\n";
        } else if ($i == $statusindex) {
            if ($row[$i] == 'В обработке') {
                $structure .= "<td id='th$i' align='center' style='color: #ffaa45; font-weight: bold'><span hidden='hidden'>1</span>$row[$i]</td>\r\n";
            } elseif ($row[$i] == 'Подтвержден') {
                $structure .= "<td id='th$i' align='center' style='color: #ffaa45; font-weight: bold'><span hidden='hidden'>2</span>$row[$i]</td>\r\n";
            } elseif ($row[$i] == 'Исполняется') {
                $structure .= "<td id='th$i' align='center' style='color: rgba(9,191,26,0.93); font-weight: bolder'><span hidden='hidden'>3</span>$row[$i]</td>\r\n";
            } elseif ($row[$i] == 'Готов к выдаче') {
                $structure .= "<td id='th$i' align='center' style='color: rgba(9,191,26,0.93); font-weight: bolder'><span hidden='hidden'>4</span>$row[$i]</td>\r\n";
            } elseif ($row[$i] == 'Отменен') {
                $structure .= "<td id='th$i' align='center' style='color: rgba(255,0,4,0.93); font-weight: bolder'><span hidden='hidden'>6</span>$row[$i]</td>\r\n";
            } elseif ($row[$i] == 'Закрыт') {
                $structure .= "<td id='th$i' align='center' style='color: rgba(255,0,4,0.93); font-weight: bolder'><span hidden='hidden'>5</span>$row[$i]</td>\r\n";
            } else {
                $structure .= "<td id='th$i' align='center' >$row[$i]</td>\r\n";
            }
            $dbstatus = $row[$i];

        } else if ($i == $costindex) {
            $structure .= "<td id='th$i' align='center'>$row[$i]</td>\r\n";

        } else if ($i == $typoindex) {

            $typos = str_replace('<option value=' . $row[$i] . '>' . $row[$i] . '</option>', '<option value=' . $row[$i] . ' selected>' . $row[$i] . '</option>', $typographers);
            $structure .= "<td id='th$i' align='center' style='display: table-cell'>\r\n";
            $structure .= "<select class='select' id='typo' name='typo$orderid' style='align-content: center; padding: 0 0 0 5%; -webkit-appearance: none; -moz-appearance: none'>\r\n";
            $structure .= "$typos</select>\r\n";
            $structure .= "<input type='text' name='idorder' value=$orderid hidden='hidden'></td>\r\n";

        } else {
            $structure .= "<td id='th$i' align='center'>$row[$i]</td>\r\n";
        }

        if ($i == $dborderid) {
            $orderid = $row[$i];
        }

        $i++;
    }

    $structure .= "<td id='th$i' align='center'>\r\n";
    $structure .= "<select class='select' id='status' name='status$orderid' style='align-content: center'>\r\n";
    $structure .= "<option value='0'>Выберите</option>\r\n<option value='В обработке'>В обработке</option>\r\n<option value='Подтвержден'>Подтвержден</option>\r\n";
    $structure .= "<option value='Исполняется'>Исполняется</option>\r\n<option value='Готов к выдаче'>Готов к выдаче</option>\r\n<option value='Закрыт'>Закрыт</option>\r\n";
    $structure .= "<option value='Отменен'>Отменен</option></select>\r\n";
    $structure .= "<input type='text' name='idorder' value=$orderid hidden='hidden'>\r\n";
    $structure .= "</tr>\r\n";

}

$locat = "location.href='orders.php'";

$structure .= "</tbody>\r\n</form>\r\n";



