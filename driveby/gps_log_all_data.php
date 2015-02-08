<?php
/*
 * RELEASED AS GNU General Public License v3 (GPL-3)
 * http://www.gnu.org/licenses/quick-guide-gplv3.html
 *
 * Originally written by Tim R. Havens 2015-01-27 please track changes below
 *
 */
include_once('classes/Client.Gps.class.inc');
include_once('classes/Config.class.inc');
$sat_arr = array();
$config = new Config();

while(true) {
   $c = new Client();
   $c->connect(); // Initiate socket with the service
   $c->watch();   // Tell the service to start report event
   //$json_tpv_data = json_decode($c->getNext('TPV')); // Get the next message of class TPV ()
   $json_sky_data = json_decode($c->getNext('SKY')); // Get the next message of class SKY ()
   //$thistime= strtotime((string)$json_tpv_data->time);
   //$datetime = date('Y-m-d H:i:s',$thistime);

   $xdop = (double)$json_sky_data->xdop;
   $ydop = (double)$json_sky_data->ydop;
   $vdop = (double)$json_sky_data->vdop;
   $tdop = (double)$json_sky_data->tdop;
   $hdop = (double)$json_sky_data->hdop;
   $gdop = (double)$json_sky_data->gdop;
   $pdop = (double)$json_sky_data->pdop;

   write_dop_data($xdop,$ydop,$vdop,$tdop,$hdop,$gdop,$pdop);

   $sat_obj_arr = $json_sky_data->satellites;
   foreach($sat_obj_arr as $o) {
      if($o->used == 1) {
         $sat_arr["{$o->PRN}"]['el'] = $o->el;
         $sat_arr["{$o->PRN}"]['az'] = $o->az;
         $sat_arr["{$o->PRN}"]['ss'] = $o->ss;
         //echo "$datetime,{$o->PRN},{$o->az},{$o->ss}\n";
         write_prn_data($o->PRN,$o->az,$o->el,$o->ss);

      } else {
         if(isset($sat_arr["{$o->PRN}"])) {
            unset($sat_arr["{$o->PRN}"]);
         }
      }
   }
   //echo "$datetime SAT CNT: (".count($sat_arr).")\n";
   //echo "$xdop $ydop $vdop $tdop $hdop $gdop $pdop\n";
   //print_r($sat_arr);
   //echo "\n\n";

   //echo "{$json->mode},{$thistime},{$datetime},{$json->lat} {$json->lon},{$ft},{$json->speed},{$json->track},{$json->climb}\n";
   sleep(2);
}

function write_prn_data($prn, $az, $el, $ss) {
   global $config;
   $prn_file_path = $config->conf->gps[0]->az_el_out; //'/disk1/driveby_data/gps_0_az_el.out';
   file_put_contents($prn_file_path,"{$prn},{$az},{$el},{$ss}\n",FILE_APPEND);
}
function write_dop_data($x,$y,$v,$t,$h,$g,$p) {
   global $config;
   $prn_file_path = $config->conf->gps[0]->dop_out; //'/disk1/driveby_data/gps_0_dop.out';
   file_put_contents($prn_file_path,"{$x},{$y},{$v},{$t},{$h},{$g},{$p}\n",FILE_APPEND);
}

?>