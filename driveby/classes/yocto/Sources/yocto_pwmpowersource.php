<?php
/*********************************************************************
 *
 * $Id: yocto_pwmpowersource.php 16241 2014-05-15 15:09:32Z seb $
 *
 * Implements YPwmPowerSource, the high-level API for PwmPowerSource functions
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

//--- (YPwmPowerSource return codes)
//--- (end of YPwmPowerSource return codes)
//--- (YPwmPowerSource definitions)
if(!defined('Y_POWERMODE_USB_5V'))           define('Y_POWERMODE_USB_5V',          0);
if(!defined('Y_POWERMODE_USB_3V'))           define('Y_POWERMODE_USB_3V',          1);
if(!defined('Y_POWERMODE_EXT_V'))            define('Y_POWERMODE_EXT_V',           2);
if(!defined('Y_POWERMODE_OPNDRN'))           define('Y_POWERMODE_OPNDRN',          3);
if(!defined('Y_POWERMODE_INVALID'))          define('Y_POWERMODE_INVALID',         -1);
//--- (end of YPwmPowerSource definitions)

//--- (YPwmPowerSource declaration)
/**
 * YPwmPowerSource Class: PwmPowerSource function interface
 * 
 * The Yoctopuce application programming interface allows you to configure
 * the voltage source used by all PWM on the same device.
 */
class YPwmPowerSource extends YFunction
{
    const POWERMODE_USB_5V               = 0;
    const POWERMODE_USB_3V               = 1;
    const POWERMODE_EXT_V                = 2;
    const POWERMODE_OPNDRN               = 3;
    const POWERMODE_INVALID              = -1;
    //--- (end of YPwmPowerSource declaration)

    //--- (YPwmPowerSource attributes)
    protected $_powerMode                = Y_POWERMODE_INVALID;          // PwmPwrState
    //--- (end of YPwmPowerSource attributes)

    function __construct($str_func)
    {
        //--- (YPwmPowerSource constructor)
        parent::__construct($str_func);
        $this->_className = 'PwmPowerSource';

        //--- (end of YPwmPowerSource constructor)
    }

    //--- (YPwmPowerSource implementation)

    function _parseAttr($name, $val)
    {
        switch($name) {
        case 'powerMode':
            $this->_powerMode = intval($val);
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Returns the selected power source for the PWM on the same device
     * 
     * @return a value among Y_POWERMODE_USB_5V, Y_POWERMODE_USB_3V, Y_POWERMODE_EXT_V and
     * Y_POWERMODE_OPNDRN corresponding to the selected power source for the PWM on the same device
     * 
     * On failure, throws an exception or returns Y_POWERMODE_INVALID.
     */
    public function get_powerMode()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_POWERMODE_INVALID;
            }
        }
        return $this->_powerMode;
    }

    /**
     * Changes  the PWM power source. PWM can use isolated 5V from USB, isolated 3V from USB or
     * voltage from an external power source. The PWM can also work in open drain  mode. In that
     * mode, the PWM actively pulls the line down.
     * Warning: this setting is common to all PWM on the same device. If you change that parameter,
     * all PWM located on the same device are  affected.
     * If you want the change to be kept after a device reboot, make sure  to call the matching
     * module saveToFlash().
     * 
     * @param newval : a value among Y_POWERMODE_USB_5V, Y_POWERMODE_USB_3V, Y_POWERMODE_EXT_V and
     * Y_POWERMODE_OPNDRN corresponding to  the PWM power source
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_powerMode($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("powerMode",$rest_val);
    }

    /**
     * Retrieves a voltage source for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     * 
     * This function does not require that the voltage source is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method YPwmPowerSource.isOnline() to test if the voltage source is
     * indeed online at a given time. In case of ambiguity when looking for
     * a voltage source by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     * 
     * @param func : a string that uniquely characterizes the voltage source
     * 
     * @return a YPwmPowerSource object allowing you to drive the voltage source.
     */
    public static function FindPwmPowerSource($func)
    {
        // $obj                    is a YPwmPowerSource;
        $obj = YFunction::_FindFromCache('PwmPowerSource', $func);
        if ($obj == null) {
            $obj = new YPwmPowerSource($func);
            YFunction::_AddToCache('PwmPowerSource', $func, $obj);
        }
        return $obj;
    }

    public function powerMode()
    { return $this->get_powerMode(); }

    public function setPowerMode($newval)
    { return $this->set_powerMode($newval); }

    /**
     * Continues the enumeration of Voltage sources started using yFirstPwmPowerSource().
     * 
     * @return a pointer to a YPwmPowerSource object, corresponding to
     *         a voltage source currently online, or a null pointer
     *         if there are no more Voltage sources to enumerate.
     */
    public function nextPwmPowerSource()
    {   $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if($resolve->errorType != YAPI_SUCCESS) return null;
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if($next_hwid == null) return null;
        return yFindPwmPowerSource($next_hwid);
    }

    /**
     * Starts the enumeration of Voltage sources currently accessible.
     * Use the method YPwmPowerSource.nextPwmPowerSource() to iterate on
     * next Voltage sources.
     * 
     * @return a pointer to a YPwmPowerSource object, corresponding to
     *         the first source currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstPwmPowerSource()
    {   $next_hwid = YAPI::getFirstHardwareId('PwmPowerSource');
        if($next_hwid == null) return null;
        return self::FindPwmPowerSource($next_hwid);
    }

    //--- (end of YPwmPowerSource implementation)

};

//--- (PwmPowerSource functions)

/**
 * Retrieves a voltage source for a given identifier.
 * The identifier can be specified using several formats:
 * <ul>
 * <li>FunctionLogicalName</li>
 * <li>ModuleSerialNumber.FunctionIdentifier</li>
 * <li>ModuleSerialNumber.FunctionLogicalName</li>
 * <li>ModuleLogicalName.FunctionIdentifier</li>
 * <li>ModuleLogicalName.FunctionLogicalName</li>
 * </ul>
 * 
 * This function does not require that the voltage source is online at the time
 * it is invoked. The returned object is nevertheless valid.
 * Use the method YPwmPowerSource.isOnline() to test if the voltage source is
 * indeed online at a given time. In case of ambiguity when looking for
 * a voltage source by logical name, no error is notified: the first instance
 * found is returned. The search is performed first by hardware name,
 * then by logical name.
 * 
 * @param func : a string that uniquely characterizes the voltage source
 * 
 * @return a YPwmPowerSource object allowing you to drive the voltage source.
 */
function yFindPwmPowerSource($func)
{
    return YPwmPowerSource::FindPwmPowerSource($func);
}

/**
 * Starts the enumeration of Voltage sources currently accessible.
 * Use the method YPwmPowerSource.nextPwmPowerSource() to iterate on
 * next Voltage sources.
 * 
 * @return a pointer to a YPwmPowerSource object, corresponding to
 *         the first source currently online, or a null pointer
 *         if there are none.
 */
function yFirstPwmPowerSource()
{
    return YPwmPowerSource::FirstPwmPowerSource();
}

//--- (end of PwmPowerSource functions)
?>