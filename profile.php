<?php
    session_start();
    require_once "config.php";

    $id = 0;
    $message = "";
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $message = "Профиль юзера. Его ник: ";
    } else if (isset($_SESSION['id'])) {
        $id = $_SESSION['id'];
        $message = "Это ваш профиль, но тут ничего нет кроме никнейма, т.к. мне не хватило времени:)
        Ваше ник: ";
    }

    $query = "SELECT * FROM users WHERE id = {$id}";
    $result = mysqli_query($link, $query);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $user = $row["username"];
    } else {
        $user = "Гость";
    }
    
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF-8">
    <title>Анекдотный</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/pagination.css">
    <link rel="stylesheet" href="css/like.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />

    <script src="jq.js"></script>
    <script type="text/javascript">
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
                        echo '<div><a href="profile/'.$_SESSION["id"].'">'.$_SESSION["username"].'</a> <a href="logout.php">Logout</a></div>';
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
            <div class="right" id='right'>
            </div>
            <div class="center">
                <div class="username" style="margin:auto auto;">
                     <?php
                        echo $message . $user;
                    ?>
                </div>
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