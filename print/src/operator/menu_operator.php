<?php
@session_start();
if(!isset($_SESSION["session_username"])) {
    echo "<script>document.location.href='../login.php';</script>";
} elseif (mysqli_fetch_assoc(mysqli_query($link, "SELECT tag FROM users WHERE username = '" . $_SESSION["session_username"] . "'"))['tag'] != 'o') {
    echo "<script>document.location.href='../login.php';</script>";
}?>

<link href="../styles/tab_style.css" media="screen" rel="stylesheet">

<?php include("../includes/header_account.php"); ?>
<div id="menu">
    <!-- Меню -->
    <div class="tab">
        <button class="<?php echo $state1 ?>" onclick="location.href='orders.php'">Работа с заказами</button>
        <button class="<?php echo $state5 ?>" onclick="location.href='allorders.php'">Полная таблица заказов</button>
        <button class="<?php echo $state2 ?>" onclick="location.href='onote.php'">Нотификации</button>
        <button class="<?php echo $state3 ?>" onclick="location.href='osettings.php'">Настройки аккаунта</button>
        <button class="<?php echo $state4 ?>" onclick="location.href='ochangepass.php'">Сменить пароль</button>
        <a href="../logout.php"><button>Выйти из системы</button></a>
    </div>
</div>