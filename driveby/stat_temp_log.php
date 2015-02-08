<?php
/*
 * RELEASED AS GNU General Public License v3 (GPL-3)
 * http://www.gnu.org/licenses/quick-guide-gplv3.html
 *
 * Originally written by Tim R. Havens 2015-01-27 please track changes below
 *
 */
   $output_file_path = '/disk1/driveby_data/tk1_stat_temp.log';
   if(file_exists($output_file_path)) {
      $output_arr = array();
      exec('sensors',$output_arr);
      $output_arr_2 = explode(" ",$output_arr[2]);
      $matches = array();
      preg_match('/[0-9\.]+/',$output_arr_2[8],$matches);
      $c_temp = trim($matches[0]);

      // maintain the log file length to only the last 100 readings
      exec("/usr/bin/tail -n 99 $output_file_path",$file_rows);
      $file_rows[] = time()." $c_temp";

      file_put_contents($output_file_path, implode(PHP_EOL, $file_rows));
   }
?>