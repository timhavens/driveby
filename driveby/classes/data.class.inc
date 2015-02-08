<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of data
 *
 * @author timhavens
 */
class Data {
   //put your code here

   public function __construct() {
      ;
   }

   public function __destruct() {
      ;
   }

   public function get_log_data($path,$last_num_lines=0) {
      $response = array();
      if(!file_exists($path)) {
         return $response;
      }
      $file = fopen($path,"r");
      while(! feof($file)) {
         $tmp_resposne = fgetcsv($file);
         if(count($tmp_resposne) > 2) {
            $response[] = $tmp_resposne;
         }
      }

      fclose($file);
      return $response;
   }

   public function get_gps_data($path,$last_num_lines=0) {
      $gps_data_arr = $this->get_log_data($path);
      if($last_num_lines == 0) {
         return $gps_data_arr;
      }

      return array_slice($gps_data_arr, $last_num_lines);
   }

   public function get_nf_data($path,$last_num_lines=0) {
      $nf_data_arr = $this->get_log_data($path);
      if($last_num_lines == 0) {
         return $nf_data_arr;
      }

      return array_slice($nf_data_arr, $last_num_lines);
   }

   public function get_nf_gps_data($last_num_lines=0) {

      $o = new stdClass();

      $o->gps   = $this->get_gps_data('/disk1/driveby_data/gps_data.out',$last_num_lines);
      $o->nf50  = $this->get_nf_data('/disk1/driveby_data/50mhz_data.out',$last_num_lines);
      $o->nf154 = $this->get_nf_data('/disk1/driveby_data/154mhz_data.out',$last_num_lines);
      $o->nf222 = $this->get_nf_data('/disk1/driveby_data/222mhz_data.out',$last_num_lines);
      $o->nf432 = $this->get_nf_data('/disk1/driveby_data/432mhz_data.out',$last_num_lines);

      return $o;
   }
}
