<link href="../styles/tab_style.css" media="screen" rel="stylesheet">

<?php
@session_start();
if(!isset($_SESSION["session_username"])) {
    echo "<script>document.location.href='../login.php';</script>";
} elseif (mysqli_fetch_assoc(mysqli_query($link, "SELECT tag FROM users WHERE username = '" . $_SESSION["session_username"] . "'"))['tag'] != 'c') {
    echo "<script>document.location.href='../login.php';</script>";
} ?>

<?php include("../includes/header_account.php"); ?>
<div id="menu">
    <!-- Меню -->
    <div class="tab">
        <button class="<?php echo $state1 ?>" onclick="location.href='orders_history.php'">История заказов</button>
        <button class="<?php echo $state2 ?>" onclick="location.href='new_order.php'">Создать заказ</button>
        <button class="<?php echo $state5 ?>" onclick="location.href='cnote.php'">Нотификации</button>
        <button class="<?php echo $state3 ?>" onclick="location.href='csettings.php'">Настройки аккаунта</button>
        <button class="<?php echo $state4 ?>" onclick="location.href='cchangepass.php'">Сменить пароль</button>
        <a href="../logout.php"><button>Выйти из системы</button></a>
    </div>
</div>