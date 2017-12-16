<?php

class Activity {

     # type = 0 => deleted/invisible
     # type = 1 => created post         (5)
     # type = 2 => liked post           (1)
     # type = 3 => created comment      (2)
     # type = 4 => liked comment        (1)


     public function addPoints($quantity, $type, $userid) {
          if (Auth::loggedin() == $userid) {
               $date = date('Y-m-d');

               DB::query('INSERT INTO activities VALUES (\'\', :type, :userid, :adate, :quantity)', [':type'=>$type, ':userid'=>$userid, ':adate'=>$date, ':quantity'=>$quantity]);

               $points = DB::query('SELECT user_points FROM users WHERE user_user_id=:userid', [':userid'=>$userid])[0]['user_points'];
               $pointsAfter = $points + $quantity;
               DB::query('UPDATE users SET user_points=:points WHERE user_user_id=:userid', [':points'=>$pointsAfter, ':userid'=>$userid]);

          }else {Auth::$error = "Błąd konta.";}
     }

     public function removePoints($quantity, $userid) {
          if (Auth::loggedin() == $userid) {
               DB::query('UPDATE activities SET activity_type=0');

               $points = DB::query('SELECT user_points FROM users WHERE user_user_id=:userid', [':userid'=>$userid])[0]['user_points'];
               $pointsAfter = $points - $quantity;
               DB::query('UPDATE users SET user_points=:points WHERE user_user_id=:userid', [':points'=>$pointsAfter, ':userid'=>$userid]);

          }else {Auth::$error = "Błąd konta.";}
     }

}
