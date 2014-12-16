<?php //include config
require_once('../includes/config.php');

//if not logged in redirect to login page
if (!$user->checkIfLogged()) {
    header('Location: login.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Edit Post</title>

    <!--CSS Style sheet-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
    <link href='styles/bootstrap-responsive.css' rel='stylesheet'>
    <link href='styles/index.css' type='text/css' rel="stylesheet">

    <script src="//tinymce.cachefly.net/4.0/tinymce.min.js"></script>
    <script>
        tinymce.init({
            selector: "textarea",
            plugins: [
                "advlist autolink lists link image charmap print preview anchor",
                "searchreplace visualblocks code fullscreen",
                "insertdatetime media table contextmenu paste"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
        });
    </script>
</head>
<body>

<div id="wrapper">
    <div class="content">

        <?php include('menu.php'); ?>

        <div class="right">
            <div class="panel panel-primary">
                <div class="panel-heading">Edit Post</div>
                <br/>

                <?php

                //if form has been submitted process it
                if (isset($_POST['submit'])) {

                    $_POST = array_map('stripslashes', $_POST);

                    //collect form data
                    extract($_POST);

                    //very basic validation
                    if ($post_id == '') {
                        $error[] = 'This post is missing a valid id!.';
                    }

                    if ($post_title == '') {
                        $error[] = 'Please enter the title.';
                    }

                    if ($post_desc == '') {
                        $error[] = 'Please enter the description.';
                    }

                    if ($post_cont == '') {
                        $error[] = 'Please enter the content.';
                    }

                    if (!isset($error)) {

                        try {

                            //insert into database
                            $stmt = $dataBase->prepare('UPDATE db_posts SET post_title = :postTitle, post_desc = :postDesc, post_cont = :postCont, post_tags = :postTags WHERE post_id = :postID');
                            $stmt->execute(array(
                                ':postTitle' => $post_title,
                                ':postDesc' => $post_desc,
                                ':postCont' => $post_cont,
                                ':postID' => $post_id,
                                ':postTags' => $post_tags
                            ));

                            //redirect to index page
                            header('Location: index.php?action=updated');
                            exit;

                        } catch (PDOException $e) {
                            echo $e->getMessage();
                        }
                    }
                }

                ?>

                <?php
                //check for any errors
                if (isset($error)) {
                    foreach ($error as $error) {
                        echo $error . '<br />';
                    }
                }

                try {

                    $stmt = $dataBase->prepare('SELECT post_id, post_title, post_desc, post_cont, post_tags FROM db_posts WHERE post_id = :postID');
                    $stmt->execute(array(':postID' => $_GET['id']));
                    $row = $stmt->fetch();

                } catch (PDOException $e) {
                    echo $e->getMessage();
                }

                ?>

                <form class="post" action='' method='post'>
                    <input type='hidden' name='post_id' value='<?php echo $row['post_id']; ?>'>

                    <span class="label label-default">Title</span><br/>
                    <input type='text' name='post_title' value='<?php echo $row['post_title']; ?>'></p>

                    <span class="label label-default">Description</span><br/>
                    <textarea name='post_desc' cols='60' rows='10'><?php echo $row['post_desc']; ?></textarea></p>

                    <span class="label label-default">Content</span><br/>
                    <textarea name='post_cont' cols='60' rows='10'><?php echo $row['post_cont']; ?></textarea></p>

                    <span class="label label-default">Tags</span><br/>
                    <input type="text" name='post_tags' value='<?php echo $row['post_tags']; ?>'/></p>
                    <input class="btn btn-primary" type='submit' name='submit' value='Update'>

                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>	
