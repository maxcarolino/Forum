<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>DietCake - Board Exercise</title>
        
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script src="/bootstrap/js/bootstrap.js"></script>
        <link href="/bootstrap/css/bootstrap.css" rel="stylesheet">
        <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
        <style>
            body {
                padding-top: 60px;
                font-family: 'Open Sans', sans-serif;
                background-image: url(/bootstrap/img/green_background.jpg);
                background-repeat: no-repeat;
                min-height: 100%;
                background-size: cover;
            }
            .navbar-right {
                margin-right: 50px;
            }
            .alert {
                width: 360px;
                margin-top: 30px;
            }
            .well {
                background-color: rgba(255, 255, 255, 0.2);
            }
            .btn {
                margin-top: 15px;
                margin-right: 15px;
            }
        </style>
    </head>

    <body>
        <nav class="navbar navbar-default navbar-fixed-top">
           <div class="container-fluid">
                <div class ="navbar-header">
                    <h2>Board Exercise</h2>
                </div>
                <?php if (isset($_SESSION['username'])): ?>
                    <div class="nav pull-right">
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
                            <span class="glyphicon glyphicon-user"></span>
                            <?php char_to_html($_SESSION['username']) ?>
                            <span class="caret"></span></button>
                            <ul class="dropdown-menu">
                                <li><a href="<?php char_to_html(url('thread/index')) ?>">Thread List</a></li>
                                <li><a href="<?php char_to_html(url('user/profile')) ?>">Profile</a></li>
                                <li><a href="<?php char_to_html(url('user/log_out')) ?>">Sign-Out</a></li>
                            </ul>
                        </div>
                    </div>
                <?php endif ?>
           </div>
        </nav>

        <div class="container">
            <?php echo $_content_ ?>
        </div>

        <script>
        console.log(<?php char_to_html(round(microtime(true) - TIME_START, 3)) ?> + 'sec');
        </script>
    </body>
</html>