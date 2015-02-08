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
<chart caption="Speedometer"
       captionfont="Arial"
       captionfontcolor="#333333"
       manageresize="1"
       origw="320"
       origh="320"
       tickvaluedistance="-10"
       bgcolor="#202020"
       upperlimit="54"
       lowerlimit="0"
       basefontcolor="#FFFFFF"
       majortmnumber="10"
       majortmcolor="#FFFFFF"
       majortmheight="8"
       majortmthickness="5"
       minortmnumber="5"
       minortmcolor="#FFFFFF"
       minortmheight="3"
       minortmthickness="2"
       pivotradius="10"
       pivotbgcolor="#000000"
       pivotbordercolor="#FFFFFF"
       pivotborderthickness="2"
       tooltipbordercolor="#FFFFFF"
       tooltipbgcolor="#333333"
       gaugeouterradius="100"
       gaugestartangle="240"
       gaugeendangle="-60"
       gaugealpha="0"
       decimals="0"
       showcolorrange="0"
       placevaluesinside="1"
       pivotfillmix=""
       showpivotborder="1"
       annrenderdelay="0"
       gaugeoriginx="160"
       gaugeoriginy="160"
       showborder="0"
       datastreamurl="/driveby_new/gps_speed_stream.php"
       refreshInterval="3">
    <dials>
        <dial id="spd_dial" value="0" bgcolor="000000" bordercolor="#FFFFFF" borderalpha="100" basewidth="4" topwidth="4" borderthickness="2" valuey="260" />
    </dials>
    <annotations>
        <annotationgroup x="100" y="100">
            <annotation type="circle" radius="70" fillasgradient="1" fillcolor="#4B4B4B,#AAAAAA" fillalpha="100,100" fillratio="95,5" />
            <annotation type="circle" x="0" y="0" radius="60" showborder="1" bordercolor="cccccc" fillasgradient="1" fillcolor="#ffffff,#000000" fillalpha="50,100" fillratio="1,99" />
        </annotationgroup>
        <annotationgroup x="100" y="70" showbelow="0" scaletext="1">
            <annotation type="text" y="80" label="MPH" fontcolor="#FFFFFF" fontsize="12" bold="1" />
        </annotationgroup>
    </annotations>
</chart>