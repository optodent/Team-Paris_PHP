<?php require('includes/config.php');

$statement = $dataBase->prepare('SELECT post_id, post_title, post_cont, post_date, post_tags, post_visits FROM db_posts WHERE post_id = :post_id');
$statement->execute(array(':post_id' => $_GET['id']));
$row = $statement->fetch();

//if doesn't exist redirect to home page
if ($row['post_id'] == '') {
    header('Location: ./');
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Blog - <?php echo $row['post_title']; ?></title>

    <!--include CSS Style sheet-->
    <link href="http://fonts.googleapis.com/css?family=Droid+Serif" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Droid+Sans" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
    <link href='styles/client/bootstrap-responsive.css' rel='stylesheet'>
    <link href='styles/client/client.css' type='text/css' rel="stylesheet">

</head>
<body>

<div id="wrapper">

    <nav class="navbar navbar-default" role="navigation">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <a class="navbar-brand" href="index.php">Blog - Team Paris</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

                <form class="navbar-form navbar-left" role="search" method="post">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Search by tag" name="searchTag">
                    </div>
                    <button type="submit" class="btn btn-default" name="submit">Search</button>
                </form>

            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>

    <h1>The Blog of Team Paris</h1>

    <button type="button" class="btn btn-default back" aria-label="Left Align">
        <span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span>
        <a href="./">Return</a>
    </button>

    <div class="content">
        <section>

            <?php
            $visits = $row['post_visits'];
            $visits++;
            $stmt = $dataBase->prepare('UPDATE db_posts SET post_visits=:visits WHERE post_id = :post_id');
            $stmt->execute(array(
                ':visits' => $visits,
                ':post_id' => $_GET['id']
            ));

            echo '<article>';
            echo '<div class="panel panel-info">';

            echo '<div class="panel-body">';
            echo '<h3>' . $row['post_title'] . '</h3>';
            echo '</div>';

            echo '<div class="panel-footer">';
            echo '<p class="date">Posted on ' . date('jS M Y', strtotime($row['post_date'])) . '</p>';

            echo '<hr/>';

            echo '<p>' . $row['post_cont'] . '</p>';

            echo '<hr/>';

            echo '<p>' . $row['post_tags'] . '</p>';

            echo '<hr/>';

            echo '<p class="date">' . 'Visited ' . $visits . '</p>';

            echo '</div>';
            echo '</article>';
            ?>

            <header>
                <h3 class="white">Comments</h3>
            </header>

            <div class="panel panel-default comments form-comments">
                <div class="panel-body">
                    <form method="post" class="form_comments">
                        <p>
                            <input type="hidden" name="post_id" value="<?php echo $_GET['id']; ?>"/>
                            <span class="label label-default">Comments</span>
                            <br/>
                            <textarea name="content" cols="30" rows="5"></textarea>
                            <br/>
                            <span class="label label-default">Name</span>
                            <input type="text" name="name" class="form-control" placeholder="Name">
                            <br/>
                            <span class="label label-default">Email</span>
                            <input type="email" name="email" class="form-control" placeholder="Email">
                            <br/>
                            <button type="submit" name="submit" class="btn btn-default">Submit</button>
                        </p>
                    </form>
                    <img src="styles/client/comments_original.jpg" alt="comments"/>
                </div>
            </div>

            <?php
            if (isset($_POST['submit'])) {
                $_POST = array_map('stripslashes', $_POST);

                //collect form data
                extract($_POST);

                //very basic validation
                if ($name == '') {
                    $error = 'Please enter a valid name.';
                }

                if ($content == '' || strlen($content) < 20) {
                    $error = 'Please enter valid content minimum 20 characters';
                }

                if (!isset($error)) {

                    try {

                        //insert into database
                        $stmt = $dataBase->prepare('INSERT INTO db_comments(post_id, name, email, content) VALUES (:postID, :name, :email, :content )');
                        $stmt->execute(array(
                            ':name' => $name,
                            ':content' => $content,
                            ':postID' => $post_id,
                            ':email' => $email
                        ));


                    } catch (PDOException $e) {
                        echo $e->getMessage();
                    }
                } else {
                    echo $error;
                }
            }
            ?>

            <?php

            $stmt = $dataBase->prepare('SELECT comment_id, name, email, content FROM db_comments WHERE post_id=:post_id');
            $stmt->execute(array(
                ':post_id' => $_GET['id'],
            ));

            while ($row = $stmt->fetch()) {

                echo '<div class="panel panel-default comments">';
                echo '<div class="panel-body">';
                echo '<h4>By ' . htmlspecialchars($row['name']) . '    ' . htmlspecialchars($row['email']) . '</h4>';
                echo '<p>' . htmlspecialchars($row['content']) . '</p>';
                echo '</div>';
                echo '</div>';
            }
            ?>

    </div>

</body>
</html>