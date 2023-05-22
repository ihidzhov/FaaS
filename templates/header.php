<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Lambda - <?php echo isset($title) ? $title : ""; ?></title>
    <link rel="stylesheet" type="text/css" href="./assets/bootstrap.min-6.css">
    <link rel="stylesheet" href="./assets/style.css">

    <script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js" integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.21.4/dist/bootstrap-table.min.css">
    <script src="https://unpkg.com/bootstrap-table@1.21.4/dist/bootstrap-table.min.js"></script>


    <link rel="icon" href="./favicon.ico" type="image/x-icon">
  </head>
  <body>
    <main class="content">
      <h1 class="site-title">FaaS (Lambda / Cloud Functions)</h1>
      <nav>
        <ul>
          <li><a href="index.php?action=dashboard">Dashboard</a></li>
          <li><a href="index.php?action=funcs">Functions</a></li>
          <li><a href="index.php?action=logs">Logs</a></li>
          <li><a href="index.php?action=config">Config</a></li>
          <li><a href="index.php?action=settings">User settings</a></li>
          <li><a href="index.php?action=docs">Docs</a></li>
        </ul>
      </nav>
