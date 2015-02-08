<?php
/*
 * RELEASED AS GNU General Public License v3 (GPL-3)
 * http://www.gnu.org/licenses/quick-guide-gplv3.html
 *
 * Originally written by Tim R. Havens 2015-01-27 please track changes below
 *
 */
   header("content-type: text/xml");
?>
<?xml version='1.0' encoding='utf-8' standalone='yes'?>
<chart manageresize="1" origw="270" origh="270"
       upperlimit="360"
       lowerlimit="0"
       upperlimitdisplay=" "
       lowerlimitdisplay="N"
       bgcolor="202020"
       showborder="0"
       showvalue="1"
       valuebelowpivot="1"
       majortmnumber="12"
       majortmheight="9"
       minortmnumber="5"
       minortmcolor="000000"
       minortmheight="3"
       majortmthickness="2"
       gaugeinnerradius="0"
       gaugeouterradius="85"
       gaugestartangle="90"
       gaugeendangle="-270"
       charttopmargin="0"
       chartleftmargin="0"
       chartrightmargin="0"
       chartbottommargin="0"
       basefontcolor="333333"
       decimals="0"
       gaugeoriginx="135"
       gaugeoriginy="135"
       managevalueoverlapping="1"
       autoaligntickvalues="1"
       tickvaluedistance="5"
       datastreamurl="/driveby_new/gps_az_stream.php"
       refreshInterval="3">
   <colorrange>
      <color minvalue="0" maxvalue="360" code="00B900" bordercolor="00B900" />
   </colorrange>
   <dials>
      <dial id="az_dial" radius="100" value="0" tooltext="Azimuth" bgcolor="#FF0000" />
      <dial id="track_dial" radius="90" value="0" tooltext="Track Azimuth" bgcolor="#D3D3D3" borderAlpha='0' />
   </dials>
   <annotations>
      <annotationgroup>
         <annotation type="rectangle"
                     x="$chartStartX+1"
                     y="$chartStartY+1"
                     tox="$chartEndX-1"
                     toy="$chartEndY-1"
                     radius="15"
                     showborder="1"
                     fillcolor="333333"
                     bordercolor="333333"
                     borderthickness="2" />
         <annotation type="rectangle"
                     x="$chartStartX+8"
                     y="$chartStartY+8"
                     tox="$chartEndX-8"
                     toy="$chartEndY-8"
                     radius="15"
                     showborder="1"
                     fillcolor="FFFFFF,009999,FFFFFF"
                     fillangle="45"
                     fillalpha="100,100,100"
                     bordercolor="333333" />
      </annotationgroup>
   </annotations>
</chart>
<?php
