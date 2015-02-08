<?php

/*
 * RELEASED AS GNU General Public License v3 (GPL-3)
 * http://www.gnu.org/licenses/quick-guide-gplv3.html
 *
 * Originally written by Tim R. Havens 2015-01-27 please track changes below
 *
 */

/**
 * Description of Gps
 *
 * @author timhavens
 */
class Gps {
   public $config;
   public $gps_conf;
   public $php_exec_path;
   public $www_root;
   public $data_storage;
   public $device = 0;
   public $remote_host;

   public function __construct($device=0) {
      include_once('Config.class.inc');
      $this->device = $device;
      $this->config = new Config();
      $this->gps_conf = $this->get_gps_config($device);
      $this->php_exec_path = $this->config->conf->php_exec_path;
      $this->www_root = $this->config->conf->www_root;
      $this->data_storage = $this->config->conf->data_storage_local;
      $this->remote_host = $this->config->conf->http_gui_remote;
   }

   public function __destruct() {
      ;
   }

   public function get_gps_config($device=-1) {
      if($device < 0) return new stdClass();
      return $this->config->conf->gps[$device];
   }

   public function clear_gps($device=-1) {
      if($device < 0) {
         if($this->device >= 0) {
            $device = $this->device;
         } else {
            return false;
         }
      }
      error_log("clear_gps() STARTED",0);
      $DATE      = date('Y-m-d-H-i-s_');

      if(file_exists($this->gps_conf->data_out)) {
         $FILE_PATH = $this->data_storage;
         $FILE      = basename($this->gps_conf->data_out);
         $DATE_FILE = $DATE;
         $DATE_FILE.=$FILE_PATH;
         $FILE_PATH.=$DATE;
         $FILE_PATH.=$FILE;
         error_log("{$this->gps_conf->data_out} $FILE_PATH",0);
         rename($this->gps_conf->data_out, $FILE_PATH);
      }

      if(file_exists($this->gps_conf->az_el_out)) {
         $FILE_PATH = $this->data_storage;
         $FILE1     = basename($this->gps_conf->az_el_out);
         $DATE_FILE = $DATE;
         $DATE_FILE.=$FILE_PATH;
         $FILE_PATH.=$DATE;
         $FILE_PATH.=$FILE1;
         error_log("{$this->gps_conf->az_el_out} $FILE_PATH",0);
         rename($this->gps_conf->az_el_out, $FILE_PATH);
      }

      if(file_exists($this->gps_conf->dop_out)) {
         $FILE_PATH=$this->data_storage;
         $FILE2=basename($this->gps_conf->dop_out);
         $DATE_FILE=$DATE;
         $DATE_FILE.=$FILE_PATH;
         $FILE_PATH.=$DATE;
         $FILE_PATH.=$FILE2;
         error_log("{$this->gps_conf->dop_out} $FILE_PATH",0);
         rename($this->gps_conf->dop_out, $FILE_PATH);
      }

      error_log("clear_gps() COMPLETED",0);
      return true;
   }

   public function start_gps() {
      $cmd = "{$this->php_exec_path} {$this->www_root}gps_log_data.php >> {$this->gps_conf->data_out_local} 2>&1 &";
      error_log($cmd,0);
      passthru($cmd);
      sleep(1);
      $cmd = "{$this->php_exec_path} {$this->www_root}gps_log_all_data.php > {$this->gps_conf->system_stat_all_data_out} 2>&1 &";
      passthru($cmd);
      error_log($cmd,0);
      return true;
   }

   public function request_start_gps() {
      if($this->findCommandPID('gps_log_data')) {
         $results = "ERROR: request_start_gps() GPS aleady running.";
         error_log($results,0);
      } else {
         $this->start_gps();
         sleep(3);
         if($this->findCommandPID('gps_log_data')) {
            $results = "SUCCESS: request_start_gps() GPS Started.";
            error_log($results,0);
         } else {
            $results = "ERROR: request_start_gps() GPS did not start.";
            error_log($results,0);
         }
      }

      error_log($results,0);
      return $results;
   }

   public function request_stop_gps() {
      if($this->findCommandPID('gps_log_data')) {
         $results = $this->killpid($this->findCommandPID('gps_log_data'));
         if($this->findCommandPID('gps_log_data')) {
            $results = "ERROR: request_stop_gps() Unable to STOP GPS.";
         } else {
            $results = "SUCCESS: request_stop_gps() GPS STOPPED.";
            $this->clear_gps();
         }
      } else {
         $results = "SUCCESS: request_stop_gps() (kinda) NO GPS found running.";
      }

      if($this->findCommandPID('gps_log_all_data')) {
         $results = $this->killpid($this->findCommandPID('gps_log_all_data'));
         if($this->findCommandPID('gps_log_all_data')) {
            $results = "ERROR: request_stop_gps() Unable to STOP GPS (ALL).";
         } else {
            $results = "SUCCESS: request_stop_gps() GPS (ALL) STOPPED .";
            $this->clear_gps();
         }
      } else {
         $results .= "SUCCESS: request_stop_gps() (kinda) NO GPS (ALL) found running.";
      }

      error_log($results,0);
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

   function killpid($pid) {
      return posix_kill($pid,9);
   }

}
