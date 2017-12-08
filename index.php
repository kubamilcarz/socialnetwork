<?php require_once('./app/autoload.php'); ?>
<!DOCTYPE html>
<html lang="<?= init::$app_lang; ?>">
<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <meta http-equiv="X-UA-Compatible" content="ie=edge">
     <title>start | <?= init::$app_name; ?></title>

     <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
     <?php if (Auth::loggedin()) { ?>
          <form action="" method="post"><input type="submit" name="logoutbtn" value="wyloguj się"></form>
     <?php } ?>
     <script src="assets/js/juery.js"></script>
     <script src="assets/js/functions.js"></script>
</body>
</html>
