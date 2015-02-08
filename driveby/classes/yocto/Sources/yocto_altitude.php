<?php
/*********************************************************************
 *
 * $Id: yocto_altitude.php 16895 2014-07-18 00:12:08Z mvuilleu $
 *
 * Implements YAltitude, the high-level API for Altitude functions
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

//--- (YAltitude return codes)
//--- (end of YAltitude return codes)
//--- (YAltitude definitions)
if(!defined('Y_QNH_INVALID'))                define('Y_QNH_INVALID',               YAPI_INVALID_DOUBLE);
//--- (end of YAltitude definitions)

//--- (YAltitude declaration)
/**
 * YAltitude Class: Altitude function interface
 * 
 * The Yoctopuce application programming interface allows you to read an instant
 * measure of the sensor, as well as the minimal and maximal values observed.
 */
class YAltitude extends YSensor
{
    const QNH_INVALID                    = YAPI_INVALID_DOUBLE;
    //--- (end of YAltitude declaration)

    //--- (YAltitude attributes)
    protected $_qnh                      = Y_QNH_INVALID;                // MeasureVal
    //--- (end of YAltitude attributes)

    function __construct($str_func)
    {
        //--- (YAltitude constructor)
        parent::__construct($str_func);
        $this->_className = 'Altitude';

        //--- (end of YAltitude constructor)
    }

    //--- (YAltitude implementation)

    function _parseAttr($name, $val)
    {
        switch($name) {
        case 'qnh':
            $this->_qnh = round($val * 1000.0 / 65536.0) / 1000.0;
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Changes the current estimated altitude. This allows to compensate for
     * ambient pressure variations and to work in relative mode.
     * 
     * @param newval : a floating point number corresponding to the current estimated altitude
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_currentValue($newval)
    {
        $rest_val = strval(round($newval * 65536.0));
        return $this->_setAttr("currentValue",$rest_val);
    }

    /**
     * Changes the barometric pressure adjusted to sea level used to compute
     * the altitude (QNH). This enables you to compensate for atmospheric pressure
     * changes due to weather conditions.
     * 
     * @param newval : a floating point number corresponding to the barometric pressure adjusted to sea
     * level used to compute
     *         the altitude (QNH)
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_qnh($newval)
    {
        $rest_val = strval(round($newval * 65536.0));
        return $this->_setAttr("qnh",$rest_val);
    }

    /**
     * Returns the barometric pressure adjusted to sea level used to compute
     * the altitude (QNH).
     * 
     * @return a floating point number corresponding to the barometric pressure adjusted to sea level used to compute
     *         the altitude (QNH)
     * 
     * On failure, throws an exception or returns Y_QNH_INVALID.
     */
    public function get_qnh()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_QNH_INVALID;
            }
        }
        return $this->_qnh;
    }

    /**
     * Retrieves an altimeter for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     * 
     * This function does not require that the altimeter is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method YAltitude.isOnline() to test if the altimeter is
     * indeed online at a given time. In case of ambiguity when looking for
     * an altimeter by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     * 
     * @param func : a string that uniquely characterizes the altimeter
     * 
     * @return a YAltitude object allowing you to drive the altimeter.
     */
    public static function FindAltitude($func)
    {
        // $obj                    is a YAltitude;
        $obj = YFunction::_FindFromCache('Altitude', $func);
        if ($obj == null) {
            $obj = new YAltitude($func);
            YFunction::_AddToCache('Altitude', $func, $obj);
        }
        return $obj;
    }

    public function setCurrentValue($newval)
    { return $this->set_currentValue($newval); }

    public function setQnh($newval)
    { return $this->set_qnh($newval); }

    public function qnh()
    { return $this->get_qnh(); }

    /**
     * Continues the enumeration of altimeters started using yFirstAltitude().
     * 
     * @return a pointer to a YAltitude object, corresponding to
     *         an altimeter currently online, or a null pointer
     *         if there are no more altimeters to enumerate.
     */
    public function nextAltitude()
    {   $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if($resolve->errorType != YAPI_SUCCESS) return null;
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if($next_hwid == null) return null;
        return yFindAltitude($next_hwid);
    }

    /**
     * Starts the enumeration of altimeters currently accessible.
     * Use the method YAltitude.nextAltitude() to iterate on
     * next altimeters.
     * 
     * @return a pointer to a YAltitude object, corresponding to
     *         the first altimeter currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstAltitude()
    {   $next_hwid = YAPI::getFirstHardwareId('Altitude');
        if($next_hwid == null) return null;
        return self::FindAltitude($next_hwid);
    }

    //--- (end of YAltitude implementation)

};

//--- (Altitude functions)

/**
 * Retrieves an altimeter for a given identifier.
 * The identifier can be specified using several formats:
 * <ul>
 * <li>FunctionLogicalName</li>
 * <li>ModuleSerialNumber.FunctionIdentifier</li>
 * <li>ModuleSerialNumber.FunctionLogicalName</li>
 * <li>ModuleLogicalName.FunctionIdentifier</li>
 * <li>ModuleLogicalName.FunctionLogicalName</li>
 * </ul>
 * 
 * This function does not require that the altimeter is online at the time
 * it is invoked. The returned object is nevertheless valid.
 * Use the method YAltitude.isOnline() to test if the altimeter is
 * indeed online at a given time. In case of ambiguity when looking for
 * an altimeter by logical name, no error is notified: the first instance
 * found is returned. The search is performed first by hardware name,
 * then by logical name.
 * 
 * @param func : a string that uniquely characterizes the altimeter
 * 
 * @return a YAltitude object allowing you to drive the altimeter.
 */
function yFindAltitude($func)
{
    return YAltitude::FindAltitude($func);
}

/**
 * Starts the enumeration of altimeters currently accessible.
 * Use the method YAltitude.nextAltitude() to iterate on
 * next altimeters.
 * 
 * @return a pointer to a YAltitude object, corresponding to
 *         the first altimeter currently online, or a null pointer
 *         if there are none.
 */
function yFirstAltitude()
{
    return YAltitude::FirstAltitude();
}

//--- (end of Altitude functions)
?>