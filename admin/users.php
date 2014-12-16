<?php
//include config
require_once('../includes/config.php');

//if not logged in redirect to login page
if (!$user->checkIfLogged()) {
    header('Location: login.php');
}

//show message from add / edit page
if (isset($_GET['deluser'])) {

    //if user id is 1 ignore
    if ($_GET['deluser'] != '1') {

        $stmt = $dataBase->prepare('DELETE FROM db_members WHERE member_id = :memberID');
        $stmt->execute(array(':memberID' => $_GET['deluser']));

        header('Location: users.php?action=deleted');
        exit;

    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Users</title>

    <!--CSS Style sheet	-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
    <link href='styles/bootstrap-responsive.css' rel='stylesheet'>
    <link href='styles/index.css' type='text/css' rel="stylesheet">

    <!--JavaScript-->
    <script language="JavaScript" type="text/javascript">
        function deluser(id, title) {
            if (confirm("Are you sure you want to delete '" + title + "'")) {
                window.location.href = 'users.php?deluser=' + id;
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
				<p class="success">Success! User ' . $_GET['action'] .
                '.</p>
			  </div>';
        }
        ?>

        <div class="right">
            <div class="panel panel-primary">
                <div class="panel-heading">Users</div>
                <table data-toggle="table" data-url="data1.json" data-cache="false" data-height="299" class="table">
                    <thead>
                    <tr>
                        <td class="titles">Username</td>
                        <td class="titles">Email</td>
                        <td class="titles">Action</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    try {

                        $stmt = $dataBase->query('SELECT member_id, username, email FROM db_members ORDER BY username');
                        while ($row = $stmt->fetch()) {

                            echo '<tr>';
                            echo '<td class="desc">' . $row['username'] . '</td>';
                            echo '<td class="desc">' . $row['email'] . '</td>';
                            ?>

                            <td class="desc">
                                <span class="glyphicon glyphicon-edit"></span>
                                <a href="edituser.php?id=<?php echo $row['member_id']; ?>">Edit</a>
                                <?php if ($row['member_id'] != 1) { ?>
                                    <span> | </span>
                                    <span class="glyphicon glyphicon-remove"></span>
                                    <a href="javascript:deluser('<?php echo $row['member_id']; ?>','<?php echo $row['username']; ?>')">Delete</a>
                                <?php } ?>
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
                <a href='adduser.php' class="none">Add User <span class="glyphicon glyphicon-plus"></span></a>
            </button>

        </div>

</body>
</html>
