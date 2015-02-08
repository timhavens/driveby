<?php

/*
 * RELEASED AS GNU General Public License v3 (GPL-3)
 * http://www.gnu.org/licenses/quick-guide-gplv3.html
 *
 * Originally written by Tim R. Havens 2015-01-27 please track changes below
 *
 */

/**
 * Description of RTL SDR Controls
 *
 * @author timhavens
 */
class Rtl {

   public $config;

   public function __construct() {
      include_once('Rpc.class.inc');
      include_once('Config.class.inc');
      $this->config = new Config();
   }

   public function __destruct() {
      ;
   }

   public function get_rtl_config($device=-1) {
      if($device < 0) return new stdClass();
      return $this->config->conf->rtl[$device];
   }

   public function get_start_rtl_command($device=-1) {
      if($device < 0) return "";
      $rtl_conf = $this->get_rtl_config($device);

      // run this is as ROOT user or some other user of your choice
      // if running as ROOT you probably wanna setup SUDOERS in /etc/sudoers (google how if you don't know)

      $start_cmd = "sudo -u root __RTL__POWER__PATH__ -d __DEVICE__ -f __FREQ__START__:__FREQ__STOP__:__BW__ -i __INTEGRATION__ -g __GAIN__ -w __WINDOW__ -F __FIR__SIZE__ -c __CROP__PERCENT__ __DATA__OUT__ > /dev/null&";

      $start_cmd = preg_replace('/__RTL__POWER__PATH__/',$this->config->conf->rtl_power_path,$start_cmd);
      $start_cmd = preg_replace('/__DEVICE__/',$device,$start_cmd);
      $start_cmd = preg_replace('/__FREQ__START__/',$rtl_conf->freq_start,$start_cmd);
      $start_cmd = preg_replace('/__FREQ__STOP__/',$rtl_conf->freq_stop,$start_cmd);
      $start_cmd = preg_replace('/__BW__/',$rtl_conf->bw,$start_cmd);
      $start_cmd = preg_replace('/__INTEGRATION__/',$rtl_conf->integration,$start_cmd);
      $start_cmd = preg_replace('/__GAIN__/',$rtl_conf->gain,$start_cmd);
      $start_cmd = preg_replace('/__WINDOW__/',$rtl_conf->window,$start_cmd);
      $start_cmd = preg_replace('/__FIR__SIZE__/',$rtl_conf->fir_size,$start_cmd);
      $start_cmd = preg_replace('/__CROP__PERCENT__/',$rtl_conf->crop_percent,$start_cmd);
      $start_cmd = preg_replace('/__DATA__OUT__/',$rtl_conf->data_out,$start_cmd);

      echo "\n\n$start_cmd\n\n";
      error_log("get_start_rtl_command ($device) ATTEMPTED START", 0);
      error_log("$start_cmd",0);
      if(gethostbyaddr($rtl_conf->hostname) == php_uname('n')) {
         echo "START LOCALLY\n";
         error_log("Start RTL ($device) LOCALLY",0);
      } else {
         $rpc = new Rpc($rtl_conf->hostname);
         $rpc->run_remote($start_cmd);
         error_log("Start RTL ($device) REMOTELY ({$rtl_conf->hostname})",0);
      }

      return $start_cmd;
   }

   public function get_stop_rtl_command($device=-1) {
      if($device < 0) return "";
      $rtl_conf = $this->get_rtl_config($device);

      //$stop_cmd = "sudo -u root ps -ef | grep \"rtl_power\" | grep \"__FREQ__START__\" | awk '{print $2}' | xargs kill";
      $stop_cmd = "sudo -u root pkill -f 'rtl_power -d {$device} -f __FREQ__START__'";

      $stop_cmd = preg_replace('/__FREQ__START__/',$rtl_conf->freq_start,$stop_cmd);

      echo "\n\n$stop_cmd\n\n";
      error_log("get_stop_rtl_command ($device) ATTEMPTED STOP", 0);
      error_log("$stop_cmd",0);
      if(gethostbyaddr($rtl_conf->hostname) == php_uname('n')) {
         echo "STOP LOCALLY\n";
         error_log("Stop RTL ($device) LOCALLY",0);
      } else {
         $rpc = new Rpc($rtl_conf->hostname);
         $rpc->run_remote($stop_cmd);
         error_log("Stop RTL ($device) REMOTELY ({$rtl_conf->hostname})",0);
      }

      $this->clear_rtl($device);
      error_log("get_stop_rtl_command ($device)", 0);
      return $stop_cmd;
   }

   public function start_rtl($device=-1) {
      if($device < 0) return "";
      $rtl_conf = $this->get_rtl_config($device);

      $cmd = $this->get_start_rtl_command($device);
      passthru($cmd);
      error_log("start_rtl ($device)", 0);
      return true;
   }

   public function stop_rtl($device=-1) {
      if($device < 0) return "";
      $rtl_conf = $this->get_rtl_config($device);

      $cmd = $this->get_stop_rtl_command($device);
      passthru($cmd);
      $this->clear_rtl($device);
      error_log("stop_rtl ($device)", 0);
      return true;
   }

   public function clear_rtl($device) {
      if($device < 0) return "";
      $rtl_conf = $this->get_rtl_config($device);

      $FULL_FILE_PATH=$rtl_conf->data_out_local;
      $FILE_PATH=$this->config->conf->data_storage_local;
      $FILE=$rtl_conf->data_out_file;
      $DATE=date('Y-m-d-H-i-s_');
      $DATE_FILE=$DATE;
      $DATE_FILE.=$FILE_PATH;
      $FILE_PATH.=$DATE;
      $FILE_PATH.=$FILE;
      echo "MV: $FULL_FILE_PATH $FILE_PATH\n";

      rename($FULL_FILE_PATH, $FILE_PATH);
      if(file_exists($FILE_PATH)) {
         return true;
      }

      return false;
   }

/*
   public function request_stop($device=-1) {
      if($device < 0) return "";
      $rtl_conf = $this->get_rtl_config($device);

      if($this->findRootCommandPID('rtl_power',$rtl_conf->freq_start)) {
         $results = $this->stop_rtl($device);
         sleep(3);
         if($this->findRootCommandPID('rtl_power',$rtl_conf->freq_start)) {
            $results = "ERROR: Unable to STOP RTL($device).";
         } else {
            $results = "SUCCESS: RTL($device) STOPPED.";
         }
      } else {
         $results = "SUCCESS: (kinda) NO RTL($device) found running.";
      }

      return $results;
   }

   public function request_start($device=-1) {
      if($device < 0) return "";
      $rtl_conf = $this->get_rtl_config($device);

      if($this->findRootCommandPID('rtl_power',$rtl_conf->freq_start)) {
         $results = "ERROR: RTL($device) aleady running.";
      } else {
         $this->start_rtl_44();
         sleep(3);
         if($this->findRootCommandPID('rtl_power',$rtl_conf->freq_start)) {
            $results = "SUCCESS: RTL($device) Started.";
         } else {
            $results = "ERROR: RTL($device) did not start.";
         }
      }

      return $results;
   }

   function findRootCommandPID($command,$args="")  {
      $ps = `sudo -u root ps aux | grep 'root' | grep $command | grep $args`; // this is a problem for rtl_power running...we'll need to resolve how to
                                      // stop and start rtl_power from the www-data user commands in control.php
      $ps_lines = explode("\n", $ps);
      foreach($ps_lines as $line) {
         if(preg_match('/www-data/',$line)) { continue; }
         $a = preg_split('/\s+/', trim($line));
         //print_r($a);
         if(count($a)<2) { continue; }
         $cpid  = trim($a[1]);
         return $cpid;
      }
   }

   function findCommandPID($command,$args="")  {
      $ps = `ps aux | grep www-data`; // this is a problem for rtl_power running...we'll need to resolve how to
                                      // stop and start rtl_power from the www-data user commands in control.php
      $ps_lines = explode("\n", $ps);
     //print_r($ps_lines);
      foreach($ps_lines as $line) {
         $a = preg_split('/\s+/', trim($line));
         //print_r($a);
         if(count($a)<2) continue;
         $cpid  = trim($a[1]);
         $ccmd  = trim($a[10]);
         $c2cmd = trim($a[11]);
         if(preg_match("/$command/",$c2cmd)) {
            if($args == "") {
               return $cpid;
            } elseif(preg_match("/$args/",$line)) {
               return $cpid;
            }
         }
      }
   }
*/
   function killpid($pid) {
      //file_put_contents("GPS STOPPED\n",'/disk1/driveby_data/gps_data.out',FILE_APPEND);
      return posix_kill($pid,9);
   }
}