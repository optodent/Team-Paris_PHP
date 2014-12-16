<?php
//include config
require_once('../includes/config.php');

//check if already logged in
if ($user->checkIfLogged()) {
    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>

    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>Admin Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--include CSS Style Sheet-->
    <link href='styles/bootstrap.css' rel='stylesheet'>
    <link href='styles/bootstrap-responsive.css' rel='stylesheet'>
    <link href='styles/login.css' rel='stylesheet'>

</head>

<body>

<div class="container">

    <div id="login-wraper">

        <form class="form login-form">
            <legend>
                Login to <span class="blue">Admin Panel</span>
            </legend>

            <div class="body">
                <label>Username</label>
                <input type="text" name="username">

                <label>Password</label>
                <input type="password" name="password">

            </div>

            <div class="footer">
                <button type="submit" class="btn btn-primary" name="submit">
                    Login
                </button>
            </div>

        </form>

        <?php

        //process login form if submitted
        if (isset($_GET['submit'])) {

            $username = trim($_GET['username']);
            $password = trim($_GET['password']);

            if ($user->login($username, $password)) {

                //logged in return to index page
                header('Location: index.php');
                exit;


            } else {
                $message = '<div class="alert alert-danger" role="alert">
								<p class="error">
										Oops! Wrong username or password.
								</p>
							</div>';
            }

        }//end if submit

        if (isset($message)) {
            echo $message;
        }
        ?>

    </div>

</div>

</body>
</html>