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

   if(file_exists("{$config->conf->data_storage_local}test")) {
      $nfs_stat = true;
   }

   if(isset($_REQUEST['submit']) and $_REQUEST['submit'] == 'start_nfs' and !$nfs_stat) {
      $cmd = 'sudo -u root /usr/bin/start_nfs';
      passthru($cmd);
   }

   if(isset($_REQUEST['submit']) and $_REQUEST['submit'] == 'stop_nfs' and $nfs_stat) {
      $cmd = 'sudo -u root /usr/bin/stop_nfs';
      passthru($cmd);
   }

   $nfs_stat = false;
   $check_nfs_color ="#CC0066";

   if(file_exists("{$config->conf->data_storage_local}test")) {
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
      <title>Driveby - System Status</title>
   </head>
   <body style="font-family:Arial;background-color:white;">
      <form action="http://<?=$config->conf->http_gui_remote?>/driveby/nfs.php" method="post" target="nfs_iframe">
         <button type="submit" value="start_nfs" name="submit">Start NFS</button>
         <button type="submit" value="stop_nfs" name="submit">Stop NFS</button>
         <button type="submit" value="check_nfs" name="submit" style="background-color:<?=$check_nfs_color?>">Check NFS</button>
      </form>
   </body>
</html>