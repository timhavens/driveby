<?php
/*
 * RELEASED AS GNU General Public License v3 (GPL-3)
 * http://www.gnu.org/licenses/quick-guide-gplv3.html
 *
 * Originally written by Tim R. Havens 2015-01-27 please track changes below
 *
 */
   $live_sat_arr = array();
   $fc_arr = array();

   if(file_exists('/disk1/driveby_data/gps_az_el.out')) {
      $fc_arr = array_reverse(array_slice(file('/disk1/driveby_data/gps_az_el.out'),-20));

      foreach($fc_arr as $ls_row) {
         $lsr = trim($ls_row);
         $ls_arr = explode(",",$lsr);
         if(isset($live_sat_arr[$ls_arr[0]])) { continue; }

         $live_sat_arr[] = $ls_arr;
      }
   }
   echo json_encode($live_sat_arr);
?>


