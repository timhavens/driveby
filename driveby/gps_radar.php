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
?>
<!DOCTYPE html>
<html>
   <head>
     <meta charset="utf-8">
     <title>GPS Radar</title>
   </head>

   <body style="font-family:Arial;background-color:grey;">
      <table>
          <tr>
              <td>
                  <a href="/driveby_new/gps_radar_off.php" target="_self">GPS Visibility OFF</a>
              </td>
          </tr>
         <tr>
            <td colspan="2">
               <form action="/driveby_new/control.php" method="post" target="hid_iframe">
                  <button type="submit" value="start_gps" name="submit">Start GPS</button>
                  <button type="submit" value="stop_gps" name="submit">Stop GPS</button>
                  <button type="submit" value="reset_usb" name="submit">Reset USB</button>
                  <button type="submit" value="clear_gps" name="submit">Clear GPS</button>
                  <iframe name='hid_iframe' src='/driveby_new/blank.php' style="width: 200px; height: 40px; overflow:hidden;" frameBorder="0"></iframe>
               </form>
            </td>
         </tr>
         <tr>
            <td width="50%" valign="top">
               <iframe frameBorder="0" scrolling="no" src="/driveby_new/gps_radar_chart.php" style="width:550px;height:560px"></iframe>
            </td>
            <td valign="top" width="50%">
               <table width="100%">
                  <tr>
                     <td valign="top">
                        <iframe frameBorder="0" src="/driveby_new/gps_table.php" style="width:100%;height:250px"></iframe>
                     </td>
                  </tr>
                  <tr>
                     <td colspan="2" valign="top">
                        <iframe frameBorder="0" src="/driveby_new/gps_dop_table.php" style="width:100%;height:70px"></iframe>
                     </td>
                  </tr>
                  <tr>
                     <td colspan="2" valign="top">
                        <iframe frameBorder="0" src="/driveby_new/compass_table.php" style="width:100%;height:70px"></iframe>
                     </td>
                  </tr>
                  <tr>
                     <td colspan="2" valign="top">
                        <iframe frameBorder="0" src="/driveby_new/gps_lat_long_table.php" style="width:100%;height:70px"></iframe>
                     </td>
                  </tr>
               </table>
            </td>
         </tr>
      </table>
   </body>
</html>