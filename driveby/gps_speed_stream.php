<?php
/*
 * RELEASED AS GNU General Public License v3 (GPL-3)
 * http://www.gnu.org/licenses/quick-guide-gplv3.html
 *
 * Originally written by Tim R. Havens 2015-01-27 please track changes below
 *
 */
   $file = "/disk1/driveby_data/gps_data.out";

   if(file_exists($file)) {
      $file = escapeshellarg($file); // for the security concious (should be everyone!)
      $line = `tail -n 1 $file`;
      //3,1416324603,2014-11-18 15:30:03,37.859596667 -90.589985,833,0.005,278.83,0
      $data_gps_arr = explode(",",trim($line));
   } else {
      echo "&spd_dial=0";
      exit;
   }

   echo "&spd_dial=".round($data_gps_arr[5]);
?>