<?php
   chdir(dirname(__FILE__)); // cd to this directory (in case you are running from cron)
   $ureset_file_path = dirname(__FILE__)."/usbreset";
   $resp_content = shell_exec('lsusb');
   $bus_path = "/dev/bus/usb/";
   $reset_arr = array();

   $resp_content_arr = explode("\n",$resp_content);
   foreach($resp_content_arr as $r) {
      if(trim($r) == "") continue;
      $r_arr = explode(" ",trim($r));
      //print_r($r_arr);
      $main_b = trim($r_arr[1]);
      $sub_b  = preg_replace('/:/','',trim($r_arr[3]));
      $reset_bus_path = "{$bus_path}{$main_b}/{$sub_b}";
      //echo "$reset_bus_path\n";
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
   //print_r($reset_arr);

   foreach($reset_arr as $m_k => $sk_arr) {
      foreach($sk_arr as $s_k => $s_path) {
         $reset_results = "";
         echo "$m_k:$s_k => $s_path\n";
         echo "$ureset_file_path $s_path\n";
         $reset_results = shell_exec("$ureset_file_path $s_path");
         echo "$reset_results\n\n";
      }
   }

?>



