<?php
/*
 * RELEASED AS GNU General Public License v3 (GPL-3)
 * http://www.gnu.org/licenses/quick-guide-gplv3.html
 *
 * Originally written by Tim R. Havens 2015-01-27 please track changes below
 *
 */
   /*
    * TRACK AZIMUTH FROM GPS
    */
   $file = "/disk1/driveby_data/gps_data.out";
   $track_az = 0;
   if(file_exists($file)) {
      $file = escapeshellarg($file); // for the security concious (should be everyone!)
      $line = `tail -n 1 $file`;
      //3,1416324603,2014-11-18 15:30:03,37.859596667 -90.589985,833,0.005,278.83,0
      $data_gps_arr = explode(",",trim($line));

      $track_az = $data_gps_arr[6];
   }

   /*
    * ACTUAL AZIMUTH
    */
  include('classes/yocto/Sources/yocto_api.php');
  include('classes/yocto/Sources/yocto_tilt.php');
  include('classes/yocto/Sources/yocto_compass.php');
  include('classes/yocto/Sources/yocto_gyro.php');
  include('classes/yocto/Sources/yocto_accelerometer.php');

  // Use explicit error handling rather than exceptions
  yDisableExceptions();

  // Setup the API to use the VirtualHub on local machine
  if(yRegisterHub('http://127.0.0.1:4444/',$errmsg) != YAPI_SUCCESS) {
      die("Cannot contact VirtualHub on 127.0.0.1");
  }

  @$serial = $_GET['serial'];
  if ($serial != '') {
      // Check if a specified module is available online
      $anytilt = yFindTilt("$serial.tilt1");
      if (!$anytilt->isOnline()) {
          die("Module not connected (check serial and USB cable)");
      }
  } else {
      // or use any connected module suitable for the demo
      $anytilt = yFirstTilt();
      if(is_null($anytilt)) {
          die("No module connected (check USB cable)");
      } else {
          $serial = $anytilt->module()->get_serialnumber();
      }
  }
  //Print("Module to use: <input name='serial' value='$serial'><br>");

  // Get all sensor on the device matching the serial
  //$tilt1         = yFindTilt("$serial.tilt1");
  //$tilt2         = yFindTilt("$serial.tilt2");
  $compass       = yFindCompass("$serial.compass");
  //$gyro          = yFindGyro("$serial.gyro");
  //$accelerometer = yFindAccelerometer ("$serial.accelerometer");

  //$tilt1value         = $tilt1->get_currentValue();
  //$tilt2value         = $tilt2 ->get_currentValue();
  $compassvalue       = $compass->get_currentValue();
  //$gyrovalue          = $gyro->get_currentValue();
  //$accelerometervalue = $accelerometer->get_currentValue();

   echo "&az_dial={$compassvalue}&track_dial={$track_az}";
?>