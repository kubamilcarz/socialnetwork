<?php

function __autoload($class_name) {
     require_once('../classes/' . $class_name . '.php');
}

if (isset($_POST['squery'])) {
     $pdo = new PDO('mysql:host=127.0.0.1;dbname=yt-social;charset=utf8mb4', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8mb4'"));

     $query = $_POST['squery'];
     $querye = explode(" ", $query);

     $x = 0;
     $construct = "";
     $params = array();

     foreach ($querye as $term) {
          $x++;
          if ($x == 1) {
               $construct .= "user_full_name LIKE CONCAT('%',:search$x,'%') OR user_firstname LIKE CONCAT('%',:search$x,'%') OR user_lastname LIKE CONCAT('%',:search$x,'%') OR user_email LIKE CONCAT('%',:search$x,'%')";
          }else {
               $construct .= " AND user_full_name LIKE CONCAT('%',:search$x,'%') OR user_firstname LIKE CONCAT('%',:search$x,'%') OR user_lastname LIKE CONCAT('%',:search$x,'%') OR user_email LIKE CONCAT('%',:search$x,'%')";
          }
          $params["search$x"] = $term;
     }

     $results = $pdo->prepare("SELECT * FROM users WHERE $construct");
     $results->execute($params);
     ?>

     <a class="btn" href="/social-network/">Pokaż wyniki na oddzielnej stronie</a>
     <div class="grid"><?php
          // if ($results->rowCount() == 0) {
          //      echo "0 results found <hr>";
          // }else {
          //      echo $results->rowCount() . " results found <br>";
          // }
          foreach ($results->fetchAll() as $result) { ?>
               <div class="user">
                    <img src="<?= $result['user_profile_picture']; ?>"/>
                    <div class="about">
                         <h2 class="name"><?= $result['user_full_name']; ?></h2>
                         <div class="info">
                              <a class="btn btn-follow" href="/social-network/profile/<?= $result['user_user_id']; ?>">Odwiedź profil</a>
                              <a class="btn btn-send-message" href=""><i class="fa fa-comment"></i>Wyślij wiadomość</a>
                         </div>
                    </div>
               </div>
          <?php } ?>
     </div><?php

}
