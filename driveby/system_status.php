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

   $rtl_0_mhz = $config->conf->rtl[0]->mhz;
   $rtl_1_mhz = $config->conf->rtl[1]->mhz;
   $rtl_2_mhz = $config->conf->rtl[2]->mhz;
   $rtl_3_mhz = $config->conf->rtl[3]->mhz;
   $rtl_4_mhz = $config->conf->rtl[4]->mhz;

   $rtl_mhz_arr  = array(0 => $rtl_0_mhz, 1 => $rtl_1_mhz, 2 => $rtl_2_mhz, 3 => $rtl_3_mhz, 4 => $rtl_4_mhz);
   $freq_rtl_arr = array($rtl_0_mhz => 0, $rtl_1_mhz => 1, $rtl_2_mhz => 2, $rtl_3_mhz => 3, $rtl_4_mhz => 4);

   $nfs_stat = false;
   $check_nfs_color ="#CC0066";

   if(file_exists('{$config->conf->data_storage_local}test')) {
      $nfs_stat = true;
   }

   if($nfs_stat) {
      $check_nfs_color ="lightgreen";
   }
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
      <META HTTP-EQUIV="refresh" CONTENT="20">
      <title>Driveby - System Status</title>
   </head>
   <body style="font-family:Arial;background-color:white;">
      <b>System Load Avg (<?=date('Y-m-d H:i:s')?>)</b><br>
      <?php
         @exec("tail -n 1 {$config->conf->data_storage_local}tk1_stat_sysload.log", $results_tk1_sysload);
         @exec("tail -n 1 {$config->conf->data_storage_local}tk1_stat_temp.log",    $results_tk1_temp);
         @exec("tail -n 1 {$config->conf->data_storage_local}odroid_stat_sysload.log",$results_odroid_sysload);
         @exec("tail -n 1 {$config->conf->data_storage_local}odroid_stat_temp.log",   $results_odroid_temp);

         /*
          * Array ( [0] => 1417898281 0.45 1.03 0.8 )
          * Array ( [0] => 1417898281 35.0 )
          * Array ( [0] => 1417898281 0 0.01 0.05 )
          * Array ( [0] => 1417898281 53.6 )
          */
         $tk1_sysload_arr    = @explode(" ",$results_tk1_sysload[0]);
         $tk1_temp_arr       = @explode(" ",$results_tk1_temp[0]);
         $odroid_sysload_arr = @explode(" ",$results_odroid_sysload[0]);
         $odroid_temp_arr    = @explode(" ",$results_odroid_temp[0]);

         echo "<b>TK1</b>  temp {$tk1_temp_arr[1]}c 1m({$tk1_sysload_arr[1]}) 5m({$tk1_sysload_arr[2]}) 15m({$tk1_sysload_arr[3]})  <br>\n";
         echo "<b>ODROID</b> temp {$odroid_temp_arr[1]}c 1m({$odroid_sysload_arr[1]}) 5m({$odroid_sysload_arr[2]}) 15m({$odroid_sysload_arr[3]})  <br>\n";

         echo "<br><br>\n";

         $dfs = disk_free_space("/disk1");
         $dts = disk_total_space("/disk1");
         $df = bytes($dfs);
         $ds = bytes($dts);
         $du = formatBytes(round(($dts - $dfs)-221979000),0);
         echo "<b>/disk1/driveby_data:</b><br>\n";
         echo "TOTAL: ($ds) FREE: ($df) USED: ($du)<br><br>\n";

         file_line_count();
      ?>
      <br>
      <iframe name='nfs_iframe' src='http://<?=$config->conf->http_gui_host?>/driveby_new/nfs.php' style="width: 300px; height: 40px; overflow:hidden;" frameBorder="0"></iframe>
      <iframe name='osd_iframe' src='http://<?=$config->conf->http_gui_remote?>/driveby_new/sdown.php' style="width: 200px; height: 40px; overflow:hidden;" frameBorder="0"></iframe>
      <iframe name='tsd_iframe' src='http://<?=$config->conf->http_gui_host?>/driveby_new/sdown.php' style="width: 150px; height: 40px; overflow:hidden;" frameBorder="0"></iframe>
   </body>
</html>
<?php
   function play_alert_snd() {
      echo "<audio autoplay>\n";
      echo '   <source src="ding.mp3" type="audio/mp3">'."\n";
      echo "</audio>\n";
   }

   function formatBytes($bytes, $precision = 2) {
       $units = array('B', 'KB', 'MB', 'GB', 'TB');

       $bytes = max($bytes, 0);
       $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
       $pow = min($pow, count($units) - 1);

       // Uncomment one of the following alternatives
       $bytes /= pow(1024, $pow);
       // $bytes /= (1 << (10 * $pow));

       return round($bytes, $precision) . ' ' . $units[$pow];
   }

   function bytes($bytes, $force_unit = NULL, $format = NULL, $si = TRUE) {
       // Format string
       $format = ($format === NULL) ? '%01.2f %s' : (string) $format;

       // IEC prefixes (binary)
       if ($si == FALSE OR strpos($force_unit, 'i') !== FALSE)
       {
           $units = array('B', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB');
           $mod   = 1024;
       }
       // SI prefixes (decimal)
       else
       {
           $units = array('B', 'kB', 'MB', 'GB', 'TB', 'PB');
           $mod   = 1000;
       }

       // Determine unit to use
       if (($power = array_search((string) $force_unit, $units)) === FALSE)
       {
           $power = ($bytes > 0) ? floor(log($bytes, $mod)) : 0;
       }

       return sprintf($format, $bytes / pow($mod, $power), $units[$power]);
   }

   function file_line_count($path="") {
      global $config;
      echo "<b>Num Lines In Data Files:</b><br>\n";
      exec("wc -l {$config->conf->data_storage_local}*",$response_arr);
      foreach($response_arr as $r) {
         if(preg_match('/201/',$r)) continue;
         if(preg_match('/200/',$r)) continue;
         if(preg_match('/stat/',$r)) continue;
         if(preg_match('/log$/',$r)) continue;
         if(preg_match('/calib/',$r)) continue;
         if(preg_match('/test/',$r)) continue;
         if(preg_match('/log_all/',$r)) continue;
         echo "$r<br>\n";
      }
      echo "<br>\n";
   }
?>
