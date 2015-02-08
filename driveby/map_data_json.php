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
//$freq_rtl_arr[$freq] == deviceid

$map_data_arr = array();
$ts = 0;
$freq = 0;
$gps_data_arr = array();
$rtl_device = -1;

if(isset($_REQUEST['ts'])) {
   $ts = $_REQUEST['ts'];
}
if(isset($_REQUEST['freq']) and $_REQUEST['freq'] != "") {
   $freq = $_REQUEST['freq'];
   $rtl_device = $freq_rtl_arr[$_REQUEST['freq']];
   if(!isset($freq_rtl_arr[$freq])) {
      echo "FREQ ($freq) RTL: ($rtl_device)\n\n";
      die("ERROR: No such FREQ");
   }
}

//echo "FREQ ($freq) RTL: ($rtl_device)\n\n";

if(isset($_REQUEST['RV_TS']) and $_REQUEST['RV_TS'] != "") {

   $file_list = array();
   $rf_data_arr = array();
   $lat_long_limit_arr = array();
   $tmp_map_data_arr = array();

   $datetime_arr = preg_split("/[-: ]/",$_REQUEST['RV_TS']);
   $minute_str = substr($datetime_arr[4],0,1)."0";
   $rv_ts = $datetime_arr[0].'-'.$datetime_arr[1].'-'.$datetime_arr[2].' '.$datetime_arr[3].':'.$minute_str;

   $prev_run_arr = get_previous_run_data($freq);
   $file_list = $prev_run_arr[$rv_ts];
   $gps_file_path = $config->conf->data_storage_local.get_gps_data_file_path($file_list);
   //print_r($prev_run_arr);
   //print_r($gps_file_path);
   //echo "\n\n\n";
   //echo "GPS FILE PATH: $gps_file_path";
   //exit;

   if(file_exists($gps_file_path)) {
      $fc_gps = file($gps_file_path);
      foreach($fc_gps as $row) {
         $gpsa = explode(",",trim($row));
         if($gpsa[0] != 3) continue;
         $datetime = $gpsa[2];
         list($lat,$long) = explode(" ",$gpsa[3]);
         $alt_ft = $gpsa[4];
         $track_speed = $gpsa[5];
         $track_az = $gpsa[6];
         $datetime_time = strtotime($datetime);
         // need to round up to the nearest 2 second interval
         $rounded_datetime_time = ceil($datetime_time/2)*2;
         $hour_min_sec = date("H:i:s",$rounded_datetime_time);

         $gps_data_arr["$hour_min_sec"] = array($lat,$long,$alt_ft,$track_speed,$track_az,$rounded_datetime_time);
      }
   }

   //print_r($file_list);exit;

   foreach($file_list as $temp_file_name) {
      if(preg_match('/gps/',$temp_file_name)) {continue;}
      if($freq != 0 and !preg_match("/rtl_{$freq_rtl_arr[$freq]}/",$temp_file_name)) {
         //echo "EXCLUDE: {$config->conf->data_storage_local}$temp_file_name\n";
         continue;
      }
      //echo "USING: {$config->conf->data_storage_local}$temp_file_name\n";
      $rf_data_arr = get_rf_data($config->conf->data_storage_local.$temp_file_name);
   }

   //print_r($rf_data_arr);exit;

   if(count($rf_data_arr) > 0 and count($gps_data_arr) > 0) {
      foreach($rf_data_arr as $time => $arr) {
          if(isset($gps_data_arr[$time])) {
             $lat    = $gps_data_arr[$time][0];
             $long   = $gps_data_arr[$time][1];
             $timestamp = $gps_data_arr[$time][5];
             $weight = $arr[1];
             if($ts > 0) {
                if($timestamp <= $ts) continue;
             }
             if(isset($lat_long_limit_arr["$lat:$long"])) {
                //error_log("$lat:$long = {$lat_long_limit_arr["$lat:$long"]}",0);
                $lat_long_limit_arr["$lat:$long"]++;
             } else {
                $lat_long_limit_arr["$lat:$long"] = 1;
             }
             if($lat_long_limit_arr["$lat:$long"]>1) {
                // if this signal is stronger than the previous ones we want to replace it in the $map_data_arr
                // meaning locate the index that matches $lat and $long and see if $weight is stronger if so replace it
                // The idea is that if we stop for longer then a second or two we'll end up having very large summed values
                // for this lat/long in the map.  Which can skew results based solely on how long we spent there. (not good)
                //echo "CNT: {$lat_long_limit_arr["$lat:$long"]}\n";
                if(isset($map_data_arr["$lat:$long"]['weight'])) {
                   if($weight > $map_data_arr["$lat:$long"]['weight']) {
                      $map_data_arr["$lat:$long"]['weight'] = $weight;
                      $map_data_arr["$lat:$long"]['timestamp'] = $timestamp;
                   }
                }
             }
             $map_data_arr["$lat:$long"] = array('lat' => $lat, 'long' => $long, 'weight' => $weight, 'timestamp' => $timestamp);
          }
      }
   }

   //print_r($map_data_arr);exit;

   foreach($map_data_arr as $data_arr) {
      $tmp_map_data_arr[] = $data_arr;
   }
   $map_data_arr = $tmp_map_data_arr;
} else {

   $file_list = array();
   $rf_data_arr = array();
   $lat_long_limit_arr = array();
   $live_run_arr = get_live_run_data();

   $gps_file_path = (string) $config->conf->data_storage_local.get_gps_data_file_path($live_run_arr);

   if(file_exists($gps_file_path)) {
      $fc_gps = file($gps_file_path);

      foreach($fc_gps as $row) {
         $gpsa = explode(",",trim($row));
         if($gpsa[0] != 3) continue;
         $datetime = $gpsa[2];
         list($lat,$long) = explode(" ",$gpsa[3]);
         //$lat = round($lat,4);
         //$long = round($long,3);
         $alt_ft = $gpsa[4];
         $track_speed = $gpsa[5];
         $track_az = $gpsa[6];
         $datetime_time = strtotime($datetime);
         // need to round up to the nearest 2 second interval
         $rounded_datetime_time = ceil($datetime_time/2)*2;
         $hour_min_sec = date("H:i:s",$rounded_datetime_time);
         $gps_data_arr["$hour_min_sec"] = array($lat,$long,$alt_ft,$track_speed,$track_az,$rounded_datetime_time);
      }
   }

   foreach($live_run_arr as $temp_file_name) {
      if(preg_match('/gps/',$temp_file_name)) {continue;}
      if($freq != 0 and !preg_match("/rtl_{$freq_rtl_arr[$freq]}/",$temp_file_name)) {
         //echo "EXCLUDE: {$config->conf->data_storage_local}$temp_file_name\n";
         continue;
      }
      //echo "USING: {$config->conf->data_storage_local}$temp_file_name\n";
      //$rf_data_arr = get_rf_data($config->conf->data_storage_local.$temp_file_name);
      $rf_data_arr = array_merge($rf_data_arr,get_rf_data($config->conf->data_storage_local.$temp_file_name));
   }

   /*if(count($rf_data_arr) > 0 and count($gps_data_arr) > 0) {
      foreach($rf_data_arr as $time => $arr) {
          if(isset($gps_data_arr[$time])) {
             $lat    = $gps_data_arr[$time][0];
             $long   = $gps_data_arr[$time][1];
             $timestamp = $gps_data_arr[$time][5];
             $weight = round($arr[1],3);
             if($ts > 0) {
                if($timestamp <= $ts) continue;
             }
             $map_data_arr[] = array('lat' => $lat, 'long' => $long, 'weight' => $weight, 'timestamp' => $timestamp);
          }
      }
   }*/

   if(count($rf_data_arr) > 0 and count($gps_data_arr) > 0) {

      foreach($rf_data_arr as $time => $arr) {
         //echo "$time\n";
          if(isset($gps_data_arr[$time])) {
             $lat    = $gps_data_arr[$time][0];
             $long   = $gps_data_arr[$time][1];
             $timestamp = $gps_data_arr[$time][5];
             $weight = $arr[1];
             if($ts > 0) {
                if($timestamp <= $ts) continue;
             }
             if(isset($lat_long_limit_arr["$lat:$long"])) {
                //error_log("$lat:$long = {$lat_long_limit_arr["$lat:$long"]}",0);
                $lat_long_limit_arr["$lat:$long"]++;
             } else {
                $lat_long_limit_arr["$lat:$long"] = 1;
             }
             if($lat_long_limit_arr["$lat:$long"]>1) {
                // if this signal is stronger than the previous ones we want to replace it in the $map_data_arr
                // meaning locate the index that matches $lat and $long and see if $weight is stronger if so replace it
                // The idea is that if we stop for longer then a second or two we'll end up having very large summed values
                // for this lat/long in the map.  Which can skew results based solely on how long we spent there. (not good)
                //echo "CNT: {$lat_long_limit_arr["$lat:$long"]}\n";
                if(isset($map_data_arr["$lat:$long"]['weight'])) {
                   if($weight > $map_data_arr["$lat:$long"]['weight']) {
                      $map_data_arr["$lat:$long"]['weight'] = $weight;
                      $map_data_arr["$lat:$long"]['timestamp'] = $timestamp;
                   }
                }
             }
             $map_data_arr["$lat:$long"] = array('lat' => $lat, 'long' => $long, 'weight' => $weight, 'timestamp' => $timestamp);
          }
      }
   }
   foreach($map_data_arr as $data_arr) {
      $tmp_map_data_arr[] = $data_arr;
   }
   $map_data_arr = $tmp_map_data_arr;
}

header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');
//print_r($map_data_arr);exit;
echo json_encode($map_data_arr);

exit;

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

function get_previous_run_data($freq="") {
   global $freq_rtl_arr,$config;
   $return_arr = array();
   $final_return_arr = array();
   $disk1_driveby_data_arr = dirToArray($config->conf->data_storage_local);
   //print_r($disk1_driveby_data_arr);exit;
   foreach($disk1_driveby_data_arr as $filename) {
      //echo "FILE $filename\n";
      $part_list_arr = explode("_",$filename);

      $datetime_arr = explode("-",$part_list_arr[0]);
      //print_r($part_list_arr);
      if(empty($datetime_arr) or !isset($datetime_arr[4]) or (trim($datetime_arr[4]) == "")) continue;

      $minute_str = substr($datetime_arr[4],0,1)."0";
      $datetime_str = $datetime_arr[0].'-'.$datetime_arr[1].'-'.$datetime_arr[2].' '.$datetime_arr[3].':'.$minute_str;
      //echo "$datetime_str\n";
      if($freq != "") {
         //echo "{$freq_rtl_arr[$freq]} found.\n";
         if(preg_match("/{$freq_rtl_arr[$freq]}/",$filename) or preg_match("/gps_0_data/",$filename)) {
            //echo "yep\n";
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

function get_live_run_data() {
   global $config;

   $has_gps = false;
   $return_arr = array();
   $disk1_driveby_data_arr = dirToArray($config->conf->data_storage_local);

   foreach($disk1_driveby_data_arr as $filename) {
      if(in_array($filename,array('rtl_0_data.out','rtl_1_data.out','rtl_2_data.out','rtl_3_data.out','rtl_4_data.out','gps_0_data.out'))) {
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

function get_gps_data_file_path($arr) {
   foreach($arr as $file_path) {
      if(preg_match('/gps_0_data/',$file_path)) {
         return $file_path;
      }
   }
}

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
         /*
          * 79 or 83 should really be based on the running average from the quietest location
          */
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
?>