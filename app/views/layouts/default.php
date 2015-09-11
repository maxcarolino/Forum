<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>DietCake - Board Exercise</title>

        <link href="/bootstrap/css/bootstrap.css" rel="stylesheet">
        <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
        <style>
            body {
                padding-top: 60px;
                font-family: 'Open Sans', sans-serif;
                background-image: url(/bootstrap/img/blue_background.jpg);
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
                background-color: rgba(255, 255, 255, 0.2);
            }
            .well {
                background-color: rgba(255, 255, 255, 0.2);
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
                    <a class="btn btn-warning navbar-right" href="<?php char_to_html(url('user/log_out')) ?>">
                        <span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>
                        Sign-Out
                    </a>
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