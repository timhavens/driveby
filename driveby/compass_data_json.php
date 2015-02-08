<?php
/*
 * RELEASED AS GNU General Public License v3 (GPL-3)
 * http://www.gnu.org/licenses/quick-guide-gplv3.html
 *
 * Originally written by Tim R. Havens 2015-01-27 please track changes below
 *
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
  $tilt1         = yFindTilt("$serial.tilt1");
  $tilt2         = yFindTilt("$serial.tilt2");
  $compass       = yFindCompass("$serial.compass");
  $gyro          = yFindGyro("$serial.gyro");
  $accelerometer = yFindAccelerometer ("$serial.accelerometer");

  $tilt1value         = $tilt1->get_currentValue();
  $tilt2value         = $tilt2 ->get_currentValue();
  $compassvalue       = $compass->get_currentValue();
  $gyrovalue          = $gyro->get_currentValue();
  $accelerometervalue = $accelerometer->get_currentValue();

  $return_arr = array('tilt1'=>$tilt1value,'tilt2'=>$tilt2value,'compass'=>$compassvalue,'gyro'=>$gyrovalue,'accelerometer'=>$accelerometervalue);

  echo json_encode($return_arr);

  ?>

