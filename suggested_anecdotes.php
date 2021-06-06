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
    <style>
        table, tr, th, td {
            border: 1px solid black;
        }
    </style>
    <script src="jq.js"></script>
    <script type="text/javascript">
        $("a[class='accept_link']").click(function(e) {
            e.preventDefault();
            var url = $(this).attr('href');
            var row = $(this).parents('tr:first');

            $.ajax({
                type: "GET",
                url: url,
                success: function(data){
                    $(row).remove();
                    $("result_log").text(data);
                }
            });
        return false;
        });
    </script>
</head>

<body>

    <div class="content">
        <div class="container">
            <div class="center">
            <h1 id="result-log"></h1>
                <table>
                <tr>
                    <th>ID</th>
                    <th>Author</th>
                    <th>Content</th>
                    <th>Accept</th>
                </tr>
                    <?php
                        $query = "SELECT * FROM suggested_anecdotes";
                        $result = mysqli_query($link, $query);

                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>
                                        <th>{$row["id"]}</th>
                                        <th>{$row["author_name"]}</th>
                                        <th>{$row["content"]}</th>
                                        <th><a class='accept_link' href='publish_anecdote.php?id={$row["id"]}'>Опубликовать</a></th>
                                    </tr>";
                            }
                        }
                    
                    ?>

                </table>
            </div>
        </div>
    </div>

</body>

</html>