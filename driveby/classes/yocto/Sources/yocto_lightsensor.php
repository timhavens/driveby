<?php
/*********************************************************************
 *
 * $Id: yocto_lightsensor.php 17655 2014-09-16 12:24:27Z mvuilleu $
 *
 * Implements YLightSensor, the high-level API for LightSensor functions
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

//--- (YLightSensor return codes)
//--- (end of YLightSensor return codes)
//--- (YLightSensor definitions)
if(!defined('Y_MEASURETYPE_HUMAN_EYE'))      define('Y_MEASURETYPE_HUMAN_EYE',     0);
if(!defined('Y_MEASURETYPE_WIDE_SPECTRUM'))  define('Y_MEASURETYPE_WIDE_SPECTRUM', 1);
if(!defined('Y_MEASURETYPE_INFRARED'))       define('Y_MEASURETYPE_INFRARED',      2);
if(!defined('Y_MEASURETYPE_HIGH_RATE'))      define('Y_MEASURETYPE_HIGH_RATE',     3);
if(!defined('Y_MEASURETYPE_HIGH_ENERGY'))    define('Y_MEASURETYPE_HIGH_ENERGY',   4);
if(!defined('Y_MEASURETYPE_INVALID'))        define('Y_MEASURETYPE_INVALID',       -1);
//--- (end of YLightSensor definitions)

//--- (YLightSensor declaration)
/**
 * YLightSensor Class: LightSensor function interface
 * 
 * The Yoctopuce application programming interface allows you to read an instant
 * measure of the sensor, as well as the minimal and maximal values observed.
 */
class YLightSensor extends YSensor
{
    const MEASURETYPE_HUMAN_EYE          = 0;
    const MEASURETYPE_WIDE_SPECTRUM      = 1;
    const MEASURETYPE_INFRARED           = 2;
    const MEASURETYPE_HIGH_RATE          = 3;
    const MEASURETYPE_HIGH_ENERGY        = 4;
    const MEASURETYPE_INVALID            = -1;
    //--- (end of YLightSensor declaration)

    //--- (YLightSensor attributes)
    protected $_measureType              = Y_MEASURETYPE_INVALID;        // LightSensorType
    //--- (end of YLightSensor attributes)

    function __construct($str_func)
    {
        //--- (YLightSensor constructor)
        parent::__construct($str_func);
        $this->_className = 'LightSensor';

        //--- (end of YLightSensor constructor)
    }

    //--- (YLightSensor implementation)

    function _parseAttr($name, $val)
    {
        switch($name) {
        case 'measureType':
            $this->_measureType = intval($val);
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    public function set_currentValue($newval)
    {
        $rest_val = strval(round($newval * 65536.0));
        return $this->_setAttr("currentValue",$rest_val);
    }

    /**
     * Changes the sensor-specific calibration parameter so that the current value
     * matches a desired target (linear scaling).
     * 
     * @param calibratedVal : the desired target value.
     * 
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function calibrate($calibratedVal)
    {
        $rest_val = strval(round($calibratedVal * 65536.0));
        return $this->_setAttr("currentValue",$rest_val);
    }

    /**
     * Returns the type of light measure.
     * 
     * @return a value among Y_MEASURETYPE_HUMAN_EYE, Y_MEASURETYPE_WIDE_SPECTRUM, Y_MEASURETYPE_INFRARED,
     * Y_MEASURETYPE_HIGH_RATE and Y_MEASURETYPE_HIGH_ENERGY corresponding to the type of light measure
     * 
     * On failure, throws an exception or returns Y_MEASURETYPE_INVALID.
     */
    public function get_measureType()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_MEASURETYPE_INVALID;
            }
        }
        return $this->_measureType;
    }

    /**
     * Modify the light sensor type used in the device. The measure can either
     * approximate the response of the human eye, focus on a specific light
     * spectrum, depending on the capabilities of the light-sensitive cell.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     * 
     * @param newval : a value among Y_MEASURETYPE_HUMAN_EYE, Y_MEASURETYPE_WIDE_SPECTRUM,
     * Y_MEASURETYPE_INFRARED, Y_MEASURETYPE_HIGH_RATE and Y_MEASURETYPE_HIGH_ENERGY
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_measureType($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("measureType",$rest_val);
    }

    /**
     * Retrieves a light sensor for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     * 
     * This function does not require that the light sensor is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method YLightSensor.isOnline() to test if the light sensor is
     * indeed online at a given time. In case of ambiguity when looking for
     * a light sensor by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     * 
     * @param func : a string that uniquely characterizes the light sensor
     * 
     * @return a YLightSensor object allowing you to drive the light sensor.
     */
    public static function FindLightSensor($func)
    {
        // $obj                    is a YLightSensor;
        $obj = YFunction::_FindFromCache('LightSensor', $func);
        if ($obj == null) {
            $obj = new YLightSensor($func);
            YFunction::_AddToCache('LightSensor', $func, $obj);
        }
        return $obj;
    }

    public function setCurrentValue($newval)
    { return $this->set_currentValue($newval); }

    public function measureType()
    { return $this->get_measureType(); }

    public function setMeasureType($newval)
    { return $this->set_measureType($newval); }

    /**
     * Continues the enumeration of light sensors started using yFirstLightSensor().
     * 
     * @return a pointer to a YLightSensor object, corresponding to
     *         a light sensor currently online, or a null pointer
     *         if there are no more light sensors to enumerate.
     */
    public function nextLightSensor()
    {   $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if($resolve->errorType != YAPI_SUCCESS) return null;
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if($next_hwid == null) return null;
        return yFindLightSensor($next_hwid);
    }

    /**
     * Starts the enumeration of light sensors currently accessible.
     * Use the method YLightSensor.nextLightSensor() to iterate on
     * next light sensors.
     * 
     * @return a pointer to a YLightSensor object, corresponding to
     *         the first light sensor currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstLightSensor()
    {   $next_hwid = YAPI::getFirstHardwareId('LightSensor');
        if($next_hwid == null) return null;
        return self::FindLightSensor($next_hwid);
    }

    //--- (end of YLightSensor implementation)

};

//--- (LightSensor functions)

/**
 * Retrieves a light sensor for a given identifier.
 * The identifier can be specified using several formats:
 * <ul>
 * <li>FunctionLogicalName</li>
 * <li>ModuleSerialNumber.FunctionIdentifier</li>
 * <li>ModuleSerialNumber.FunctionLogicalName</li>
 * <li>ModuleLogicalName.FunctionIdentifier</li>
 * <li>ModuleLogicalName.FunctionLogicalName</li>
 * </ul>
 * 
 * This function does not require that the light sensor is online at the time
 * it is invoked. The returned object is nevertheless valid.
 * Use the method YLightSensor.isOnline() to test if the light sensor is
 * indeed online at a given time. In case of ambiguity when looking for
 * a light sensor by logical name, no error is notified: the first instance
 * found is returned. The search is performed first by hardware name,
 * then by logical name.
 * 
 * @param func : a string that uniquely characterizes the light sensor
 * 
 * @return a YLightSensor object allowing you to drive the light sensor.
 */
function yFindLightSensor($func)
{
    return YLightSensor::FindLightSensor($func);
}

/**
 * Starts the enumeration of light sensors currently accessible.
 * Use the method YLightSensor.nextLightSensor() to iterate on
 * next light sensors.
 * 
 * @return a pointer to a YLightSensor object, corresponding to
 *         the first light sensor currently online, or a null pointer
 *         if there are none.
 */
function yFirstLightSensor()
{
    return YLightSensor::FirstLightSensor();
}

//--- (end of LightSensor functions)
?>