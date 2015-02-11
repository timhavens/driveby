<?php
/*
 * RELEASED AS GNU General Public License v3 (GPL-3)
 * http://www.gnu.org/licenses/quick-guide-gplv3.html
 *
 * Originally written by Tim R. Havens 2015-01-27 please track changes below
 *
 */
$results = "";
global $reload_parent_window;
$reload_parent_window = false;

if(isset($_REQUEST['submit']) and $_REQUEST['submit'] == 'start_all') {
   $tmp_request_arr = array();
   $tmp_request_arr[] = $rtl->request_start_gps();
   sleep(2);
   $tmp_request_arr[] = $rtl->request_start_rtl_0();
   sleep(2);
   $tmp_request_arr[] = $rtl->request_start_rtl_1();
   sleep(2);
   $tmp_request_arr[] = $rtl->request_start_rtl_2();
   $request = print_r($tmp_request_arr,true);
   sleep(2);
   $tmp_request_arr[] = $rtl->request_start_rtl_3();
   $request = print_r($tmp_request_arr,true);
   sleep(2);
   $tmp_request_arr[] = $rtl->request_start_rtl_4();
   $request = print_r($tmp_request_arr,true);
}
if(isset($_REQUEST['submit']) and $_REQUEST['submit'] == 'stop_all') {
   $tmp_request_arr = array();
   $tmp_request_arr[] = $rtl->request_stop_gps();
   sleep(2);
   $tmp_request_arr[] = $rtl->request_stop_rtl_0();
   sleep(2);
   $tmp_request_arr[] = $rtl->request_stop_rtl_1();
   sleep(2);
   $tmp_request_arr[] = $rtl->request_stop_rtl_2();
   $request = print_r($tmp_request_arr,true);
   sleep(2);
   $tmp_request_arr[] = $rtl->request_stop_rtl_3();
   sleep(2);
   $tmp_request_arr[] = $rtl->request_stop_rtl_4();
   $request = print_r($tmp_request_arr,true);
}

if(isset($_REQUEST['submit']) and $_REQUEST['submit'] == 'clear_gps') {
   include_once('classes/Gps.class.inc');
   $gps = new Gps(0);
   $gps->clear_gps();
}
if(isset($_REQUEST['submit']) and $_REQUEST['submit'] == 'stop_gps') {
   include_once('classes/Gps.class.inc');
   $gps = new Gps(0);
   $results = $gps->request_stop_gps();
   $reload_parent_window = true;
}
if(isset($_REQUEST['submit']) and $_REQUEST['submit'] == 'start_gps') {
   include_once('classes/Gps.class.inc');
   $gps = new Gps(0);
   $results = $gps->request_start_gps();
   $reload_parent_window = true;
}
if(isset($_REQUEST['submit']) and $_REQUEST['submit'] == 'reset_usb') {
   chdir(dirname(__FILE__)."/bin"); // cd to this directory (in case you are running from cron)
   $ureset_file_path = dirname(__FILE__)."/bin/usbreset";
   $resp_content = shell_exec('sudo -u root /usr/bin/lsusb');
   $bus_path = "/dev/bus/usb/";
   $reset_arr = array();

   $resp_content_arr = explode("\n",$resp_content);
   foreach($resp_content_arr as $r) {
      if(trim($r) == "") continue;
      $r_arr = explode(" ",trim($r));
      $main_b = trim($r_arr[1]);
      $sub_b  = preg_replace('/:/','',trim($r_arr[3]));
      $reset_bus_path = "{$bus_path}{$main_b}/{$sub_b}";
      if(isset($r_arr[10]) and trim($r_arr[10]) == 'hub') {
         $reset_arr["$main_b"]["$sub_b"] = $reset_bus_path;
      }
   }

   ksort($reset_arr);
   foreach($reset_arr as $k => $v_arr) {
      ksort($v_arr,SORT_NUMERIC);
      $reset_arr[$k]=$v_arr;
   }

   // Now things are ordered for a good reset
   foreach($reset_arr as $m_k => $sk_arr) {
      foreach($sk_arr as $s_k => $s_path) {
         $reset_results = "";
         echo "$m_k:$s_k => $s_path\n";
         echo "$ureset_file_path $s_path\n";
         $reset_results = shell_exec("sudo -u root $ureset_file_path $s_path");
         echo "$reset_results\n\n";
      }
   }
   $reload_parent_window = true;
}
if(isset($_REQUEST['submit']) and $_REQUEST['submit'] == 'gps_set_time') {
   include_once('classes/Gps.class.inc');
   $gps = new Gps(0);
   $results = $gps->gps_set_time();
   $reload_parent_window = true;
}

if(isset($_REQUEST['submit']) and $_REQUEST['submit'] == 'stop_rtl_0') {
   include_once('classes/Rtl.class.inc');
   $rtl = new Rtl();
   $results = $rtl->get_stop_rtl_command(0);
}
if(isset($_REQUEST['submit']) and $_REQUEST['submit'] == 'start_rtl_0') {
   include_once('classes/Rtl.class.inc');
   $rtl = new Rtl();
   $results = $rtl->get_start_rtl_command(0);
}
if(isset($_REQUEST['submit']) and $_REQUEST['submit'] == 'clear_rtl_0') {
   include_once('classes/Rtl.class.inc');
   $rtl = new Rtl();
   $rtl->clear_rtl(0);
}

if(isset($_REQUEST['submit']) and $_REQUEST['submit'] == 'stop_rtl_1') {
   include_once('classes/Rtl.class.inc');
   $rtl = new Rtl();
   $results = $rtl->get_stop_rtl_command(1);
}
if(isset($_REQUEST['submit']) and $_REQUEST['submit'] == 'start_rtl_1') {
   include_once('classes/Rtl.class.inc');
   $rtl = new Rtl();
   $results = $rtl->get_start_rtl_command(1);
}
if(isset($_REQUEST['submit']) and $_REQUEST['submit'] == 'clear_rtl_1') {
   include_once('classes/Rtl.class.inc');
   $rtl = new Rtl();
   $rtl->clear_rtl(1);
}

if(isset($_REQUEST['submit']) and $_REQUEST['submit'] == 'stop_rtl_2') {
   include_once('classes/Rtl.class.inc');
   $rtl = new Rtl();
   $results = $rtl->get_stop_rtl_command(2);
}
if(isset($_REQUEST['submit']) and $_REQUEST['submit'] == 'start_rtl_2') {
   include_once('classes/Rtl.class.inc');
   $rtl = new Rtl();
   $results = $rtl->get_start_rtl_command(2);
}
if(isset($_REQUEST['submit']) and $_REQUEST['submit'] == 'clear_rtl_2') {
   include_once('classes/Rtl.class.inc');
   $rtl = new Rtl();
   $rtl->clear_rtl(2);
}

if(isset($_REQUEST['submit']) and $_REQUEST['submit'] == 'stop_rtl_3') {
   include_once('classes/Rtl.class.inc');
   $rtl = new Rtl();
   $results = $rtl->get_stop_rtl_command(3);
}
if(isset($_REQUEST['submit']) and $_REQUEST['submit'] == 'start_rtl_3') {
   include_once('classes/Rtl.class.inc');
   $rtl = new Rtl();
   $results = $rtl->get_start_rtl_command(3);
}
if(isset($_REQUEST['submit']) and $_REQUEST['submit'] == 'clear_rtl_3') {
   include_once('classes/Rtl.class.inc');
   $rtl = new Rtl();
   $rtl->clear_rtl(3);
}

if(isset($_REQUEST['submit']) and $_REQUEST['submit'] == 'stop_rtl_4') {
   include_once('classes/Rtl.class.inc');
   $rtl = new Rtl();
   $results = $rtl->get_stop_rtl_command(4);
}
if(isset($_REQUEST['submit']) and $_REQUEST['submit'] == 'start_rtl_4') {
   include_once('classes/Rtl.class.inc');
   $rtl = new Rtl();
   $results = $rtl->get_start_rtl_command(4);
}
if(isset($_REQUEST['submit']) and $_REQUEST['submit'] == 'clear_rtl_4') {
   include_once('classes/Rtl.class.inc');
   $rtl = new Rtl();
   $rtl->clear_rtl(4);
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
function get_previous_run_data() {

   $return_arr = array();
   $final_return_arr = array();
   $disk1_driveby_data_arr = dirToArray('/disk1/driveby_data/');
   foreach($disk1_driveby_data_arr as $filename) {
      list($part1,$part2) = explode("_",$filename);
      $datetime_arr = explode("-",$part1);
      if(count($datetime_arr) < 2) { continue; }
      $datetime_str = $datetime_arr[0].'-'.$datetime_arr[1].'-'.$datetime_arr[2].' '.$datetime_arr[3].':'.$datetime_arr[4];
      $return_arr[$datetime_str][] = $filename;
   }

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

   return $final_return_arr;
}

$prev_run_arr = array();
//$prev_run_arr = get_previous_run_data();

?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
   <head>
      <meta charset="UTF-8">
      <title>Driveby - Control Center</title>
      <?php
         if($reload_parent_window) {
            echo '      <script type="text/javascript" language="javascript">'."\n";
            echo '         parent.location.reload();'."\n";
            echo '      </script>'."\n";
         }
      ?>
   </head>
   <body style="font-family:Arial;background-color:grey;">

   </body>
</html>