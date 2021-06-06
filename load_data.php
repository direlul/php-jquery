<?php
    session_start();
    require_once "config.php";

    $limit = 5;

    $sql = "SELECT * FROM posts";

    $records = mysqli_query($link, $sql);

    $totalRecords = mysqli_num_rows($records);

    $totalPage = ceil($totalRecords/$limit);

    if (isset($_GET['page'])) {
        $page = $_GET['page'];
        if ($page < 1) {
            $page = 1;
        } else if ($page > $totalPage) {
            $page = $totalPage;
        }
    } else {
        $page = 1;
    }

    

    $offset = ($page - 1) * $limit;

    if (isset($_GET['sort_type'])) {
        if ($_GET['sort_type'] == 'sort-popularity') {
            $query = "SELECT * FROM posts ORDER BY likes DESC LIMIT $offset, $limit";
        } else if ($_GET['sort_type'] == 'sort-time') {
            $query = "SELECT * FROM posts ORDER BY id DESC LIMIT $offset, $limit";
        } else {
            $query = "SELECT * FROM posts LIMIT $offset, $limit";
        }
    } else {
        $query = "SELECT * FROM posts LIMIT $offset, $limit";
    }



    $result = mysqli_query($link, $query);

    $output = "";

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            if (!isset($_SESSION['id'])) {
                $liked = mysqli_query($link, "SELECT * FROM likes WHERE user_id=100000 AND post_id='{$row["id"]}'");;
            } else {
                $liked = mysqli_query($link, "SELECT * FROM likes WHERE user_id='{$_SESSION["id"]}' AND post_id='{$row["id"]}'");
            }
            

            $output.= '
            <div class="post">
                <input value="'.$row["id"].'" hidden>
                <div class="post__content">
                    '.$row["content"].'
                </div>
                <div class="post__footer">
                <div class="post__rating">';
                if (mysqli_num_rows($liked) == 1 ) {
                    $output.= '<span class="like fa fa-thumbs-up" data-id="'.$row['id'].'"></span>';
                } else {
                    $output.= '<span class="unlike fa fa-thumbs-o-up" data-id="'.$row['id'].'"></span>';
                }

                $output.='<span class="likes-count">'.$row['likes'].'</span>
                </div>
                    <a href="profile.php?id='.$row["author_id"].'">'.$row["author_name"].'</a>
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