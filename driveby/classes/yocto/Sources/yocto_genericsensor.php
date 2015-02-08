<?php
/*********************************************************************
 *
 * $Id: yocto_genericsensor.php 16923 2014-07-18 14:47:20Z mvuilleu $
 *
 * Implements YGenericSensor, the high-level API for GenericSensor functions
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

//--- (YGenericSensor return codes)
//--- (end of YGenericSensor return codes)
//--- (YGenericSensor definitions)
if(!defined('Y_SIGNALVALUE_INVALID'))        define('Y_SIGNALVALUE_INVALID',       YAPI_INVALID_DOUBLE);
if(!defined('Y_SIGNALUNIT_INVALID'))         define('Y_SIGNALUNIT_INVALID',        YAPI_INVALID_STRING);
if(!defined('Y_SIGNALRANGE_INVALID'))        define('Y_SIGNALRANGE_INVALID',       YAPI_INVALID_STRING);
if(!defined('Y_VALUERANGE_INVALID'))         define('Y_VALUERANGE_INVALID',        YAPI_INVALID_STRING);
if(!defined('Y_SIGNALBIAS_INVALID'))         define('Y_SIGNALBIAS_INVALID',        YAPI_INVALID_DOUBLE);
//--- (end of YGenericSensor definitions)

//--- (YGenericSensor declaration)
/**
 * YGenericSensor Class: GenericSensor function interface
 * 
 * The Yoctopuce application programming interface allows you to read an instant
 * measure of the sensor, as well as the minimal and maximal values observed.
 */
class YGenericSensor extends YSensor
{
    const SIGNALVALUE_INVALID            = YAPI_INVALID_DOUBLE;
    const SIGNALUNIT_INVALID             = YAPI_INVALID_STRING;
    const SIGNALRANGE_INVALID            = YAPI_INVALID_STRING;
    const VALUERANGE_INVALID             = YAPI_INVALID_STRING;
    const SIGNALBIAS_INVALID             = YAPI_INVALID_DOUBLE;
    //--- (end of YGenericSensor declaration)

    //--- (YGenericSensor attributes)
    protected $_signalValue              = Y_SIGNALVALUE_INVALID;        // MeasureVal
    protected $_signalUnit               = Y_SIGNALUNIT_INVALID;         // Text
    protected $_signalRange              = Y_SIGNALRANGE_INVALID;        // ValueRange
    protected $_valueRange               = Y_VALUERANGE_INVALID;         // ValueRange
    protected $_signalBias               = Y_SIGNALBIAS_INVALID;         // MeasureVal
    //--- (end of YGenericSensor attributes)

    function __construct($str_func)
    {
        //--- (YGenericSensor constructor)
        parent::__construct($str_func);
        $this->_className = 'GenericSensor';

        //--- (end of YGenericSensor constructor)
    }

    //--- (YGenericSensor implementation)

    function _parseAttr($name, $val)
    {
        switch($name) {
        case 'signalValue':
            $this->_signalValue = round($val * 1000.0 / 65536.0) / 1000.0;
            return 1;
        case 'signalUnit':
            $this->_signalUnit = $val;
            return 1;
        case 'signalRange':
            $this->_signalRange = $val;
            return 1;
        case 'valueRange':
            $this->_valueRange = $val;
            return 1;
        case 'signalBias':
            $this->_signalBias = round($val * 1000.0 / 65536.0) / 1000.0;
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Changes the measuring unit for the measured value.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     * 
     * @param newval : a string corresponding to the measuring unit for the measured value
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_unit($newval)
    {
        $rest_val = $newval;
        return $this->_setAttr("unit",$rest_val);
    }

    /**
     * Returns the measured value of the electrical signal used by the sensor.
     * 
     * @return a floating point number corresponding to the measured value of the electrical signal used by the sensor
     * 
     * On failure, throws an exception or returns Y_SIGNALVALUE_INVALID.
     */
    public function get_signalValue()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_SIGNALVALUE_INVALID;
            }
        }
        return round($this->_signalValue * 1000) / 1000;
    }

    /**
     * Returns the measuring unit of the electrical signal used by the sensor.
     * 
     * @return a string corresponding to the measuring unit of the electrical signal used by the sensor
     * 
     * On failure, throws an exception or returns Y_SIGNALUNIT_INVALID.
     */
    public function get_signalUnit()
    {
        if ($this->_cacheExpiration == 0) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_SIGNALUNIT_INVALID;
            }
        }
        return $this->_signalUnit;
    }

    /**
     * Returns the electric signal range used by the sensor.
     * 
     * @return a string corresponding to the electric signal range used by the sensor
     * 
     * On failure, throws an exception or returns Y_SIGNALRANGE_INVALID.
     */
    public function get_signalRange()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_SIGNALRANGE_INVALID;
            }
        }
        return $this->_signalRange;
    }

    /**
     * Changes the electric signal range used by the sensor.
     * 
     * @param newval : a string corresponding to the electric signal range used by the sensor
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_signalRange($newval)
    {
        $rest_val = $newval;
        return $this->_setAttr("signalRange",$rest_val);
    }

    /**
     * Returns the physical value range measured by the sensor.
     * 
     * @return a string corresponding to the physical value range measured by the sensor
     * 
     * On failure, throws an exception or returns Y_VALUERANGE_INVALID.
     */
    public function get_valueRange()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_VALUERANGE_INVALID;
            }
        }
        return $this->_valueRange;
    }

    /**
     * Changes the physical value range measured by the sensor. As a side effect, the range modification may
     * automatically modify the display resolution.
     * 
     * @param newval : a string corresponding to the physical value range measured by the sensor
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_valueRange($newval)
    {
        $rest_val = $newval;
        return $this->_setAttr("valueRange",$rest_val);
    }

    /**
     * Changes the electric signal bias for zero shift adjustment.
     * If your electric signal reads positif when it should be zero, setup
     * a positive signalBias of the same value to fix the zero shift.
     * 
     * @param newval : a floating point number corresponding to the electric signal bias for zero shift adjustment
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_signalBias($newval)
    {
        $rest_val = strval(round($newval * 65536.0));
        return $this->_setAttr("signalBias",$rest_val);
    }

    /**
     * Returns the electric signal bias for zero shift adjustment.
     * A positive bias means that the signal is over-reporting the measure,
     * while a negative bias means that the signal is underreporting the measure.
     * 
     * @return a floating point number corresponding to the electric signal bias for zero shift adjustment
     * 
     * On failure, throws an exception or returns Y_SIGNALBIAS_INVALID.
     */
    public function get_signalBias()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_SIGNALBIAS_INVALID;
            }
        }
        return $this->_signalBias;
    }

    /**
     * Retrieves a generic sensor for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     * 
     * This function does not require that the generic sensor is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method YGenericSensor.isOnline() to test if the generic sensor is
     * indeed online at a given time. In case of ambiguity when looking for
     * a generic sensor by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     * 
     * @param func : a string that uniquely characterizes the generic sensor
     * 
     * @return a YGenericSensor object allowing you to drive the generic sensor.
     */
    public static function FindGenericSensor($func)
    {
        // $obj                    is a YGenericSensor;
        $obj = YFunction::_FindFromCache('GenericSensor', $func);
        if ($obj == null) {
            $obj = new YGenericSensor($func);
            YFunction::_AddToCache('GenericSensor', $func, $obj);
        }
        return $obj;
    }

    /**
     * Adjusts the signal bias so that the current signal value is need
     * precisely as zero.
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function zeroAdjust()
    {
        // $currSignal             is a float;
        // $currBias               is a float;
        $currSignal = $this->get_signalValue();
        $currBias = $this->get_signalBias();
        return $this->set_signalBias($currSignal + $currBias);
    }

    public function setUnit($newval)
    { return $this->set_unit($newval); }

    public function signalValue()
    { return $this->get_signalValue(); }

    public function signalUnit()
    { return $this->get_signalUnit(); }

    public function signalRange()
    { return $this->get_signalRange(); }

    public function setSignalRange($newval)
    { return $this->set_signalRange($newval); }

    public function valueRange()
    { return $this->get_valueRange(); }

    public function setValueRange($newval)
    { return $this->set_valueRange($newval); }

    public function setSignalBias($newval)
    { return $this->set_signalBias($newval); }

    public function signalBias()
    { return $this->get_signalBias(); }

    /**
     * Continues the enumeration of generic sensors started using yFirstGenericSensor().
     * 
     * @return a pointer to a YGenericSensor object, corresponding to
     *         a generic sensor currently online, or a null pointer
     *         if there are no more generic sensors to enumerate.
     */
    public function nextGenericSensor()
    {   $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if($resolve->errorType != YAPI_SUCCESS) return null;
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if($next_hwid == null) return null;
        return yFindGenericSensor($next_hwid);
    }

    /**
     * Starts the enumeration of generic sensors currently accessible.
     * Use the method YGenericSensor.nextGenericSensor() to iterate on
     * next generic sensors.
     * 
     * @return a pointer to a YGenericSensor object, corresponding to
     *         the first generic sensor currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstGenericSensor()
    {   $next_hwid = YAPI::getFirstHardwareId('GenericSensor');
        if($next_hwid == null) return null;
        return self::FindGenericSensor($next_hwid);
    }

    //--- (end of YGenericSensor implementation)

};

//--- (GenericSensor functions)

/**
 * Retrieves a generic sensor for a given identifier.
 * The identifier can be specified using several formats:
 * <ul>
 * <li>FunctionLogicalName</li>
 * <li>ModuleSerialNumber.FunctionIdentifier</li>
 * <li>ModuleSerialNumber.FunctionLogicalName</li>
 * <li>ModuleLogicalName.FunctionIdentifier</li>
 * <li>ModuleLogicalName.FunctionLogicalName</li>
 * </ul>
 * 
 * This function does not require that the generic sensor is online at the time
 * it is invoked. The returned object is nevertheless valid.
 * Use the method YGenericSensor.isOnline() to test if the generic sensor is
 * indeed online at a given time. In case of ambiguity when looking for
 * a generic sensor by logical name, no error is notified: the first instance
 * found is returned. The search is performed first by hardware name,
 * then by logical name.
 * 
 * @param func : a string that uniquely characterizes the generic sensor
 * 
 * @return a YGenericSensor object allowing you to drive the generic sensor.
 */
function yFindGenericSensor($func)
{
    return YGenericSensor::FindGenericSensor($func);
}

/**
 * Starts the enumeration of generic sensors currently accessible.
 * Use the method YGenericSensor.nextGenericSensor() to iterate on
 * next generic sensors.
 * 
 * @return a pointer to a YGenericSensor object, corresponding to
 *         the first generic sensor currently online, or a null pointer
 *         if there are none.
 */
function yFirstGenericSensor()
{
    return YGenericSensor::FirstGenericSensor();
}

//--- (end of GenericSensor functions)
?>