<?php
//include config
require_once('../includes/config.php');

//if not logged in redirect to login page
if (!$user->checkIfLogged()) {
    header('Location: login.php');
}

//show message from add / edit page
if (isset($_GET['delpost'])) {

    $stmt = $dataBase->prepare('DELETE FROM db_posts WHERE post_id = :postID; DELETE FROM db_comments WHERE post_id = :postID');
    $stmt->execute(array(':postID' => $_GET['delpost']));

    header('Location: index.php?action=deleted');
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>

    <!--CSS Style sheet	-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
    <link href='styles/bootstrap-responsive.css' rel='stylesheet'>
    <link href='styles/index.css' type='text/css' rel="stylesheet">

    <!--JavaScript-->
    <script language="JavaScript" type="text/javascript">
        function delpost(id, title) {
            if (confirm("Are you sure you want to delete '" + title + "'")) {
                window.location.href = 'index.php?delpost=' + id;
            }
        }
    </script>
</head>
<body>

<div id="wrapper">
    <div class="content">

        <?php include('menu.php'); ?>

        <?php
        //show message from add / edit page
        if (isset($_GET['action'])) {
            echo '<div class="alert alert-success" role="alert">
				<p class="success">Success! Post ' . $_GET['action'] .
                '.</p>
			  </div>';
        }
        ?>
        <div class="right">
            <div class="panel panel-primary">
                <div class="panel-heading">Blog</div>
                <table data-toggle="table" data-url="data1.json" data-cache="false" data-height="299" class="table">
                    <thead>
                    <tr>
                        <td class="titles">Title</td>
                        <td class="titles">Date</td>
                        <td class="titles">Action</td>
                    </tr>
                    </thead>
                    <tbody>

                    <?php
                    try {

                        $stmt = $dataBase->query('SELECT post_id, post_title, post_date FROM db_posts ORDER BY post_id DESC');
                        while ($row = $stmt->fetch()) {

                            echo '<tr>';
                            echo '<td class="desc">' . $row['post_title'] . '</td>';
                            echo '<td class="desc">' . date('jS M Y', strtotime($row['post_date'])) . '</td>';
                            ?>

                            <td class="desc">
                                <span class="glyphicon glyphicon-edit"></span>
                                <a href="editpost.php?id=<?php echo $row['post_id'];?>">Edit</a>
                                <span> | </span>
                                <span class="glyphicon glyphicon-remove"></span>
                                <a href="javascript:delpost('<?php echo $row['post_id'];?>','<?php echo $row['post_title'];?>')">Delete</a>
                            </td>

                            <?php
                            echo '</tr>';

                        }

                    } catch (PDOException $e) {
                        echo $e->getMessage();
                    }
                    ?>

                    </tbody>
                </table>
            </div>

            <button type="button" class="btn btn-default">
                <a href='addpost.php' class="none">Add Post <span class="glyphicon glyphicon-plus"></span></a>
            </button>

        </div>
    </div>
</div>
</div>

</body>
</html>
