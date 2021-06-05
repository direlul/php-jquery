<?php
    require_once "config.php";
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
    } else {
        header("location: error.php");
    }

    $update_likes = "UPDATE `posts` SET dislikes = dislikes + 1 WHERE id = ?";
    $get_likes = "SELECT 'dislikes' FROM posts WHERE id = ?";

    if($statement = mysqli_prepare($link, $update_likes)){
        mysqli_stmt_bind_param($statement, "i", $id);

        if(mysqli_stmt_execute($statement)){
            mysqli_stmt_store_result($result);
            
            if(mysqli_stmt_num_rows($result) == 1) {
                $statement = mysqli_prepare($link, $get_likes);
                mysqli_stmt_bind_param($statement, "i", $id);
                mysqli_stmt_execute($statement);
                mysqli_stmt_store_result($new_likes);
                echo $new_likes;
            } else {
                echo "Нет такого поста!";
            }

        } else {
            echo "Что-то пошло не так!";
        }

    }

?>