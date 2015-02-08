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

   $rtl_0_mhz = $config->conf->rtl[0]->mhz;
   $rtl_1_mhz = $config->conf->rtl[1]->mhz;
   $rtl_2_mhz = $config->conf->rtl[2]->mhz;
   $rtl_3_mhz = $config->conf->rtl[3]->mhz;
   $rtl_4_mhz = $config->conf->rtl[4]->mhz;

   $rtl_mhz_arr = array(0 => $rtl_0_mhz, 1 => $rtl_1_mhz, 2 => $rtl_2_mhz, 3 => $rtl_3_mhz, 4 => $rtl_4_mhz);
   $freq_rtl_arr = array($rtl_0_mhz => 0, $rtl_1_mhz => 1, $rtl_2_mhz => 2, $rtl_3_mhz => 3, $rtl_4_mhz => 4);

   $rf_data_arr = array();
   $live_run_arr = get_live_run_data();
   $calibration_arr = array();

   $rv_ts = "";
   $ts = "";
   $freq = "";
   $rtl_device = -1;

   if(isset($_REQUEST['ts'])) {
      $ts = $_REQUEST['ts'];
   }

   $datetime_arr = preg_split("/[-: ]/",$_REQUEST['RV_TS']);
   $minute_str = substr($datetime_arr[4],0,1)."0";
   $rv_ts = $datetime_arr[0].'-'.$datetime_arr[1].'-'.$datetime_arr[2].' '.$datetime_arr[3].':'.$minute_str;

   if(isset($_REQUEST['freq']) and $_REQUEST['freq'] != "") {
      $freq = $_REQUEST['freq'];
      $rtl_device = $freq_rtl_arr[$_REQUEST['freq']];
   }

   foreach($live_run_arr as $temp_file_name) {
      if(preg_match('/gps/',$temp_file_name)) {continue;}
      $rf_data_arr[$temp_file_name] = get_rf_data('/disk1/driveby_data/'.$temp_file_name);
      //echo "FILE: $temp_file_name<br><pre>\n";
      //print_r(get_rf_data('/disk1/driveby_data/'.$temp_file_name));
      //echo "</pre><br>\n";
   }

   //echo "<pre>\n";
   //print_r($rf_data_arr);
   //echo "</pre>\n";
   //exit;

   foreach($rf_data_arr as $t_filename => $time_arr) {
      $tmp_calibration_arr = array();
      foreach($time_arr as $time => $arr) {
         $tmp_calibration_arr[] = $arr[0];
      }
      $calibration_arr[$t_filename] = abs( round((array_sum($tmp_calibration_arr) / count($tmp_calibration_arr)),3) );
   }

   echo "<pre>\n";
   print_r($calibration_arr);
   echo "</pre>\n";

   /*
      Array
      (
          [144mhz_data.out] => -78.216
          [222mhz_data.out] => -78.66
          [432mhz_data.out] => -76.932
          [50mhz_data.out] => -76.409
      )
    */

   foreach($calibration_arr as $w_filepath => $w_value) {
      file_put_contents('/disk1/driveby_data/rtl_calib_'.$w_filepath,$w_value);
   }
   exit;

/*function get_rf_data($file_path) {
   $return_arr = array();
   if(file_exists($file_path)) {
      $fc = file($file_path);
      foreach($fc as $row) {
         $ra = explode(", ",trim($row));
         $datetime_time = strtotime($ra[0]." ".$ra[1]);
         // need to round up to the nearest 2 second interval
         $rounded_datetime_time = ceil($datetime_time/2)*2;
         $hour_min_sec = date("H:i:s",$rounded_datetime_time);
         $freq = substr($ra[2],0,3);
         $nf = $ra[6];

         // 79 or 83 should really be based on the running average from the quietest location

         $weight = (79 - abs($nf)); // was 83 we need to normalize and invert these values for weight we assume -80 is minimum nf possible.
         $return_arr["$hour_min_sec"] = array($nf,$weight);
      }
   }
   return $return_arr;
}*/

function get_rf_data($file_path) {
   global $freq,$freq_rtl_arr,$config,$rtl_0_mhz,$rtl_1_mhz,$rtl_2_mhz,$rtl_3_mhz,$rtl_4_mhz;
   $return_arr = array();

   if(file_exists($file_path)) {
      $fc = file($file_path);
      foreach($fc as $row) {
         $ra = explode(", ",trim($row));
         $datetime_time = strtotime($ra[0]." ".$ra[1]);
         // need to round up to the nearest 2 second interval
         $rounded_datetime_time = ceil($datetime_time/2)*2;
         $hour_min_sec = date("H:i:s",$rounded_datetime_time);
         $freq_not_used = substr($ra[2],0,3);
         $nf = $ra[6];

         // 79 or 83 should really be based on the running average from the quietest location

         if(in_array($freq,array($rtl_0_mhz,$rtl_1_mhz,$rtl_2_mhz,$rtl_3_mhz,$rtl_4_mhz))) {
            $avg_nf = trim(file_get_contents($config->conf->data_storage_local."rtl_calib_rtl_{$freq_rtl_arr[$freq]}_data.out"));
         } else {
            $avg_nf = 79;
         }

         // because the $avg_nf vs. abs($nf) ends up being a neg number normally
         // this was changed to use abs() around the whole math.  There ARE issues here we need
         // to address ASAP
         $weight = abs($avg_nf - abs($nf)); // was 83 we need to normalize and invert these values for weight we assume -80 is minimum nf possible.
         $return_arr["$hour_min_sec"] = array($nf,$weight);
      }
   }
   return $return_arr;
}

/*
   function get_live_run_data() {

   $has_gps = true; // not really, we're just faking it to force us to be allowed to calibrate for now
   $return_arr = array();
   $disk1_driveby_data_arr = dirToArray('/disk1/driveby_data/');

   foreach($disk1_driveby_data_arr as $filename) {
      if(in_array($filename,array('44mhz_data.out','50mhz_data.out','144mhz_data.out','222mhz_data.out','432mhz_data.out','gps_data.out'))) {
         $return_arr[] = $filename;
      }
   }

   //foreach($return_arr as $dt_filename) {
   //   if(preg_match('/gps/',$dt_filename)) {
   //      $has_gps = true;
   //      break;
   //   }
   //}

   //if($has_gps and count($return_arr) > 1) {
      return $return_arr;
   //}

   //return array();
}

   function dirToArray($dir) {
   $result = array();
   $cdir = scandir($dir);
   foreach ($cdir as $key => $value) {
      if (!in_array($value,array(".",".."))){
         if(preg_match('/\.log$/',$value)) continue;

         if (is_dir($dir . DIRECTORY_SEPARATOR . $value)) {
            $result[$value] = dirToArray($dir . DIRECTORY_SEPARATOR . $value);
         } else {
            $result[] = $value;
         }
      }
   }
   return $result;
}
*/

function get_live_run_data() {
   global $config;

   $has_gps = false;
   $return_arr = array();
   $disk1_driveby_data_arr = dirToArray($config->conf->data_storage_local);

   foreach($disk1_driveby_data_arr as $filename) {
      if(in_array($filename,array('rtl_0_data.out','rtl_1_data.out','rtl_2_data.out','rtl_3_data.out','rtl_4_data.out','gps_data.out'))) {
         $return_arr[] = $filename;
      }
   }

   foreach($return_arr as $dt_filename) {
      if(preg_match('/gps/',$dt_filename)) {
         $has_gps = true;
         break;
      }
   }

   if($has_gps and count($return_arr) > 1) {
      return $return_arr;
   }

   return array();
}

function get_previous_run_data($freq="") {
   global $freq_rtl_arr,$config;
   $return_arr = array();
   $final_return_arr = array();
   $disk1_driveby_data_arr = dirToArray($config->conf->data_storage_local);
   foreach($disk1_driveby_data_arr as $filename) {
      //echo "FILE $filename\n";
      $part_list_arr = explode("_",$filename);

      $datetime_arr = explode("-",$part_list_arr[0]);

      if(empty($datetime_arr) or !isset($datetime_arr[4]) or (trim($datetime_arr[4]) == "")) continue;

      $minute_str = substr($datetime_arr[4],0,1)."0";
      $datetime_str = $datetime_arr[0].'-'.$datetime_arr[1].'-'.$datetime_arr[2].' '.$datetime_arr[3].':'.$minute_str;
      if($freq != "") {
         if(preg_match("/{$freq_rtl_arr[$freq]}/",$filename) or preg_match("/gps_data/",$filename)) {
             $return_arr[$datetime_str][] = $filename;
         } else {
             continue;
         }
      } else {
         $return_arr[$datetime_str][] = $filename;
      }
   }
   //print_r($return_arr);

   foreach($return_arr as $dt_key => $dt_arr) {
      $has_gps = false;

      foreach($dt_arr as $dt_filename) {
         if(preg_match('/gps/',$dt_filename)) {
            $has_gps = true;
            break;
         }
      }
      if($has_gps and count($dt_arr) > 1) {
         $final_return_arr[$dt_key] = $dt_arr;
      }
   }

   //print_r($final_return_arr);
   return $final_return_arr;
}
