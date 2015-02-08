<?php

/*
 * RELEASED AS GNU General Public License v3 (GPL-3)
 * http://www.gnu.org/licenses/quick-guide-gplv3.html
 *
 * Originally written by Tim R. Havens 2015-01-27 please track changes below
 *
 */

?>
<html>
<head>
  <script type="text/javascript" src="https://www.google.com/jsapi"></script>
  <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      var data,chart,options;

      function drawChart() {
         data = new google.visualization.DataTable();
         data.addColumn('number');
         data.addColumn('number');

         //var radius = 90;
         //for (var i = 0; i < 6.28; i += 0.1)
         //   data.addRow([radius * Math.cos(i), radius * Math.sin(i)]);
         //data.addRows([
         //   [-180, -300],
         //   [-170, -50],
         //   [-70, -30],
         //   [150, 64],
         //   [160, 256]
         //]);
         // Our central point, which will jiggle.
         data.addRow([0, 0]);

         options = {
            legend: 'none',
            colors: ['#087037'],
            pointShape: 'star',
            pointSize: 18,
            animation: {
               duration: 200,
               easing: 'inAndOut',
            },
            hAxis: {
                viewWindow: {
                    min: -90,
                    max: 90
                },
                ticks: [-90, -80, -70, -60, -50, -40, -30, -20, -10, 0, 10, 20, 30, 40, 50, 60, 70, 80, 90]
            },
            vAxis: {
                viewWindow: {
                    min: -90,
                    max: 90
                },
                ticks: [-90, -80, -70, -60, -50, -40, -30, -20, -10, 0, 10, 20, 30, 40, 50, 60, 70, 80, 90]
            }
         };

         chart = new google.visualization.ScatterChart(document.getElementById('animatedshapes_div'));
         chart.draw(data, options);

         window.setInterval(getDataJson, 5000);
      }

      // TRH Add-ons
      var userInteraction = false;
      /*
       *
       * See javascript block in BODY area after the chart_div DIV element
       * it was placed AFTER the DIV element so that it could SEE the element
       * and not be NULL when the listeners are being created for mouseover/mouseout events
       *
       */
      function onmouseovercheck() {
         // event
         userInteraction = true;
      }
      function onmouseoutcheck() {
         // event
         userInteraction = false;
      }

      var xmlhttp = new XMLHttpRequest();
      var url = "/driveby_new/compass_table_json.php";

      function getDataJson() {
         var xhr = new XMLHttpRequest();
         var thisurl = url;
         xhr.open('GET', thisurl, true);
         xhr.onload = function() {
            updateDataTable(this.responseText);
         };
         xhr.send();
      }

      function updateDataTable(newData) {
         var tmpNewData = JSON.parse(newData);

         if (typeof data === 'undefined' | typeof tmpNewData === 'undefined') {
            return;
         } else {

            if(userInteraction) {
            } else {
               updateRow(tmpNewData);
               chart.draw(data, options);
            }
         }
      }

      function updateRow(newDataRowArr) {
         if (typeof newDataRowArr === 'undefined') {
            return;
         }
            data.setValue(0, 0, newDataRowArr[0]);
            data.setValue(0, 1, newDataRowArr[1]);
      }

      function sleep(milliseconds) {
        var start = new Date().getTime();
        for (var i = 0; i < 1e7; i++) {
          if ((new Date().getTime() - start) > milliseconds){
            break;
          }
        }
      }

      sleep(1);
      //getDataJson();
      // END
   </script>
</head>

<body>
   <div id="animatedshapes_div" style="width: 500px; height: 500px;"></div>
</body>
</html>
