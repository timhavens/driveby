<?php
// https://developers.google.com/chart/interactive/docs/gallery/gauge

/*
 * RELEASED AS GNU General Public License v3 (GPL-3)
 * http://www.gnu.org/licenses/quick-guide-gplv3.html
 *
 * Originally written by Tim R. Havens 2015-01-27 please track changes below
 *
 */
$dataUrl = "/driveby/fc_data.php";
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
<!DOCTYPE html>
<html>
  <head>
   <script type="text/javascript" src="https://www.google.com/jsapi"></script>
   <script type="text/javascript">
      google.load("visualization", "1", {packages:["gauge"]});
      google.setOnLoadCallback(drawChart);
      var data,chart,options;

      function drawChart() {
         data = google.visualization.arrayToDataTable([
            ['Label', 'Value'],
            ['NF <?=$rtl_0_mhz?>M', -85],
            ['NF <?=$rtl_1_mhz?>M', -85],
            ['NF <?=$rtl_2_mhz?>M', -85],
            ['NF <?=$rtl_3_mhz?>M', -85],
            ['NF <?=$rtl_4_mhz?>M', -85]
         ]);

         options = {
            min: -85,
            max:-30,
            width: 1024, height: 250,
            greenFrom: -85, greenTo: -77,
            yellowFrom:-77, yellowTo: -55,
            redFrom: -55, redTo: -30,
            minorTicks: 5
         };

         chart = new google.visualization.Gauge(document.getElementById('chart_div'));

         chart.draw(data, options);
      }

      var xmlhttp = new XMLHttpRequest();
      var url = "/driveby/nf_data.php";

      function getMapDataJson(data) {
         var xhr = new XMLHttpRequest();
         var thisurl = url;
         xhr.open('GET', thisurl, true);
         xhr.onload = function() {
            setNoiseFloorData(this.responseText);
         };
         xhr.send();
         setTimeout(getMapDataJson,1500); // run this again every 1.5 seconds
      }

      function setNoiseFloorData(nfData) {
         var tmpNFData = JSON.parse(nfData);
         data.setValue(0, 1, tmpNFData[0]);
         data.setValue(1, 1, tmpNFData[1]);
         data.setValue(2, 1, tmpNFData[2]);
         data.setValue(3, 1, tmpNFData[3]);
         data.setValue(4, 1, tmpNFData[4]);
         chart.draw(data, options);
      }

      function sleep(milliseconds) {
        var start = new Date().getTime();
        for (var i = 0; i < 1e7; i++) {
          if ((new Date().getTime() - start) > milliseconds){
            break;
          }
        }
      }

      // RTL NF CALIBRATION (used for mapping)
      function runRTLNFCalibration() {
         var xhr1 = new XMLHttpRequest();
         var thisurl = "/driveby/rtl_nf_calibration.php";
         xhr1.open('GET', thisurl, true);
         xhr1.onload = function() {
            //we could display this someplace this.responseText but it's not really needed at this point
         };
         xhr1.send();
         setTimeout(runRTLNFCalibration,10000); // run this again every 10 seconds
      }

      sleep(3);
      getMapDataJson();
      runRTLNFCalibration();
   </script>

  </head>
  <body style="font-family:Arial;background-color:grey;">
      <table style="width: 1324px;">
          <tr>
              <td>
                 <a href="/driveby/rtl_nf_calibration.php" target="hid_iframe">force rtl calib</a>
              </td>
          </tr>
         <tr>
            <td>
               <iframe frameBorder="0" src="/driveby/nf_line_chart.php" scrolling="no" style="width:98%; height:260px"></iframe>
            </td>
         </tr>
         <tr>
            <td>
               <div id="chart_div" style="width: 98%; height: 120px;"></div>
            </td>
         </tr>
         <tr><td>&nbsp;</td></tr>
         <tr><td>&nbsp;</td></tr>
         <tr><td>&nbsp;</td></tr>
         <tr>
            <td>
               <table style="width: 1024px;">
                  <tr>
                     <td align="center">
                        <form action="http://<?=$localhost?>/driveby/control.php" method="post" target="hid_iframe">
                           <button type="submit" value="start_rtl_0" name="submit" style="width: 4em;  height: 4em; background-color: green; color: white">Start <?=$rtl_0_mhz?></button>
                           <br><br>
                           <button type="submit" value="stop_rtl_0" name="submit" style="width: 4em;  height: 4em; background-color: red; color: white">Stop <?=$rtl_0_mhz?></button>
                           <br><br>
                        </form>
                     </td>
                     <td align="center">
                        <form action="http://<?=$localhost?>/driveby/control.php" method="post" target="hid_iframe">
                           <button type="submit" value="start_rtl_1" name="submit" style="width: 4em;  height: 4em; background-color: green; color: white">Start <?=$rtl_1_mhz?></button>
                           <br><br>
                           <button type="submit" value="stop_rtl_1" name="submit" style="width: 4em;  height: 4em; background-color: red; color: white">Stop <?=$rtl_1_mhz?></button>
                           <br><br>
                        </form>
                     </td>
                     <td align="center">
                        <form action="http://<?=$localhost?>/driveby/control.php" method="post" target="hid_iframe">
                           <button type="submit" value="start_rtl_2" name="submit" style="width: 4em;  height: 4em; background-color: green; color: white">Start <?=$rtl_2_mhz?></button>
                           <br><br>
                           <button type="submit" value="stop_rtl_2" name="submit" style="width: 4em;  height: 4em; background-color: red; color: white">Stop <?=$rtl_2_mhz?></button>
                           <br><br>
                        </form>
                     </td>
                     <td align="center">
                        <form action="http://<?=$localhost?>/driveby/control.php" method="post" target="hid_iframe">
                           <button type="submit" value="start_rtl_3" name="submit" style="width: 4em;  height: 4em; background-color: green; color: white">Start <?=$rtl_3_mhz?></button>
                           <br><br>
                           <button type="submit" value="stop_rtl_3" name="submit" style="width: 4em;  height: 4em; background-color: red; color: white">Stop <?=$rtl_3_mhz?></button>
                           <br><br>
                        </form>
                     </td>
                     <td align="center">
                        <form action="http://<?=$localhost?>/driveby/control.php" method="post" target="hid_iframe">
                           <button type="submit" value="start_rtl_4" name="submit" style="width: 4em;  height: 4em; background-color: green; color: white">Start <?=$rtl_4_mhz?></button>
                           <br><br>
                           <button type="submit" value="stop_rtl_4" name="submit" style="width: 4em;  height: 4em; background-color: red; color: white">Stop <?=$rtl_4_mhz?></button>
                           <br><br>
                        </form>
                     </td>
                  </tr>
                  <tr>
                     <td colspan="5">
                        <iframe name='hid_iframe' src='/driveby/blank.php' style="width: 800px; height: 0px; overflow:hidden;" frameBorder="0"></iframe>
                     </td>
                  </tr>
               </table>
            </td>
         </tr>
      </table>
  </body>
</html>


