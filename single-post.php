<?php
require_once('./app/autoload.php');

$postid = $_GET['p'];

if (!DB::query('SELECT * FROM posts, users WHERE posts_id=:postid AND user_user_id=posts_userid AND posts_privacy=2', [':postid'=>$postid])){
     require_once('app/modules/404.html');
     exit();
}

$post = DB::query('SELECT * FROM posts, users WHERE posts_id=:postid AND user_user_id=posts_userid AND posts_privacy=2', [':postid'=>$postid])[0];

if (isset($_POST['deletePost'])) {
     Post::deletePost($postid);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <meta http-equiv="X-UA-Compatible" content="ie=edge">
     <script src="../assets/js/jquery.js"></script>
     <title><?= substr($post['posts_body'], 0, 52) . "..."; ?></title>
</head>
<body id="single-post-container">
     <?php require_once("app/modules/ajax/single-post.php"); ?>
</body>
</html>
