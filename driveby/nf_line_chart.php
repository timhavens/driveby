<?php
   // https://google-developers.appspot.com/chart/interactive/docs/gallery/linechart

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

$rtl_0_mhz = $config->conf->rtl[0]->mhz;
$rtl_1_mhz = $config->conf->rtl[1]->mhz;
$rtl_2_mhz = $config->conf->rtl[2]->mhz;
$rtl_3_mhz = $config->conf->rtl[3]->mhz;
$rtl_4_mhz = $config->conf->rtl[4]->mhz;
?>
<html>
  <head>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);

      var data,chart,options,chart_div_item;

      function drawChart() {
         data = google.visualization.arrayToDataTable([
            ['Time', 'NF <?=$rtl_0_mhz?>M', 'NF <?=$rtl_1_mhz?>M', 'NF <?=$rtl_2_mhz?>M', 'NF <?=$rtl_3_mhz?>M', 'NF <?=$rtl_4_mhz?>M'],
            ['00:00:00', -82, -82, -82, -82, -82]
         ]);

         options = {
            min: -82,
            max: -74,
            width: 1024, height: 250,
            title: 'Rolling NF over Time',
            curveType: 'function',
            legend: { position: 'bottom' },
            chartArea:{left:10,top:0,width:'100%',height:'75%'},
            explorer: {
               maxZoomOut:2,
               keepInBounds: true
            }
         };

         chart = new google.visualization.LineChart(document.getElementById('chart_div'));

         chart.draw(data, options);

      }

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
      var url = "/driveby_new/nf_line_chart_json.php";

      function getDataJson(data) {
         var xhr = new XMLHttpRequest();
         var thisurl = url;
         xhr.open('GET', thisurl, true);
         xhr.onload = function() {
            setNoiseFloorData(this.responseText);
         };
         xhr.send();
         setTimeout(getDataJson,1500); // run this again every 10 seconds
      }

      function setNoiseFloorData(nfData) {
         var tmpNFData = JSON.parse(nfData);
         var max_datatable_rows = 900;
         if (typeof data === 'undefined') {
            return;
         } else {
            data.addRow(tmpNFData);
            if(userInteraction) {

            } else {
               var data_num_rows = data.getNumberOfRows();
               if(data_num_rows > max_datatable_rows) {
                  var data_num_rows_to_remove = (data_num_rows - max_datatable_rows);
                  data.removeRows(0,data_num_rows_to_remove);
               }
               chart.draw(data, options);
            }
         }
      }

      function sleep(milliseconds) {
        var start = new Date().getTime();
        for (var i = 0; i < 1e7; i++) {
          if ((new Date().getTime() - start) > milliseconds){
            break;
          }
        }
      }

      sleep(3);
      getDataJson();
    </script>
  </head>
  <body>
    <div id="chart_div" style="width: 1024px; height: 300px;"></div>
    <script type="text/javascript">
      chart_div_item = document.getElementById("chart_div");
      chart_div_item.addEventListener("mouseover", onmouseovercheck, false);
      chart_div_item.addEventListener("mouseout", onmouseoutcheck, false);
    </script>
  </body>
</html>