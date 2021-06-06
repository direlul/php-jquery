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
        $("a[class='delete_link']").click(function(e) {
            e.preventDefault();
            var url = $(this).attr('href');
            var row = $(this).parents('tr:first');

            $.ajax({
                type: "GET",
                url: url,
                success: function(data){
                    $(row).remove();
                    alert(data);
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
                <div id="error_log"></div>
                <table>
                <tr>
                    <th>ID</th>
                    <th>Author</th>
                    <th>Content</th>
                    <th>Delete</th>
                </tr>
                    <?php
                        $query = "SELECT * FROM posts";
                        $result = mysqli_query($link, $query);

                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>
                                        <th>{$row["id"]}</th>
                                        <th>{$row["author_name"]}</th>
                                        <th>{$row["content"]}</th>
                                        <th><a class='delete_link' href='delete.php?id={$row["id"]}'>Удалить</a></th>
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