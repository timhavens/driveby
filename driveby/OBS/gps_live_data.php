<?php
/*
 * RELEASED AS GNU General Public License v3 (GPL-3)
 * http://www.gnu.org/licenses/quick-guide-gplv3.html
 *
 * Originally written by Tim R. Havens 2015-01-27 please track changes below
 *
 */
/*
  NOTE: https://developers.google.com/maps/documentation/javascript/tutorial

  rm /disk1/driveby_data/*.out
  php /home/ubuntu/driveby_new/test.php > /disk1/driveby_data/gps_data.out&
  rtl_power -d 0 -f 50000000:50300000:300k -i 3 -g 5 -w blackman -F 7 -c 20% /disk1/driveby_data/50mhz_data.out&
  rtl_power -d 1 -f 154700000:154900000:300k -i 3 -g 5 -w blackman -F 7 -c 20% /disk1/driveby_data/154mhz_data.out&
  rtl_power -d 2 -f 222000000:222300000:300k -i 3 -g 5 -w blackman -F 7 -c 20% /disk1/driveby_data/222mhz_data.out&
  rtl_power -d 3 -f 432000000:432300000:300k -i 3 -g 5 -w blackman -F 7 -c 20% /disk1/driveby_data/432mhz_data.out&
  tail -f /disk1/driveby_data/*.out
 */
   //error_reporting(E_ALL);
   include_once('/var/www/html/driveby_new/classes/Data.class.inc');
   $d = new Data();
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
      <META HTTP-EQUIV="refresh" CONTENT="3">
      <title>Driveby - RTL Log Data</title>
   </head>
   <body style="font-family:Arial">
      <?php
         $o = $d->get_nf_gps_data(-7);
         foreach($o as $key => $data_arr){
            if(count($data_arr) < 1) {
               continue;
            }
            if($key == 'gps') {
               echo "<b>$key</b><br>\n";
            }
            foreach($data_arr as $i) {
               if($key == 'gps') {
                  echo "{$i[0]} {$i[1]} {$i[2]} {$i[3]} {$i[4]} {$i[5]} {$i[6]} {$i[7]}<br>\n";
               } else {
                  continue;
               }
            }
            echo "<br>\n";
         }
      ?>
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

   function file_line_count($path,$only_total) {
      echo "<b>Num Lines In Data Files:</b><br>\n";
      exec("wc -l /disk1/driveby_data/*",$response_arr);
      foreach($response_arr as $r) {
         echo "$r<br>\n";
      }
      echo "<br>\n";
   }
?>
