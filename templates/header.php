<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>FaaS - <?php echo isset($title) ? $title : ""; ?></title>
 
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js" integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.21.4/dist/bootstrap-table.min.css">
    <script src="https://unpkg.com/bootstrap-table@1.21.4/dist/bootstrap-table.min.js"></script>

    <link rel="stylesheet" type="text/css" href="./assets/themes/bootstrap.min-<?php echo $siteTheme; ?>.css">
    <link rel="stylesheet" href="./assets/style.css">

    <link rel="icon" href="./favicon.ico" type="image/x-icon">
  </head>
  <body>
    <main class="content">
      <div class="header">
        <h1 class="site-title">Own FaaS</h1>
        <nav>
          <ul>
            <?php foreach($navigation as $nav) : ?>
              <li <?php echo isset($nav["active"]) ? "class=\"active\"" : ""; ?>>
                <a href="index.php?action=<?php echo $nav["slug"];?>"><?php echo $nav["name"];?></a>
              </li>
            <?php endforeach; ?>
          </ul>
        </nav>
      </div>
      <br /><br />
