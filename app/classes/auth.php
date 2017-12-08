<?php

class Auth {
     public $system_login_with_email_or_username = true;

     public function logout() {
          DB::query('DELETE FROM login_tokens WHERE user_id=:userid', array(':userid'=>self::loggedin()));
          setcookie("" . DB::$system_cookie_name . "", '1', time()-3600);
          setcookie("" . DB::$system_cookie_name . "_", '1', time()-3600);
          header('Location: '.$_SERVER['PHP_SELF']);
     }

     public function loggedin() {
          if (isset($_COOKIE['' . DB::$system_cookie_name . ''])) {
               if (DB::query('SELECT user_id FROM login_tokens WHERE token=:token', array(':token'=>sha1($_COOKIE['' . DB::$system_cookie_name . ''])))) {
                    $userid = DB::query('SELECT user_id FROM login_tokens WHERE token=:token', array(':token'=>sha1($_COOKIE['' . DB::$system_cookie_name . ''])))[0]['user_id'];
                    if (isset($_COOKIE['' . DB::$system_cookie_name . '_'])) {
                         return $userid;
                    } else {
                         $cstrong = True;
                         $token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
                         DB::query('INSERT INTO login_tokens VALUES (\'\', :token, :user_id)', array(':token'=>sha1($token), ':user_id'=>$userid));
                         DB::query('DELETE FROM login_tokens WHERE token=:token', array(':token'=>sha1($_COOKIE["" . DB::$system_cookie_name . ""])));
                         setcookie("" . DB::$system_cookie_name . "", $token, time() + 60 * 60 * 24 * 30, '/', NULL, NULL, TRUE);
                         setcookie("" . DB::$system_cookie_name . "_", '1', time() + 60 * 60 * 24 * 3, '/', NULL, NULL, TRUE);
                         return $userid;
                    }
               }
          }
          return false;
     }

}

?>
