<?php
session_start();
if(!isset($_SESSION["session_username"])) {
    echo "<script>document.location.href='../login.php';</script>";
}
?>

<?php include("../includes/header_account.php"); ?>
<div id="welcome">
    <h2>Добро пожаловать оператор, <span><?php echo $_SESSION['session_username'];?></span>!</h2>
</div>
<?php include("../includes/footer.php"); ?>

<?php
echo "<script>document.location.href='orders.php';</script>";
exit; ?>
