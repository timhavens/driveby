<?php
/*********************************************************************
 *
 * $Id: yocto_refframe.php 17481 2014-09-03 09:38:35Z mvuilleu $
 *
 * Implements YRefFrame, the high-level API for RefFrame functions
 *
 * - - - - - - - - - License information: - - - - - - - - - 
 *
 *  Copyright (C) 2011 and beyond by Yoctopuce Sarl, Switzerland.
 *
 *  Yoctopuce Sarl (hereafter Licensor) grants to you a perpetual
 *  non-exclusive license to use, modify, copy and integrate this
 *  file into your software for the sole purpose of interfacing
 *  with Yoctopuce products.
 *
 *  You may reproduce and distribute copies of this file in
 *  source or object form, as long as the sole purpose of this
 *  code is to interface with Yoctopuce products. You must retain
 *  this notice in the distributed source file.
 *
 *  You should refer to Yoctopuce General Terms and Conditions
 *  for additional information regarding your rights and
 *  obligations.
 *
 *  THE SOFTWARE AND DOCUMENTATION ARE PROVIDED 'AS IS' WITHOUT
 *  WARRANTY OF ANY KIND, EITHER EXPRESS OR IMPLIED, INCLUDING 
 *  WITHOUT LIMITATION, ANY WARRANTY OF MERCHANTABILITY, FITNESS
 *  FOR A PARTICULAR PURPOSE, TITLE AND NON-INFRINGEMENT. IN NO
 *  EVENT SHALL LICENSOR BE LIABLE FOR ANY INCIDENTAL, SPECIAL,
 *  INDIRECT OR CONSEQUENTIAL DAMAGES, LOST PROFITS OR LOST DATA,
 *  COST OF PROCUREMENT OF SUBSTITUTE GOODS, TECHNOLOGY OR 
 *  SERVICES, ANY CLAIMS BY THIRD PARTIES (INCLUDING BUT NOT 
 *  LIMITED TO ANY DEFENSE THEREOF), ANY CLAIMS FOR INDEMNITY OR
 *  CONTRIBUTION, OR OTHER SIMILAR COSTS, WHETHER ASSERTED ON THE
 *  BASIS OF CONTRACT, TORT (INCLUDING NEGLIGENCE), BREACH OF
 *  WARRANTY, OR OTHERWISE.
 *
 *********************************************************************/

//--- (YRefFrame return codes)
//--- (end of YRefFrame return codes)
//--- (YRefFrame definitions)
if(!defined('Y_MOUNTPOSITION_BOTTOM'))       define('Y_MOUNTPOSITION_BOTTOM',      0);
if(!defined('Y_MOUNTPOSITION_TOP'))          define('Y_MOUNTPOSITION_TOP',         1);
if(!defined('Y_MOUNTPOSITION_FRONT'))        define('Y_MOUNTPOSITION_FRONT',       2);
if(!defined('Y_MOUNTPOSITION_RIGHT'))        define('Y_MOUNTPOSITION_RIGHT',       3);
if(!defined('Y_MOUNTPOSITION_REAR'))         define('Y_MOUNTPOSITION_REAR',        4);
if(!defined('Y_MOUNTPOSITION_LEFT'))         define('Y_MOUNTPOSITION_LEFT',        5);
if(!defined('Y_MOUNTORIENTATION_TWELVE'))    define('Y_MOUNTORIENTATION_TWELVE',   0);
if(!defined('Y_MOUNTORIENTATION_THREE'))     define('Y_MOUNTORIENTATION_THREE',    1);
if(!defined('Y_MOUNTORIENTATION_SIX'))       define('Y_MOUNTORIENTATION_SIX',      2);
if(!defined('Y_MOUNTORIENTATION_NINE'))      define('Y_MOUNTORIENTATION_NINE',     3);
if(!defined('Y_MOUNTPOS_INVALID'))           define('Y_MOUNTPOS_INVALID',          YAPI_INVALID_UINT);
if(!defined('Y_BEARING_INVALID'))            define('Y_BEARING_INVALID',           YAPI_INVALID_DOUBLE);
if(!defined('Y_CALIBRATIONPARAM_INVALID'))   define('Y_CALIBRATIONPARAM_INVALID',  YAPI_INVALID_STRING);
//--- (end of YRefFrame definitions)

//--- (YRefFrame declaration)
/**
 * YRefFrame Class: Reference frame configuration
 * 
 * This class is used to setup the base orientation of the Yocto-3D, so that
 * the orientation functions, relative to the earth surface plane, use
 * the proper reference frame. The class also implements a tridimensional
 * sensor calibration process, which can compensate for local variations
 * of standard gravity and improve the precision of the tilt sensors.
 */
class YRefFrame extends YFunction
{
    const MOUNTPOS_INVALID               = YAPI_INVALID_UINT;
    const BEARING_INVALID                = YAPI_INVALID_DOUBLE;
    const CALIBRATIONPARAM_INVALID       = YAPI_INVALID_STRING;
    const MOUNTPOSITION_BOTTOM           = 0;
    const MOUNTPOSITION_TOP              = 1;
    const MOUNTPOSITION_FRONT            = 2;
    const MOUNTPOSITION_RIGHT            = 3;
    const MOUNTPOSITION_REAR             = 4;
    const MOUNTPOSITION_LEFT             = 5;
    const MOUNTORIENTATION_TWELVE        = 0;
    const MOUNTORIENTATION_THREE         = 1;
    const MOUNTORIENTATION_SIX           = 2;
    const MOUNTORIENTATION_NINE          = 3;
    //--- (end of YRefFrame declaration)

    //--- (YRefFrame attributes)
    protected $_mountPos                 = Y_MOUNTPOS_INVALID;           // UInt31
    protected $_bearing                  = Y_BEARING_INVALID;            // MeasureVal
    protected $_calibrationParam         = Y_CALIBRATIONPARAM_INVALID;   // CalibParams
    protected $_calibStage               = 0;                            // int
    protected $_calibStageHint           = "";                           // str
    protected $_calibStageProgress       = 0;                            // int
    protected $_calibProgress            = 0;                            // int
    protected $_calibLogMsg              = "";                           // str
    protected $_calibSavedParams         = "";                           // str
    protected $_calibCount               = 0;                            // int
    protected $_calibInternalPos         = 0;                            // int
    protected $_calibPrevTick            = 0;                            // int
    protected $_calibOrient              = Array();                      // intArr
    protected $_calibDataAccX            = Array();                      // floatArr
    protected $_calibDataAccY            = Array();                      // floatArr
    protected $_calibDataAccZ            = Array();                      // floatArr
    protected $_calibDataAcc             = Array();                      // floatArr
    protected $_calibAccXOfs             = 0;                            // float
    protected $_calibAccYOfs             = 0;                            // float
    protected $_calibAccZOfs             = 0;                            // float
    protected $_calibAccXScale           = 0;                            // float
    protected $_calibAccYScale           = 0;                            // float
    protected $_calibAccZScale           = 0;                            // float
    //--- (end of YRefFrame attributes)

    function __construct($str_func)
    {
        //--- (YRefFrame constructor)
        parent::__construct($str_func);
        $this->_className = 'RefFrame';

        //--- (end of YRefFrame constructor)
    }

    //--- (YRefFrame implementation)

    function _parseAttr($name, $val)
    {
        switch($name) {
        case 'mountPos':
            $this->_mountPos = intval($val);
            return 1;
        case 'bearing':
            $this->_bearing = round($val * 1000.0 / 65536.0) / 1000.0;
            return 1;
        case 'calibrationParam':
            $this->_calibrationParam = $val;
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    public function get_mountPos()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_MOUNTPOS_INVALID;
            }
        }
        return $this->_mountPos;
    }

    public function set_mountPos($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("mountPos",$rest_val);
    }

    /**
     * Changes the reference bearing used by the compass. The relative bearing
     * indicated by the compass is the difference between the measured magnetic
     * heading and the reference bearing indicated here.
     * 
     * For instance, if you setup as reference bearing the value of the earth
     * magnetic declination, the compass will provide the orientation relative
     * to the geographic North.
     * 
     * Similarly, when the sensor is not mounted along the standard directions
     * because it has an additional yaw angle, you can set this angle in the reference
     * bearing so that the compass provides the expected natural direction.
     * 
     * Remember to call the saveToFlash()
     * method of the module if the modification must be kept.
     * 
     * @param newval : a floating point number corresponding to the reference bearing used by the compass
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_bearing($newval)
    {
        $rest_val = strval(round($newval * 65536.0));
        return $this->_setAttr("bearing",$rest_val);
    }

    /**
     * Returns the reference bearing used by the compass. The relative bearing
     * indicated by the compass is the difference between the measured magnetic
     * heading and the reference bearing indicated here.
     * 
     * @return a floating point number corresponding to the reference bearing used by the compass
     * 
     * On failure, throws an exception or returns Y_BEARING_INVALID.
     */
    public function get_bearing()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_BEARING_INVALID;
            }
        }
        return $this->_bearing;
    }

    public function get_calibrationParam()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_CALIBRATIONPARAM_INVALID;
            }
        }
        return $this->_calibrationParam;
    }

    public function set_calibrationParam($newval)
    {
        $rest_val = $newval;
        return $this->_setAttr("calibrationParam",$rest_val);
    }

    /**
     * Retrieves a reference frame for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     * 
     * This function does not require that the reference frame is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method YRefFrame.isOnline() to test if the reference frame is
     * indeed online at a given time. In case of ambiguity when looking for
     * a reference frame by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     * 
     * @param func : a string that uniquely characterizes the reference frame
     * 
     * @return a YRefFrame object allowing you to drive the reference frame.
     */
    public static function FindRefFrame($func)
    {
        // $obj                    is a YRefFrame;
        $obj = YFunction::_FindFromCache('RefFrame', $func);
        if ($obj == null) {
            $obj = new YRefFrame($func);
            YFunction::_AddToCache('RefFrame', $func, $obj);
        }
        return $obj;
    }

    /**
     * Returns the installation position of the device, as configured
     * in order to define the reference frame for the compass and the
     * pitch/roll tilt sensors.
     * 
     * @return a value among the Y_MOUNTPOSITION enumeration
     *         (Y_MOUNTPOSITION_BOTTOM,   Y_MOUNTPOSITION_TOP,
     *         Y_MOUNTPOSITION_FRONT,    Y_MOUNTPOSITION_RIGHT,
     *         Y_MOUNTPOSITION_REAR,     Y_MOUNTPOSITION_LEFT),
     *         corresponding to the installation in a box, on one of the six faces.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function get_mountPosition()
    {
        // $position               is a int;
        $position = $this->get_mountPos();
        return (($position) >> (2));
    }

    /**
     * Returns the installation orientation of the device, as configured
     * in order to define the reference frame for the compass and the
     * pitch/roll tilt sensors.
     * 
     * @return a value among the enumeration Y_MOUNTORIENTATION
     *         (Y_MOUNTORIENTATION_TWELVE, Y_MOUNTORIENTATION_THREE,
     *         Y_MOUNTORIENTATION_SIX,     Y_MOUNTORIENTATION_NINE)
     *         corresponding to the orientation of the "X" arrow on the device,
     *         as on a clock dial seen from an observer in the center of the box.
     *         On the bottom face, the 12H orientation points to the front, while
     *         on the top face, the 12H orientation points to the rear.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function get_mountOrientation()
    {
        // $position               is a int;
        $position = $this->get_mountPos();
        return (($position) & (3));
    }

    /**
     * Changes the compass and tilt sensor frame of reference. The magnetic compass
     * and the tilt sensors (pitch and roll) naturally work in the plane
     * parallel to the earth surface. In case the device is not installed upright
     * and horizontally, you must select its reference orientation (parallel to
     * the earth surface) so that the measures are made relative to this position.
     * 
     * @param position : a value among the Y_MOUNTPOSITION enumeration
     *         (Y_MOUNTPOSITION_BOTTOM,   Y_MOUNTPOSITION_TOP,
     *         Y_MOUNTPOSITION_FRONT,    Y_MOUNTPOSITION_RIGHT,
     *         Y_MOUNTPOSITION_REAR,     Y_MOUNTPOSITION_LEFT),
     *         corresponding to the installation in a box, on one of the six faces.
     * @param orientation : a value among the enumeration Y_MOUNTORIENTATION
     *         (Y_MOUNTORIENTATION_TWELVE, Y_MOUNTORIENTATION_THREE,
     *         Y_MOUNTORIENTATION_SIX,     Y_MOUNTORIENTATION_NINE)
     *         corresponding to the orientation of the "X" arrow on the device,
     *         as on a clock dial seen from an observer in the center of the box.
     *         On the bottom face, the 12H orientation points to the front, while
     *         on the top face, the 12H orientation points to the rear.
     * 
     * Remember to call the saveToFlash()
     * method of the module if the modification must be kept.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_mountPosition($position,$orientation)
    {
        // $mixedPos               is a int;
        $mixedPos = (($position) << (2)) + $orientation;
        return $this->set_mountPos($mixedPos);
    }

    public function _calibSort($start,$stopidx)
    {
        // $idx                    is a int;
        // $changed                is a int;
        // $a                      is a float;
        // $b                      is a float;
        // $xa                     is a float;
        // $xb                     is a float;
        
        // bubble sort is good since we will re-sort again after offset adjustment
        $changed = 1;
        while ($changed > 0) {
            $changed = 0;
            $a = $this->_calibDataAcc[$start];
            $idx = $start + 1;
            while ($idx < $stopidx) {
                $b = $this->_calibDataAcc[$idx];
                if ($a > $b) {
                    $this->_calibDataAcc[$idx-1] = $b;
                    $this->_calibDataAcc[$idx] = $a;
                    $xa = $this->_calibDataAccX[$idx-1];
                    $xb = $this->_calibDataAccX[$idx];
                    $this->_calibDataAccX[$idx-1] = $xb;
                    $this->_calibDataAccX[$idx] = $xa;
                    $xa = $this->_calibDataAccY[$idx-1];
                    $xb = $this->_calibDataAccY[$idx];
                    $this->_calibDataAccY[$idx-1] = $xb;
                    $this->_calibDataAccY[$idx] = $xa;
                    $xa = $this->_calibDataAccZ[$idx-1];
                    $xb = $this->_calibDataAccZ[$idx];
                    $this->_calibDataAccZ[$idx-1] = $xb;
                    $this->_calibDataAccZ[$idx] = $xa;
                    $changed = $changed + 1;
                } else {
                    $a = $b;
                }
                $idx = $idx + 1;
            }
        }
        return 0;
    }

    /**
     * Initiates the sensors tridimensional calibration process.
     * This calibration is used at low level for inertial position estimation
     * and to enhance the precision of the tilt sensors.
     * 
     * After calling this method, the device should be moved according to the
     * instructions provided by method get_3DCalibrationHint,
     * and more3DCalibration should be invoked about 5 times per second.
     * The calibration procedure is completed when the method
     * get_3DCalibrationProgress returns 100. At this point,
     * the computed calibration parameters can be applied using method
     * save3DCalibration. The calibration process can be canceled
     * at any time using method cancel3DCalibration.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function start3DCalibration()
    {
        if (!($this->isOnline())) {
            return YAPI_DEVICE_NOT_FOUND;
        }
        if ($this->_calibStage != 0) {
            $this->cancel3DCalibration();
        }
        $this->_calibSavedParams = $this->get_calibrationParam();
        $this->set_calibrationParam('0');
        $this->_calibCount = 50;
        $this->_calibStage = 1;
        $this->_calibStageHint = 'Set down the device on a steady horizontal surface';
        $this->_calibStageProgress = 0;
        $this->_calibProgress = 1;
        $this->_calibInternalPos = 0;
        $this->_calibPrevTick = ((YAPI::GetTickCount()) & (0x7FFFFFFF));
        while(sizeof($this->_calibOrient) > 0) { array_pop($this->_calibOrient); };
        while(sizeof($this->_calibDataAccX) > 0) { array_pop($this->_calibDataAccX); };
        while(sizeof($this->_calibDataAccY) > 0) { array_pop($this->_calibDataAccY); };
        while(sizeof($this->_calibDataAccZ) > 0) { array_pop($this->_calibDataAccZ); };
        while(sizeof($this->_calibDataAcc) > 0) { array_pop($this->_calibDataAcc); };
        return YAPI_SUCCESS;
    }

    /**
     * Continues the sensors tridimensional calibration process previously
     * initiated using method start3DCalibration.
     * This method should be called approximately 5 times per second, while
     * positioning the device according to the instructions provided by method
     * get_3DCalibrationHint. Note that the instructions change during
     * the calibration process.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function more3DCalibration()
    {
        // $currTick               is a int;
        // $jsonData               is a bin;
        // $xVal                   is a float;
        // $yVal                   is a float;
        // $zVal                   is a float;
        // $xSq                    is a float;
        // $ySq                    is a float;
        // $zSq                    is a float;
        // $norm                   is a float;
        // $orient                 is a int;
        // $idx                    is a int;
        // $intpos                 is a int;
        // $err                    is a int;
        // make sure calibration has been started
        if ($this->_calibStage == 0) {
            return YAPI_INVALID_ARGUMENT;
        }
        if ($this->_calibProgress == 100) {
            return YAPI_SUCCESS;
        }
        
        // make sure we leave at least 160ms between samples
        $currTick =  ((YAPI::GetTickCount()) & (0x7FFFFFFF));
        if ((($currTick - $this->_calibPrevTick) & (0x7FFFFFFF)) < 160) {
            return YAPI_SUCCESS;
        }
        // load current accelerometer values, make sure we are on a straight angle
        // (default timeout to 0,5 sec without reading measure when out of range)
        $this->_calibStageHint = 'Set down the device on a steady horizontal surface';
        $this->_calibPrevTick = (($currTick + 500) & (0x7FFFFFFF));
        $jsonData = $this->_download('api/accelerometer.json');
        $xVal = intVal($this->_json_get_key($jsonData, 'xValue')) / 65536.0;
        $yVal = intVal($this->_json_get_key($jsonData, 'yValue')) / 65536.0;
        $zVal = intVal($this->_json_get_key($jsonData, 'zValue')) / 65536.0;
        $xSq = $xVal * $xVal;
        if ($xSq >= 0.04 && $xSq < 0.64) {
            return YAPI_SUCCESS;
        }
        if ($xSq >= 1.44) {
            return YAPI_SUCCESS;
        }
        $ySq = $yVal * $yVal;
        if ($ySq >= 0.04 && $ySq < 0.64) {
            return YAPI_SUCCESS;
        }
        if ($ySq >= 1.44) {
            return YAPI_SUCCESS;
        }
        $zSq = $zVal * $zVal;
        if ($zSq >= 0.04 && $zSq < 0.64) {
            return YAPI_SUCCESS;
        }
        if ($zSq >= 1.44) {
            return YAPI_SUCCESS;
        }
        $norm = sqrt($xSq + $ySq + $zSq);
        if ($norm < 0.8 || $norm > 1.2) {
            return YAPI_SUCCESS;
        }
        $this->_calibPrevTick = $currTick;
        
        // Determine the device orientation index
        $orient = 0;
        if ($zSq > 0.5) {
            if ($zVal > 0) {
                $orient = 0;
            } else {
                $orient = 1;
            }
        }
        if ($xSq > 0.5) {
            if ($xVal > 0) {
                $orient = 2;
            } else {
                $orient = 3;
            }
        }
        if ($ySq > 0.5) {
            if ($yVal > 0) {
                $orient = 4;
            } else {
                $orient = 5;
            }
        }
        
        // Discard measures that are not in the proper orientation
        if ($this->_calibStageProgress == 0) {
            $idx = 0;
            $err = 0;
            while ($idx + 1 < $this->_calibStage) {
                if ($this->_calibOrient[$idx] == $orient) {
                    $err = 1;
                }
                $idx = $idx + 1;
            }
            if ($err != 0) {
                $this->_calibStageHint = 'Turn the device on another face';
                return YAPI_SUCCESS;
            }
            $this->_calibOrient[] = $orient;
        } else {
            if ($orient != $this->_calibOrient[$this->_calibStage-1]) {
                $this->_calibStageHint = 'Not yet done, please move back to the previous face';
                return YAPI_SUCCESS;
            }
        }
        
        // Save measure
        $this->_calibStageHint = 'calibrating->.';
        $this->_calibDataAccX[] = $xVal;
        $this->_calibDataAccY[] = $yVal;
        $this->_calibDataAccZ[] = $zVal;
        $this->_calibDataAcc[] = $norm;
        $this->_calibInternalPos = $this->_calibInternalPos + 1;
        $this->_calibProgress = 1 + 16 * ($this->_calibStage - 1) + intVal((16 * $this->_calibInternalPos) / ($this->_calibCount));
        if ($this->_calibInternalPos < $this->_calibCount) {
            $this->_calibStageProgress = 1 + intVal((99 * $this->_calibInternalPos) / ($this->_calibCount));
            return YAPI_SUCCESS;
        }
        
        // Stage done, compute preliminary result
        $intpos = ($this->_calibStage - 1) * $this->_calibCount;
        $this->_calibSort($intpos, $intpos + $this->_calibCount);
        $intpos = $intpos + intVal(($this->_calibCount) / (2));
        $this->_calibLogMsg = sprintf('Stage %d: median is %d,%d,%d', $this->_calibStage,
                                      round(1000*$this->_calibDataAccX[$intpos]),
                                      round(1000*$this->_calibDataAccY[$intpos]),
                                      round(1000*$this->_calibDataAccZ[$intpos]));
        
        // move to next stage
        $this->_calibStage = $this->_calibStage + 1;
        if ($this->_calibStage < 7) {
            $this->_calibStageHint = 'Turn the device on another face';
            $this->_calibPrevTick = (($currTick + 500) & (0x7FFFFFFF));
            $this->_calibStageProgress = 0;
            $this->_calibInternalPos = 0;
            return YAPI_SUCCESS;
        }
        // Data collection completed, compute accelerometer shift
        $xVal = 0;
        $yVal = 0;
        $zVal = 0;
        $idx = 0;
        while ($idx < 6) {
            $intpos = $idx * $this->_calibCount + intVal(($this->_calibCount) / (2));
            $orient = $this->_calibOrient[$idx];
            if ($orient == 0 || $orient == 1) {
                $zVal = $zVal + $this->_calibDataAccZ[$intpos];
            }
            if ($orient == 2 || $orient == 3) {
                $xVal = $xVal + $this->_calibDataAccX[$intpos];
            }
            if ($orient == 4 || $orient == 5) {
                $yVal = $yVal + $this->_calibDataAccY[$intpos];
            }
            $idx = $idx + 1;
        }
        $this->_calibAccXOfs = $xVal / 2.0;
        $this->_calibAccYOfs = $yVal / 2.0;
        $this->_calibAccZOfs = $zVal / 2.0;
        
        // Recompute all norms, taking into account the computed shift, and re-sort
        $intpos = 0;
        while ($intpos < sizeof($this->_calibDataAcc)) {
            $xVal = $this->_calibDataAccX[$intpos] - $this->_calibAccXOfs;
            $yVal = $this->_calibDataAccY[$intpos] - $this->_calibAccYOfs;
            $zVal = $this->_calibDataAccZ[$intpos] - $this->_calibAccZOfs;
            $norm = sqrt($xVal * $xVal + $yVal * $yVal + $zVal * $zVal);
            $this->_calibDataAcc[$intpos] = $norm;
            $intpos = $intpos + 1;
        }
        $idx = 0;
        while ($idx < 6) {
            $intpos = $idx * $this->_calibCount;
            $this->_calibSort($intpos, $intpos + $this->_calibCount);
            $idx = $idx + 1;
        }
        
        // Compute the scaling factor for each axis
        $xVal = 0;
        $yVal = 0;
        $zVal = 0;
        $idx = 0;
        while ($idx < 6) {
            $intpos = $idx * $this->_calibCount + intVal(($this->_calibCount) / (2));
            $orient = $this->_calibOrient[$idx];
            if ($orient == 0 || $orient == 1) {
                $zVal = $zVal + $this->_calibDataAcc[$intpos];
            }
            if ($orient == 2 || $orient == 3) {
                $xVal = $xVal + $this->_calibDataAcc[$intpos];
            }
            if ($orient == 4 || $orient == 5) {
                $yVal = $yVal + $this->_calibDataAcc[$intpos];
            }
            $idx = $idx + 1;
        }
        $this->_calibAccXScale = $xVal / 2.0;
        $this->_calibAccYScale = $yVal / 2.0;
        $this->_calibAccZScale = $zVal / 2.0;
        
        // Report completion
        $this->_calibProgress = 100;
        $this->_calibStageHint = 'Calibration data ready for saving';
        return YAPI_SUCCESS;
    }

    /**
     * Returns instructions to proceed to the tridimensional calibration initiated with
     * method start3DCalibration.
     * 
     * @return a character string.
     */
    public function get_3DCalibrationHint()
    {
        return $this->_calibStageHint;
    }

    /**
     * Returns the global process indicator for the tridimensional calibration
     * initiated with method start3DCalibration.
     * 
     * @return an integer between 0 (not started) and 100 (stage completed).
     */
    public function get_3DCalibrationProgress()
    {
        return $this->_calibProgress;
    }

    /**
     * Returns index of the current stage of the calibration
     * initiated with method start3DCalibration.
     * 
     * @return an integer, growing each time a calibration stage is completed.
     */
    public function get_3DCalibrationStage()
    {
        return $this->_calibStage;
    }

    /**
     * Returns the process indicator for the current stage of the calibration
     * initiated with method start3DCalibration.
     * 
     * @return an integer between 0 (not started) and 100 (stage completed).
     */
    public function get_3DCalibrationStageProgress()
    {
        return $this->_calibStageProgress;
    }

    /**
     * Returns the latest log message from the calibration process.
     * When no new message is available, returns an empty string.
     * 
     * @return a character string.
     */
    public function get_3DCalibrationLogMsg()
    {
        // $msg                    is a str;
        $msg = $this->_calibLogMsg;
        $this->_calibLogMsg = '';
        return $msg;
    }

    /**
     * Applies the sensors tridimensional calibration parameters that have just been computed.
     * Remember to call the saveToFlash()  method of the module if the changes
     * must be kept when the device is restarted.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function save3DCalibration()
    {
        // $shiftX                 is a int;
        // $shiftY                 is a int;
        // $shiftZ                 is a int;
        // $scaleExp               is a int;
        // $scaleX                 is a int;
        // $scaleY                 is a int;
        // $scaleZ                 is a int;
        // $scaleLo                is a int;
        // $scaleHi                is a int;
        // $newcalib               is a str;
        if ($this->_calibProgress != 100) {
            return YAPI_INVALID_ARGUMENT;
        }
        
        // Compute integer values (correction unit is 732ug/count)
        $shiftX = -round($this->_calibAccXOfs / 0.000732);
        if ($shiftX < 0) {
            $shiftX = $shiftX + 65536;
        }
        $shiftY = -round($this->_calibAccYOfs / 0.000732);
        if ($shiftY < 0) {
            $shiftY = $shiftY + 65536;
        }
        $shiftZ = -round($this->_calibAccZOfs / 0.000732);
        if ($shiftZ < 0) {
            $shiftZ = $shiftZ + 65536;
        }
        $scaleX = round(2048.0 / $this->_calibAccXScale) - 2048;
        $scaleY = round(2048.0 / $this->_calibAccYScale) - 2048;
        $scaleZ = round(2048.0 / $this->_calibAccZScale) - 2048;
        if ($scaleX < -2048 || $scaleX >= 2048 || $scaleY < -2048 || $scaleY >= 2048 || $scaleZ < -2048 || $scaleZ >= 2048) {
            $scaleExp = 3;
        } else {
            if ($scaleX < -1024 || $scaleX >= 1024 || $scaleY < -1024 || $scaleY >= 1024 || $scaleZ < -1024 || $scaleZ >= 1024) {
                $scaleExp = 2;
            } else {
                if ($scaleX < -512 || $scaleX >= 512 || $scaleY < -512 || $scaleY >= 512 || $scaleZ < -512 || $scaleZ >= 512) {
                    $scaleExp = 1;
                } else {
                    $scaleExp = 0;
                }
            }
        }
        if ($scaleExp > 0) {
            $scaleX = (($scaleX) >> ($scaleExp));
            $scaleY = (($scaleY) >> ($scaleExp));
            $scaleZ = (($scaleZ) >> ($scaleExp));
        }
        if ($scaleX < 0) {
            $scaleX = $scaleX + 1024;
        }
        if ($scaleY < 0) {
            $scaleY = $scaleY + 1024;
        }
        if ($scaleZ < 0) {
            $scaleZ = $scaleZ + 1024;
        }
        $scaleLo = (((($scaleY) & (15))) << (12)) + (($scaleX) << (2)) + $scaleExp;
        $scaleHi = (($scaleZ) << (6)) + (($scaleY) >> (4));
        
        // Save calibration parameters
        $newcalib = sprintf('5,%d,%d,%d,%d,%d', $shiftX, $shiftY, $shiftZ, $scaleLo, $scaleHi);
        $this->_calibStage = 0;
        return $this->set_calibrationParam($newcalib);
    }

    /**
     * Aborts the sensors tridimensional calibration process et restores normal settings.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function cancel3DCalibration()
    {
        if ($this->_calibStage == 0) {
            return YAPI_SUCCESS;
        }
        // may throw an exception
        $this->_calibStage = 0;
        return $this->set_calibrationParam($this->_calibSavedParams);
    }

    public function mountPos()
    { return $this->get_mountPos(); }

    public function setMountPos($newval)
    { return $this->set_mountPos($newval); }

    public function setBearing($newval)
    { return $this->set_bearing($newval); }

    public function bearing()
    { return $this->get_bearing(); }

    public function calibrationParam()
    { return $this->get_calibrationParam(); }

    public function setCalibrationParam($newval)
    { return $this->set_calibrationParam($newval); }

    /**
     * Continues the enumeration of reference frames started using yFirstRefFrame().
     * 
     * @return a pointer to a YRefFrame object, corresponding to
     *         a reference frame currently online, or a null pointer
     *         if there are no more reference frames to enumerate.
     */
    public function nextRefFrame()
    {   $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if($resolve->errorType != YAPI_SUCCESS) return null;
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if($next_hwid == null) return null;
        return yFindRefFrame($next_hwid);
    }

    /**
     * Starts the enumeration of reference frames currently accessible.
     * Use the method YRefFrame.nextRefFrame() to iterate on
     * next reference frames.
     * 
     * @return a pointer to a YRefFrame object, corresponding to
     *         the first reference frame currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstRefFrame()
    {   $next_hwid = YAPI::getFirstHardwareId('RefFrame');
        if($next_hwid == null) return null;
        return self::FindRefFrame($next_hwid);
    }

    //--- (end of YRefFrame implementation)

};

//--- (RefFrame functions)

/**
 * Retrieves a reference frame for a given identifier.
 * The identifier can be specified using several formats:
 * <ul>
 * <li>FunctionLogicalName</li>
 * <li>ModuleSerialNumber.FunctionIdentifier</li>
 * <li>ModuleSerialNumber.FunctionLogicalName</li>
 * <li>ModuleLogicalName.FunctionIdentifier</li>
 * <li>ModuleLogicalName.FunctionLogicalName</li>
 * </ul>
 * 
 * This function does not require that the reference frame is online at the time
 * it is invoked. The returned object is nevertheless valid.
 * Use the method YRefFrame.isOnline() to test if the reference frame is
 * indeed online at a given time. In case of ambiguity when looking for
 * a reference frame by logical name, no error is notified: the first instance
 * found is returned. The search is performed first by hardware name,
 * then by logical name.
 * 
 * @param func : a string that uniquely characterizes the reference frame
 * 
 * @return a YRefFrame object allowing you to drive the reference frame.
 */
function yFindRefFrame($func)
{
    return YRefFrame::FindRefFrame($func);
}

/**
 * Starts the enumeration of reference frames currently accessible.
 * Use the method YRefFrame.nextRefFrame() to iterate on
 * next reference frames.
 * 
 * @return a pointer to a YRefFrame object, corresponding to
 *         the first reference frame currently online, or a null pointer
 *         if there are none.
 */
function yFirstRefFrame()
{
    return YRefFrame::FirstRefFrame();
}

//--- (end of RefFrame functions)
?>