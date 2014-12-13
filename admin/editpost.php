<?php //include config
require_once('../includes/config.php');

//if not logged in redirect to login page
if(!$user->checkIfLogged()){ header('Location: login.php'); }
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Admin - Edit Post</title>
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

	<?php include('menu.php');?>
	<p><a href="./">Blog Admin Index</a></p>

	<h2>Edit Post</h2>


	<?php

	//if form has been submitted process it
	if(isset($_POST['submit'])){

		$_POST = array_map( 'stripslashes', $_POST );

		//collect form data
		extract($_POST);

		//very basic validation
		if($post_id ==''){
			$error[] = 'This post is missing a valid id!.';
		}

		if($post_title ==''){
			$error[] = 'Please enter the title.';
		}

		if($post_desc ==''){
			$error[] = 'Please enter the description.';
		}

		if($post_cont ==''){
			$error[] = 'Please enter the content.';
		}

		if(!isset($error)){

			try {

				//insert into database
				$stmt = $dataBase->prepare('UPDATE db_posts SET post_title = :postTitle, post_desc = :postDesc, post_cont = :postCont, post_tags = :postTags WHERE post_id = :postID') ;
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

			} catch(PDOException $e) {
			    echo $e->getMessage();
			}
		}
	}

	?>

	<?php
	//check for any errors
	if(isset($error)){
		foreach($error as $error){
			echo $error.'<br />';
		}
	}

		try {

			$stmt = $dataBase->prepare('SELECT post_id, post_title, post_desc, post_cont, post_tags FROM db_posts WHERE post_id = :postID') ;
			$stmt->execute(array(':postID' => $_GET['id']));
			$row = $stmt->fetch(); 

		} catch(PDOException $e) {
		    echo $e->getMessage();
		}

	?>

	<form action='' method='post'>
		<input type='hidden' name='post_id' value='<?php echo $row['post_id'];?>'>

		<p><label>Title</label><br />
		<input type='text' name='post_title' value='<?php echo $row['post_title'];?>'></p>

		<p><label>Description</label><br />
		<textarea name='post_desc' cols='60' rows='10'><?php echo $row['post_desc'];?></textarea></p>

		<p><label>Content</label><br />
		<textarea name='post_cont' cols='60' rows='10'><?php echo $row['post_cont'];?></textarea></p>
        <p><label>Tags</label>
            <input type="text" name='post_tags' value='<?php echo $row['post_tags'];?>' /></p>
		<p><input type='submit' name='submit' value='Update'></p>

	</form>

</div>

</body>
</html>	
