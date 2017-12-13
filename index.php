<?php require_once('./app/autoload.php'); ?>
<!DOCTYPE html>
<html lang="<?= init::$app_lang; ?>">
<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <meta http-equiv="X-UA-Compatible" content="ie=edge">
     <title>start | <?= init::$app_name; ?></title>

     <link rel="stylesheet" href="assets/css/main.css">
</head>
<body>
     <?php if (Auth::loggedin()) {
          require_once("app/modules/nav.php");
     }else {
          require_once("app/modules/nav-not-loggedin.php");
     } ?>
     <?php if (Auth::loggedin()) { ?>
          <form action="" method="post"><input type="submit" name="logoutbtn" value="wyloguj się"></form>

          <?php
               # timeline
               // $posts = DB::query('SELECT * FROM posts, users, friends WHERE user_user_id=posts_userid AND friends_status=4 AND posts_privacy=2 AND (friends_friendid=user_user_id OR friends_userid=user_user_id) ORDER BY posts_id DESC');
               // foreach ($posts as $post) {
               //      echo '<a href="posts/' . $post['posts_id'] .'">' . $post['user_full_name'] . " ~ " . $post['posts_body'] . " (" . $post['posts_date'] . ") " . "<br><hr>" . '</a>';
               // }

          ?>

     <?php } ?>
     <script src="assets/js/juery.js"></script>
     <script src="assets/js/functions.js"></script>
</body>
</html>
