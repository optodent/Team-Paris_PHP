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
    <title>Admin - Add User</title>

    <!--CSS Style sheet	-->
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
                <div class="panel-heading">Add User</div>
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

                    if ($password == '') {
                        $error[] = 'Please enter the password.';
                    }

                    if ($passwordConfirm == '') {
                        $error[] = 'Please confirm the password.';
                    }

                    if ($password != $passwordConfirm) {
                        $error[] = 'Passwords do not match.';
                    }

                    if ($email == '') {
                        $error[] = 'Please enter the email address.';
                    }

                    if (!isset($error)) {

                        $hashedpassword = $user->password_hash($password, PASSWORD_BCRYPT);

                        try {

                            //insert into database
                            $stmt = $dataBase->prepare('INSERT INTO db_members (username,password,email) VALUES (:username, :password, :email)');
                            $stmt->execute(array(
                                ':username' => $username,
                                ':password' => $hashedpassword,
                                ':email' => $email
                            ));

                            //redirect to index page
                            header('Location: users.php?action=added');
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

                    <span class="label label-default">Username</span><br/>
                    <input type='text' name='username' value='<?php if (isset($error)) {
                        echo $_POST['username'];
                    } ?>'></p>

                    <span class="label label-default">Password</span><br/>
                    <input type='password' name='password' value='<?php if (isset($error)) {
                        echo $_POST['password'];
                    } ?>'></p>

                    <span class="label label-default">Confirm Password</span><br/>
                    <input type='password' name='passwordConfirm' value='<?php if (isset($error)) {
                        echo $_POST['passwordConfirm'];
                    } ?>'></p>

                    <span class="label label-default">Email</span><br/>
                    <input type='text' name='email' value='<?php if (isset($error)) {
                        echo $_POST['email'];
                    } ?>'></p>

                    <input class="btn btn-primary" type='submit' name='submit' value='Add User'>

                </form>

            </div>
        </div>
    </div>
</div>