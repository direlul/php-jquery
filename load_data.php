<?php
    session_start();
    require_once "config.php";

    $limit = 5;

    $sql = "SELECT * FROM posts";

    $records = mysqli_query($link, $sql);

    $totalRecords = mysqli_num_rows($records);

    $totalPage = ceil($totalRecords/$limit);

    if (isset($_POST['page'])) {
        $page = $_POST['page'];
        if ($page < 1) {
            $page = 1;
        } else if ($page > $totalPage) {
            $page = $totalPage;
        }
    } else {
        $page = 1;
    }

    

    $offset = ($page - 1) * $limit;

    $query = "SELECT * FROM posts LIMIT $offset, $limit";

    $result = mysqli_query($link, $query);

    $output = "";

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $liked = mysqli_query($link, "SELECT * FROM likes WHERE user_id='{$_SESSION["id"]}' AND post_id='{$row["id"]}'");

            $output.= '
            <div class="post">
                <input value="'.$row["id"].'" hidden>
                <div class="post__content">
                    '.$row["content"].'
                </div>
                <div class="post__footer">
                <div class="post__rating">';
                if (mysqli_num_rows($liked) == 1 ) {
                    $output.= '<span class="unlike fa fa-thumbs-up" data-id="'.$row['id'].'"></span>
                    <span class="like hide fa fa-thumbs-o-down" data-id="'.$row['id'].'"></span> ';
                } else {
                    $output.= '<span class="like fa fa-thumbs-o-up" data-id="'.$row['id'].'"></span> 
                    <span class="unlike hide fa fa-thumbs-down" data-id="'.$row['id'].'"></span> ';
                }

                $output.='<span class="likes-count">'.$row['likes'].'</span>
                </div>
                <a href="post.php?id='.$row["id"].'">Комментировать</a>
                    <a href="user.php?id='.$row["author_id"].'">'.$row["author_name"].'</a>
                </div>
            </div>
            ';
        } 

        $output.="<div class='pagination'>";
        $output.="<a href='#' data-val='prev'>&laquo;</a>";

        for ($i = 1; $i <= $totalPage; $i++) { 
            if ($i == $page) {
                $active = "active";
            } else {
                $active = "";
            }

            $output.="<a class='$active' id='$i' href='#'>$i</a>";
        }

        $output.="<a href='#' data-val='next'>&raquo;</a>";
        $output .= "</div>";

        mysqli_close($link);

        echo $output;

    }
?>