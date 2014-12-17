<?php
require('includes/config.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog - Team PARIS</title>

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

    <div class="content">
        <section>

            <?php
            try {
                //viewing all posts
                if (isset($_POST['submit'])) {
                    $searchTag = '%' . htmlspecialchars($_POST['searchTag']) . '%';

                } else {
                    $searchTag = '%';
                }
                $stmt = $dataBase->query("SELECT post_id, post_title, post_desc, post_date FROM db_posts WHERE post_tags LIKE '$searchTag' ORDER BY post_id DESC");
                while ($row = $stmt->fetch()) {
                    echo '<article>';
                    echo '<div class="panel panel-info">';

                    echo '<div class="panel-body">';
                    echo '<h3><a href="viewpost.php?id=' . $row['post_id'] . '">' . $row['post_title'] . '</a></h3>';
                    echo '</div>';

                    echo '<div class="panel-footer">';
                    echo '<p class="date">Posted on ' . date('jS M Y H:i:s', strtotime($row['post_date'])) . '</p>';

                    echo '<hr/>';

                    echo '<p>' . $row['post_desc'] . '</p>';
                    echo '<p><a href="viewpost.php?id=' . $row['post_id'] . '">Read More</a></p>';

                    echo '</div>';
                    echo '</article>';
                }

            } catch (PDOException $e) {
                echo $e->getMessage();
            }
            ?>
        </section>

    </div>
</div>

</body>
</html>