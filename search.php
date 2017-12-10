<?php
require_once('./app/autoload.php');

if (isset($_GET['q'])) {
     $pdo = new PDO('mysql:host=127.0.0.1;dbname=yt-social;charset=utf8mb4', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8mb4'"));

     $query = $_GET['q'];
     $querye = explode(" ", $query);

     $x = 0;
     $construct = "";
     $params = array();

     foreach ($querye as $term) {
          $x++;
          if ($x == 1) {
               $construct .= "user_full_name LIKE CONCAT('%',:search$x,'%') OR user_firstname LIKE CONCAT('%',:search$x,'%') OR user_lastname LIKE CONCAT('%',:search$x,'%') OR user_email LIKE CONCAT('%',:search$x,'%') OR user_phone LIKE CONCAT('%',:search$x,'%')";
          }else {
               $construct .= " AND user_full_name LIKE CONCAT('%',:search$x,'%') OR user_firstname LIKE CONCAT('%',:search$x,'%') OR user_lastname LIKE CONCAT('%',:search$x,'%') OR user_email LIKE CONCAT('%',:search$x,'%') OR user_phone LIKE CONCAT('%',:search$x,'%')";
          }
          $params["search$x"] = $term;
     }

     $results = $pdo->prepare("SELECT * FROM users WHERE $construct");
     $results->execute($params);

     if ($results->rowCount() == 0) {
          echo "0 results found <hr>";
     }else {
          echo $results->rowCount() . " results found <br>";
     }
     foreach ($results->fetchAll() as $result) {
          echo "<a href='profile/" . $result['user_user_id'] . "'>" . $result['user_full_name'] . "</a><br>";
     }
}
