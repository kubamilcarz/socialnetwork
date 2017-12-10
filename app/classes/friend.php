<?php

class Friend {

     # status = 1 => pending (wysłane)
     # status = 2 => accepted (zaakceptowane)
     # status = 3 => canceled (anulowane)
     # status = 4 => friends (znajomi)
     # status = 5 => invisible (niewidoczny)

     public function sendFriendRequest($userid, $friendid) {
          if ($userid != $friendid) {
               if (!DB::query('SELECT friends_friendid FROM friends WHERE friends_userid=:userid AND friends_friendid=:friendid', [':userid'=>$userid, ':friendid'=>$friendid])) {
                    DB::query('INSERT INTO friends VALUES (\'\', :userid, :friendid, 1, NOW())', [':userid'=>$userid, ':friendid'=>$friendid]);

                    # add to notifications

               } else {Auth::$error = "Już się przyjaźnicie!";}
          }
     }

     public function cancelSendedFriendRequest($userid, $friendid) {
          if ($userid != $friendid) {
               if (DB::query('SELECT friends_status FROM friends WHERE friends_userid=:userid AND friends_friendid=:friendid', [':userid'=>$userid, ':friendid'=>$friendid]) == "1") {
                    echo "we can delete";
               }
               DB::query('DELETE FROM friends WHERE friends_userid=:userid AND friends_friendid=:friendid', [':userid'=>$userid, ':friendid'=>$friendid]);

                    # add to notifications

          }
     }
}
