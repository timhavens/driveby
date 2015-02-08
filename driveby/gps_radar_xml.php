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
   $localhost = $config->conf->http_gui_host;
   $remotehost = $config->conf->http_gui_remote;
   $gps_conf = $config->conf->gps[0];

   header("content-type: text/xml");
   $all_data_set_xml = "";
   $tmp_sat_data_arr = array();
   $sat_data_arr = array();
   $deg_arr = range(360,0,1);
   $live_sat_arr = array();

   if(file_exists("{$gps_conf->az_el_out}")) {
      $fc_arr = file("{$gps_conf->az_el_out}");
      $live_sat_arr = array_slice($fc_arr, -20);
      foreach($live_sat_arr as $ls_row) {
         $lsr = trim($ls_row);
         $ls_arr = explode(",",$lsr);
         $live_sat_arr[$ls_arr[0]] = $ls_arr[0];
      }

      foreach($fc_arr as $row) {
         $r = trim($row);
         $r_arr = explode(",",$r);
         if(!isset($live_sat_arr[$r_arr[0]])) { continue; }
         $tmp_sat_data_arr["{$r_arr[0]}"]["{$r_arr[1]}"][] = $r_arr[2];
      }
      foreach($tmp_sat_data_arr as $sat_key => $az_arr) {
         foreach($az_arr as $sat_az => $el_arr) {
            $avg_el = round((array_sum($el_arr)/count($el_arr)));
            $rev_el_for_graphing = (90 - $avg_el);
            $sat_data_arr[$sat_key][$sat_az] = $rev_el_for_graphing;
         }
      }
   }

   $xml_out = "";
   //print_r($sat_data_arr);
   //exit;
   foreach($sat_data_arr as $g_sat_series_key => $g_az_arr) {
      $xml_out .= "<dataset seriesname=\"PRN $g_sat_series_key\" plotBorderAlpha=\"100\" anchorBorderThickness=\"0\" >\n";
      foreach($deg_arr as $az) {
         if(isset($g_az_arr[$az])) {
            $xml_out .= "   <set value=\"{$g_az_arr[$az]}\" />\n";
         } else {
            $xml_out .= "   <set value=\"0\" />\n";
         }
      }
      $xml_out .= "</dataset>\n";
   }

   //print_r($xml_out);
   //exit;
?>
<?xml version='1.0' encoding='utf-8' standalone='yes'?>
<chart caption="GPS Radar Chart" animation="0" anchoralpha="0" showborder="0" plotFillAlpha="0" radarSpikeAlpha="20" >
<categories>
   <category label="NORTH" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="355" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="350" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="345" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="340" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="335" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="330" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="325" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="320" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="315" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="310" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="305" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="300" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="295" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="290" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="285" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="280" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="275" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="WEST" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="265" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="260" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="255" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="250" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="245" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="240" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="235" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="230" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="225" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="220" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="215" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="210" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="205" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="200" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="195" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="190" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="185" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="S" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="175" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="170" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="165" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="160" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="155" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="150" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="145" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="140" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="135" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="130" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="125" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="120" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="115" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="110" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="105" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="100" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="95" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="EAST" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="85" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="80" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="75" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="70" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="65" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="60" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="55" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="50" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="45" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="40" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="35" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="30" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="25" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="20" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="15" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="10" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="5" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="" />
   <category label="" />
</categories>
<?php
   echo $xml_out;
?>
</chart>
