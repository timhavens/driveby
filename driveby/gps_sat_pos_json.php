<?php
/*
 * RELEASED AS GNU General Public License v3 (GPL-3)
 * http://www.gnu.org/licenses/quick-guide-gplv3.html
 *
 * Originally written by Tim R. Havens 2015-01-27 please track changes below
 *
 */
   $all_data_set_xml = "";
   $tmp_sat_data_arr = array();
   $sat_data_arr = array();
   $deg_arr = range(360,0,1);
   $live_sat_arr = array();

   if(file_exists('/disk1/driveby_data/gps_az_el.out')) {
      $fc_arr = file('/disk1/driveby_data/gps_az_el.out');
      $live_sat_arr = array_slice($fc_arr, -20);
      foreach($live_sat_arr as $ls_row) {
         $lsr = trim($ls_row);
         $ls_arr = explode(",",$lsr);
         $live_sat_arr[$ls_arr[0]] = $ls_arr[0];
      }

      foreach($fc_arr as $row) {
         $r = trim($row);
         $r_arr = explode(",",$r);
         if(!isset($live_sat_arr[$r_arr[0]])) { continue; }
         $tmp_sat_data_arr["{$r_arr[0]}"]["{$r_arr[1]}"][] = $r_arr[2];
      }
      foreach($tmp_sat_data_arr as $sat_key => $az_arr) {
         foreach($az_arr as $sat_az => $el_arr) {
            $avg_el = round((array_sum($el_arr)/count($el_arr)));
            //$rev_el_for_graphing = (90 - $avg_el);
            $sat_data_arr[$sat_key][]=array('az'=>intval($sat_az),'el'=>intval($avg_el));
         }
      }
   }

   //echo json_encode($sat_data_arr[2]);
   echo json_encode($sat_data_arr);
?>