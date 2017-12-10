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

          <?php
               # timeline
               if (!DB::query('SELECT friends_friendid FROM friends, users WHERE user_user_id=friends_userid OR user_user_id=friends_friendid AND friends_status=1')) {
                    $posts = DB::query('SELECT * FROM posts, users WHERE posts_userid=user_user_id AND user_user_id=:userid ORDER BY posts_id DESC', [':userid'=>Auth::loggedin()]);
                    foreach ($posts as $post) {
                         echo '<a href="post/' . $post['posts_id'] .'">' . $post['user_full_name'] . " ~ " . $post['posts_body'] . " (" . $post['posts_date'] . ") " . "<br><hr>" . '</a>';
                    }
               }else {
                    $posts = DB::query('SELECT * FROM posts, users, friends WHERE user_user_id=posts_userid AND posts_privacy=2 AND friends_status=4 AND (user_user_id=friends_userid OR user_user_id=friends_friendid) ORDER BY posts_id DESC');
                    foreach ($posts as $post) {
                         echo '<a href="post/' . $post['posts_id'] .'">' . $post['user_full_name'] . " ~ " . $post['posts_body'] . " (" . $post['posts_date'] . ") " . "<br><hr>" . '</a>';
                    }
               }

          ?>

     <?php } ?>
     <script src="assets/js/juery.js"></script>
     <script src="assets/js/functions.js"></script>
</body>
</html>
