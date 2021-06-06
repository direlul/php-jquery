<?php
    session_start();
    require_once "config.php";
    
	if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == false || $_SESSION['role'] != 'ADMIN') {
		header('Location: permission_denied.php');
        exit();
	}

    $result_log = "";

    if (isset($_POST['anecdote'])) {
        $anecdote = $_POST['anecdote'];

        if ($anecdote != '') {
            $query = "INSERT INTO posts(content, author_name, author_id) VALUES (?, ?, ?)";

            if($statement = mysqli_prepare($link, $query)){
                mysqli_stmt_bind_param($statement, "ssi", $anecdote, $_SESSION['username'], $_SESSION['id']);
                
                if(mysqli_stmt_execute($statement)){
                    mysqli_stmt_store_result($statement);

                    $result_log = "Анекдот успешно добавлен";
                    header("location: admin.php?result_log={$result_log}");
                } else {
                    $result_log =  "Что-то пошло не так!";
                    header("location: admin.php?result_log={$result_log}");
                }
    
                mysqli_stmt_close($statement);
            }
        }
    }


?>
<style>
    input[type=text], textarea {
        width: 85%;
        padding: 12px; 
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box; 
        margin-top: 6px;
        margin-bottom: 16px;
        resize: vertical
    }

    input[type=submit] {
        display: block;
        background-color: #04AA6D;
        color: white;
        padding: 12px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    input[type=submit]:hover {
        background-color: #45a049;
    }

</style>



<div class="container">
    <form id="form" action="add_anecdote.php" method="POST">
        <h1 id="result-log"></h1>
        <textarea id="anecdote" name="anecdote" placeholder="Напишите анекдот" style="height:200px"></textarea>
    
        <input type="submit" value="Submit">
    
      </form>
</div>