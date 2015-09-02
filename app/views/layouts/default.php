<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>DietCake</title>

    <link href="/bootstrap/css/bootstrap.css" rel="stylesheet">
    <style>
      body {
        padding-top: 60px;
      }
    </style>
  </head>

  <body>

    <nav class="navbar navbar-default navbar-fixed-top">
    <ul class="nav nav-pills">
    <li role="presentation" class="active"><a href="http://10.3.140.112">Home</a></li>
    </ul>
    </nav>
    <div class="container">

      <?php echo $_content_ ?>

    </div>

    <script>
    console.log(<?php eh(round(microtime(true) - TIME_START, 3)) ?> + 'sec');
    </script>

  </body>
</html>
