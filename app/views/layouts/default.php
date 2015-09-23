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
                margin-right: 10px;
            }
            .alert {
                width: 360px;
                margin-top: 30px;
            }
            .well {
                background-color: rgba(255, 255, 255, 0.2);
            }
            .btn {
                margin-right: 15px;
                margin-top: 5px;
            }
            .nav {
                margin-top: 10px;
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
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="<?php
                            char_to_html(url('thread/create')) ?>">
                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                            Create Thread
                        </a></li>
                        <li><a href="<?php
                            char_to_html(url('thread/search_thread')) ?>">
                            <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                            Search For a Thread
                        </a></li>
                        <li><div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
                            <span class="glyphicon glyphicon-user"></span>
                            <?php char_to_html($_SESSION['username']) ?>
                            <span class="caret"></span></button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="<?php char_to_html(url('thread/index')) ?>">
                                    <i class="glyphicon glyphicon-th-list"></i> Thread List</a>
                                </li>
                                <li role="separator" class="divider"></li>
                                <li>
                                    <a href="<?php char_to_html(url('user/profile')) ?>">
                                    <i class="glyphicon glyphicon-user"></i> Profile</a>
                                </li>
                                <li role="separator" class="divider"></li>
                                <li>
                                    <a href="<?php char_to_html(url('user/log_out')) ?>">
                                    <i class="glyphicon glyphicon-log-out"></i> Sign-Out</a>
                                </li>
                            </ul>
                        </div></li>
                    </ul>
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