<?php
    require("constants.php");

    $link = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
    mysqli_query($link,"set names 'utf8'");
    if (!$link) {
        echo "Ошибка: Невозможно установить соединение с MySQL." . PHP_EOL;
        echo "Код ошибки error: " . mysqli_connect_errno() . PHP_EOL;
        echo "Текст ошибки error: " . mysqli_connect_error() . PHP_EOL;
        exit;
    }
?>