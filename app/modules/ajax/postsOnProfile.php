<div class="posts">
     <?php
     if (isset($_GET['u'])) {
          echo Post::displayPostsOnProfile($_GET['u']);
     }else {
          echo Post::displayPostsOnProfile($profileID);
     }
      ?>
</div>
