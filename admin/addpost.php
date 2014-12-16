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
    <title>Admin - Add Post</title>

    <!--CSS Style sheet-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
    <link href='styles/abootstrap-responsive.css' rel='stylesheet'>
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
                <div class="panel-heading">Add Post</div>
                <br/>

                <?php

                //if form has been submitted process it
                if (isset($_POST['submit'])) {

                    $_POST = array_map('stripslashes', $_POST);

                    //collect form data
                    extract($_POST);

                    //very basic validation
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
                            $stmt = $dataBase->prepare('INSERT INTO db_posts (post_title,post_desc,post_cont,post_date,post_tags) VALUES (:postTitle, :postDesc, :postCont, :postDate, :postTags)');
                            $stmt->execute(array(
                                ':postTitle' => $post_title,
                                ':postDesc' => $post_desc,
                                ':postCont' => $post_cont,
                                ':postDate' => date('Y-m-d H:i:s'),
                                ':postTags' => $post_tags
                            ));

                            //redirect to index page
                            header('Location: index.php?action=added');
                            exit;

                        } catch (PDOException $e) {
                            echo $e->getMessage();
                        }

                    }

                }

                //check for any errors
                if (isset($error)) {
                    foreach ($error as $error) {
                        echo '<div class="alert alert-danger" role="alert">
					<p class="success">' . $error .
                            '</p>
				  </div>';
                    }
                }
                ?>

                <form class='post' method='post'>

                    <span class="label label-default">Title</span><br/>
                    <input type='text' name='post_title' value='<?php if (isset($error)) {
                        echo $_POST['post_title'];
                    } ?>'></p>

                    <span class="label label-default">Description</span><br/>
                    <textarea name='post_desc' cols='60' rows='10'><?php if (isset($error)) {
                            echo $_POST['post_desc'];
                        } ?></textarea></p>

                    <span class="label label-default">Content</span><br/>
                    <textarea name='post_cont' cols='60' rows='10'><?php if (isset($error)) {
                            echo $_POST['post_cont'];
                        } ?></textarea></p>

                    <span class="label label-default">Tags</span><br/>
                    <input type="text" name='post_tags' value='<?php if (isset($error)) {
                        echo $_POST['post_tags'];
                    } ?>'/></p>
                    <input class="btn btn-primary" type='submit' name='submit' value='Submit'>

                </form>

            </div>
        </div>
    </div>
</div>
