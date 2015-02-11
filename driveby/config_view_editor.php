<?php
   /*
    * RELEASED AS GNU General Public License v3 (GPL-3)
    * http://www.gnu.org/licenses/quick-guide-gplv3.html
    *
    * Originally written by Tim R. Havens 2015-01-27 please track changes below
    *
    */
   include_once('classes/Config.class.inc');
   $config = new Config();

   if(isset($_REQUEST['Submit']) and $_REQUEST['Submit'] == 'save_config') {
      //print_r($_REQUEST);
      foreach($_REQUEST as $k => $v) {
         $k_name_arr = preg_split("/:/",trim($k));
         print_r($k_name_arr);
         echo "\n\n$v\n\n";
      }
      exit;
   } else {
      //echo "TEST FAIL\n";
      //exit;
   }

   /* SAVE ENTIRE CONFIG */
   function set_config_form_content() {

   }

   /* SAVE ITEM ONLY FUNCT */
   function set_item($item_name, $item_value) {

   }

   /* GET ITEM ONLY FUNCT */
   function get_item($item_name) {

   }

   function get_config_form_content() {
      global $config;

      foreach($config->conf as $fkey => $fval) {

         echo "                     <tr>\n";
         echo "                        <td><b>$fkey</b></td>\n";

         if(is_array($fval)) {
            echo "                        <td>&nbsp;</td>\n";
            echo "                        <td>&nbsp;</td>\n";
            echo "                        <td>&nbsp;</td>\n";
            echo "                     </tr>\n";
            foreach($fval as $fval_key => $fval_val) {
               echo "                     <tr>\n";
               echo "                        <td>&nbsp;</td>\n";
               echo "                        <td><b>$fval_key</b></td>\n";
               echo "                        <td>&nbsp;</td>\n";
               echo "                        <td>&nbsp;</td>\n";
               echo "                     </tr>\n";

               if(is_object($fval_val)) {

                  foreach($fval_val as $fval_val_key => $fval_fval_fval) {
                     $input_name_str = preg_replace('/ /',':',$fkey);
                     $input_name_str .= ":".preg_replace('/ /',':',$fval_key);
                     $input_name_str .= ":".preg_replace('/ /',':',$fval_val_key);
                     echo "                     <tr>\n";
                     echo "                        <td>&nbsp;</td>\n";
                     echo "                        <td>&nbsp;</td>\n";
                     echo "                        <td><b>$fval_val_key</b></td>\n";
                     echo "                        <td>\n";
                     echo "                           <input type=\"text\" size=\"35\" name=\"$input_name_str\" value=\"$fval_fval_fval\">\n";
                     echo "                        </td>\n";
                     echo "                     </tr>\n";
                     continue;
                  }

               } else {
                  $input_name_str = preg_replace('/ /',':',$fkey);
                  $input_name_str .= ":".preg_replace('/ /',':',$fval_key);
                  echo "                     <tr>\n";
                  echo "                        <td>&nbsp;</td>\n";
                  echo "                        <td>&nbsp;</td>\n";
                  echo "                        <td><b>$fval_key</b></td>\n";
                  echo "                        <td>\n";
                  echo "                           <input type=\"text\" size=\"35\" name=\"$input_name_str\" value=\"$fval_val\">\n";
                  echo "                        </td>\n";
                  echo "                     </tr>\n";
                  continue;

               }
            }

         } else {

            $input_name_str = preg_replace('/ /',':',$fkey);
            $input_name_str .= ":";
            echo "                        <td>&nbsp;</td>\n";
            echo "                        <td>&nbsp;</td>\n";
            echo "                        <td>\n";
            echo "                           <input type=\"text\" size=\"35\" name=\"$input_name_str\" value=\"$fval\">\n";
            echo "                        </td>\n";
            echo "                     </tr>\n";

         }
      }
   }
?>
<!DOCTYPE html>
<html>
   <head>

   </head>

   <body style="font-family:Arial;background-color:grey;">
      <table style="width: 1324px;">
         <tr>
            <td>
               Config Editor
            </td>
         </tr>
         <tr>
            <td>
               <form action="http://<?=$config->conf->http_gui_host?>/driveby/config_view_editor.php" method="POST">
                  <table>
                     <?php get_config_form_content(); ?>
                     <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>
                           <button type="Submit" value="save_config" name="Submit" style="width: 4em;  height: 4em; background-color: gray; color: white">Save</button>
                        </td>
                     </tr>
                  </table>
               </form>
            </td>
         </tr>
      </table>
   </body>
</html>

