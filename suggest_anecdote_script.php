<?php
    session_start();
    require_once "config.php";

    if (isset($_SESSION["id"]) && isset($_SESSION["loggedin"])) {
        $id = $_SESSION["id"];
        $username = $_SESSION["username"];
    } else {
        $id = null;
        $username = "Гость";
    }

    $result_log = "";

    if (isset($_POST['anecdote'])) {
        $anecdote = $_POST['anecdote'];

        if ($anecdote != '') {
            $query = "INSERT INTO suggested_anecdotes(content, author_name, user_id) VALUES (?, ?, ?)";

            if($statement = mysqli_prepare($link, $query)){
                mysqli_stmt_bind_param($statement, "ssi", $anecdote, $username, $id);
                
                if(mysqli_stmt_execute($statement)){
                    mysqli_stmt_store_result($statement);

                    $result_log = "Анекдот принят на рассмотрение.";
                } else {
                    $result_log =  "Что-то пошло не так!";
                }

                echo $result_log;
    
                mysqli_stmt_close($statement);
            }
        }
    }


?>