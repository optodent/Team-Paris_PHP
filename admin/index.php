<?php
//include config
require_once('../includes/config.php');

//if not logged in redirect to login page
if(!$user->checkIfLogged()){ header('Location: login.php'); }

//show message from add / edit page
if(isset($_GET['delpost'])){ 

	$stmt = $dataBase->prepare('DELETE FROM db_posts WHERE post_id = :postID') ;
	$stmt->execute(array(':postID' => $_GET['delpost']));

	header('Location: index.php?action=deleted');
	exit;
} 

?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Admin</title>
  <script language="JavaScript" type="text/javascript">
  function delpost(id, title)
  {
	  if (confirm("Are you sure you want to delete '" + title + "'"))
	  {
	  	window.location.href = 'index.php?delpost=' + id;
	  }
  }
  </script>
</head>
<body>

	<div id="wrapper">

	<?php include('menu.php');?>

	<?php 
	//show message from add / edit page
	if(isset($_GET['action'])){ 
		echo '<h3>Post '.$_GET['action'].'.</h3>'; 
	} 
	?>

	<table>
	<tr>
		<th>Title</th>
		<th>Date</th>
		<th>Action</th>
	</tr>
	<?php
		try {

			$stmt = $dataBase->query('SELECT post_id, post_title, post_date FROM db_posts ORDER BY post_id DESC');
			while($row = $stmt->fetch()){
				
				echo '<tr>';
				echo '<td>'.$row['post_title'].'</td>';
				echo '<td>'.date('jS M Y', strtotime($row['post_date'])).'</td>';
				?>

				<td>
					<a href="editpost.php?id=<?php echo $row['post_id'];?>">Edit</a> |
					<a href="javascript:delpost('<?php echo $row['post_id'];?>','<?php echo $row['post_title'];?>')">Delete</a>
				</td>
				
				<?php 
				echo '</tr>';

			}

		} catch(PDOException $e) {
		    echo $e->getMessage();
		}
	?>
	</table>

	<p><a href='addpost.php'>Add Post</a></p>

</div>

</body>
</html>
