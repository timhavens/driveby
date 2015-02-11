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
 *    fuction redo() {
         myChart.render("gpscanvas");
         setTimeout(redo,5000);
      }
 */
?>
<!DOCTYPE html>
<html>
   <head>
     <meta charset="utf-8">
     <META HTTP-EQUIV="refresh" CONTENT="60">
     <title>GPS Radar</title>
     <script type="text/javascript" language="javascript" src="/driveby/js/FusionCharts.js"></script>
     <script type="text/javascript" src="/driveby/js/jquery-1.8.3.js"></script>
     <script type="text/javascript" src="/driveby/js/jquery-ui-1.9.1.custom.js"></script>
   </head>

   <body style="font-family:Arial;background-color:grey;">
      <table>
         <tr>
            <td width="50%" valign="top">
               <div id="gpscanvas">TEST</div>
               <script type="text/javascript">
                  var myChart = new FusionCharts("/driveby/FusionCharts/PowerCharts/Radar.swf", "myChartId", "550", "550", "0", "0");
                  myChart.setDataURL(encodeURIComponent("/driveby/gps_radar_xml.php"));
                  myChart.render("gpscanvas");
               </script>
            </td>
         </tr>
      </table>
   </body>
</html>
