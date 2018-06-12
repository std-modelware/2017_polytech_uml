<?php

$structure = '';
$res = mysqli_query($dbname, "SHOW COLUMNS FROM $tablename");
$colnames = '';
while ($col = mysqli_fetch_row($res)) {
    if ($col[0] != 'user_id' and $col[0] != 'typo_id') {
        $colnames .= $col[0] . ',';
    }
}

$colnames = substr($colnames, 0, -1);

$query = "SELECT $colnames FROM $tablename WHERE user_id = '" . $user_id . "'";
$result = mysqli_query($dbname, $query);

$total_rows = mysqli_num_rows($result);

$colnames = explode(',', $colnames);

$ruscolnames = '№ Заказа,Тип,Бумага,Размер,Кол-во,Дата создания,Срок исполнения,URL,Цена (₽),Статус';
$ruscolnames = explode(',', $ruscolnames);


if (!$total_rows) {
    $structure .= "<HTML><BODY><h2>У вас не создано ни одного заказа</h2></BODY></HTML>\r\n";
    return;
}

$row = mysqli_fetch_row($result);
$total_cols = count($row);

$urlindex = array_search('url', $colnames);
$statusindex = array_search('status', $colnames);
$costindex = array_search('cost', $colnames);
$dborderid = '';
$dbstatus = '';
$orderid = '';
$width_title = $total_cols + 1;

//Формируем название таблицы
$structure .= "<table id='table' class='sortable' width='100%' border='2' cellspacing='1' cellpadding='2' align='center' style='table-layout: auto; overflow: scroll'>\r\n";
//$structure .= "<tr><td colspan=$width_title align=center style='font-weight: bold'>Ваши заказы</td></tr>" . "\r\n";


//Формируем шапку таблицы
$structure .= "<thead style='font-weight: 600'>\r\n<tr>\r\n";

$i = 0;
while ($i < count($ruscolnames)) {
// style='background-color: #ffdeae'
    $structure .= "<td align='center'>$ruscolnames[$i]</td>\r\n";
    $i++;
}
$structure .= "<td class='nosort'></td>\r\n";
$structure .= "</tr>\r\n</thead>\r\n";


$structure .= "<tbody>\r\n<tr>\r\n";
$i = 0;

while ($i < $total_cols) {
    if ($i == $urlindex) {
        $structure .= "<td align='center'><a href=$row[$i]>URL</a></td>\r\n";
    } else if ($i == $statusindex) {
        if ($row[$i] == 'В обработке') {
            $structure .= "<td align='center' style='color: #ffaa45; font-weight: bold'><span hidden='hidden'>1</span>$row[$i]</td>\r\n";
        } elseif ($row[$i] == 'Подтвержден') {
            $structure .= "<td align='center' style='color: #ffaa45; font-weight: bold'><span hidden='hidden'>2</span>$row[$i]</td>\r\n";
        } elseif ($row[$i] == 'Исполняется') {
            $structure .= "<td align='center' style='color: rgba(9,191,26,0.93); font-weight: bolder'><span hidden='hidden'>3</span>$row[$i]</td>\r\n";
        } elseif ($row[$i] == 'Готов к выдаче') {
            $structure .= "<td align='center' style='color: rgba(9,191,26,0.93); font-weight: bolder'><span hidden='hidden'>4</span>$row[$i]</td>\r\n";
        } elseif ($row[$i] == 'Отменен') {
            $structure .= "<td align='center' style='color: rgba(255,0,4,0.93); font-weight: bolder'><span hidden='hidden'>6</span>$row[$i]</td>\r\n";
        } elseif ($row[$i] == 'Закрыт') {
            $structure .= "<td align='center' style='color: rgba(255,0,4,0.93); font-weight: bolder'><span hidden='hidden'>5</span>$row[$i]</td>\r\n";
        } else {
            $structure .= "<td align='center'>$row[$i]</td>\r\n";
        }
        $dbstatus = $row[$i];

    } else if ($i == $costindex) {
        $structure .= "<td align='center'>$row[$i]</td>\r\n";
    } else {
        $structure .= "<td align='center'>$row[$i]</td>\r\n";
    }

    if ($i == $dborderid) {
        $orderid = $row[$i];
    }

    $i++;
}
if ($dbstatus == 'В обработке' || $dbstatus == 'Подтвержден') {
    $structure .= "<td align='center'><form method='post'><input type='text' name='idorder' value=$orderid hidden='hidden'><input formaction='orders_history.php' class='button' name='cancel' type='submit' value='Отменить'></form></td>\r\n";
} else {
    $structure .= "<td align='center'></td>\r\n";
}
$structure .= "</tr>\r\n";


while ($row = mysqli_fetch_row($result)) {
    $i = 0;
    $structure .= "<tr>";

    while ($i < $total_cols) {

        if ($i == $urlindex) {
            $structure .= "<td align='center'><a href=$row[$i]>URL</a></td>\r\n";
        } else if ($i == $statusindex) {
            if ($row[$i] == 'В обработке') {
                $structure .= "<td align='center' style='color: #ffaa45; font-weight: bold'><span hidden='hidden'>1</span>$row[$i]</td>\r\n";
            } elseif ($row[$i] == 'Подтвержден') {
                $structure .= "<td align='center' style='color: #ffaa45; font-weight: bold'><span hidden='hidden'>2</span>$row[$i]</td>\r\n";
            } elseif ($row[$i] == 'Исполняется') {
                $structure .= "<td align='center' style='color: rgba(9,191,26,0.93); font-weight: bolder'><span hidden='hidden'>3</span>$row[$i]</td>\r\n";
            } elseif ($row[$i] == 'Готов к выдаче') {
                $structure .= "<td align='center' style='color: rgba(9,191,26,0.93); font-weight: bolder'><span hidden='hidden'>4</span>$row[$i]</td>\r\n";
            } elseif ($row[$i] == 'Отменен') {
                $structure .= "<td align='center' style='color: rgba(255,0,4,0.93); font-weight: bolder'><span hidden='hidden'>6</span>$row[$i]</td>\r\n";
            } elseif ($row[$i] == 'Закрыт') {
                $structure .= "<td align='center' style='color: rgba(255,0,4,0.93); font-weight: bolder'><span hidden='hidden'>5</span>$row[$i]</td>\r\n";
            } else {
                $structure .= "<td align='center'>$row[$i]</td>\r\n";
            }
            $dbstatus = $row[$i];

        } else if ($i == $costindex) {
            $structure .= "<td align='center'>$row[$i]</td>\r\n";
        } else {
            $structure .= "<td align='center'>$row[$i]</td>\r\n";
        }

        if ($i == $dborderid) {
            $orderid = $row[$i];
        }

        $i++;
    }
    if ($dbstatus == 'В обработке' || $dbstatus == 'Подтвержден') {
        $structure .= "<td align='center'><form method='post'><input type='text' name='idorder' value=$orderid hidden='hidden'><input formaction='orders_history.php' class='button' name='cancel' type='submit' value='Отменить'></form></td>\r\n";
    } else {
        $structure .= "<td align='center'></td>\r\n";
    }
    $structure .= "</tr>\r\n";
}
$structure .= "</tbody>\r\n";

