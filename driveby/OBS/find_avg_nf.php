<?php

$file = fopen('/disk1/driveby_data/2015-01-24-21-23-45_rtl_0_data.out', 'r');
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

$file = fopen('/disk1/driveby_data/2015-01-24-21-23-47_rtl_1_data.out', 'r');
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


$file = fopen('/disk1/driveby_data/2015-01-24-21-23-47_rtl_2_data.out', 'r');
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


$file = fopen('/disk1/driveby_data/2015-01-24-21-23-49_rtl_3_data.out', 'r');
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


$file = fopen('/disk1/driveby_data/2015-01-24-21-23-49_rtl_4_data.out', 'r');
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
exit;
//$calibration_arr[$t_filename] = abs( round((array_sum($tmp_calibration_arr) / count($tmp_calibration_arr)),3) );