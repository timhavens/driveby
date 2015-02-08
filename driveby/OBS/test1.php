<?php
   include('../classes/Rtl.class.inc');

   $rtl = new Rtl();

   $shortopts  = "";
   $shortopts .= "c:"; // start / stop
   //$shortopts .= "t:"; // test
   $opts = getopt($shortopts);

   if($opts['c'] == 'start') {
      $rtl->get_start_rtl_command(0);
   } elseif ($opts['c'] == 'stop') {
      $rtl->get_stop_rtl_command(0);
   } else {
       //$rtl->get_stop_rtl_command(0);
   }

   //if($opts['t'] == 'test') {
     // $rtl->clear_rtl(0);
   //}


?>
