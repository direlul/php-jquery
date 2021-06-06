<?php
    session_start();
    require_once "config.php";

    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == false || $_SESSION['role'] != 'ADMIN') {
		header('Location: permission_denied.php');
        exit();
	}

    if (isset($_GET['id'])) {
        $query_select_suggeted_anecdote = "SELECT * FROM suggested_anecdotes WHERE id={$_GET['id']}";   
        $query_delete_suggeted_anecdote = "DELETE FROM suggested_anecdotes WHERE id={$_GET['id']}";
        $query_insert_into_main_anecdotes = "INSERT INTO posts(content, author_name, author_id) VALUES (?, ?, ?)";

        $suggested_anecdote = mysqli_query($link, $query_select_suggeted_anecdote);

        if (mysqli_num_rows($suggested_anecdote) > 0) {
            $suggested_anecdote = mysqli_fetch_assoc($suggested_anecdote);
            mysqli_query($link, $query_delete_suggeted_anecdote);

            if($statement = mysqli_prepare($link, $query_insert_into_main_anecdotes)){
                mysqli_stmt_bind_param($statement, "ssi", $suggested_anecdote['content'], $suggested_anecdote['author_name'], $suggested_anecdote['user_id']);
                
                if(mysqli_stmt_execute($statement)){
                    mysqli_stmt_store_result($statement);

                    $result_log = "Анекдот опубликован!";
                } else {
                    $result_log =  "Что-то пошло не так!";
                }

                mysqli_stmt_close($statement);

                echo $result_log;   
            }

        }
    }
?>