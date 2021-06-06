<?php
    session_start();
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF-8">
    <title>Анекдотный</title>
    <link rel="stylesheet" href="css/main.css">
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
    <script src="jq.js"></script>
    <script>
        $(document).ready(function(){
            $("#form").submit(function(e) {
            e.preventDefault();
            var form = $(this);

            $.ajax({
                type: "POST",
                url: "suggest_anecdote_script.php",
                data: form.serialize(), 
                success: function(data)
                {
                    $("#result-log").text(data);
                    $("#anecdote").val("");
                }
            });
        });
    });


    </script>
</head>

<body>

    <div class="header">
        <div class="container">
            <div class="header__inner">
                <a href="index.php">Анекдотный</a>
                <a href="admin.php">Админская панель</a>
                <a href="suggest_anecdote.php">Предложить свой анекдот</a>
                <nav class="nav">
                    <?php
                    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
                        echo '<div><a href="profile.php">'.$_SESSION["username"].'</a> <a href="logout.php">Logout</a></div>';
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

    <div class="content">
        <div class="container">
            <div class="right">
                
            </div>
            <div class="center">
                <form id="form" method="POST">
                    <h1 id="result-log"></h1>
                    <textarea id="anecdote" name="anecdote" placeholder="Предложите анекдот. Он будет принят на рассмотрение" style="height:200px"></textarea>
                
                    <input type="submit" value="Submit">
                
                </form>
            </div>
        </div>
    </div>

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