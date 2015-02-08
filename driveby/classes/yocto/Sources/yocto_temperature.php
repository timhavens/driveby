<?php
/*********************************************************************
 *
 * $Id: yocto_temperature.php 16543 2014-06-13 12:15:09Z mvuilleu $
 *
 * Implements YTemperature, the high-level API for Temperature functions
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

//--- (YTemperature return codes)
//--- (end of YTemperature return codes)
//--- (YTemperature definitions)
if(!defined('Y_SENSORTYPE_DIGITAL'))         define('Y_SENSORTYPE_DIGITAL',        0);
if(!defined('Y_SENSORTYPE_TYPE_K'))          define('Y_SENSORTYPE_TYPE_K',         1);
if(!defined('Y_SENSORTYPE_TYPE_E'))          define('Y_SENSORTYPE_TYPE_E',         2);
if(!defined('Y_SENSORTYPE_TYPE_J'))          define('Y_SENSORTYPE_TYPE_J',         3);
if(!defined('Y_SENSORTYPE_TYPE_N'))          define('Y_SENSORTYPE_TYPE_N',         4);
if(!defined('Y_SENSORTYPE_TYPE_R'))          define('Y_SENSORTYPE_TYPE_R',         5);
if(!defined('Y_SENSORTYPE_TYPE_S'))          define('Y_SENSORTYPE_TYPE_S',         6);
if(!defined('Y_SENSORTYPE_TYPE_T'))          define('Y_SENSORTYPE_TYPE_T',         7);
if(!defined('Y_SENSORTYPE_PT100_4WIRES'))    define('Y_SENSORTYPE_PT100_4WIRES',   8);
if(!defined('Y_SENSORTYPE_PT100_3WIRES'))    define('Y_SENSORTYPE_PT100_3WIRES',   9);
if(!defined('Y_SENSORTYPE_PT100_2WIRES'))    define('Y_SENSORTYPE_PT100_2WIRES',   10);
if(!defined('Y_SENSORTYPE_INVALID'))         define('Y_SENSORTYPE_INVALID',        -1);
//--- (end of YTemperature definitions)

//--- (YTemperature declaration)
/**
 * YTemperature Class: Temperature function interface
 * 
 * The Yoctopuce application programming interface allows you to read an instant
 * measure of the sensor, as well as the minimal and maximal values observed.
 */
class YTemperature extends YSensor
{
    const SENSORTYPE_DIGITAL             = 0;
    const SENSORTYPE_TYPE_K              = 1;
    const SENSORTYPE_TYPE_E              = 2;
    const SENSORTYPE_TYPE_J              = 3;
    const SENSORTYPE_TYPE_N              = 4;
    const SENSORTYPE_TYPE_R              = 5;
    const SENSORTYPE_TYPE_S              = 6;
    const SENSORTYPE_TYPE_T              = 7;
    const SENSORTYPE_PT100_4WIRES        = 8;
    const SENSORTYPE_PT100_3WIRES        = 9;
    const SENSORTYPE_PT100_2WIRES        = 10;
    const SENSORTYPE_INVALID             = -1;
    //--- (end of YTemperature declaration)

    //--- (YTemperature attributes)
    protected $_sensorType               = Y_SENSORTYPE_INVALID;         // TempSensorType
    //--- (end of YTemperature attributes)

    function __construct($str_func)
    {
        //--- (YTemperature constructor)
        parent::__construct($str_func);
        $this->_className = 'Temperature';

        //--- (end of YTemperature constructor)
    }

    //--- (YTemperature implementation)

    function _parseAttr($name, $val)
    {
        switch($name) {
        case 'sensorType':
            $this->_sensorType = intval($val);
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Returns the temperature sensor type.
     * 
     * @return a value among Y_SENSORTYPE_DIGITAL, Y_SENSORTYPE_TYPE_K, Y_SENSORTYPE_TYPE_E,
     * Y_SENSORTYPE_TYPE_J, Y_SENSORTYPE_TYPE_N, Y_SENSORTYPE_TYPE_R, Y_SENSORTYPE_TYPE_S,
     * Y_SENSORTYPE_TYPE_T, Y_SENSORTYPE_PT100_4WIRES, Y_SENSORTYPE_PT100_3WIRES and
     * Y_SENSORTYPE_PT100_2WIRES corresponding to the temperature sensor type
     * 
     * On failure, throws an exception or returns Y_SENSORTYPE_INVALID.
     */
    public function get_sensorType()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_SENSORTYPE_INVALID;
            }
        }
        return $this->_sensorType;
    }

    /**
     * Modify the temperature sensor type.  This function is used to
     * to define the type of thermocouple (K,E...) used with the device.
     * This will have no effect if module is using a digital sensor.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     * 
     * @param newval : a value among Y_SENSORTYPE_DIGITAL, Y_SENSORTYPE_TYPE_K, Y_SENSORTYPE_TYPE_E,
     * Y_SENSORTYPE_TYPE_J, Y_SENSORTYPE_TYPE_N, Y_SENSORTYPE_TYPE_R, Y_SENSORTYPE_TYPE_S,
     * Y_SENSORTYPE_TYPE_T, Y_SENSORTYPE_PT100_4WIRES, Y_SENSORTYPE_PT100_3WIRES and Y_SENSORTYPE_PT100_2WIRES
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_sensorType($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("sensorType",$rest_val);
    }

    /**
     * Retrieves a temperature sensor for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     * 
     * This function does not require that the temperature sensor is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method YTemperature.isOnline() to test if the temperature sensor is
     * indeed online at a given time. In case of ambiguity when looking for
     * a temperature sensor by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     * 
     * @param func : a string that uniquely characterizes the temperature sensor
     * 
     * @return a YTemperature object allowing you to drive the temperature sensor.
     */
    public static function FindTemperature($func)
    {
        // $obj                    is a YTemperature;
        $obj = YFunction::_FindFromCache('Temperature', $func);
        if ($obj == null) {
            $obj = new YTemperature($func);
            YFunction::_AddToCache('Temperature', $func, $obj);
        }
        return $obj;
    }

    public function sensorType()
    { return $this->get_sensorType(); }

    public function setSensorType($newval)
    { return $this->set_sensorType($newval); }

    /**
     * Continues the enumeration of temperature sensors started using yFirstTemperature().
     * 
     * @return a pointer to a YTemperature object, corresponding to
     *         a temperature sensor currently online, or a null pointer
     *         if there are no more temperature sensors to enumerate.
     */
    public function nextTemperature()
    {   $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if($resolve->errorType != YAPI_SUCCESS) return null;
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if($next_hwid == null) return null;
        return yFindTemperature($next_hwid);
    }

    /**
     * Starts the enumeration of temperature sensors currently accessible.
     * Use the method YTemperature.nextTemperature() to iterate on
     * next temperature sensors.
     * 
     * @return a pointer to a YTemperature object, corresponding to
     *         the first temperature sensor currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstTemperature()
    {   $next_hwid = YAPI::getFirstHardwareId('Temperature');
        if($next_hwid == null) return null;
        return self::FindTemperature($next_hwid);
    }

    //--- (end of YTemperature implementation)

};

//--- (Temperature functions)

/**
 * Retrieves a temperature sensor for a given identifier.
 * The identifier can be specified using several formats:
 * <ul>
 * <li>FunctionLogicalName</li>
 * <li>ModuleSerialNumber.FunctionIdentifier</li>
 * <li>ModuleSerialNumber.FunctionLogicalName</li>
 * <li>ModuleLogicalName.FunctionIdentifier</li>
 * <li>ModuleLogicalName.FunctionLogicalName</li>
 * </ul>
 * 
 * This function does not require that the temperature sensor is online at the time
 * it is invoked. The returned object is nevertheless valid.
 * Use the method YTemperature.isOnline() to test if the temperature sensor is
 * indeed online at a given time. In case of ambiguity when looking for
 * a temperature sensor by logical name, no error is notified: the first instance
 * found is returned. The search is performed first by hardware name,
 * then by logical name.
 * 
 * @param func : a string that uniquely characterizes the temperature sensor
 * 
 * @return a YTemperature object allowing you to drive the temperature sensor.
 */
function yFindTemperature($func)
{
    return YTemperature::FindTemperature($func);
}

/**
 * Starts the enumeration of temperature sensors currently accessible.
 * Use the method YTemperature.nextTemperature() to iterate on
 * next temperature sensors.
 * 
 * @return a pointer to a YTemperature object, corresponding to
 *         the first temperature sensor currently online, or a null pointer
 *         if there are none.
 */
function yFirstTemperature()
{
    return YTemperature::FirstTemperature();
}

//--- (end of Temperature functions)
?>