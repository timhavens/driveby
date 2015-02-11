<?php

/*
 * RELEASED AS GNU General Public License v3 (GPL-3)
 * http://www.gnu.org/licenses/quick-guide-gplv3.html
 *
 * Originally written by Tim R. Havens 2015-01-27 please track changes below
 *
 */

/**
 * Description of Rpc
 *
 * @author timhavens
 */
class Rpc {
   public $host;

   public function __construct($host="") {
      if($host!="") $this->host = trim($host);
   }

   public function __destruct() {
      ;
   }

   public function run_remote($cmd="") {
      //echo "RUN REMOTELY: ($this->host)\n";
      $urlencoded_start_cmd = rawurlencode($cmd);
      $url = "http://{$this->host}/driveby/rpc/rpc.php?q={$urlencoded_start_cmd}";
      //echo "URL: ($url)\n\n";
      // create curl resource
      $ch = curl_init();
      // set url
      curl_setopt($ch, CURLOPT_URL, $url);
      //return the transfer as a string
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      // milli second timeout
      curl_setopt($ch, CURLOPT_TIMEOUT_MS, 3000);
      curl_setopt($ch, CURLOPT_NOSIGNAL, 1);
      // $output contains the output string
      $output = curl_exec($ch);
      // close curl resource to free up system resources

      if(curl_error($ch)) {
         error_log("ERROR: curl error = ".curl_error($ch),0);
         die("ERROR: curl error = ".curl_error($ch));
      }
      curl_close($ch);
      //print_r($output);
      return $output;
   }

   public function run_local($host="",$cmd="") {
      ;
   }
}
