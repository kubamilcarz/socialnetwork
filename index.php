<?php require_once('./app/autoload.php'); ?>
<!DOCTYPE html>
<html lang="<?= init::$app_lang; ?>">
<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <meta http-equiv="X-UA-Compatible" content="ie=edge">
     <title><?= init::$app_name; ?></title>
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
     <link rel="stylesheet" href="/social-network/assets/css/main.css">
</head>
<body>
     <?php if (Auth::loggedin()) {
          require_once("app/modules/nav.php");
     }else {
          require_once("app/modules/nav-guest.php");
          require_once("app/modules/auth/register.php");
     } ?>
     <?php if (Auth::loggedin()) {
          require_once("app/modules/posts/timeline.php");
               # timeline
               // $posts = DB::query('SELECT * FROM posts, users, friends WHERE user_user_id=posts_userid AND friends_status=4 AND posts_privacy=2 AND (friends_friendid=user_user_id OR friends_userid=user_user_id) ORDER BY posts_id DESC');
               // foreach ($posts as $post) {
               //      echo '<a href="posts/' . $post['posts_id'] .'">' . $post['user_full_name'] . " ~ " . $post['posts_body'] . " (" . $post['posts_date'] . ") " . "<br><hr>" . '</a>';
               // }

          ?>

     <?php } ?>
     <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
     <script src="/social-network/assets/javascript/functions.js"></script>
</body>
</html>
