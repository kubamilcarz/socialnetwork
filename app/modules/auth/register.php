<div id="auth-container">
     <div id="main-container">
          <div class="container">
               <div class="grid" id="register">
                    <div class="column hello">
                         <h1>Witaj na<br><span>Primus Connection</span></h1>
                         <p>Szukaj znajomych,<br>Czatuj z nimi, pisz posty oraz<br>dodawaj zdjęcia i twórz albumy!</p>
                    </div>
                    <div class="column form">
                         <h1>Utwórz nowe konto!</h1>
                         <form action="register.php" method="post">
                              <div class="row">
                                   <input type="text" name="fname" placeholder="Imię" class="marginer" autocomplete="off" data-type="text">
                                   <input type="text" name="lname" placeholder="Nazwisko" autocomplete="off" data-type="text">
                              </div>
                              <div class="row">
                                   <input type="email" name="email" placeholder="Adres email" autocomplete="off" data-type="text">
                              </div>
                              <div class="row">
                                   <input type="text" name="uname" placeholder="Username" autocomplete="off" data-type="text">
                              </div>
                              <div class="row">
                                   <select name="sex">
                                        <option value="">wybierz swoją płeć</option>
                                        <option value="m">male</option>
                                        <option value="f">female</option>
                                        <option value="o">inna</option>
                                   </select>
                              </div>
                              <div class="row">
                                   <input type="password" name="pass" placeholder="Hasło" autocomplete="off" data-type="password">
                              </div>
                              <div class="row">
                                   <select name="birthD" class="marginer">
                                        <?php
                                             $days = ["day", 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31];
                                             for ($i = 0; $i < count($days); $i++) {
                                                  if ($i == 0) {echo "<option value=''>" . $days[$i] . "</option>";} else {
                                                       echo "<option value='" . $days[$i] . "'>" . $days[$i] . "</option>";
                                                  }

                                             }
                                        ?>
                                   </select>
                                   <select name="birthM" class="marginer">
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
                              <div class="row">
                                   <button type="submit" name="registerbtn">Utwórz konto</button>
                              </div>
                         </form>
                    </div>
               </div>
          </div>
     </div>
</div>
