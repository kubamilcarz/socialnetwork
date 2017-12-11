<a href="<?= $_SERVER['HTTP_REFERER']; ?>"><– wróć</a>
<?php if ($post['posts_userid'] == Auth::loggedin()) {
     echo '<a href="../post/edit.php?p=' . $post['posts_id'] . '">edytuj</a>';
     ?>
     <form action="" method="post"><input type="submit" name="deletePost" value="usuń"></form>
     <?php
} ?>

<div>
     <h2><?= $post['user_full_name']; ?></h2>
     <p><?= $post['posts_date']; ?></p>
     <hr>
     <?= $post['posts_body']; ?>
     <hr>
</div>
     <?php if (Auth::loggedin()) { ?>
     <div>
          <p>

               likes: <b><?= $post['posts_likes']; ?></b>
               <?php if (!DB::query('SELECT post_likes_postid FROM post_likes WHERE post_likes_postid=:postid', [':postid'=>$postid])) { ?>
                    <span class="leave-like">
                         <input type="hidden" name="postid" value="<?= $post['posts_id']; ?>" id="Likepostid">
                         <input type="submit" value="Lubię to!" name="likePost" id="likePost">
                    </span>
               <?php }else { ?>
                    <span class="unlike">
                         <input type="hidden" name="likepostid" value="<?= $post['posts_id']; ?>" id="UnLikepostid">
                         <input type="submit" value="Nie Lubię to!" name="unlikePost" id="unlikePost">
                    </span>
               <?php } ?>
          </p>
          <p>comments: <b><?= $post['posts_comments']; ?></b></p>
          <hr>
     </div>

     <hr>

     <?= Auth::$error; ?><br>
     <div class="form">
          <textarea name="body" rows="4" cols="50" id="commentbody"></textarea>
          <input type="hidden" name="postid" value="<?= $post['posts_id']; ?>" id="Commentpostid">
          <input type="submit" value="skomentuj" name="createComment" id="createComment">
     </div>
     <hr>
     <script>
          $("#createComment").click(function() {
               var commentBody = $("#commentbody").val();
               var CpostId = $("#Commentpostid").val();
               $.post("./../app/api/post.php", {
                    commentBody: commentBody,
                    Cpostid: CpostId
               }, function(data, status) {
                    $("#single-post-container").html(data);
                    $("#single-post-container");
               });
          });

          <?php if (!DB::query('SELECT post_likes_postid FROM post_likes WHERE post_likes_postid=:postid', [':postid'=>$postid])) { ?>
               $("#likePost").click(function() {
                    var LpostId = $("#Likepostid").val();
                    $.post("./../app/api/post.php", {
                         likePostid: LpostId
                    }, function(data, status) {
                         $("#single-post-container").html(data);
                         $("#single-post-container");
                    });
               });
          <?php }else { ?>
               $("#unlikePost").click(function() {
                    var ULpostId = $("#UnLikepostid").val();
                    $.post("./../app/api/post.php", {
                         unlikePostid: ULpostId
                    }, function(data, status) {
                         $("#single-post-container").html(data);
                         $("#single-post-container");
                    });
               });
          <?php } ?>
     </script>
<?php }else { ?>
<div>
     <p>
          <?= Auth::$error; ?><br>
          likes: <b><?= $post['posts_likes']; ?></b>
     </p>
     <p>comments: <b><?= $post['posts_comments']; ?></b></p>
     <hr>
     </div>
<?php } ?>
<div id="comment-container"><?php Comment::displayComments($post['posts_id']); ?></div>
