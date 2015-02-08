<?php
/*********************************************************************
 *
 * $Id: yocto_compass.php 16895 2014-07-18 00:12:08Z mvuilleu $
 *
 * Implements YCompass, the high-level API for Compass functions
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

//--- (YCompass return codes)
//--- (end of YCompass return codes)
//--- (YCompass definitions)
if(!defined('Y_AXIS_X'))                     define('Y_AXIS_X',                    0);
if(!defined('Y_AXIS_Y'))                     define('Y_AXIS_Y',                    1);
if(!defined('Y_AXIS_Z'))                     define('Y_AXIS_Z',                    2);
if(!defined('Y_AXIS_INVALID'))               define('Y_AXIS_INVALID',              -1);
if(!defined('Y_MAGNETICHEADING_INVALID'))    define('Y_MAGNETICHEADING_INVALID',   YAPI_INVALID_DOUBLE);
//--- (end of YCompass definitions)

//--- (YCompass declaration)
/**
 * YCompass Class: Compass function interface
 * 
 * The Yoctopuce application programming interface allows you to read an instant
 * measure of the sensor, as well as the minimal and maximal values observed.
 */
class YCompass extends YSensor
{
    const AXIS_X                         = 0;
    const AXIS_Y                         = 1;
    const AXIS_Z                         = 2;
    const AXIS_INVALID                   = -1;
    const MAGNETICHEADING_INVALID        = YAPI_INVALID_DOUBLE;
    //--- (end of YCompass declaration)

    //--- (YCompass attributes)
    protected $_axis                     = Y_AXIS_INVALID;               // Axis
    protected $_magneticHeading          = Y_MAGNETICHEADING_INVALID;    // MeasureVal
    //--- (end of YCompass attributes)

    function __construct($str_func)
    {
        //--- (YCompass constructor)
        parent::__construct($str_func);
        $this->_className = 'Compass';

        //--- (end of YCompass constructor)
    }

    //--- (YCompass implementation)

    function _parseAttr($name, $val)
    {
        switch($name) {
        case 'axis':
            $this->_axis = intval($val);
            return 1;
        case 'magneticHeading':
            $this->_magneticHeading = round($val * 1000.0 / 65536.0) / 1000.0;
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    public function get_axis()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_AXIS_INVALID;
            }
        }
        return $this->_axis;
    }

    /**
     * Returns the magnetic heading, regardless of the configured bearing.
     * 
     * @return a floating point number corresponding to the magnetic heading, regardless of the configured bearing
     * 
     * On failure, throws an exception or returns Y_MAGNETICHEADING_INVALID.
     */
    public function get_magneticHeading()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_MAGNETICHEADING_INVALID;
            }
        }
        return $this->_magneticHeading;
    }

    /**
     * Retrieves a compass for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     * 
     * This function does not require that the compass is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method YCompass.isOnline() to test if the compass is
     * indeed online at a given time. In case of ambiguity when looking for
     * a compass by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     * 
     * @param func : a string that uniquely characterizes the compass
     * 
     * @return a YCompass object allowing you to drive the compass.
     */
    public static function FindCompass($func)
    {
        // $obj                    is a YCompass;
        $obj = YFunction::_FindFromCache('Compass', $func);
        if ($obj == null) {
            $obj = new YCompass($func);
            YFunction::_AddToCache('Compass', $func, $obj);
        }
        return $obj;
    }

    public function axis()
    { return $this->get_axis(); }

    public function magneticHeading()
    { return $this->get_magneticHeading(); }

    /**
     * Continues the enumeration of compasses started using yFirstCompass().
     * 
     * @return a pointer to a YCompass object, corresponding to
     *         a compass currently online, or a null pointer
     *         if there are no more compasses to enumerate.
     */
    public function nextCompass()
    {   $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if($resolve->errorType != YAPI_SUCCESS) return null;
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if($next_hwid == null) return null;
        return yFindCompass($next_hwid);
    }

    /**
     * Starts the enumeration of compasses currently accessible.
     * Use the method YCompass.nextCompass() to iterate on
     * next compasses.
     * 
     * @return a pointer to a YCompass object, corresponding to
     *         the first compass currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstCompass()
    {   $next_hwid = YAPI::getFirstHardwareId('Compass');
        if($next_hwid == null) return null;
        return self::FindCompass($next_hwid);
    }

    //--- (end of YCompass implementation)

};

//--- (Compass functions)

/**
 * Retrieves a compass for a given identifier.
 * The identifier can be specified using several formats:
 * <ul>
 * <li>FunctionLogicalName</li>
 * <li>ModuleSerialNumber.FunctionIdentifier</li>
 * <li>ModuleSerialNumber.FunctionLogicalName</li>
 * <li>ModuleLogicalName.FunctionIdentifier</li>
 * <li>ModuleLogicalName.FunctionLogicalName</li>
 * </ul>
 * 
 * This function does not require that the compass is online at the time
 * it is invoked. The returned object is nevertheless valid.
 * Use the method YCompass.isOnline() to test if the compass is
 * indeed online at a given time. In case of ambiguity when looking for
 * a compass by logical name, no error is notified: the first instance
 * found is returned. The search is performed first by hardware name,
 * then by logical name.
 * 
 * @param func : a string that uniquely characterizes the compass
 * 
 * @return a YCompass object allowing you to drive the compass.
 */
function yFindCompass($func)
{
    return YCompass::FindCompass($func);
}

/**
 * Starts the enumeration of compasses currently accessible.
 * Use the method YCompass.nextCompass() to iterate on
 * next compasses.
 * 
 * @return a pointer to a YCompass object, corresponding to
 *         the first compass currently online, or a null pointer
 *         if there are none.
 */
function yFirstCompass()
{
    return YCompass::FirstCompass();
}

//--- (end of Compass functions)
?>