<?php
   /*
    * RELEASED AS GNU General Public License v3 (GPL-3)
    * http://www.gnu.org/licenses/quick-guide-gplv3.html
    *
    * Originally written by Tim R. Havens 2015-01-27 please track changes below
    *
    */
   include_once ('classes/Config.class.inc');
   $config = new Config();
   $localhost = $config->conf->http_gui_host;
   $remotehost = $config->conf->http_gui_remote;
   $gps_conf = $config->conf->gps[0];
   $live_sat_arr = array();

   $fc_arr = array();

   if(file_exists($gps_conf->dop_out)) {
      $fc_arr = array_reverse(array_slice(file($gps_conf->dop_out),-1));

      foreach($fc_arr as $ls_row) {
         $lsr = trim($ls_row);
         $ls_arr = explode(",",$lsr);
         $live_sat_arr[] = $ls_arr;
         break;
      }
   }
   echo json_encode($live_sat_arr);
?>