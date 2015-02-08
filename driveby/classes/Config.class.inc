<?php

/*
 * RELEASED AS GNU General Public License v3 (GPL-3)
 * http://www.gnu.org/licenses/quick-guide-gplv3.html
 *
 * Originally written by Tim R. Havens 2015-01-27 please track changes below
 *
 */

/**
 * Description of config
 *
 * @author timhavens
 */
class Config {
   public $conf;
   public $conf_file_path = "";

   public function __construct() {
      $this->conf_file_path = dirname(__FILE__)."/config.php";
      $this->get_config();
   }

   public function __destruct() {
      ;
   }

   public function get_conf_file_path() {
      return $this->conf_file_path;
   }

   public function set_config() {
      /* SAVE ENTIRE CONFIG */
   }

   public function set_config_item($item_name,$item_value) {
      /* SAVE ITEM ONLY FUNCT */
   }

   public function get_config_item($item_name) {
      /* GET ITEM ONLY FUNCT */
   }

   public function get_config() {
      // read the config and store in an object
      $this->conf = include_once($this->conf_file_path);
   }

}
