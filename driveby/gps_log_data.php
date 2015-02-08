<?php
/*
 * RELEASED AS GNU General Public License v3 (GPL-3)
 * http://www.gnu.org/licenses/quick-guide-gplv3.html
 *
 * Originally written by Tim R. Havens 2015-01-27 please track changes below
 *
 */
include_once('classes/Client.Gps.class.inc');

while(true) {
   $c = new Client();
   $c->connect(); // Initiate socket with the service
   $c->watch();   // Tell the service to start report event
   $data = $c->getNext('TPV'); // Get the next message of class TPV ()
   $json = json_decode($data);
   $thistime= strtotime((string)$json->time);
   $datetime = date('Y-m-d H:i:s',$thistime);
   $ft = round((float)$json->alt * 3.2808399,1);
   echo "{$json->mode},{$thistime},{$datetime},{$json->lat} {$json->lon},{$ft},{$json->speed},{$json->track},{$json->climb}\n";
   sleep(1);
}

?>
