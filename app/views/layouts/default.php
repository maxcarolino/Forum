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
