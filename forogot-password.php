<?php require_once('./app/autoload.php'); ?>
<!DOCTYPE html>
<html lang="<?= init::$app_lang; ?>">
<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <meta http-equiv="X-UA-Compatible" content="ie=edge">
     <title>forgot password | <?= init::$app_name; ?></title>

     <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>

     <form action="forgot-password.php" method="post">
          <input type="email" name="email" placeholder="E-mail address">
          <input type="submit" name="send" value="send email">
     </form>

     <script src="assets/js/juery.js"></script>
     <script src="assets/js/functions.js"></script>
</body>
</html>
