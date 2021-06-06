<?php
    session_start();
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF-8">
    <title>Анекдотный</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/pagination.css">
    <link rel="stylesheet" href="css/like.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />

    <script src="jq.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            var sortType = "";

            function loadData(page_number, sort){
            $.ajax({
                url  : "load_data.php",
                type : "GET",
                cache: false,
                data : {
                    page:page_number,
                    sort_type: sort,
                },
                success:function(response){
                    $("#posts").html(response);
                }
            });
            }
            loadData();

            $(document).on("click", "#right li a", function(e){
                sortType = $(this).attr('id');
                loadData(1, sortType);
            });
            
            // Пагинация
            $(document).on("click", ".pagination a", function(e){
                e.preventDefault();
                if ($(this).data("val") == "next") {
                    var pageId = parseInt($(".pagination a[class='active']").attr("id")) + 1;
                } else if ($(this).data("val") == "prev") {
                    var pageId = parseInt($(".pagination a[class='active']").attr("id")) - 1;
                } else {
                    var pageId = $(this).attr("id");
                }

                loadData(pageId, sortType);
            });

            $(document).ajaxError(function (e, xhr, settings) {
                if (xhr.status == 401) {
                    document.location = "login.php";
                } else  if (xhr.status == 403) {
                    document.location = "permission_denied.php";
                }
            });

            $(document).on("click", "span[class~='unlike']", function(e){
                var postid = $(this).data("id");

                $.ajax({
                    url: "like.php",
                    type: 'post',
                    data: {
                        liked: 1,
                        post_id: postid
                    },
                    success: function(response){
                        var likes = $(e.target);
                        var count = likes.parent().find(".likes-count");
                        count.text(response);
                        likes.removeClass();
                        likes.addClass("like fa fa-thumbs-up");
                    }
                });
		});

        $(document).on("click", "span[class~='like']", function(e){
                var postid = $(this).data("id");

                $.ajax({
                    url: "like.php",
                    type: "post",
                    data: {
                        unliked: 1,
                        post_id: postid
                    },
                    success: function(response){
                        var likes = $(e.target);
                        var count = likes.parent().find(".likes-count");
                        count.text(response);
                        likes.removeClass();
                        likes.addClass("unlike fa fa-thumbs-o-up");
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
            <div class="right" id='right'>
                <li><a id="sort-popularity">Сортировать по популярности</a></li>
                <li><a id="sort-time">Сортировать по дате добавления</a></li>
            </div>
            <div class="center">
                <div class="posts" id="posts">
                    

                </div>
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