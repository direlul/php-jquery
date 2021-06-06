<?php
    session_start();
    require_once "config.php";

    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == false || $_SESSION['role'] != 'ADMIN') {
		header('Location: permission_denied.php');
        exit();
	}

    if (isset($_GET['id'])) {
        $query = "DELETE FROM posts WHERE id = '{$_GET['id']}'";
        $result = mysqli_query($link, $query);

        if ($result > 0) {
            echo "Пост удален!";
        } else {
            echo ("Could not insert data : " . mysqli_error($link) . " " . mysqli_errno($link));
        }
    }
?>