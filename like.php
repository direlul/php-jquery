<?php
    session_start();
    require_once "config.php";
    
	if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == false) {
		header('Location: login.php', true, 401);
		exit;
	}

    if (isset($_POST['liked'])) {
		$postid = $_POST['post_id'];
		$result = mysqli_query($link, "SELECT * FROM posts WHERE id=$postid");
		$row = mysqli_fetch_array($result);
		$n = $row['likes'];

		mysqli_query($link, "INSERT INTO likes (user_id, post_id) VALUES ({$_SESSION["id"]}, $postid)");
		mysqli_query($link, "UPDATE posts SET likes=$n+1 WHERE id=$postid");

		echo $n+1;
		exit();
	}
	if (isset($_POST['unliked'])) {
		$postid = $_POST['post_id'];
		$result = mysqli_query($link, "SELECT * FROM posts WHERE id=$postid");
		$row = mysqli_fetch_array($result);
		$n = $row['likes'];

		mysqli_query($link, "DELETE FROM likes WHERE post_id=$postid AND user_id={$_SESSION['id']}");
		mysqli_query($link, "UPDATE posts SET likes=$n-1 WHERE id=$postid");
		
		echo $n-1;
		exit();
	}

?>