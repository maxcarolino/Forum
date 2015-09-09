<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>DietCake</title>

    <link href="/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300' rel='stylesheet' type='text/css'>
    <style>
      body {
        padding-top: 60px;
        font-family: 'Open Sans', sans-serif;
      }
    </style>
  </head>

  <body>

    <nav class="navbar navbar-default navbar-fixed-top">
       <div class="container">
         <h3>Board Exercise</h3>
       </div>
    </nav>

    <div class="container">

      <?php echo $_content_ ?>

    </div>

    <script>
    console.log(<?php eh(round(microtime(true) - TIME_START, 3)) ?> + 'sec');
    </script>

  </body>
</html>
