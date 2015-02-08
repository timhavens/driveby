<?php
/*********************************************************************
 *
 * $Id: yocto_wakeupmonitor.php 16962 2014-07-23 13:16:33Z mvuilleu $
 *
 * Implements YWakeUpMonitor, the high-level API for WakeUpMonitor functions
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

//--- (YWakeUpMonitor return codes)
//--- (end of YWakeUpMonitor return codes)
//--- (YWakeUpMonitor definitions)
if(!defined('Y_WAKEUPREASON_USBPOWER'))      define('Y_WAKEUPREASON_USBPOWER',     0);
if(!defined('Y_WAKEUPREASON_EXTPOWER'))      define('Y_WAKEUPREASON_EXTPOWER',     1);
if(!defined('Y_WAKEUPREASON_ENDOFSLEEP'))    define('Y_WAKEUPREASON_ENDOFSLEEP',   2);
if(!defined('Y_WAKEUPREASON_EXTSIG1'))       define('Y_WAKEUPREASON_EXTSIG1',      3);
if(!defined('Y_WAKEUPREASON_SCHEDULE1'))     define('Y_WAKEUPREASON_SCHEDULE1',    4);
if(!defined('Y_WAKEUPREASON_SCHEDULE2'))     define('Y_WAKEUPREASON_SCHEDULE2',    5);
if(!defined('Y_WAKEUPREASON_INVALID'))       define('Y_WAKEUPREASON_INVALID',      -1);
if(!defined('Y_WAKEUPSTATE_SLEEPING'))       define('Y_WAKEUPSTATE_SLEEPING',      0);
if(!defined('Y_WAKEUPSTATE_AWAKE'))          define('Y_WAKEUPSTATE_AWAKE',         1);
if(!defined('Y_WAKEUPSTATE_INVALID'))        define('Y_WAKEUPSTATE_INVALID',       -1);
if(!defined('Y_POWERDURATION_INVALID'))      define('Y_POWERDURATION_INVALID',     YAPI_INVALID_INT);
if(!defined('Y_SLEEPCOUNTDOWN_INVALID'))     define('Y_SLEEPCOUNTDOWN_INVALID',    YAPI_INVALID_INT);
if(!defined('Y_NEXTWAKEUP_INVALID'))         define('Y_NEXTWAKEUP_INVALID',        YAPI_INVALID_LONG);
if(!defined('Y_RTCTIME_INVALID'))            define('Y_RTCTIME_INVALID',           YAPI_INVALID_LONG);
//--- (end of YWakeUpMonitor definitions)

//--- (YWakeUpMonitor declaration)
/**
 * YWakeUpMonitor Class: WakeUpMonitor function interface
 * 
 * The WakeUpMonitor function handles globally all wake-up sources, as well
 * as automated sleep mode.
 */
class YWakeUpMonitor extends YFunction
{
    const POWERDURATION_INVALID          = YAPI_INVALID_INT;
    const SLEEPCOUNTDOWN_INVALID         = YAPI_INVALID_INT;
    const NEXTWAKEUP_INVALID             = YAPI_INVALID_LONG;
    const WAKEUPREASON_USBPOWER          = 0;
    const WAKEUPREASON_EXTPOWER          = 1;
    const WAKEUPREASON_ENDOFSLEEP        = 2;
    const WAKEUPREASON_EXTSIG1           = 3;
    const WAKEUPREASON_SCHEDULE1         = 4;
    const WAKEUPREASON_SCHEDULE2         = 5;
    const WAKEUPREASON_INVALID           = -1;
    const WAKEUPSTATE_SLEEPING           = 0;
    const WAKEUPSTATE_AWAKE              = 1;
    const WAKEUPSTATE_INVALID            = -1;
    const RTCTIME_INVALID                = YAPI_INVALID_LONG;
    //--- (end of YWakeUpMonitor declaration)

    //--- (YWakeUpMonitor attributes)
    protected $_powerDuration            = Y_POWERDURATION_INVALID;      // Int
    protected $_sleepCountdown           = Y_SLEEPCOUNTDOWN_INVALID;     // Int
    protected $_nextWakeUp               = Y_NEXTWAKEUP_INVALID;         // UTCTime
    protected $_wakeUpReason             = Y_WAKEUPREASON_INVALID;       // WakeUpReason
    protected $_wakeUpState              = Y_WAKEUPSTATE_INVALID;        // WakeUpState
    protected $_rtcTime                  = Y_RTCTIME_INVALID;            // UTCTime
    protected $_endOfTime                = 2145960000;                   // UInt31 (constant)
    //--- (end of YWakeUpMonitor attributes)

    function __construct($str_func)
    {
        //--- (YWakeUpMonitor constructor)
        parent::__construct($str_func);
        $this->_className = 'WakeUpMonitor';

        //--- (end of YWakeUpMonitor constructor)
    }

    //--- (YWakeUpMonitor implementation)

    function _parseAttr($name, $val)
    {
        switch($name) {
        case 'powerDuration':
            $this->_powerDuration = intval($val);
            return 1;
        case 'sleepCountdown':
            $this->_sleepCountdown = intval($val);
            return 1;
        case 'nextWakeUp':
            $this->_nextWakeUp = intval($val);
            return 1;
        case 'wakeUpReason':
            $this->_wakeUpReason = intval($val);
            return 1;
        case 'wakeUpState':
            $this->_wakeUpState = intval($val);
            return 1;
        case 'rtcTime':
            $this->_rtcTime = intval($val);
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Returns the maximal wake up time (in seconds) before automatically going to sleep.
     * 
     * @return an integer corresponding to the maximal wake up time (in seconds) before automatically going to sleep
     * 
     * On failure, throws an exception or returns Y_POWERDURATION_INVALID.
     */
    public function get_powerDuration()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_POWERDURATION_INVALID;
            }
        }
        return $this->_powerDuration;
    }

    /**
     * Changes the maximal wake up time (seconds) before automatically going to sleep.
     * 
     * @param newval : an integer corresponding to the maximal wake up time (seconds) before automatically
     * going to sleep
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_powerDuration($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("powerDuration",$rest_val);
    }

    /**
     * Returns the delay before the  next sleep period.
     * 
     * @return an integer corresponding to the delay before the  next sleep period
     * 
     * On failure, throws an exception or returns Y_SLEEPCOUNTDOWN_INVALID.
     */
    public function get_sleepCountdown()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_SLEEPCOUNTDOWN_INVALID;
            }
        }
        return $this->_sleepCountdown;
    }

    /**
     * Changes the delay before the next sleep period.
     * 
     * @param newval : an integer corresponding to the delay before the next sleep period
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_sleepCountdown($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("sleepCountdown",$rest_val);
    }

    /**
     * Returns the next scheduled wake up date/time (UNIX format)
     * 
     * @return an integer corresponding to the next scheduled wake up date/time (UNIX format)
     * 
     * On failure, throws an exception or returns Y_NEXTWAKEUP_INVALID.
     */
    public function get_nextWakeUp()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_NEXTWAKEUP_INVALID;
            }
        }
        return $this->_nextWakeUp;
    }

    /**
     * Changes the days of the week when a wake up must take place.
     * 
     * @param newval : an integer corresponding to the days of the week when a wake up must take place
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_nextWakeUp($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("nextWakeUp",$rest_val);
    }

    /**
     * Returns the latest wake up reason.
     * 
     * @return a value among Y_WAKEUPREASON_USBPOWER, Y_WAKEUPREASON_EXTPOWER, Y_WAKEUPREASON_ENDOFSLEEP,
     * Y_WAKEUPREASON_EXTSIG1, Y_WAKEUPREASON_SCHEDULE1 and Y_WAKEUPREASON_SCHEDULE2 corresponding to the
     * latest wake up reason
     * 
     * On failure, throws an exception or returns Y_WAKEUPREASON_INVALID.
     */
    public function get_wakeUpReason()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_WAKEUPREASON_INVALID;
            }
        }
        return $this->_wakeUpReason;
    }

    /**
     * Returns  the current state of the monitor
     * 
     * @return either Y_WAKEUPSTATE_SLEEPING or Y_WAKEUPSTATE_AWAKE, according to  the current state of the monitor
     * 
     * On failure, throws an exception or returns Y_WAKEUPSTATE_INVALID.
     */
    public function get_wakeUpState()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_WAKEUPSTATE_INVALID;
            }
        }
        return $this->_wakeUpState;
    }

    public function set_wakeUpState($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("wakeUpState",$rest_val);
    }

    public function get_rtcTime()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_RTCTIME_INVALID;
            }
        }
        return $this->_rtcTime;
    }

    /**
     * Retrieves a monitor for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     * 
     * This function does not require that the monitor is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method YWakeUpMonitor.isOnline() to test if the monitor is
     * indeed online at a given time. In case of ambiguity when looking for
     * a monitor by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     * 
     * @param func : a string that uniquely characterizes the monitor
     * 
     * @return a YWakeUpMonitor object allowing you to drive the monitor.
     */
    public static function FindWakeUpMonitor($func)
    {
        // $obj                    is a YWakeUpMonitor;
        $obj = YFunction::_FindFromCache('WakeUpMonitor', $func);
        if ($obj == null) {
            $obj = new YWakeUpMonitor($func);
            YFunction::_AddToCache('WakeUpMonitor', $func, $obj);
        }
        return $obj;
    }

    /**
     * Forces a wake up.
     */
    public function wakeUp()
    {
        return $this->set_wakeUpState(Y_WAKEUPSTATE_AWAKE);
    }

    /**
     * Goes to sleep until the next wake up condition is met,  the
     * RTC time must have been set before calling this function.
     * 
     * @param secBeforeSleep : number of seconds before going into sleep mode,
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function sleep($secBeforeSleep)
    {
        // $currTime               is a int;
        $currTime = $this->get_rtcTime();
        if (!($currTime != 0)) return $this->_throw( YAPI_RTC_NOT_READY, 'RTC time not set',YAPI_RTC_NOT_READY);
        $this->set_nextWakeUp($this->_endOfTime);
        $this->set_sleepCountdown($secBeforeSleep);
        return YAPI_SUCCESS;
    }

    /**
     * Goes to sleep for a specific duration or until the next wake up condition is met, the
     * RTC time must have been set before calling this function. The count down before sleep
     * can be canceled with resetSleepCountDown.
     * 
     * @param secUntilWakeUp : number of seconds before next wake up
     * @param secBeforeSleep : number of seconds before going into sleep mode
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function sleepFor($secUntilWakeUp,$secBeforeSleep)
    {
        // $currTime               is a int;
        $currTime = $this->get_rtcTime();
        if (!($currTime != 0)) return $this->_throw( YAPI_RTC_NOT_READY, 'RTC time not set',YAPI_RTC_NOT_READY);
        $this->set_nextWakeUp($currTime+$secUntilWakeUp);
        $this->set_sleepCountdown($secBeforeSleep);
        return YAPI_SUCCESS;
    }

    /**
     * Go to sleep until a specific date is reached or until the next wake up condition is met, the
     * RTC time must have been set before calling this function. The count down before sleep
     * can be canceled with resetSleepCountDown.
     * 
     * @param wakeUpTime : wake-up datetime (UNIX format)
     * @param secBeforeSleep : number of seconds before going into sleep mode
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function sleepUntil($wakeUpTime,$secBeforeSleep)
    {
        // $currTime               is a int;
        $currTime = $this->get_rtcTime();
        if (!($currTime != 0)) return $this->_throw( YAPI_RTC_NOT_READY, 'RTC time not set',YAPI_RTC_NOT_READY);
        $this->set_nextWakeUp($wakeUpTime);
        $this->set_sleepCountdown($secBeforeSleep);
        return YAPI_SUCCESS;
    }

    /**
     * Resets the sleep countdown.
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     *         On failure, throws an exception or returns a negative error code.
     */
    public function resetSleepCountDown()
    {
        $this->set_sleepCountdown(0);
        $this->set_nextWakeUp(0);
        return YAPI_SUCCESS;
    }

    public function powerDuration()
    { return $this->get_powerDuration(); }

    public function setPowerDuration($newval)
    { return $this->set_powerDuration($newval); }

    public function sleepCountdown()
    { return $this->get_sleepCountdown(); }

    public function setSleepCountdown($newval)
    { return $this->set_sleepCountdown($newval); }

    public function nextWakeUp()
    { return $this->get_nextWakeUp(); }

    public function setNextWakeUp($newval)
    { return $this->set_nextWakeUp($newval); }

    public function wakeUpReason()
    { return $this->get_wakeUpReason(); }

    public function wakeUpState()
    { return $this->get_wakeUpState(); }

    public function setWakeUpState($newval)
    { return $this->set_wakeUpState($newval); }

    public function rtcTime()
    { return $this->get_rtcTime(); }

    /**
     * Continues the enumeration of monitors started using yFirstWakeUpMonitor().
     * 
     * @return a pointer to a YWakeUpMonitor object, corresponding to
     *         a monitor currently online, or a null pointer
     *         if there are no more monitors to enumerate.
     */
    public function nextWakeUpMonitor()
    {   $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if($resolve->errorType != YAPI_SUCCESS) return null;
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if($next_hwid == null) return null;
        return yFindWakeUpMonitor($next_hwid);
    }

    /**
     * Starts the enumeration of monitors currently accessible.
     * Use the method YWakeUpMonitor.nextWakeUpMonitor() to iterate on
     * next monitors.
     * 
     * @return a pointer to a YWakeUpMonitor object, corresponding to
     *         the first monitor currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstWakeUpMonitor()
    {   $next_hwid = YAPI::getFirstHardwareId('WakeUpMonitor');
        if($next_hwid == null) return null;
        return self::FindWakeUpMonitor($next_hwid);
    }

    //--- (end of YWakeUpMonitor implementation)

};

//--- (WakeUpMonitor functions)

/**
 * Retrieves a monitor for a given identifier.
 * The identifier can be specified using several formats:
 * <ul>
 * <li>FunctionLogicalName</li>
 * <li>ModuleSerialNumber.FunctionIdentifier</li>
 * <li>ModuleSerialNumber.FunctionLogicalName</li>
 * <li>ModuleLogicalName.FunctionIdentifier</li>
 * <li>ModuleLogicalName.FunctionLogicalName</li>
 * </ul>
 * 
 * This function does not require that the monitor is online at the time
 * it is invoked. The returned object is nevertheless valid.
 * Use the method YWakeUpMonitor.isOnline() to test if the monitor is
 * indeed online at a given time. In case of ambiguity when looking for
 * a monitor by logical name, no error is notified: the first instance
 * found is returned. The search is performed first by hardware name,
 * then by logical name.
 * 
 * @param func : a string that uniquely characterizes the monitor
 * 
 * @return a YWakeUpMonitor object allowing you to drive the monitor.
 */
function yFindWakeUpMonitor($func)
{
    return YWakeUpMonitor::FindWakeUpMonitor($func);
}

/**
 * Starts the enumeration of monitors currently accessible.
 * Use the method YWakeUpMonitor.nextWakeUpMonitor() to iterate on
 * next monitors.
 * 
 * @return a pointer to a YWakeUpMonitor object, corresponding to
 *         the first monitor currently online, or a null pointer
 *         if there are none.
 */
function yFirstWakeUpMonitor()
{
    return YWakeUpMonitor::FirstWakeUpMonitor();
}

//--- (end of WakeUpMonitor functions)
?>