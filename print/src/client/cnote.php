<?php require_once("../includes/connection.php"); ?>

<?php
$state1 = 'links';
$state5 = 'links active';
$state2 = 'links';
$state3 = 'links';
$state4 = 'links';
include("menu_client.php");

$username = $_SESSION['session_username'];
$user_id = '';
$user_id = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM users WHERE username = '" . $username . "'"))['user_id'];
?>

<?php include("../includes/header_account.php"); ?>
<div id="orders" class="content" style="display: block">
    <div class="container_order_history">
        <center>
            <div id="settings">
                <h1>Нотификации</h1>

                <?php include("note_table.php");

                if (isset($_POST['delete'])) {

                    $id_note = htmlspecialchars($_POST['idnote']);

                    $result = mysqli_query($link, "DELETE FROM notifications WHERE id = '" . $id_note . "'");

                    if ($result != 0) {
                        include("note_table.php");
                    } else {
                        printf("Errormessage: %s\n", mysqli_error($link));
                    }

                }
                ?>
                <?php echo $structure; ?>

            </div>
        </center>
    </div>
</div>