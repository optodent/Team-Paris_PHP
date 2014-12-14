<?php
require('includes/config.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Blog</title>

</head>
<body>

<div id="wrapper">

    <h1>The Blog of Team Paris</h1>

    <form method="post">
        <p>
            <label>Search By Tag</label>
            <input type="text" name="searchTag"/>
        </p>
        <input type="submit" name="submit" value="Search"/>
    </form>
    <?php
    try {
        //viewing all posts
        if(isset($_POST['submit'])){
            $searchTag = '%'.htmlspecialchars($_POST['searchTag']).'%';

        }else{
            $searchTag = '%';
        }
        $stmt = $dataBase->query("SELECT post_id, post_title, post_desc, post_date FROM db_posts WHERE post_tags LIKE '$searchTag' ORDER BY post_id DESC");
        while($row = $stmt->fetch()){

            echo '<div>';
            echo '<h1><a href="viewpost.php?id='.$row['post_id'].'">'.$row['post_title'].'</a></h1>';
            echo '<p>Posted on '.date('jS M Y H:i:s', strtotime($row['post_date'])).'</p>';
            echo '<p>'.$row['post_desc'].'</p>';
            echo '<p><a href="viewpost.php?id='.$row['post_id'].'">Read More</a></p>';
            echo '</div>';

        }

    } catch(PDOException $e) {
        echo $e->getMessage();
    }
    ?>

</div>


</body>
</html>