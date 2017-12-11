<?php
require_once('./../app/autoload.php');
Auth::guard();
if (isset($_GET['p'])) {
     $postid = $_GET['p'];
     if (!DB::query('SELECT posts_id FROM posts WHERE posts_userid=:userid AND posts_id=:postid', [':userid'=>Auth::loggedin(), ':postid'=>$postid])) {
          require_once("./../app/modules/guard-error.html");
          exit();
     }

     $post = DB::query('SELECT * FROM posts WHERE posts_userid=:userid AND posts_id=:postid', [':userid'=>Auth::loggedin(), ':postid'=>$postid])[0];

     if (isset($_POST['updatePost'])) {
          Post::updatePost($_POST['body'], Auth::loggedin(), $_POST['privacy'], $postid);
          if ($_POST['privacy'] == "2") {
               header("Location: ../posts/" . $postid);
               exit();
          }else {
               header("Location: ../profile/" . Auth::loggedin());
               exit();
          }

     }

?>
<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <meta http-equiv="X-UA-Compatible" content="ie=edge">
     <title>edytujesz post</title>
</head>
<body>
     <form action="" method="post">
          <?= Auth::$error; ?>
          <textarea name="body" rows="8" cols="80"><?= $post['posts_body']; ?></textarea>
          <select name="privacy">
               <?php if ($post['posts_privacy'] == "1") { ?>
                    <option value="1" selected>prywatny</option>
                    <option value="2">publiczny</option>
               <?php }else { ?>
                    <option value="1">prywatny</option>
                    <option value="2" selected>publiczny</option>
               <?php } ?>

          </select>
          <input type="submit" value="zaakceptuj zmiany" name="updatePost">
     </form>
</body>
</html>
<?php }else {
     require_once("./../app/modules/guard-error.html");
     exit();
} ?>
