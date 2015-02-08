<?php
   /*
    * RELEASED AS GNU General Public License v3 (GPL-3)
    * http://www.gnu.org/licenses/quick-guide-gplv3.html
    *
    * Originally written by Tim R. Havens 2015-01-27 please track changes below
    *
    */
   include_once ('classes/Gps.class.inc');
   $gps = new Gps(0);
   $gps_conf = $gps->get_gps_config(0);

   $live_sat_arr = array();
   $fc_arr = array();

   if(file_exists($gps_conf->data_out_local)) {
      $fc_arr = array_reverse(array_slice(file($gps_conf->data_out_local),-1));

      foreach($fc_arr as $ls_row) {
         $lsr = trim($ls_row);
         $ls_arr = explode(",",$lsr);
         $lat_long_arr = explode(" ",$ls_arr[3]);
         $live_sat_arr["lat"] = doubleval($lat_long_arr[0]);
         $live_sat_arr["long"] = doubleval($lat_long_arr[1]);
         break;
      }
   }
   echo json_encode($live_sat_arr);
?>

