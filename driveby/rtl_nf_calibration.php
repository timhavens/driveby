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

$min_nf = 0;$avg_nf=0;$max_nf=0;

if(file_exists("{$config->conf->data_storage_local}rtl_0_data.out")) {
   $file = fopen("{$config->conf->data_storage_local}rtl_0_data.out", 'r');
   while (($r = fgetcsv($file)) !== FALSE) {
     //$line is an array of the csv elements
     $nf_arr[] = $r[6];
   }
   fclose($file);
   $avg_nf = abs( round((array_sum($nf_arr) / count($nf_arr)),3) );
   $min_nf = abs(min($nf_arr));
   $max_nf = abs(max($nf_arr));
   echo "(44) $min_nf | $avg_nf | $max_nf\n";
   file_put_contents('/disk1/driveby_data/rtl_calib_rtl_0_data.out', $min_nf);
   $min_nf = 0;$avg_nf=0;$max_nf=0;
}

if(file_exists("{$config->conf->data_storage_local}rtl_1_data.out")) {
   $file = fopen("{$config->conf->data_storage_local}rtl_1_data.out", 'r');
   while (($r = fgetcsv($file)) !== FALSE) {
     //$line is an array of the csv elements
     $nf_arr[] = $r[6];
   }
   fclose($file);
   $avg_nf = abs( round((array_sum($nf_arr) / count($nf_arr)),3) );
   $min_nf = abs(min($nf_arr));
   $max_nf = abs(max($nf_arr));
   echo "(50) $min_nf | $avg_nf | $max_nf\n";
   file_put_contents('/disk1/driveby_data/rtl_calib_rtl_1_data.out', $min_nf);
   $min_nf = 0;$avg_nf=0;$max_nf=0;
}

if(file_exists("{$config->conf->data_storage_local}rtl_2_data.out")) {
   $file = fopen("{$config->conf->data_storage_local}rtl_2_data.out", 'r');
   while (($r = fgetcsv($file)) !== FALSE) {
     //$line is an array of the csv elements
     $nf_arr[] = $r[6];
   }
   fclose($file);
   $avg_nf = abs( round((array_sum($nf_arr) / count($nf_arr)),3) );
   $min_nf = abs(min($nf_arr));
   $max_nf = abs(max($nf_arr));
   echo "(144) $min_nf | $avg_nf | $max_nf\n";
   file_put_contents('/disk1/driveby_data/rtl_calib_rtl_2_data.out', $min_nf);
   $min_nf = 0;$avg_nf=0;$max_nf=0;
}

if(file_exists("{$config->conf->data_storage_local}rtl_3_data.out")) {
   $file = fopen("{$config->conf->data_storage_local}rtl_3_data.out", 'r');
   while (($r = fgetcsv($file)) !== FALSE) {
     //$line is an array of the csv elements
     $nf_arr[] = $r[6];
   }
   fclose($file);
   $avg_nf = abs( round((array_sum($nf_arr) / count($nf_arr)),3) );
   $min_nf = abs(min($nf_arr));
   $max_nf = abs(max($nf_arr));
   echo "(222) $min_nf | $avg_nf | $max_nf\n";
   file_put_contents('/disk1/driveby_data/rtl_calib_rtl_3_data.out', $min_nf);
   $min_nf = 0;$avg_nf=0;$max_nf=0;
}

if(file_exists("{$config->conf->data_storage_local}rtl_4_data.out")) {
   $file = fopen("{$config->conf->data_storage_local}rtl_4_data.out", 'r');
   while (($r = fgetcsv($file)) !== FALSE) {
     //$line is an array of the csv elements
     $nf_arr[] = $r[6];
   }
   fclose($file);
   $avg_nf = abs( round((array_sum($nf_arr) / count($nf_arr)),3) );
   $min_nf = abs(min($nf_arr));
   $max_nf = abs(max($nf_arr));
   echo "(432) $min_nf | $avg_nf | $max_nf\n";
   file_put_contents('/disk1/driveby_data/rtl_calib_rtl_4_data.out', $min_nf);
}

exit;