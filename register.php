<?php
require_once('./app/autoload.php');

if (isset($_POST['register'])) {
     Auth::register($_POST['fname'], $_POST['lname'], $_POST['email'], $_POST['uname'], $_POST['pass'], $_POST['rpass'], $_POST['birthD'], $_POST['birthM'], $_POST['birthY'], $_POST['sex']);
}

?>
<!DOCTYPE html>
<html lang="<?= init::$app_lang; ?>">
<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <meta http-equiv="X-UA-Compatible" content="ie=edge">
     <title>register | <?= init::$app_name; ?></title>

     <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
     <?php echo Auth::$error; ?>
     <form action="register.php" method="post">
          <div class="row">
               <input type="text" name="fname" placeholder="Imię">
               <input type="text" name="lname" placeholder="Nazwisko">
          </div>
          <input type="email" name="email" placeholder="Adres email">
          <input type="text" name="uname" placeholder="Username">
          <div class="row">
               <input type="password" name="pass" placeholder="Hasło">
               <input type="password" name="rpass" placeholder="Powtórz hasło">
          </div>
          <div class="row">
               <select name="birthD">
                    <?php
                         $days = ["day", 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31];
                         for ($i = 0; $i < count($days); $i++) {
                              if ($i == 0) {echo "<option value=''>" . $days[$i] . "</option>";} else {
                                   echo "<option value='" . $days[$i] . "'>" . $days[$i] . "</option>";
                              }

                         }
                    ?>
               </select>
               <select name="birthM">
                    <option value="">month</option>
                    <option value="1">January</option>
                    <option value="2">February</option>
                    <option value="3">March</option>
                    <option value="4">April</option>
                    <option value="5">May</option>
                    <option value="6">June</option>
                    <option value="7">July</option>
                    <option value="8">August</option>
                    <option value="9">September</option>
                    <option value="10">October</option>
                    <option value="11">November</option>
                    <option value="12">December</option>
               </select>
               <select name="birthY">
                    <?php
                         $years = ["year", 1930, 1931, 1932, 1933, 1934, 1935, 1936, 1937, 1938, 1939, 1940, 1941, 1942, 1943, 1944, 1945, 1946, 1947, 1948, 1949,
                              1950, 1951, 1952, 1953, 1954, 1955, 1956, 1957, 1958, 1959, 1960, 1961, 1962, 1963, 1964, 1965, 1966, 1967, 1968, 1969,
                              1970, 1971, 1972, 1973, 1974, 1975, 1976, 1977, 1978, 1979, 1980, 1981, 1982, 1983, 1984, 1985, 1986, 1987, 1988, 1989,
                              1990, 1991, 1992, 1993, 1994, 1995, 1996, 1997, 1998, 1999, 2000, 2001, 2002, 2003, 2004, 2005, 2006, 2007, 2008, 2009, 2010, 2011, 2012, 2013, 2014, 2015];
                         for ($i = 0; $i < count($years); $i++) {
                              if ($i == 0) {echo "<option value=''>" . $years[$i] . "</option>";}else {
                                   echo "<option value='" . $years[$i] . "'>" . $years[$i] . "</option>";
                              }

                         }
                    ?>
               </select>
          </div>
          <select name="sex">
               <option value="">sex</option>
               <option value="m">male</option>
               <option value="f">female</option>
               <option value="o">inna</option>
          </select>
          <input type="submit" name="register" value="zarejestruj się">
     </form>

     <script src="assets/js/juery.js"></script>
     <script src="assets/js/functions.js"></script>
</body>
</html>
