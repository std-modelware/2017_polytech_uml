<?php include("includes/header.php"); ?>
    <body>
    <div class="containe" align="center">
        <div id="log">
            <br>
            <h1 style="color: #ff8300">Добро пожаловать на сайт Типографии!</h1>
        </div>
        <div style="width: 50%">
            <table align="center" width="100%" style="table-layout: auto">

                <tr>
                    <td width="50%" align="center"><img src="images/login.png" style="height: 45%" href="login.php"
                                                        onclick="location.href='login.php'"></td>
                    <td width="50%" align="center"><img src="images/register.png" style="height: 90%"
                                                        href="register.php" onclick="location.href='register.php'"></td>

                </tr>
                <tr>
                    <td width="50%" align="center"><p class="regtext"><a href="login.php"
                                                                         style="font-weight: 600; font-size: larger">Вход в личный кабинет!</a>
                        </p></td>
                    <td width="50%" align="center"><p class="regtext"><a href="register.php"
                                                                         style="font-weight: 600; font-size: larger">Регистрация!</a>
                        </p></td>
                </tr>
            </table>

            <table>
        </div>
    </div>
    </body>
<?php include("includes/footer.php"); ?>