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

         options = {
            legend: 'none',
            colors: ['#087037'],
            pointShape: 'star',
            pointSize: 10,
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

         getDataJson();
         //window.setInterval(getDataJson, 2000);
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
      var url = "/driveby/gps_sat_pos_json.php";

      function plotAz(az,el) {
         var radius = 90;
         var x = Math.round((radius * Math.cos(az * Math.PI / 180))*10000)/10000;
         var y = Math.round((radius * Math.sin(az * Math.PI / 180))*10000)/10000;
         x = (x-(x*(el/90)));
         y = (y-(y*(el/90)));

         //alert([y,x]);
         //
         // we need to relate an PRN ID with this point somehow
         // we also need to asign a different color with this each point we add
         // we also need to be able to UPDATE an existing PRN ID with each new plot
         data.addRow([ y, x ]);
      }

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
               // loop incoming array
               //for(i=0;i<tmpNewData.length;i++) {
               //   plotAz(tmpNewData[i].az,tmpNewData[i].el);
               //}
               var keys_arr = Object.keys(tmpNewData);
               for(i=0;keys_arr.length;i++) {
                  var key = keys_arr[i];
                  for(j=0;keys_arr[key].length;j++) {
                     if(typeof tmpNewData[key][j] === 'undefined') {
                     } else {
                        plotAz(tmpNewData[key][j].az,tmpNewData[key][j].el);
               chart.draw(data, options);
                     }
                  }
               }


            }
         }
      }

      function updateRow(newDataRowArr) {
         if (typeof newDataRowArr === 'undefined') {
            return;
         }
         /*                           90,0
          *                             -
          *                             -
          *                             -
          *                             -
          * -90,0 -----------------------------------------------------0,90
          *                             -
          *                             -
          *                             -
          *                             -
          *                             -
          *                            0,0
          */
         //
         // FIRST NUMBER is LEFT to RIGHT  from 0 with a range of -90 to +90 (which is 180 degrees)
         // SECOND NUMBER is TOP to BOTTOM from 0 with a range of -90 to +90 (which is 180 degrees)
         //
         // IN OUR RENDERED Chart EL of 90 is directly overhead which equates to 0,0
         // IF EL was at any horizon it would be +90 or -90 so we have a range of 90 degrees total for EL (duh right?)
         // The quadrant which we plot EL depends on the AZ location which is related to the below detail.
         // ---------------------
         // TO Start with we can just plot any az at a EL of 0 which would place it on the edge of our graph.
         // this is a good start to getting AZ correct FIRST.  EL is the EASY part!!!
         //
         // in the datatable there are two columns which define the position in the scatter chart.
         // 0,0 is the center
         // 0,90 is the V 0 and H+90 is the edge of the graph
         // 90,90 is the V top-edge and 90 is the H+90 edge of the graph (RIGHT SIDE)
         // 0,-90 is the V 0 and the H-90 is the edge of the graph (LEFT SIDE)
         //
         // if AZ between 91 and 269 then V is negative
         // if AZ between 271 and 360 or 0 and 89
         // if AZ is 90 or 270 exactly then this = 0
         //
         // LETS JUST HARD CODE some TEST NUMBERS TO SEE HOW THEY PLOT FIRST.
         // if EL is always between 0 and 90. this determines the distance from 0,0 at the center of the graph. 0 is the middle, 90 is one of the edges

         //data.addRow([newDataRowArr[0]['az'],newDataRowArr[0]['el']]);
         //data.addRow([newDataRowArr[0]['az'],newDataRowArr[0]['el']]);

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
