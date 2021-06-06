<?php
    session_start();
    require_once "config.php";
    
	if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == false || $_SESSION['role'] != 'ADMIN') {
		header('Location: permission_denied.php');
        exit();
	}

?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF-8">
    <title>Анекдотный</title>
    <link rel="stylesheet" href="css/main.css">
    <script src="jq.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#admin_nav li a").click(function() {
        
                $("#ajax-content").empty().append("<div id='loading'><img src='images/loading.gif' alt='Loading' /></div>");
                $("#admin_nav li a").removeClass('current');
                $(this).addClass('current');
        
                $.ajax({ url: this.href, success: function(html) {
                    $("#ajax-content").empty().append(html);
                }
            });
            return false;
            });
        });
        
    </script>
</head>

<body>

    <div class="header">
        <div class="container">
            <div class="header__inner">
                <a href="index.php">Анекдотный</a>
                <a href="admin.php">Админская панель</a>
                <a href="suggest_anecdote.php">Предложить свой анекдот</a>
                <nav class="nav">
                    <?php
                    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
                        echo '<div><a href="profile.php">'.$_SESSION["username"].'</a> <a href="logout.php">Logout</a></div>';
                    } else {
                        echo "<div>
                                <a href='login.php'>Sign in</a>
                                <a href='registration.php'>Sign up</a>
                            </div>";
                    }
                    ?>
                </nav>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container">
            <div class="right" id="admin_nav">
                <li><a href="add_anecdote.php">Добавить новый анекдот</a></li>
                <li><a href="anecdotes_for_delete.php">Удалить анекдот</a></li>
                <li><a href="suggested_anecdotes.php">Посмотреть предложенные</a></li>
            </div>
            
            <div class="center">
                <div id="ajax-content">Это админская панель, сюда могут попасть только админы. Меню справа.</div>
                <div><?php 
                    if (isset($_GET["result_log"])) {
                        echo $_GET["result_log"];
                    }
                ?></div>
            </div>
        </div>
    </div>

    <div class="footer">
        <div class="container">
            <div class="footer__inner">
                Сабуров Л.М.<br>
                БСБО-08-18<br>
                2021
            </div>
        </div>
    </div>


</body>

</html>