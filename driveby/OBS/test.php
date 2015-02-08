<?php
/*
 * http://www.fusioncharts.com/explore/angular_8/
 */
?>
<!DOCTYPE html>
<html>
   <head>
     <meta charset="utf-8">
     <title>GPS</title>
     <script type="text/javascript" language="javascript" src="/driveby_new/js/FusionCharts.js"></script>
     <script type="text/javascript" src="/driveby_new/js/jquery-1.8.3.js"></script>
     <script type="text/javascript" src="/driveby_new/js/jquery-ui-1.9.1.custom.js"></script>
   </head>

   <body>

               <div id="speedcanvas">TEST</div>
               <script type="text/javascript">
                  var myChart = new FusionCharts("/driveby_new/FusionCharts/Gadgets/AngularGauge.swf", "myChartId1", "200", "200", "0", "0");
                  myChart.setDataURL(encodeURIComponent("http://127.0.0.1/driveby_new/gps_speed_xml.php"));
                  myChart.render("speedcanvas");
               </script>

   </body>
</html>