<?php

class User {
     public function getDob($dob) {
          $exploded_dob = explode('-', $dob);
          $day = $exploded_dob[2];
          $month = $exploded_dob[1];
          $year = $exploded_dob[0];

          $d_0num = ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29", "30", "31"];
          $d_num = ["1.", "2.", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29", "30", "31"];
          $pday = str_replace($d_0num, $d_num, $day);

          $m_num = array("01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12");
          $m_pol = array("Stycznia", "Lutego", "Marca", "Kwietnia", "Maja", "Czerwca", "Lipca", "Sierpnia", "Września", "Października", "Listopada", "Grudnia");
          $pmonth = str_replace($m_num, $m_pol, $month);

          echo $pday . " ". $pmonth . " " . $year;
     }
}
