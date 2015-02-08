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

$nf_rtl_0_db = -82;
$nf_rtl_1_db = -82;
$nf_rtl_2_db = -82;
$nf_rtl_3_db = -82;
$nf_rtl_4_db = -82;

$file = "/disk1/driveby_data/rtl_0_data.out";
if(file_exists($file)) {
   $file = escapeshellarg($file); // for the security concious (should be everyone!)
   $line = `tail -n 1 $file`;
   $data_rtl_0_arr = explode(", ",trim($line));
}

$file = "/disk1/driveby_data/rtl_1_data.out";
if(file_exists($file)) {
   $file = escapeshellarg($file); // for the security concious (should be everyone!)
   $line = `tail -n 1 $file`;
   $data_rtl_1_arr = explode(", ",trim($line));
}

$file = "/disk1/driveby_data/rtl_2_data.out";
if(file_exists($file)) {
   $file = escapeshellarg($file); // for the security concious (should be everyone!)
   $line = `tail -n 1 $file`;
   $data_rtl_2_arr = explode(", ",trim($line));
}

$file = "/disk1/driveby_data/rtl_3_data.out";
if(file_exists($file)) {
   $file = escapeshellarg($file); // for the security concious (should be everyone!)
   $line = `tail -n 1 $file`;
   $data_rtl_3_arr = explode(", ",trim($line));
}

$file = "/disk1/driveby_data/rtl_4_data.out";
if(file_exists($file)) {
   $file = escapeshellarg($file); // for the security concious (should be everyone!)
   $line = `tail -n 1 $file`;
   $data_rtl_4_arr = explode(", ",trim($line));
}

$hour_min_sec = "00:00:00";

if(isset($data_rtl_0_arr[6])) {
   //2014-11-23, 17:20:21, 49707813, 49942187, 39062.rtl_1, 772096, -45.39, -43.22, -39.40, -36.14, -36.11, -36.11, -39.40, -43.23, -43.23
   $arr_len = count($data_rtl_0_arr)-6;
   $num_ele = -1 * abs(count($data_rtl_0_arr)-6);
   $data_rtl_0_data_arr = array_slice($data_rtl_0_arr, $num_ele);
   $nf_rtl_0_db = trim(max($data_rtl_0_data_arr));

   $datetime_time = strtotime($data_rtl_0_arr[0]." ".$data_rtl_0_arr[1]);
   // need to round up to the nearest 2 second interval
   $rounded_datetime_time = ceil($datetime_time/2)*2;
   $hour_min_sec = date("H:i:s",$rounded_datetime_time);
}

if(isset($data_rtl_1_arr[6])) {
   $nf_rtl_1_db = trim($data_rtl_1_arr[6]);
   if($hour_min_sec == "00:00:00") {
      $datetime_time = strtotime($data_rtl_1_arr[0]." ".$data_rtl_1_arr[1]);
      // need to round up to the nearest 2 second interval
      $rounded_datetime_time = ceil($datetime_time/2)*2;
      $hour_min_sec = date("H:i:s",$rounded_datetime_time);
   }
}

if(isset($data_rtl_2_arr[6])) {
   $nf_rtl_2_db = trim($data_rtl_2_arr[6]);
   if($hour_min_sec == "00:00:00") {
      $datetime_time = strtotime($data_rtl_2_arr[0]." ".$data_rtl_2_arr[1]);
      // need to round up to the nearest 2 second interval
      $rounded_datetime_time = ceil($datetime_time/2)*2;
      $hour_min_sec = date("H:i:s",$rounded_datetime_time);
   }
}
if(isset($data_rtl_3_arr[6])) {
   $nf_rtl_3_db = trim($data_rtl_3_arr[6]);
   if($hour_min_sec == "00:00:00") {
      $datetime_time = strtotime($data_rtl_3_arr[0]." ".$data_rtl_3_arr[1]);
      // need to round up to the nearest 2 second interval
      $rounded_datetime_time = ceil($datetime_time/2)*2;
      $hour_min_sec = date("H:i:s",$rounded_datetime_time);
   }
}
if(isset($data_rtl_4_arr[6])) {
   $nf_rtl_4_db = trim($data_rtl_4_arr[6]);
   if($hour_min_sec == "00:00:00") {
      $datetime_time = strtotime($data_rtl_4_arr[0]." ".$data_rtl_4_arr[1]);
      // need to round up to the nearest 2 second interval
      $rounded_datetime_time = ceil($datetime_time/2)*2;
      $hour_min_sec = date("H:i:s",$rounded_datetime_time);
   }
}

$nf = array($hour_min_sec, floatval($nf_rtl_0_db), floatval($nf_rtl_1_db), floatval($nf_rtl_2_db), floatval($nf_rtl_3_db), floatval($nf_rtl_4_db));

echo json_encode($nf);