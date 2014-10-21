<?php

session_start();

$_SESSION["login"] = FALSE;

if (!empty($_POST['username']) && !empty($_POST['password'])) {
  if ($_POST['username'] == 'studentdeng' && $_POST['password'] == '88888888') {
    $_SESSION["login"] = TRUE;

    header('Location: index.php');
  }
  else {
    echo "login failed\n";
  }
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Sign in &middot; Twitter Bootstrap</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="/curer/cola/assets/styles/jquery-ui-1.8.16.custom.css?version=103" rel="stylesheet" />
    <link href="/curer/cola/assets/styles/style.css?version=103" rel="stylesheet" />
    <link href="/curer/cola/assets/styles/lightbox.css?version=103" rel="stylesheet" />

    <link href="/curer/cola/assets/styles/bootstrap.min.css" rel="stylesheet">

    <style type="text/css">
      body {
  padding-top: 40px;
  padding-bottom: 40px;
  background-color: #eee;
}

.form-signin {
  max-width: 330px;
  padding: 15px;
  margin: 0 auto;
}
.form-signin .form-signin-heading,
.form-signin .checkbox {
  margin-bottom: 10px;
}
.form-signin .checkbox {
  font-weight: normal;
}
.form-signin .form-control {
  position: relative;
  height: auto;
  -webkit-box-sizing: border-box;
     -moz-box-sizing: border-box;
          box-sizing: border-box;
  padding: 10px;
  font-size: 16px;
}
.form-signin .form-control:focus {
  z-index: 2;
}
.form-signin input[type="email"] {
  margin-bottom: -1px;
  border-bottom-right-radius: 0;
  border-bottom-left-radius: 0;
}
.form-signin input[type="password"] {
  margin-bottom: 10px;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
}

    </style>
  </head>

  <body>

    <div class="container">

      <form class="form-signin" role="form" action="login.php" method="post">
        <h2 class="form-signin-heading">Please sign in</h2>
        <input name="username" type="" class="form-control" placeholder="username" required autofocus>
        <input name = "password"type="password" class="form-control" placeholder="Password" required>
        <div class="checkbox">
          <label>
            <input type="checkbox" value="remember-me"> Remember me
          </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      </form>
    </div> <!-- /container -->
</body>
</html>