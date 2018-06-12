<?php

$structure = '';
$id_note = '';

$res = mysqli_query($link, "SHOW COLUMNS FROM notifications");
$colnames = '';
while ($col = mysqli_fetch_row($res)) {
    if ($col[0] != 'user_id' and $col[0] != 'type') {
        $colnames .= $col[0] . ',';
    }
}

$colnames = substr($colnames, 0, -1);

$ruscolnames = 'Время,Уведомление';
$ruscolnames = explode(',', $ruscolnames);


$query = "SELECT $colnames FROM notifications WHERE user_id = '" . $user_id . "' AND type = 'c'";
$result = mysqli_query($link, $query);

$total_rows = mysqli_num_rows($result);

if (!$total_rows) {
    $structure .= "<HTML><BODY><h2>У вас нет уведомлений</h2></BODY></HTML>\r\n";
    return;
}

$row = mysqli_fetch_row($result);
$total_cols = count($row);

$colnames = explode(',', $colnames);
$id_index = array_search('id', $colnames);

//Формируем название таблицы
$structure .= "<table id='table' width='100%' border='0' cellspacing='0' cellpadding='2' style='table-layout: auto; overflow: scroll'>\r\n";


//Формируем шапку таблицы
$structure .= "<thead style='font-weight: 600'>\r\n<tr>\r\n";

$i = 0;
while ($i < count($ruscolnames)) {

    $structure .= "<td>$ruscolnames[$i]</td>\r\n";
    $i++;


}
$structure .= "<td></td>\r\n";
$structure .= "</tr>\r\n</thead>\r\n";


//Формируем содержимое таблицы
$structure .= "<tbody>\r\n<tr>\r\n";
$i = 0;
while ($i < $total_cols) {

    if ($i == $id_index) {
        $id_note = $row[$i];
        $i++;
    } else {
        $structure .= "<td>$row[$i]</td>\r\n";
        $i++;
    }
}

$structure .= "<td align='center'><form method='post' action=''><input type='text' name='idnote' id='idnote' value=$id_note hidden='hidden'><button name='delete' id='delete' type='submit' style='border: none; cursor: pointer; background-color: transparent'><image src='../images/delete.png'></image></button></form></td>\r\n";
$structure .= "</tr>\r\n";


while ($row = mysqli_fetch_row($result)) {
    $i = 0;
    $structure .= "<tr>";

    while ($i < $total_cols) {

        if ($i == $id_index) {
            $id_note = $row[$i];
            $i++;
        } else {
            $structure .= "<td>$row[$i]</td>\r\n";
            $i++;
        }
    }
    $structure .= "<td align='center'><form method='post' action=''><input type='text' name='idnote' id='idnote' value=$id_note hidden='hidden'><button name='delete' id='delete' type='submit' style='border: none; cursor: pointer; background-color: transparent'><image src='../images/delete.png'></image></button></form></td>\r\n";
    $structure .= "</tr>\r\n";

}

$structure .= "</tbody>\r\n";
