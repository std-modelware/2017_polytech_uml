<?php require_once("../includes/connection.php"); ?>



<?php
$state1 = 'links';
$state5 = 'links active';
$state2 = 'links';
$state3 = 'links';
$state4 = 'links';
include("menu_operator.php");

$dbname = $link;
$tablename = 'orders';
$_SESSION['session_opage'] = 1;
?>

<div id="orders" class="content" style="display: block">
    <div class="container_order_history">
        <center>
            <div id="settings">
                <h1>Полная таблица заказов</h1>
                <?php include("allorders_table.php"); ?>


                <table border="0" align='center' style='table-layout: auto; overflow: scroll'>
                    <tr>
                        <td width="33%" style="padding: 0% 0% 0% 1%">
                            <div class="perpage" id="perpage">
                                <select id="perpage_select" onchange="sorter.size(this.value)">
                                    <option value="5">5</option>
                                    <option value="10" selected="selected">10</option>
                                    <option value="20">20</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </div>
                        </td>

                        <td width="33%" style="vertical-align: top; padding: 0% 0% 0% 1%">
                            <div id="navigation">
                                <img src="../images/first.png" width="16" height="16" alt="First Page"
                                     onclick="sorter.move(-1,true)"/>
                                <img src="../images/previous.png" width="16" height="16" alt="First Page"
                                     onclick="sorter.move(-1)"/>
                                <img src="../images/next.png" width="16" height="16" alt="First Page"
                                     onclick="sorter.move(1)"/>
                                <img src="../images/last.png" width="16" height="16" alt="Last Page"
                                     onclick="sorter.move(1,true)"/>
                            </div>
                        </td>

                        <td width="33%" align="center" style="vertical-align: top; font-size: large">
                            <div id="text">Страница <span id="currentpage"></span> из <span id="pagelimit"></span></div>
                        </td>

                    </tr>
                </table>

                <?php echo $structure; ?>


                <script type="text/javascript" src="../scripts/diff_display.js"></script>
                <script type="text/javascript" src="../scripts/sort_odisplay.js"></script>

            </div>
        </center>
    </div>
</div>