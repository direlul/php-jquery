<?php
session_start();

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: index.php");
    exit;
}


require_once "config.php";

$username = $password = "";
$username_err = $password_err = $login_err = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty(trim($_POST["username"]))) {
        $username_err = "Пожалуйста, введите имя пользователя.";
    } else {
        $username = trim($_POST["username"]);
    }

    if (empty(trim($_POST["password"]))) {
        $password_err = "Пожалуйста, введите пароль.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Проверка логина - пароля
    if (empty($username_err) && empty($password_err)) {
        $sql = "SELECT users.id, username, password, role 
        FROM users INNER JOIN roles ON users.role_id = roles.id 
        WHERE username = ?";

        if ($statement = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($statement, "s", $param_username);

            $param_username = $username;

            if (mysqli_stmt_execute($statement)) {
                mysqli_stmt_store_result($statement);
                //Если пользователь существует, проверка пароля
                if (mysqli_stmt_num_rows($statement) == 1) {
                    mysqli_stmt_bind_result($statement, $id, $username, $hashed_password, $role);
                    if (mysqli_stmt_fetch($statement)) {
                        if (password_verify($password, $hashed_password)) {
                            session_start();

                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;
                            $_SESSION["role"] = $role;

                            header("location: index.php");
                        } else {
                            $login_err = "Плохой ник или пароль.";
                        }
                    }
                } else {
                    $login_err = "Пользователь не существует.";
                }
            } else {
                echo "Что-то пошло не так!.";
            }

            mysqli_stmt_close($statement);
        }
    }

    mysqli_close($link);
}
?>


<!DOCTYPE HTML>
<html>

<head>
    <meta charset="UTF-8">
    <title>Анекдотный</title>
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/login.css">
    <script src="jq.js"></script>
    <style>
        .error-msg {
            color: #e03434;
        }
    </style>
    <script>
        window.onload = function() {
            const form = document.getElementsByTagName('form')[0];
            form.addEventListener('submit', function(event) {
                var login = $("#login").val();
                var password = $("#psw").val();
                var isValid = true;
                if (login == "") {
                    $("#error_login").text("Заполните ,пожалуйста, логин.");
                    $("#error_login").addClass("error-msg");
                    isValid = false;
                } else {
                    $("#error_login").text("");
                    $("#error_login").removeClass("error-msg");
                }

                if (password == "") {
                    $("#error_password").text("Заполните ,пожалуйста, пароль.");
                    $("#error_password").addClass("error-msg");
                    isValid = false;
                } else {
                    $("#error_password").text("");
                    $("#error_password").removeClass("error-msg");
                }

                if (!isValid) {
                    event.preventDefault();
                }
            });
        }
    </script>
</head>

<body>
    <div class="header">
        <div class="container">
            <div class="header__inner">
                <a href="index.php">Анекдотный</a>
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

    <form action="login.php" method="POST">
        <div class="container">
            <h1>Аутентификация</h1>
            <p>Заполните поля для аутентификации.</p>
            <hr>

            <label for="login"><b>Логин</b></label>
            <input type="text" placeholder="Введите логин" name="username" id="login">
            <div id="error_login"></div>
            <div class="error-msg"><?php if (isset($username_err) && $username_err != '') {
                                        echo $username_err;
                                    } ?></div>
            <div class="error-msg"><?php if (isset($login_err) && $login_err != '') {
                                        echo $login_err;
                                    } ?></div>

            <label for="psw"><b>Password</b></label>
            <input type="password" placeholder="Введите пароль" name="password" id="psw">
            <div id="error_password"></div>
            <div class="error-msg"><?php if (isset($password_err) && $password_err != '') {
                                        echo $username_err;
                                    } ?></div>


            <button type="submit" class="registerbtn" id="#submit">Log in</button>
        </div>

    </form>

    <div class="footer">
        <div class="container">

        </div>
    </div>
</body>

</html>