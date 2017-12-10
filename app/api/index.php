<?php

function __autoload($class_name) {
     require_once('../classes/' . $class_name . '.php');
}

if (isset($_POST['postid'])) {
     Comment::createComment($_POST['commentBody'], Auth::loggedin(), $_POST['postid']);
     $postid = $_POST['postid'];
     $post = DB::query('SELECT * FROM posts, users WHERE posts_id=:postid AND user_user_id=posts_userid AND posts_privacy=2', [':postid'=>$postid])[0];
     ?>
     <a href="<?= $_SERVER['HTTP_REFERER']; ?>"><– wróć</a>
     <div>
          <h2><?= $post['user_full_name']; ?></h2>
          <p><?= $post['posts_date']; ?></p>
          <hr>
          <?= $post['posts_body']; ?>
          <hr>
          <p>likes: <b><?= $post['posts_likes']; ?></b></p>
          <p>comments: <b><?= $post['posts_comments']; ?></b></p>
          <hr><hr>
     </div>
     <?php if (Auth::loggedin()) { ?>
               <?= Auth::$error; ?>
               <div class="form">
                    <textarea name="body" rows="4" cols="50" id="commentbody"></textarea>
                    <input type="hidden" name="postid" value="<?= $post['posts_id']; ?>" id="postid">
                    <input type="submit" value="skomentuj" name="createComment" id="createComment">
               </div>
               <hr>
               <script>
               $("#createComment").click(function() {
                    var commentBody = $("#commentbody").val();
                    var postId = $("#postid").val();
                    $.post("../app/api/index.php", {
                         commentBody: commentBody,
                         postid: postId
                    }, function(data, status) {
                         $("#single-post-container").html(data);
                         $("#single-post-container").reset();
                    });
               });
               </script>
     <?php }
     Comment::displayComments($_POST['postid']);
}
