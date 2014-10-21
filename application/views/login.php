<?php

$this->session->set_userdata('isLogin', 0);

$username = $this->input->post('username');
$password = $this->input->post('password');

if (!empty($username) && !empty($password)) {
    if ($username == 'studentdeng' && $password == '88888888') {
        $this->session->set_userdata('isLogin', 1);

        $url = base_url("/index.php/time/index");
        redirect($url, 'location', 301);

    } else {
        echo "login failed\n";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <?php $this->load->view('header'); ?>

    <link href = "/curer/assets/styles/bootstrap.min.css" rel = "stylesheet" >

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

    <form class="form-signin" role="form" action="" method="post">
        <h2 class="form-signin-heading">Please sign in</h2>
        <input name="username" type="" class="form-control" placeholder="username" required autofocus>
        <input name="password" type="password" class="form-control" placeholder="Password" required>

        <div class="checkbox">
            <label>
                <input type="checkbox" value="remember-me"> Remember me
            </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
    </form>
</div>
<!-- /container -->
</body>
</html>
