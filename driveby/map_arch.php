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

$rtl_0_mhz = $config->conf->rtl[0]->mhz;
$rtl_1_mhz = $config->conf->rtl[1]->mhz;
$rtl_2_mhz = $config->conf->rtl[2]->mhz;
$rtl_3_mhz = $config->conf->rtl[3]->mhz;
$rtl_4_mhz = $config->conf->rtl[4]->mhz;

$results = "";
global $reload_parent_window;
$reload_parent_window = false;

function dirToArray($dir) {
   $result = array();
   $cdir = scandir($dir);
   foreach ($cdir as $key => $value) {
      if (!in_array($value,array(".",".."))){
         if(preg_match('/\.log$/',$value)) continue;

         if (is_dir($dir . DIRECTORY_SEPARATOR . $value)) {
            $result[$value] = dirToArray($dir . DIRECTORY_SEPARATOR . $value);
         } else {
            $result[] = $value;
         }
      }
   }
   return $result;
}

function get_previous_run_data() {
   global $config;

   $return_arr = array();
   $final_return_arr = array();
   $disk1_driveby_data_arr = dirToArray($config->conf->data_storage_local);

   foreach($disk1_driveby_data_arr as $filename) {
      if(!preg_match('/_/',$filename)) continue;

      list($part1,$part2) = explode("_",$filename);
      $datetime_arr = explode("-",$part1);
      if(count($datetime_arr) < 2) { continue; }
      $datetime_str = $datetime_arr[0].'-'.$datetime_arr[1].'-'.$datetime_arr[2].' '.$datetime_arr[3].':'.$datetime_arr[4];
      $return_arr[$datetime_str][] = $filename;
   }

   foreach($return_arr as $dt_key => $dt_arr) {
      $has_gps = false;

      foreach($dt_arr as $dt_filename) {
         if(preg_match('/gps/',$dt_filename)) {
            $has_gps = true;
            break;
         }
      }
      if($has_gps and count($dt_arr) > 1) {
         $final_return_arr[$dt_key] = $dt_arr;
      }
   }

   return $final_return_arr;
}

$prev_run_arr = array();
$prev_run_arr = get_previous_run_data();

?>
<!DOCTYPE html>
<html>
   <head>
      <meta charset="UTF-8">
      <title>Driveby - Google Map Archives</title>
      <?php
         if($reload_parent_window) {
            echo '      <script type="text/javascript" language="javascript">'."\n";
            echo '         parent.location.reload();'."\n";
            echo '      </script>'."\n";
         }
      ?>
   </head>
   <body style="font-family:Arial;background-color:grey;">
      Google Map Archive Control Panel
      <form action="/driveby/map.php" method="get" target="_blank">
          <input type="hidden" name="nocenter" value="1">
         <table>
             <tr>
                 <td>
                     <select name="freq">
                         <option value="">ALL</option>
                         <option value="<?=$rtl_0_mhz?>"><?=$rtl_0_mhz?></option>
                         <option value="<?=$rtl_1_mhz?>"><?=$rtl_1_mhz?></option>
                         <option value="<?=$rtl_2_mhz?>"><?=$rtl_2_mhz?></option>
                         <option value="<?=$rtl_3_mhz?>"><?=$rtl_3_mhz?></option>
                         <option value="<?=$rtl_4_mhz?>"><?=$rtl_4_mhz?></option>
                     </select>
                 </td>
             </tr>
            <tr>
               <td>
                  <select name="RV_TS">
                     <option value="">REVIEW PREV RUN</option>
                     <?php
                        foreach($prev_run_arr as $dt_key => $dt_arr) {
                           echo "<option value=\"$dt_key\">$dt_key</option>\n";
                        }
                     ?>
                  </select>
                  <input type="submit" value="map_this">
               </td>
            </tr>
         </table>
      </form>
      <table>
         <tr>
            <td>
               <pre>
               <?=$results?>
               </pre>
            </td>
         </tr>
      </table>
   </body>
</html>
