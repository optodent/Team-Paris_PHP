<?php //include config
require_once('../includes/config.php');

//if not logged in redirect to login page
if (!$user->checkIfLogged()) {
    header('Location: login.php');
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Edit User</title>

    <!--CSS Style sheet-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
    <link href='styles/bootstrap-responsive.css' rel='stylesheet'>
    <link href='styles/index.css' type='text/css' rel="stylesheet">
</head>
<body>

<div id="wrapper">
    <div class="content">

        <?php include('menu.php'); ?>

        <div class="right">
            <div class="panel panel-primary">
                <div class="panel-heading">Edit User</div>
                <br/>

                <?php

                //if form has been submitted process it
                if (isset($_POST['submit'])) {

                    //collect form data
                    extract($_POST);

                    //very basic validation
                    if ($username == '') {
                        $error[] = 'Please enter the username.';
                    }

                    if (strlen($password) > 0) {

                        if ($password == '') {
                            $error[] = 'Please enter the password.';
                        }

                        if ($passwordConfirm == '') {
                            $error[] = 'Please confirm the password.';
                        }

                        if ($password != $passwordConfirm) {
                            $error[] = 'Passwords do not match.';
                        }

                    }


                    if ($email == '') {
                        $error[] = 'Please enter the email address.';
                    }

                    if (!isset($error)) {

                        try {

                            if (isset($password)) {

                                $hashedpassword = $user->password_hash($password, PASSWORD_BCRYPT);

                                //update into database
                                $stmt = $dataBase->prepare('UPDATE db_members SET username = :username, password = :password, email = :email WHERE member_id = :memberID');
                                $stmt->execute(array(
                                    ':username' => $username,
                                    ':password' => $hashedpassword,
                                    ':email' => $email,
                                    ':memberID' => $member_id
                                ));


                            } else {

                                //update database
                                $stmt = $dataBase->prepare('UPDATE db_members SET username = :username, email = :email WHERE member_id = :memberID');
                                $stmt->execute(array(
                                    ':username' => $username,
                                    ':email' => $email,
                                    ':memberID' => $member_id
                                ));

                            }


                            //redirect to index page
                            header('Location: users.php?action=updated');
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

                    $stmt = $dataBase->prepare('SELECT member_id, username, email FROM db_members WHERE member_id = :memberID');
                    $stmt->execute(array(':memberID' => $_GET['id']));
                    $row = $stmt->fetch();

                } catch (PDOException $e) {
                    echo $e->getMessage();
                }

                ?>

                <form class='post' action='' method='post'>
                    <input type='hidden' name='member_id' value='<?php echo $row['member_id']; ?>'>

                    <span class="label label-default">Username</span><br/>
                    <input type='text' name='username' value='<?php echo $row['username']; ?>'></p>

                    <span class="label label-default">Password (only to change)</span><br/>
                    <input type='password' name='password' value=''></p>

                    <span class="label label-default">Confirm Password</span><br/>
                    <input type='password' name='passwordConfirm' value=''></p>

                    <span class="label label-default">Email</span><br/>
                    <input type='text' name='email' value='<?php echo $row['email']; ?>'></p>

                    <input class="btn btn-primary" type='submit' name='submit' value='Update User'>

                </form>

            </div>
        </div>
    </div>
</div>

</body>
</html>	
