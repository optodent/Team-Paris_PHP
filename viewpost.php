<?php require('includes/config.php');

$statement = $dataBase->prepare('SELECT post_id, post_title, post_cont, post_date, post_tags, post_visits FROM db_posts WHERE post_id = :post_id');
$statement->execute(array(':post_id' => $_GET['id']));
$row = $statement->fetch();

//if doesn't exist redirect to home page
if($row['post_id'] == ''){
    header('Location: ./');
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Blog - <?php echo $row['post_title'];?></title>

</head>
<body>

<div id="wrapper">

    <h1>The Blog of Team Paris</h1>
    <p><a href="./">Return</a></p>


    <?php
    $visits = $row['post_visits'];
    $visits++;
    $stmt = $dataBase->prepare('UPDATE db_posts SET post_visits=:visits WHERE post_id = :post_id') ;
    $stmt->execute(array(
        ':visits' => $visits,
        ':post_id' => $_GET['id']
    ));
    echo '<div>';
    echo '<h1>'.$row['post_title'].'</h1>';
    echo '<p>Posted on '.date('jS M Y', strtotime($row['post_date'])).'</p>';
    echo '<p>'.$row['post_cont'].'</p>';
    echo '<p>'.$row['post_tags'].'</p>';
    echo '<p>'.'Visited '.$visits.'</p>';
    echo '</div>';
    ?>

    <header>
        <h3>Comments</h3>
    </header>

    <?php
    if(isset($_POST['submit'])){
        $_POST = array_map( 'stripslashes', $_POST );

        //collect form data
        extract($_POST);

        //very basic validation
        if($name ==''){
            $error = 'Please enter a valid name.';
        }

        if($content == '' || strlen($content) < 20){
            $error = 'Please enter valid content minimum 20 characters';
        }

        if(!isset($error)){

            try {

                //insert into database
                $stmt = $dataBase->prepare('INSERT INTO db_comments(post_id, name, email, content) VALUES (:postID, :name, :email, :content )');
                $stmt->execute(array(
                    ':name' => $name,
                    ':content' => $content,
                    ':postID' => $post_id,
                    ':email' => $email
                ));


            } catch(PDOException $e) {
                echo $e->getMessage();
            }
        }
        else{
            echo $error;
        }
    }
    ?>

    <?php

    $stmt = $dataBase->prepare('SELECT comment_id, name, email, content FROM db_comments WHERE post_id=:post_id') ;
    $stmt->execute(array(
        ':post_id' => $_GET['id'],
    ));

    while($row = $stmt->fetch()){

        echo '<div>';
        echo   '<h4>By '.htmlspecialchars($row['name']).'    '. htmlspecialchars($row['email']). '</h4>' ;
        echo '<p>'.htmlspecialchars($row['content']).'</p>';
        echo '</div>';
    }
    ?>


    <form method="post">
        <p>
            <input type="hidden" name="post_id" value="<?php echo $_GET['id']; ?>"/>
            <label>Comments</label>
            <br/>
            <textarea name="content"  cols="30" rows="5"></textarea>
            <br/>
            <label>Name</label>
            <input type="text" name="name"/>
            <br/>
            <label>Email</label>
            <input type="email" name="email"/>
            <br/>
            <input type="submit" name="submit" value="Add Comment"/>
        </p>
    </form>

</div>

</body>
</html>