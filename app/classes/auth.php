<?php

class Auth {
     public $system_login_with_email_or_username = true;
     public static $error = "";

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

     public function guard() {
          if (!self::loggedin()) {
               header("Location: index.php");
               exit();
          }
     }

     # register

     public function register($fname, $lname, $email, $uname, $pass, $rpass, $birthD, $birthM, $birthY, $sex) {
          if (!empty($fname) && !empty($lname) && !empty($email) && !empty($uname) && !empty($pass) && !empty($rpass) && !empty($birthD) && !empty($birthM) && !empty($birthY) && !empty($sex)) {
               if (!DB::query('SELECT user_username FROM users WHERE user_username=:username', [':username'=>$uname])) {
                    // if (!DB::query('SELECT user_email FROM users WHERE user_email=:email', [':email'=>$email])) {
                    //
                    // }else {self::$error = "Użytkownik z takim email'em już istnieje!";}
                    if (strlen($fname) >= 2 && strlen($fname) <= 16) {
                    if (strlen($lname) >= 2 && strlen($lname) <= 16) {
                         if (strlen($uname) >= 3 && strlen($uname) <= 16) {
                         if (strlen($email) >= 6 && strlen($email) <= 128) {

                              if (preg_match('/[a-zA-Z]+/', $fname)) {
                              if (preg_match('/[a-zA-Z]+/', $lname)) {
                                   if (preg_match('/[a-zA-Z0-9]+/', $uname)) {
                                   if (strpos($email, '@') !== false) {

                                        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                        if (!DB::query('SELECT user_email FROM users WHERE user_email=:email', array(':email'=>$email))) {

                                             if (strlen($pass) >= 8 && strlen($pass) <= 64) {
                                             if (strlen($rpass) >= 8 && strlen($rpass) <= 64) {
                                             if ($pass === $rpass) {

                                                  if (preg_match('/[0-9]+/', $birthD) && preg_match('/[0-9]+/', $birthM) && preg_match('/[0-9]+/', $birthY)) {

                                                       if ($sex == "m" || $sex == "f" || $sex == "o") {

                                                            $fullname = $fname . " " . $lname;
                                                            $dobirth = $birthY . "-" . $birthM . "-" . $birthD;
                                                            $password = password_hash($pass, PASSWORD_BCRYPT);
                                                            $profileImg = "";
                                                            $backgroundImg = "";
                                                            self::$error = "ahahhahha";

                                                            DB::query('INSERT INTO users VALUES (\'\', :fullname, :firstname, :lastname, :username, :email, :password, \'\', :gender, :dob, \'\', :profileimg, :backgroundimg, 0, 0, 0)',
                                                            [':fullname'=>$fullname, ':firstname'=>$fname, ':lastname'=>$lname, ':username'=>$uname, ':email'=>$email, ':password'=>$password, ':gender'=>$sex, ':dob'=>$dobirth, ':profileimg'=>$profileImg, ':backgroundimg'=>$backgroundImg]);
                                                            Mail::sendMail('Witaj w Social Network!', 'Twoje konto zostało pomyślnie utworzone!', $email);
                                                            # self::login($email, $pass);

                                                       }else {self::$error = "Niepoprawna płeć!";}

                                                  }else {self::$error = "Data urodzenia może zawierać tylko cyfry!";}

                                             }else {self::$error = "Podane hasła nie są identyczne!";}
                                             }else {self::$error = "Niepoprawna długość pola 'powtórz hasło' (min: 8, max: 64)";}
                                             }else {self::$error = "Niepoprawna długość hasła (min: 8, max: 64)";}

                                        }else {self::$error = "Adres jest niepoprawny!";}
                                        }else {self::$error = "Podany adres email jest już zajęty!";}

                                   }else {self::$error = "Adres email musi zawierać znak @ (małpy)!";}
                                   }else {self::$error = "Nazwy użytkownika może zawierać tylko litery i cyfry!";}
                              }else {self::$error = "Nazwisko może zawierać tylko litery!";}
                              }else {self::$error = "Imię może zawierać tylko litery!";}

                         }else {self::$error = "Niepoprawna długość email'a (min: 6, max: 128)";}
                         }else {self::$error = "Niepoprawna długość nazwy użytkownika (min: 3, max: 16)";}
                    }else {self::$error = "Niepoprawna długość nazwiska (min: 2, max: 16)";}
                    }else {self::$error = "Niepoprawna długość imienia (min: 2, max: 16)";}

               }else {self::$error = "Podana użytkownik już istnieje!";}
          }else {self::$error = "Jedno lub kilka pól są puste!";}
     }

}

?>
