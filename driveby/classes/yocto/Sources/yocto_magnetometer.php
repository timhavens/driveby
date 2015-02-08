<?php
/*********************************************************************
 *
 * $Id: yocto_magnetometer.php 16895 2014-07-18 00:12:08Z mvuilleu $
 *
 * Implements YMagnetometer, the high-level API for Magnetometer functions
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

//--- (YMagnetometer return codes)
//--- (end of YMagnetometer return codes)
//--- (YMagnetometer definitions)
if(!defined('Y_XVALUE_INVALID'))             define('Y_XVALUE_INVALID',            YAPI_INVALID_DOUBLE);
if(!defined('Y_YVALUE_INVALID'))             define('Y_YVALUE_INVALID',            YAPI_INVALID_DOUBLE);
if(!defined('Y_ZVALUE_INVALID'))             define('Y_ZVALUE_INVALID',            YAPI_INVALID_DOUBLE);
//--- (end of YMagnetometer definitions)

//--- (YMagnetometer declaration)
/**
 * YMagnetometer Class: Magnetometer function interface
 * 
 * The Yoctopuce application programming interface allows you to read an instant
 * measure of the sensor, as well as the minimal and maximal values observed.
 */
class YMagnetometer extends YSensor
{
    const XVALUE_INVALID                 = YAPI_INVALID_DOUBLE;
    const YVALUE_INVALID                 = YAPI_INVALID_DOUBLE;
    const ZVALUE_INVALID                 = YAPI_INVALID_DOUBLE;
    //--- (end of YMagnetometer declaration)

    //--- (YMagnetometer attributes)
    protected $_xValue                   = Y_XVALUE_INVALID;             // MeasureVal
    protected $_yValue                   = Y_YVALUE_INVALID;             // MeasureVal
    protected $_zValue                   = Y_ZVALUE_INVALID;             // MeasureVal
    //--- (end of YMagnetometer attributes)

    function __construct($str_func)
    {
        //--- (YMagnetometer constructor)
        parent::__construct($str_func);
        $this->_className = 'Magnetometer';

        //--- (end of YMagnetometer constructor)
    }

    //--- (YMagnetometer implementation)

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
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Returns the X component of the magnetic field, as a floating point number.
     * 
     * @return a floating point number corresponding to the X component of the magnetic field, as a
     * floating point number
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
     * Returns the Y component of the magnetic field, as a floating point number.
     * 
     * @return a floating point number corresponding to the Y component of the magnetic field, as a
     * floating point number
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
     * Returns the Z component of the magnetic field, as a floating point number.
     * 
     * @return a floating point number corresponding to the Z component of the magnetic field, as a
     * floating point number
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

    /**
     * Retrieves a magnetometer for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     * 
     * This function does not require that the magnetometer is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method YMagnetometer.isOnline() to test if the magnetometer is
     * indeed online at a given time. In case of ambiguity when looking for
     * a magnetometer by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     * 
     * @param func : a string that uniquely characterizes the magnetometer
     * 
     * @return a YMagnetometer object allowing you to drive the magnetometer.
     */
    public static function FindMagnetometer($func)
    {
        // $obj                    is a YMagnetometer;
        $obj = YFunction::_FindFromCache('Magnetometer', $func);
        if ($obj == null) {
            $obj = new YMagnetometer($func);
            YFunction::_AddToCache('Magnetometer', $func, $obj);
        }
        return $obj;
    }

    public function xValue()
    { return $this->get_xValue(); }

    public function yValue()
    { return $this->get_yValue(); }

    public function zValue()
    { return $this->get_zValue(); }

    /**
     * Continues the enumeration of magnetometers started using yFirstMagnetometer().
     * 
     * @return a pointer to a YMagnetometer object, corresponding to
     *         a magnetometer currently online, or a null pointer
     *         if there are no more magnetometers to enumerate.
     */
    public function nextMagnetometer()
    {   $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if($resolve->errorType != YAPI_SUCCESS) return null;
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if($next_hwid == null) return null;
        return yFindMagnetometer($next_hwid);
    }

    /**
     * Starts the enumeration of magnetometers currently accessible.
     * Use the method YMagnetometer.nextMagnetometer() to iterate on
     * next magnetometers.
     * 
     * @return a pointer to a YMagnetometer object, corresponding to
     *         the first magnetometer currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstMagnetometer()
    {   $next_hwid = YAPI::getFirstHardwareId('Magnetometer');
        if($next_hwid == null) return null;
        return self::FindMagnetometer($next_hwid);
    }

    //--- (end of YMagnetometer implementation)

};

//--- (Magnetometer functions)

/**
 * Retrieves a magnetometer for a given identifier.
 * The identifier can be specified using several formats:
 * <ul>
 * <li>FunctionLogicalName</li>
 * <li>ModuleSerialNumber.FunctionIdentifier</li>
 * <li>ModuleSerialNumber.FunctionLogicalName</li>
 * <li>ModuleLogicalName.FunctionIdentifier</li>
 * <li>ModuleLogicalName.FunctionLogicalName</li>
 * </ul>
 * 
 * This function does not require that the magnetometer is online at the time
 * it is invoked. The returned object is nevertheless valid.
 * Use the method YMagnetometer.isOnline() to test if the magnetometer is
 * indeed online at a given time. In case of ambiguity when looking for
 * a magnetometer by logical name, no error is notified: the first instance
 * found is returned. The search is performed first by hardware name,
 * then by logical name.
 * 
 * @param func : a string that uniquely characterizes the magnetometer
 * 
 * @return a YMagnetometer object allowing you to drive the magnetometer.
 */
function yFindMagnetometer($func)
{
    return YMagnetometer::FindMagnetometer($func);
}

/**
 * Starts the enumeration of magnetometers currently accessible.
 * Use the method YMagnetometer.nextMagnetometer() to iterate on
 * next magnetometers.
 * 
 * @return a pointer to a YMagnetometer object, corresponding to
 *         the first magnetometer currently online, or a null pointer
 *         if there are none.
 */
function yFirstMagnetometer()
{
    return YMagnetometer::FirstMagnetometer();
}

//--- (end of Magnetometer functions)
?>