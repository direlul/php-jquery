<?php
require_once "config.php";

$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
 

if($_SERVER["REQUEST_METHOD"] == "POST") {
 
    // Валидация имени
    if(empty(trim($_POST["username"]))) {
        $username_err = "Пожалуйста введите имя пользователя";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
        $username_err = "Имя пользователя может содержать только латнские буквы, цифры и _.";
    } else {
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if($statement = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($statement, "s", $param_username);
            
            $param_username = trim($_POST["username"]);
            
            if(mysqli_stmt_execute($statement)){
                mysqli_stmt_store_result($statement);
                
                if(mysqli_stmt_num_rows($statement) == 1){
                    $username_err = "Имя пользователя уже занято.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Что-то пошло не так!";
            }

            mysqli_stmt_close($statement);
        }
    }
    
    // Валидация пароля
    if(empty(trim($_POST["password"]))) {
        $password_err = "Необходимо ввести пароль.";     
    } elseif(strlen(trim($_POST["password"])) < 6) {
        $password_err = "Пароль должен быть больше 6 символов";
    } else {
        $password = trim($_POST["password"]);
    }
    
    // Валидация повтора пароля
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Необходимо подтвердить пароль.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Пароли не соответствуют";
        }
    }
    
    // Проверка ошибок
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        $sql = "INSERT INTO users (username, password, role_id) VALUES (?, ?, ?)";
         
        if($statement = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($statement, "ssi", $param_username, $param_password, $param_role_id);
            
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT);
            $param_role_id = 1;
            
            if(mysqli_stmt_execute($statement)){
                header("location: login.php");
            } else{
                echo "Что-то пошло не так!";
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
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/main.css">
    <script src="jq.js"></script>
    <style>
        .error-msg {
        color: #e03434; 
        }
    </style>
    <script>
        window.onload = function(){
            const form  = document.getElementsByTagName('form')[0];
            form.addEventListener('submit', function (event) {
                var login = $("#login").val();
                var password = $("#psw").val();
                var passwordRepeat = $("#psw-repeat").val();
                var isValid = true;
                if (login == "") {
                    $("#error_login").text("Заполните, пожалуйста, логин.");
                    $("#error_login").addClass("error-msg");
                    isValid = false;
                } else {
                    $("#error_login").text("");
                    $("#error_login").removeClass("error-msg");
                }

                if (password == "" || passwordRepeat == "") {
                    $("#error_password").text("Заполните, пожалуйста, поля паролей.");
                    $("#error_password").addClass("error-msg");
                    isValid = false;
                } else {
                    $("#error_password").text("");
                    $("#error_password").removeClass("error-msg");
                }

                if (password != passwordRepeat) {
                    $("#error_equals_psw").text("Пароли не равны");
                    $("#error_equals_psw").addClass("error-msg");
                    isValid = false;
                } else {
                    $("#error_equals_psw").text("");
                    $("#error_equals_psw").removeClass("error-msg");
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
                <a href="suggest_anecdote.php">Предложить свой анекдот</a>
                <nav class="nav">
                    <a href="login.php">Sign in</a>
                    <a href="registration.php">Sign up</a>
                </nav>
            </div>
        </div>
    </div>

    <form action="registration.php" method="POST">
        <div class="container">
          <h1>Регистрация</h1>
          <p>Заполните поля для регистрации аккаунта.</p>
          <hr>
      
          <label for="login"><b>Логин</b></label>
          <input type="text" placeholder="Введите логин" name="username" id="login">
          <div id="error_login"></div>
          <div class="error-msg"><?php if( isset($username_err) && $username_err != '' ) { echo $username_err; } ?></div>
      
          <label for="psw"><b>Password</b></label>
          <input type="password" placeholder="Введите пароль" name="password" id="psw">
          <div id="error_password"></div>
          <div class="error-msg"><?php if( isset($password_err) && $password_err != '' ) { echo $password_err; } ?></div>
      
          <label for="psw-repeat"><b>Repeat Password</b></label>
          <input type="password" placeholder="Повторите пароль" name="confirm_password" id="psw-repeat">
          <div id="error_equals_psw"></div>
          <div class="error-msg"><?php if( isset($confirm_password_err) && $confirm_password_err != '' ) { echo $confirm_password_err; } ?></div>
          <hr>
      
          <button type="submit" class="registerbtn">Register</button>
        </div>
      
        <div class="container signin">
          <p>Уже есть аккаунт? <a href="login.php">Залогиниться</a>.</p>
        </div>
      </form>

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