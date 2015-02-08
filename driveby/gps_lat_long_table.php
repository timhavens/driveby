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
   /*
      stdClass Object
      (
          [device] => 0
          [data_out] => /disk1/driveby_data/gps_0_data.out
          [data_out_local] => /disk1/driveby_data/gps_0_data.out
          [log_all_data_out] => /disk1/driveby_data/gps_0_log_all_data.out
          [log_all_data_out_local] => /disk1/driveby_data/gps_0_log_all_data.out
          [az_el_out] => /disk1/driveby_data/gps_0_az_el.out
          [az_el_out_local] => /disk1/driveby_data/gps_0_az_el.out
          [dop_out] => /disk1/driveby_data/gps_0_dop.out
          [dop_out_local] => /disk1/driveby_data/gps_0_dop.out
          [system_stat_out] => /disk1/driveby_data/gps_0.out
          [system_stat_all_data_out] => /disk1/driveby_data/gps_0_log_all_data.out
          [hostname] => 10.0.1.2
      )
    */
   $live_sat_arr = array();
   $fc_arr = array();

   if(file_exists($gps_conf->data_out_local)) {
      $fc_arr = array_reverse(array_slice(file($gps_conf->data_out_local),-1));

      foreach($fc_arr as $ls_row) {
         $lsr = trim($ls_row);
         $ls_arr = explode(",",$lsr);
         $lat_long_arr = explode(" ",$ls_arr[3]);
         $live_sat_arr["lat"] = doubleval($lat_long_arr[0]);
         $live_sat_arr["long"] = doubleval($lat_long_arr[1]);
         break;
      }
   }
?>
<!DOCTYPE html>
<html>
  <head>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["table"]});
      google.setOnLoadCallback(drawTable);
      var data, table;

      function drawTable() {
         data = new google.visualization.DataTable();
         data.addColumn('number', 'LAT');
         data.addColumn('number', 'LONG');

         <?php
               if(isset($live_sat_arr['lat']) and isset($live_sat_arr['long'])) {
                  $lat  = $live_sat_arr['lat'];
                  $long = $live_sat_arr['long'];

                  if($lat != 0 and $long != 0) {
                     echo "data.addRow([{v: $lat}, {v: $long}]);\n";
                  }
               } else {
                  $lat=$gps_conf->lat_default;
                  $long=$gps_conf->long_default;
                  echo "data.addRow([{v: $lat}, {v: $long}]);\n";
               }
         ?>

         table = new google.visualization.Table(document.getElementById('table_div'));

         table.draw(data, {showRowNumber: false});
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
      var url = "/driveby_new/gps_lat_long_table_json.php";

      function getDataJson() {
         var xhr = new XMLHttpRequest();
         var thisurl = url;
         xhr.open('GET', thisurl, true);
         xhr.onload = function() {
            updateDataTable(this.responseText);
         };
         xhr.send();
         setTimeout(getDataJson,2500); // run this again every 10 seconds
      }

      function updateDataTable(newData) {
         var tmpNewData = JSON.parse(newData);
         //alert(tmpNewData);

         if (typeof data === 'undefined' | typeof tmpNewData === 'undefined') {
            return;
         } else {

            if(userInteraction) {

            } else {
               for(i=0;i<=tmpNewData.length;i++) {
                  // NOTE: we need to know if data should be expireing
                  //       if we aren't getting updates for an existing row
                  //       for say 3 minutes we should probably delete the row
                  //       from the dataTable.
                  updateRow(tmpNewData[i]);
                  // NOTE: if updateRow() returns 0
                  //       this means we didn't update or add one.
                  table.draw(data, {showRowNumber: false});
               }
            }
         }
      }

      function updateRow(newDataRowArr) {
         if (typeof newDataRowArr === 'undefined') {
            return;
         }
         var prn_num = newDataRowArr[0];
         var foundRows = data.getFilteredRows([{column: 0, value: prn_num}]);

         if(foundRows.length === 1) {
            // NOTE: if we update a row with a SS greater than X
            //       we should see if we can do some sort of timed row color highlight
            //       that fades after X seconds... (would be a neat effect)
            data.setValue(foundRows[0], 1, newDataRowArr[1]);
            data.setValue(foundRows[0], 2, newDataRowArr[2]);
         } else {
            // NOTE if you don't have a foundRow[0] then you should be adding one here.
            data.addRow(newDataRowArr);
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
    <div id="table_div"></div>
  </body>
</html>
