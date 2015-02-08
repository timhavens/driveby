<?php

# Copyright (c) 2006,2010 Chris Kuethe <chris.kuethe@gmail.com>
#
# Permission to use, copy, modify, and distribute this software for any
# purpose with or without fee is hereby granted, provided that the above
# copyright notice and this permission notice appear in all copies.
#
# THE SOFTWARE IS PROVIDED "AS IS" AND THE AUTHOR DISCLAIMS ALL WARRANTIES
# WITH REGARD TO THIS SOFTWARE INCLUDING ALL IMPLIED WARRANTIES OF
# MERCHANTABILITY AND FITNESS. IN NO EVENT SHALL THE AUTHOR BE LIABLE FOR
# ANY SPECIAL, DIRECT, INDIRECT, OR CONSEQUENTIAL DAMAGES OR ANY DAMAGES
# WHATSOEVER RESULTING FROM LOSS OF USE, DATA OR PROFITS, WHETHER IN AN
# ACTION OF CONTRACT, NEGLIGENCE OR OTHER TORTIOUS ACTION, ARISING OUT OF
# OR IN CONNECTION WITH THE USE OR PERFORMANCE OF THIS SOFTWARE.

global $head, $blurb, $title, $showmap, $autorefresh, $footer, $gmap_key;
global $server, $advertise, $port, $open, $swap_ew, $testmode;
$testmode = 1; # leave this set to 1

# Public script parameters:
#   host: host name or address where GPSd runs. Default: from config file
#   port: port of GPSd. Default: from config file
#   op=view: show just the skyview image instead of the whole HTML page
#     sz=small: used with op=view, display a small (240x240px) skyview
#   op=json: respond with the GPSd POLL JSON structure
#     jsonp=prefix: used with op=json, wrap the POLL JSON in parentheses
#                   and prepend prefix

# If you're running PHP with the Suhosin patch (like the Debian PHP5 package),
# it may be necessary to increase the value of the
# suhosin.get.max_value_length parameter to 2048. The imgdata parameter used
# for displaying the skyview is longer than the default 512 allowed by Suhosin.
# Debian has the config file at /etc/php5/conf.d/suhosin.ini.

# this script shouldn't take more than a few seconds to run
set_time_limit(3);
ini_set('max_execution_time', 3);
//if (!file_exists("gpsd_config.inc"))
//      write_config();
require_once("gpsd_config.inc");
require_once("classes/Gps.class.inc");
require_once("classes/Rpc.class.inc");
$gps = new Gps(0);
$gps_conf = $gps->get_gps_config(0);

$hostname_arr = explode('.',gethostbyaddr($gps_conf->hostname));
$hostname  = $hostname_arr[0];
$localhostname = php_uname('n');

if($hostname == $localhostname) {
   $sock = @fsockopen($server, $port, $errno, $errstr, 2);
   @fwrite($sock, "?WATCH={\"enable\":true}\n");
   usleep(100);
   @fwrite($sock, "?POLL;\n");
   for($tries = 0; $tries < 10; $tries++){
         $resp = @fread($sock, 2000); # SKY can be pretty big
         if (preg_match('/{"class":"POLL".+}/i', $resp, $m)){
               $resp = $m[0];
               break;
         }
   }
   @fclose($sock);
   if (!$resp) {
      $resp = '{"class":"ERROR","message":"no response from GPS daemon"}';
      die($resp);
   }
}
$to = json_decode($resp);
//print_r($to);

if($to->time != "") {

   $curr_gps_time_stamp = strtotime($to->tpv[0]->time);
   echo "GPS TIME: ({$to->time}) $curr_gps_time_stamp\n";
   $curr_gps_date_time_formatted = date('Y-m-d H:i:s',$curr_gps_time_stamp);
   $curr_system_timestamp = time();
   echo "CURR SYSTIME: $curr_system_timestamp\n";
   $curr_system_date_time_formatted = date('Y-m-d H:i:s',$curr_system_timestamp);
   $cmd = "";
   if(abs($curr_system_timestamp - $curr_gps_time_stamp) >= 30) {
      echo "UPDATING LOCAL:  ($curr_gps_date_time_formatted) $curr_gps_time_stamp > ($curr_system_date_time_formatted) $curr_system_timestamp ".abs($curr_system_timestamp - $curr_gps_time_stamp)." seconds off\n";
      $cmd = "sudo -u root date -s '{$curr_gps_date_time_formatted}'";
      echo "DATE SET CMD: $cmd\n";
      echo shell_exec($cmd);
   } else {
      echo "NOT UPDATING LOCAL:  ($curr_gps_date_time_formatted) $curr_gps_time_stamp > ($curr_system_date_time_formatted) $curr_system_timestamp ".abs($curr_system_timestamp - $curr_gps_time_stamp)." seconds off\n";

   }

   if($gps->remote_host != "") {
      // we should first pull the time from this remote
      // then compare it with the known current time.
      // if time is off more than 60 seconds we set it now.
      // Hopefully NTP client on the remote can keep it updated after that point
      $remote_host = $gps->remote_host;
      $rpc = new Rpc($remote_host);
      $curr_remote_time_resp = $rpc->run_remote('date +"%Y-%m-%d %T"');
      $remote_resp_arr = explode("\n",$curr_remote_time_resp);
      $remote_time = trim($remote_resp_arr[0]);
      //echo "\n\n$remote_time\n\n";
      // now we have the remote time and we know the approx localtime in $curr_gps_time_stamp
      // so lets do some date/time math and find out how far apart they are.
      // if > 30 seconds we'll run the next run_remote()
      $remote_timestamp = strtotime($remote_time);
      if(abs($curr_gps_time_stamp - $remote_timestamp) >= 15) {
         echo "UPDATING REMOTE: ($curr_gps_date_time_formatted) $curr_gps_time_stamp > ($remote_time) $remote_timestamp ".abs($curr_gps_time_stamp - $remote_timestamp)." seconds off\n";
         $cmd = "sudo -u root date -s '{$curr_gps_date_time_formatted}'";
         $rpc->run_remote($cmd);
      } else {
         echo "NOT UPDATING REMOTE: ($curr_gps_date_time_formatted) $curr_gps_time_stamp - ($remote_time) $remote_timestamp ".abs($curr_gps_time_stamp - $remote_timestamp)." seconds off\n";
      }
   }

} else {
   die("ERROR: no valid datetime");
}

?>