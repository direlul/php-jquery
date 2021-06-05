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
            function loadData(page_number){
            $.ajax({
                url  : "load_data.php",
                type : "POST",
                cache: false,
                data : {page:page_number},
                success:function(response){
                $("#posts").html(response);
                }
            });
            }
            loadData();
            
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

                loadData(pageId);
            });

            $('.like').on('click', function(){
                var postid = $(this).data('id');
                    $post = $(this);

                $.ajax({
                    url: 'like.php',
                    type: 'post',
                    data: {
                        'liked': 1,
                        'post_id': postid
                    },
                    success: function(response){
                        $post.parent().find('span.likes_count').text(response + " likes");
                        $post.addClass('hide');
                        $post.siblings().removeClass('hide');
                    }
                });
		});

		$('.unlike').on('click', function(){
			var postid = $(this).data('id');
		    $post = $(this);

			$.ajax({
				url: 'like.php',
				type: 'post',
				data: {
					'unliked': 1,
					'post_id': postid
				},
				success: function(response){
					$post.parent().find('span.likes_count').text(response + " likes");
					$post.addClass('hide');
					$post.siblings().removeClass('hide');
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
                <nav class="nav">
                    <?php
                    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
                        echo '<div><a href="profile/'.$_SESSION["id"].'">'.$_SESSION["username"].'</a> <a href="logout.php">Logout</a></div>';
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
                asd
            </div>
            <div class="center">
                <div class="posts" id="posts">
                    

                </div>
            </div>
        </div>
    </div>

    <div class="footer">
        <div class="container">

        </div>
    </div>


</body>

</html>