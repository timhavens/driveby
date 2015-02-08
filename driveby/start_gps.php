<!DOCTYPE html>
<!--
/*
 * RELEASED AS GNU General Public License v3 (GPL-3)
 * http://www.gnu.org/licenses/quick-guide-gplv3.html
 *
 * Originally written by Tim R. Havens 2015-01-27 please track changes below
 *
 */
-->
<html>
   <head>
      <meta charset="UTF-8">
      <title>Driveby - Start GPS</title>
   </head>
   <body style="font-family:Arial">
<?php

include_once('classes/Gps.class.inc');
$gps = new Gps();
if($gps->findCommandPID('gps_log_data')) {
   echo "ERROR: GPS aleady running.";
   exit;
} else {
   $gps->start_gps();
   if($gps->findCommandPID('gps_log_data')) {
      echo "SUCCESS: GPS Started.";
   } else {
      echo "ERROR: GPS did not start.";
   }
}
?>
   </body>


