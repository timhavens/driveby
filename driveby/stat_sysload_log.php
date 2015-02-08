<?php
/*
 * RELEASED AS GNU General Public License v3 (GPL-3)
 * http://www.gnu.org/licenses/quick-guide-gplv3.html
 *
 * Originally written by Tim R. Havens 2015-01-27 please track changes below
 *
 */
   $output_file_path = '/disk1/driveby_data/tk1_stat_sysload.log';
   if(file_exists($output_file_path)) {
      $load  = sys_getloadavg();
      $load0 = $load[0];
      $load1 = $load[1];
      $load2 = $load[2];

      // maintain the log file length to only the last 100 readings
      exec("/usr/bin/tail -n 99 $output_file_path",$file_rows);
      $file_rows[] = time()." $load0 $load1 $load2";

      file_put_contents($output_file_path, implode(PHP_EOL, $file_rows));
   }
?>