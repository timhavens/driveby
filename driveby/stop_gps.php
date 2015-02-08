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
      <title>Driveby - Stop GPS</title>
   </head>
   <body style="font-family:Arial">
<?php

include_once('classes/Gps.class.inc');
$gps = new Gps();
if($gps->findCommandPID('gps_log_data')) {
   echo "<pre>\n";
   $gps->killpid($gps->findCommandPID('gps_log_data'));
   echo "</pre>\n";
   if($gps->findCommandPID('gps_log_data')) {
      echo "ERROR: Unable to STOP GPS.";
   } else {
      echo "SUCCESS: GPS STOPPED.";
   }
} else {
   echo "SUCCESS: (kinda) NO GPS found running.";
   exit;
}




