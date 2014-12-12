<?php
    require_once("includes/config.php");
    $statement = $dataBase->prepare('SELECT post_id, post_title, post_cont, post_date FROM db_posts WHERE post_id = :post_id');
    $statement->execute(array(':postID' => $_GET['id']));
    $row = $statement->fetch();

    //if no post redirect to home page
    if($row['post_id'] == ''){
        header('Location: ./');
        exit;
    }
    //else dispaly selected post
    echo '<div>';
    echo '<h1>'.$row['post_title'].'</h1>';
    echo '<p>Posted on '.date('jS M Y', strtotime($row['post_date'])).'</p>';
    echo '<p>'.$row['post_cont'].'</p>';
    echo '</div>';

?>