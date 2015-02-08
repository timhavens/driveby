<?php
/*********************************************************************
 *
 * $Id: yocto_accelerometer.php 17245 2014-08-20 16:16:37Z seb $
 *
 * Implements YAccelerometer, the high-level API for Accelerometer functions
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

//--- (YAccelerometer return codes)
//--- (end of YAccelerometer return codes)
//--- (YAccelerometer definitions)
if(!defined('Y_GRAVITYCANCELLATION_OFF'))    define('Y_GRAVITYCANCELLATION_OFF',   0);
if(!defined('Y_GRAVITYCANCELLATION_ON'))     define('Y_GRAVITYCANCELLATION_ON',    1);
if(!defined('Y_GRAVITYCANCELLATION_INVALID')) define('Y_GRAVITYCANCELLATION_INVALID', -1);
if(!defined('Y_XVALUE_INVALID'))             define('Y_XVALUE_INVALID',            YAPI_INVALID_DOUBLE);
if(!defined('Y_YVALUE_INVALID'))             define('Y_YVALUE_INVALID',            YAPI_INVALID_DOUBLE);
if(!defined('Y_ZVALUE_INVALID'))             define('Y_ZVALUE_INVALID',            YAPI_INVALID_DOUBLE);
//--- (end of YAccelerometer definitions)

//--- (YAccelerometer declaration)
/**
 * YAccelerometer Class: Accelerometer function interface
 * 
 * The Yoctopuce application programming interface allows you to read an instant
 * measure of the sensor, as well as the minimal and maximal values observed.
 */
class YAccelerometer extends YSensor
{
    const XVALUE_INVALID                 = YAPI_INVALID_DOUBLE;
    const YVALUE_INVALID                 = YAPI_INVALID_DOUBLE;
    const ZVALUE_INVALID                 = YAPI_INVALID_DOUBLE;
    const GRAVITYCANCELLATION_OFF        = 0;
    const GRAVITYCANCELLATION_ON         = 1;
    const GRAVITYCANCELLATION_INVALID    = -1;
    //--- (end of YAccelerometer declaration)

    //--- (YAccelerometer attributes)
    protected $_xValue                   = Y_XVALUE_INVALID;             // MeasureVal
    protected $_yValue                   = Y_YVALUE_INVALID;             // MeasureVal
    protected $_zValue                   = Y_ZVALUE_INVALID;             // MeasureVal
    protected $_gravityCancellation      = Y_GRAVITYCANCELLATION_INVALID; // OnOff
    //--- (end of YAccelerometer attributes)

    function __construct($str_func)
    {
        //--- (YAccelerometer constructor)
        parent::__construct($str_func);
        $this->_className = 'Accelerometer';

        //--- (end of YAccelerometer constructor)
    }

    //--- (YAccelerometer implementation)

    function _parseAttr($name, $val)
    {
        switch($name) {
        case 'xValue':
            $this->_xValue = round($val * 1000.0 / 65536.0) / 1000.0;
            return 1;
        case 'yValue':
            $this->_yValue = round($val * 1000.0 / 65536.0) / 1000.0;
            return 1;
        case 'zValue':
            $this->_zValue = round($val * 1000.0 / 65536.0) / 1000.0;
            return 1;
        case 'gravityCancellation':
            $this->_gravityCancellation = intval($val);
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Returns the X component of the acceleration, as a floating point number.
     * 
     * @return a floating point number corresponding to the X component of the acceleration, as a floating point number
     * 
     * On failure, throws an exception or returns Y_XVALUE_INVALID.
     */
    public function get_xValue()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_XVALUE_INVALID;
            }
        }
        return $this->_xValue;
    }

    /**
     * Returns the Y component of the acceleration, as a floating point number.
     * 
     * @return a floating point number corresponding to the Y component of the acceleration, as a floating point number
     * 
     * On failure, throws an exception or returns Y_YVALUE_INVALID.
     */
    public function get_yValue()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_YVALUE_INVALID;
            }
        }
        return $this->_yValue;
    }

    /**
     * Returns the Z component of the acceleration, as a floating point number.
     * 
     * @return a floating point number corresponding to the Z component of the acceleration, as a floating point number
     * 
     * On failure, throws an exception or returns Y_ZVALUE_INVALID.
     */
    public function get_zValue()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_ZVALUE_INVALID;
            }
        }
        return $this->_zValue;
    }

    public function get_gravityCancellation()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_GRAVITYCANCELLATION_INVALID;
            }
        }
        return $this->_gravityCancellation;
    }

    public function set_gravityCancellation($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("gravityCancellation",$rest_val);
    }

    /**
     * Retrieves an accelerometer for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     * 
     * This function does not require that the accelerometer is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method YAccelerometer.isOnline() to test if the accelerometer is
     * indeed online at a given time. In case of ambiguity when looking for
     * an accelerometer by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     * 
     * @param func : a string that uniquely characterizes the accelerometer
     * 
     * @return a YAccelerometer object allowing you to drive the accelerometer.
     */
    public static function FindAccelerometer($func)
    {
        // $obj                    is a YAccelerometer;
        $obj = YFunction::_FindFromCache('Accelerometer', $func);
        if ($obj == null) {
            $obj = new YAccelerometer($func);
            YFunction::_AddToCache('Accelerometer', $func, $obj);
        }
        return $obj;
    }

    public function xValue()
    { return $this->get_xValue(); }

    public function yValue()
    { return $this->get_yValue(); }

    public function zValue()
    { return $this->get_zValue(); }

    public function gravityCancellation()
    { return $this->get_gravityCancellation(); }

    public function setGravityCancellation($newval)
    { return $this->set_gravityCancellation($newval); }

    /**
     * Continues the enumeration of accelerometers started using yFirstAccelerometer().
     * 
     * @return a pointer to a YAccelerometer object, corresponding to
     *         an accelerometer currently online, or a null pointer
     *         if there are no more accelerometers to enumerate.
     */
    public function nextAccelerometer()
    {   $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if($resolve->errorType != YAPI_SUCCESS) return null;
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if($next_hwid == null) return null;
        return yFindAccelerometer($next_hwid);
    }

    /**
     * Starts the enumeration of accelerometers currently accessible.
     * Use the method YAccelerometer.nextAccelerometer() to iterate on
     * next accelerometers.
     * 
     * @return a pointer to a YAccelerometer object, corresponding to
     *         the first accelerometer currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstAccelerometer()
    {   $next_hwid = YAPI::getFirstHardwareId('Accelerometer');
        if($next_hwid == null) return null;
        return self::FindAccelerometer($next_hwid);
    }

    //--- (end of YAccelerometer implementation)

};

//--- (Accelerometer functions)

/**
 * Retrieves an accelerometer for a given identifier.
 * The identifier can be specified using several formats:
 * <ul>
 * <li>FunctionLogicalName</li>
 * <li>ModuleSerialNumber.FunctionIdentifier</li>
 * <li>ModuleSerialNumber.FunctionLogicalName</li>
 * <li>ModuleLogicalName.FunctionIdentifier</li>
 * <li>ModuleLogicalName.FunctionLogicalName</li>
 * </ul>
 * 
 * This function does not require that the accelerometer is online at the time
 * it is invoked. The returned object is nevertheless valid.
 * Use the method YAccelerometer.isOnline() to test if the accelerometer is
 * indeed online at a given time. In case of ambiguity when looking for
 * an accelerometer by logical name, no error is notified: the first instance
 * found is returned. The search is performed first by hardware name,
 * then by logical name.
 * 
 * @param func : a string that uniquely characterizes the accelerometer
 * 
 * @return a YAccelerometer object allowing you to drive the accelerometer.
 */
function yFindAccelerometer($func)
{
    return YAccelerometer::FindAccelerometer($func);
}

/**
 * Starts the enumeration of accelerometers currently accessible.
 * Use the method YAccelerometer.nextAccelerometer() to iterate on
 * next accelerometers.
 * 
 * @return a pointer to a YAccelerometer object, corresponding to
 *         the first accelerometer currently online, or a null pointer
 *         if there are none.
 */
function yFirstAccelerometer()
{
    return YAccelerometer::FirstAccelerometer();
}

//--- (end of Accelerometer functions)
?>