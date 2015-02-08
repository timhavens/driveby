<?php
/*********************************************************************
 *
 * $Id: yocto_tilt.php 16241 2014-05-15 15:09:32Z seb $
 *
 * Implements YTilt, the high-level API for Tilt functions
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

//--- (YTilt return codes)
//--- (end of YTilt return codes)
//--- (YTilt definitions)
if(!defined('Y_AXIS_X'))                     define('Y_AXIS_X',                    0);
if(!defined('Y_AXIS_Y'))                     define('Y_AXIS_Y',                    1);
if(!defined('Y_AXIS_Z'))                     define('Y_AXIS_Z',                    2);
if(!defined('Y_AXIS_INVALID'))               define('Y_AXIS_INVALID',              -1);
//--- (end of YTilt definitions)

//--- (YTilt declaration)
/**
 * YTilt Class: Tilt function interface
 * 
 * The Yoctopuce application programming interface allows you to read an instant
 * measure of the sensor, as well as the minimal and maximal values observed.
 */
class YTilt extends YSensor
{
    const AXIS_X                         = 0;
    const AXIS_Y                         = 1;
    const AXIS_Z                         = 2;
    const AXIS_INVALID                   = -1;
    //--- (end of YTilt declaration)

    //--- (YTilt attributes)
    protected $_axis                     = Y_AXIS_INVALID;               // Axis
    //--- (end of YTilt attributes)

    function __construct($str_func)
    {
        //--- (YTilt constructor)
        parent::__construct($str_func);
        $this->_className = 'Tilt';

        //--- (end of YTilt constructor)
    }

    //--- (YTilt implementation)

    function _parseAttr($name, $val)
    {
        switch($name) {
        case 'axis':
            $this->_axis = intval($val);
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
     * Retrieves a tilt sensor for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     * 
     * This function does not require that the tilt sensor is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method YTilt.isOnline() to test if the tilt sensor is
     * indeed online at a given time. In case of ambiguity when looking for
     * a tilt sensor by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     * 
     * @param func : a string that uniquely characterizes the tilt sensor
     * 
     * @return a YTilt object allowing you to drive the tilt sensor.
     */
    public static function FindTilt($func)
    {
        // $obj                    is a YTilt;
        $obj = YFunction::_FindFromCache('Tilt', $func);
        if ($obj == null) {
            $obj = new YTilt($func);
            YFunction::_AddToCache('Tilt', $func, $obj);
        }
        return $obj;
    }

    public function axis()
    { return $this->get_axis(); }

    /**
     * Continues the enumeration of tilt sensors started using yFirstTilt().
     * 
     * @return a pointer to a YTilt object, corresponding to
     *         a tilt sensor currently online, or a null pointer
     *         if there are no more tilt sensors to enumerate.
     */
    public function nextTilt()
    {   $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if($resolve->errorType != YAPI_SUCCESS) return null;
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if($next_hwid == null) return null;
        return yFindTilt($next_hwid);
    }

    /**
     * Starts the enumeration of tilt sensors currently accessible.
     * Use the method YTilt.nextTilt() to iterate on
     * next tilt sensors.
     * 
     * @return a pointer to a YTilt object, corresponding to
     *         the first tilt sensor currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstTilt()
    {   $next_hwid = YAPI::getFirstHardwareId('Tilt');
        if($next_hwid == null) return null;
        return self::FindTilt($next_hwid);
    }

    //--- (end of YTilt implementation)

};

//--- (Tilt functions)

/**
 * Retrieves a tilt sensor for a given identifier.
 * The identifier can be specified using several formats:
 * <ul>
 * <li>FunctionLogicalName</li>
 * <li>ModuleSerialNumber.FunctionIdentifier</li>
 * <li>ModuleSerialNumber.FunctionLogicalName</li>
 * <li>ModuleLogicalName.FunctionIdentifier</li>
 * <li>ModuleLogicalName.FunctionLogicalName</li>
 * </ul>
 * 
 * This function does not require that the tilt sensor is online at the time
 * it is invoked. The returned object is nevertheless valid.
 * Use the method YTilt.isOnline() to test if the tilt sensor is
 * indeed online at a given time. In case of ambiguity when looking for
 * a tilt sensor by logical name, no error is notified: the first instance
 * found is returned. The search is performed first by hardware name,
 * then by logical name.
 * 
 * @param func : a string that uniquely characterizes the tilt sensor
 * 
 * @return a YTilt object allowing you to drive the tilt sensor.
 */
function yFindTilt($func)
{
    return YTilt::FindTilt($func);
}

/**
 * Starts the enumeration of tilt sensors currently accessible.
 * Use the method YTilt.nextTilt() to iterate on
 * next tilt sensors.
 * 
 * @return a pointer to a YTilt object, corresponding to
 *         the first tilt sensor currently online, or a null pointer
 *         if there are none.
 */
function yFirstTilt()
{
    return YTilt::FirstTilt();
}

//--- (end of Tilt functions)
?>