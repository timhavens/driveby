<?php
   /*
    * RELEASED AS GNU General Public License v3 (GPL-3)
    * http://www.gnu.org/licenses/quick-guide-gplv3.html
    *
    * Originally written by Tim R. Havens 2015-01-27 please track changes below
    *
    */
   /*
    * NOTE To use this page we need to have
    * /usr/bin/php /var/www/html/driveby/gps_log_all_data.php&
    *
    * Running in the background.
    *
    * THIS NEEDS TO BE ADDED TO THE control.php page to turn it on and off as well as clear/archive it
    * THE WAY WE DO OTHER .out files
    *
    */
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
         data.addColumn('number', 'Tilt1');
         data.addColumn('number', 'Tilt2');
         data.addColumn('number', 'Compass AZ');
         data.addColumn('number', 'Gyro');
         data.addColumn('number', 'Accelerometer');
         data.addRow([0,0,0,0,0]);

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
      var url = "/driveby/compass_table_json.php";

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

         if (typeof data === 'undefined' | typeof tmpNewData === 'undefined') {
            return;
         } else {

            if(userInteraction) {

            } else {
               //for(i=0;i<=tmpNewData.length;i++) {
                  // NOTE: we need to know if data should be expireing
                  //       if we aren't getting updates for an existing row
                  //       for say 3 minutes we should probably delete the row
                  //       from the dataTable.
                  updateRow(tmpNewData);
                  // NOTE: if updateRow() returns 0
                  //       this means we didn't update or add one.
                  table.draw(data, {showRowNumber: false});
               //}
            }
         }
      }

      function updateRow(newDataRowArr) {
         if (typeof newDataRowArr === 'undefined') {
            return;
         }
            // NOTE: if we update a row with a SS greater than X
            //       we should see if we can do some sort of timed row color highlight
            //       that fades after X seconds... (would be a neat effect)
            data.setValue(0, 0, newDataRowArr[0]);
            data.setValue(0, 1, newDataRowArr[1]);
            data.setValue(0, 2, newDataRowArr[2]);
            data.setValue(0, 3, newDataRowArr[3]);
            data.setValue(0, 4, newDataRowArr[4]);
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
      getDataJson();

    </script>
  </head>
  <body>
    <div id="table_div"></div>
  </body>
</html>
