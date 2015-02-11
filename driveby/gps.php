<?php
/*
 * RELEASED AS GNU General Public License v3 (GPL-3)
 * http://www.gnu.org/licenses/quick-guide-gplv3.html
 *
 * Originally written by Tim R. Havens 2015-01-27 please track changes below
 *
 */
/*
 * http://www.fusioncharts.com/explore/angular_8/
 */
?>
<!DOCTYPE html>
<html>
   <head>
     <meta charset="utf-8">
     <title>GPS</title>
     <script type="text/javascript" language="javascript" src="/driveby/js/FusionCharts.js"></script>
     <script type="text/javascript" src="/driveby/js/jquery-1.8.3.js"></script>
     <script type="text/javascript" src="/driveby/js/jquery-ui-1.9.1.custom.js"></script>
   </head>

   <body style="font-family:Arial;background-color:grey;">
      <table>
         <tr>
            <td>
               <div id="gpscanvas">TEST</div>
               <script type="text/javascript">
                  var myChart = new FusionCharts("/driveby/FusionCharts/Gadgets/AngularGauge.swf", "myChartId", "200", "200", "0", "0");
                  myChart.setDataURL(encodeURIComponent("/driveby/gps_xml.php"));
                  myChart.render("gpscanvas");
               </script>
            </td>
            <td>
               <div id="speedcanvas">TEST</div>
               <script type="text/javascript">
                  var myChart = new FusionCharts("/driveby/FusionCharts/Gadgets/AngularGauge.swf", "myChartId1", "200", "200", "0", "0");
                  myChart.setDataURL(encodeURIComponent("/driveby/gps_speed_xml.php"));
                  myChart.render("speedcanvas");
               </script>
            </td>
            <td valign="top">
               <a href="/driveby/gps_radar.php" target="_blank">Show Live GPS Plot</a>
            </td>
         </tr>
      </table>
   </body>
</html>

