<?php
/*********************************************************************
 *
 * $Id: yocto_realtimeclock.php 16241 2014-05-15 15:09:32Z seb $
 *
 * Implements YRealTimeClock, the high-level API for RealTimeClock functions
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

//--- (YRealTimeClock return codes)
//--- (end of YRealTimeClock return codes)
//--- (YRealTimeClock definitions)
if(!defined('Y_TIMESET_FALSE'))              define('Y_TIMESET_FALSE',             0);
if(!defined('Y_TIMESET_TRUE'))               define('Y_TIMESET_TRUE',              1);
if(!defined('Y_TIMESET_INVALID'))            define('Y_TIMESET_INVALID',           -1);
if(!defined('Y_UNIXTIME_INVALID'))           define('Y_UNIXTIME_INVALID',          YAPI_INVALID_LONG);
if(!defined('Y_DATETIME_INVALID'))           define('Y_DATETIME_INVALID',          YAPI_INVALID_STRING);
if(!defined('Y_UTCOFFSET_INVALID'))          define('Y_UTCOFFSET_INVALID',         YAPI_INVALID_INT);
//--- (end of YRealTimeClock definitions)

//--- (YRealTimeClock declaration)
/**
 * YRealTimeClock Class: Real Time Clock function interface
 * 
 * The RealTimeClock function maintains and provides current date and time, even accross power cut
 * lasting several days. It is the base for automated wake-up functions provided by the WakeUpScheduler.
 * The current time may represent a local time as well as an UTC time, but no automatic time change
 * will occur to account for daylight saving time.
 */
class YRealTimeClock extends YFunction
{
    const UNIXTIME_INVALID               = YAPI_INVALID_LONG;
    const DATETIME_INVALID               = YAPI_INVALID_STRING;
    const UTCOFFSET_INVALID              = YAPI_INVALID_INT;
    const TIMESET_FALSE                  = 0;
    const TIMESET_TRUE                   = 1;
    const TIMESET_INVALID                = -1;
    //--- (end of YRealTimeClock declaration)

    //--- (YRealTimeClock attributes)
    protected $_unixTime                 = Y_UNIXTIME_INVALID;           // UTCTime
    protected $_dateTime                 = Y_DATETIME_INVALID;           // Text
    protected $_utcOffset                = Y_UTCOFFSET_INVALID;          // Int
    protected $_timeSet                  = Y_TIMESET_INVALID;            // Bool
    //--- (end of YRealTimeClock attributes)

    function __construct($str_func)
    {
        //--- (YRealTimeClock constructor)
        parent::__construct($str_func);
        $this->_className = 'RealTimeClock';

        //--- (end of YRealTimeClock constructor)
    }

    //--- (YRealTimeClock implementation)

    function _parseAttr($name, $val)
    {
        switch($name) {
        case 'unixTime':
            $this->_unixTime = intval($val);
            return 1;
        case 'dateTime':
            $this->_dateTime = $val;
            return 1;
        case 'utcOffset':
            $this->_utcOffset = intval($val);
            return 1;
        case 'timeSet':
            $this->_timeSet = intval($val);
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Returns the current time in Unix format (number of elapsed seconds since Jan 1st, 1970).
     * 
     * @return an integer corresponding to the current time in Unix format (number of elapsed seconds
     * since Jan 1st, 1970)
     * 
     * On failure, throws an exception or returns Y_UNIXTIME_INVALID.
     */
    public function get_unixTime()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_UNIXTIME_INVALID;
            }
        }
        return $this->_unixTime;
    }

    /**
     * Changes the current time. Time is specifid in Unix format (number of elapsed seconds since Jan 1st, 1970).
     * If current UTC time is known, utcOffset will be automatically adjusted for the new specified time.
     * 
     * @param newval : an integer corresponding to the current time
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_unixTime($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("unixTime",$rest_val);
    }

    /**
     * Returns the current time in the form "YYYY/MM/DD hh:mm:ss"
     * 
     * @return a string corresponding to the current time in the form "YYYY/MM/DD hh:mm:ss"
     * 
     * On failure, throws an exception or returns Y_DATETIME_INVALID.
     */
    public function get_dateTime()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_DATETIME_INVALID;
            }
        }
        return $this->_dateTime;
    }

    /**
     * Returns the number of seconds between current time and UTC time (time zone).
     * 
     * @return an integer corresponding to the number of seconds between current time and UTC time (time zone)
     * 
     * On failure, throws an exception or returns Y_UTCOFFSET_INVALID.
     */
    public function get_utcOffset()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_UTCOFFSET_INVALID;
            }
        }
        return $this->_utcOffset;
    }

    /**
     * Changes the number of seconds between current time and UTC time (time zone).
     * The timezone is automatically rounded to the nearest multiple of 15 minutes.
     * If current UTC time is known, the current time will automatically be updated according to the
     * selected time zone.
     * 
     * @param newval : an integer corresponding to the number of seconds between current time and UTC time (time zone)
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_utcOffset($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("utcOffset",$rest_val);
    }

    /**
     * Returns true if the clock has been set, and false otherwise.
     * 
     * @return either Y_TIMESET_FALSE or Y_TIMESET_TRUE, according to true if the clock has been set, and
     * false otherwise
     * 
     * On failure, throws an exception or returns Y_TIMESET_INVALID.
     */
    public function get_timeSet()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_TIMESET_INVALID;
            }
        }
        return $this->_timeSet;
    }

    /**
     * Retrieves a clock for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     * 
     * This function does not require that the clock is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method YRealTimeClock.isOnline() to test if the clock is
     * indeed online at a given time. In case of ambiguity when looking for
     * a clock by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     * 
     * @param func : a string that uniquely characterizes the clock
     * 
     * @return a YRealTimeClock object allowing you to drive the clock.
     */
    public static function FindRealTimeClock($func)
    {
        // $obj                    is a YRealTimeClock;
        $obj = YFunction::_FindFromCache('RealTimeClock', $func);
        if ($obj == null) {
            $obj = new YRealTimeClock($func);
            YFunction::_AddToCache('RealTimeClock', $func, $obj);
        }
        return $obj;
    }

    public function unixTime()
    { return $this->get_unixTime(); }

    public function setUnixTime($newval)
    { return $this->set_unixTime($newval); }

    public function dateTime()
    { return $this->get_dateTime(); }

    public function utcOffset()
    { return $this->get_utcOffset(); }

    public function setUtcOffset($newval)
    { return $this->set_utcOffset($newval); }

    public function timeSet()
    { return $this->get_timeSet(); }

    /**
     * Continues the enumeration of clocks started using yFirstRealTimeClock().
     * 
     * @return a pointer to a YRealTimeClock object, corresponding to
     *         a clock currently online, or a null pointer
     *         if there are no more clocks to enumerate.
     */
    public function nextRealTimeClock()
    {   $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if($resolve->errorType != YAPI_SUCCESS) return null;
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if($next_hwid == null) return null;
        return yFindRealTimeClock($next_hwid);
    }

    /**
     * Starts the enumeration of clocks currently accessible.
     * Use the method YRealTimeClock.nextRealTimeClock() to iterate on
     * next clocks.
     * 
     * @return a pointer to a YRealTimeClock object, corresponding to
     *         the first clock currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstRealTimeClock()
    {   $next_hwid = YAPI::getFirstHardwareId('RealTimeClock');
        if($next_hwid == null) return null;
        return self::FindRealTimeClock($next_hwid);
    }

    //--- (end of YRealTimeClock implementation)

};

//--- (RealTimeClock functions)

/**
 * Retrieves a clock for a given identifier.
 * The identifier can be specified using several formats:
 * <ul>
 * <li>FunctionLogicalName</li>
 * <li>ModuleSerialNumber.FunctionIdentifier</li>
 * <li>ModuleSerialNumber.FunctionLogicalName</li>
 * <li>ModuleLogicalName.FunctionIdentifier</li>
 * <li>ModuleLogicalName.FunctionLogicalName</li>
 * </ul>
 * 
 * This function does not require that the clock is online at the time
 * it is invoked. The returned object is nevertheless valid.
 * Use the method YRealTimeClock.isOnline() to test if the clock is
 * indeed online at a given time. In case of ambiguity when looking for
 * a clock by logical name, no error is notified: the first instance
 * found is returned. The search is performed first by hardware name,
 * then by logical name.
 * 
 * @param func : a string that uniquely characterizes the clock
 * 
 * @return a YRealTimeClock object allowing you to drive the clock.
 */
function yFindRealTimeClock($func)
{
    return YRealTimeClock::FindRealTimeClock($func);
}

/**
 * Starts the enumeration of clocks currently accessible.
 * Use the method YRealTimeClock.nextRealTimeClock() to iterate on
 * next clocks.
 * 
 * @return a pointer to a YRealTimeClock object, corresponding to
 *         the first clock currently online, or a null pointer
 *         if there are none.
 */
function yFirstRealTimeClock()
{
    return YRealTimeClock::FirstRealTimeClock();
}

//--- (end of RealTimeClock functions)
?>