<?php
    require_once("includes/config.php");
    //blog home page

    $statement = $dataBase->query('SELECT post_id, post_title, post_desc, post_date FROM db_posts ORDER BY post_id DESC');
    while($row = $statement->fetch()){

        echo '<div>';
        echo '<h1><a href="viewpost.php?id='.$row['post_id'].'">'.$row['post_title'].'</a></h1>';
        echo '<p>Posted on '.date('jS M Y H:i:s', strtotime($row['post_date'])).'</p>';
        echo '<p>'.$row['post_desc'].'</p>';
        echo '<p><a href="viewpost.php?id='.$row['post_id'].'">Read More</a></p>';
        echo '</div>';
    }

?>