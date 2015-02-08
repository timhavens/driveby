<?php
/*********************************************************************
 *
 * $Id: yocto_wakeupschedule.php 16241 2014-05-15 15:09:32Z seb $
 *
 * Implements YWakeUpSchedule, the high-level API for WakeUpSchedule functions
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

//--- (YWakeUpSchedule return codes)
//--- (end of YWakeUpSchedule return codes)
//--- (YWakeUpSchedule definitions)
if(!defined('Y_MINUTESA_INVALID'))           define('Y_MINUTESA_INVALID',          YAPI_INVALID_UINT);
if(!defined('Y_MINUTESB_INVALID'))           define('Y_MINUTESB_INVALID',          YAPI_INVALID_UINT);
if(!defined('Y_HOURS_INVALID'))              define('Y_HOURS_INVALID',             YAPI_INVALID_UINT);
if(!defined('Y_WEEKDAYS_INVALID'))           define('Y_WEEKDAYS_INVALID',          YAPI_INVALID_UINT);
if(!defined('Y_MONTHDAYS_INVALID'))          define('Y_MONTHDAYS_INVALID',         YAPI_INVALID_UINT);
if(!defined('Y_MONTHS_INVALID'))             define('Y_MONTHS_INVALID',            YAPI_INVALID_UINT);
if(!defined('Y_NEXTOCCURENCE_INVALID'))      define('Y_NEXTOCCURENCE_INVALID',     YAPI_INVALID_LONG);
//--- (end of YWakeUpSchedule definitions)

//--- (YWakeUpSchedule declaration)
/**
 * YWakeUpSchedule Class: WakeUpSchedule function interface
 * 
 * The WakeUpSchedule function implements a wake up condition. The wake up time is
 * specified as a set of months and/or days and/or hours and/or minutes when the
 * wake up should happen.
 */
class YWakeUpSchedule extends YFunction
{
    const MINUTESA_INVALID               = YAPI_INVALID_UINT;
    const MINUTESB_INVALID               = YAPI_INVALID_UINT;
    const HOURS_INVALID                  = YAPI_INVALID_UINT;
    const WEEKDAYS_INVALID               = YAPI_INVALID_UINT;
    const MONTHDAYS_INVALID              = YAPI_INVALID_UINT;
    const MONTHS_INVALID                 = YAPI_INVALID_UINT;
    const NEXTOCCURENCE_INVALID          = YAPI_INVALID_LONG;
    //--- (end of YWakeUpSchedule declaration)

    //--- (YWakeUpSchedule attributes)
    protected $_minutesA                 = Y_MINUTESA_INVALID;           // MinOfHalfHourBits
    protected $_minutesB                 = Y_MINUTESB_INVALID;           // MinOfHalfHourBits
    protected $_hours                    = Y_HOURS_INVALID;              // HoursOfDayBits
    protected $_weekDays                 = Y_WEEKDAYS_INVALID;           // DaysOfWeekBits
    protected $_monthDays                = Y_MONTHDAYS_INVALID;          // DaysOfMonthBits
    protected $_months                   = Y_MONTHS_INVALID;             // MonthsOfYearBits
    protected $_nextOccurence            = Y_NEXTOCCURENCE_INVALID;      // UTCTime
    //--- (end of YWakeUpSchedule attributes)

    function __construct($str_func)
    {
        //--- (YWakeUpSchedule constructor)
        parent::__construct($str_func);
        $this->_className = 'WakeUpSchedule';

        //--- (end of YWakeUpSchedule constructor)
    }

    //--- (YWakeUpSchedule implementation)

    function _parseAttr($name, $val)
    {
        switch($name) {
        case 'minutesA':
            $this->_minutesA = intval($val);
            return 1;
        case 'minutesB':
            $this->_minutesB = intval($val);
            return 1;
        case 'hours':
            $this->_hours = intval($val);
            return 1;
        case 'weekDays':
            $this->_weekDays = intval($val);
            return 1;
        case 'monthDays':
            $this->_monthDays = intval($val);
            return 1;
        case 'months':
            $this->_months = intval($val);
            return 1;
        case 'nextOccurence':
            $this->_nextOccurence = intval($val);
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Returns the minutes in the 00-29 interval of each hour scheduled for wake up.
     * 
     * @return an integer corresponding to the minutes in the 00-29 interval of each hour scheduled for wake up
     * 
     * On failure, throws an exception or returns Y_MINUTESA_INVALID.
     */
    public function get_minutesA()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_MINUTESA_INVALID;
            }
        }
        return $this->_minutesA;
    }

    /**
     * Changes the minutes in the 00-29 interval when a wake up must take place.
     * 
     * @param newval : an integer corresponding to the minutes in the 00-29 interval when a wake up must take place
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_minutesA($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("minutesA",$rest_val);
    }

    /**
     * Returns the minutes in the 30-59 intervalof each hour scheduled for wake up.
     * 
     * @return an integer corresponding to the minutes in the 30-59 intervalof each hour scheduled for wake up
     * 
     * On failure, throws an exception or returns Y_MINUTESB_INVALID.
     */
    public function get_minutesB()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_MINUTESB_INVALID;
            }
        }
        return $this->_minutesB;
    }

    /**
     * Changes the minutes in the 30-59 interval when a wake up must take place.
     * 
     * @param newval : an integer corresponding to the minutes in the 30-59 interval when a wake up must take place
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_minutesB($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("minutesB",$rest_val);
    }

    /**
     * Returns the hours scheduled for wake up.
     * 
     * @return an integer corresponding to the hours scheduled for wake up
     * 
     * On failure, throws an exception or returns Y_HOURS_INVALID.
     */
    public function get_hours()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_HOURS_INVALID;
            }
        }
        return $this->_hours;
    }

    /**
     * Changes the hours when a wake up must take place.
     * 
     * @param newval : an integer corresponding to the hours when a wake up must take place
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_hours($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("hours",$rest_val);
    }

    /**
     * Returns the days of the week scheduled for wake up.
     * 
     * @return an integer corresponding to the days of the week scheduled for wake up
     * 
     * On failure, throws an exception or returns Y_WEEKDAYS_INVALID.
     */
    public function get_weekDays()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_WEEKDAYS_INVALID;
            }
        }
        return $this->_weekDays;
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
    public function set_weekDays($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("weekDays",$rest_val);
    }

    /**
     * Returns the days of the month scheduled for wake up.
     * 
     * @return an integer corresponding to the days of the month scheduled for wake up
     * 
     * On failure, throws an exception or returns Y_MONTHDAYS_INVALID.
     */
    public function get_monthDays()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_MONTHDAYS_INVALID;
            }
        }
        return $this->_monthDays;
    }

    /**
     * Changes the days of the month when a wake up must take place.
     * 
     * @param newval : an integer corresponding to the days of the month when a wake up must take place
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_monthDays($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("monthDays",$rest_val);
    }

    /**
     * Returns the months scheduled for wake up.
     * 
     * @return an integer corresponding to the months scheduled for wake up
     * 
     * On failure, throws an exception or returns Y_MONTHS_INVALID.
     */
    public function get_months()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_MONTHS_INVALID;
            }
        }
        return $this->_months;
    }

    /**
     * Changes the months when a wake up must take place.
     * 
     * @param newval : an integer corresponding to the months when a wake up must take place
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_months($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("months",$rest_val);
    }

    /**
     * Returns the date/time (seconds) of the next wake up occurence
     * 
     * @return an integer corresponding to the date/time (seconds) of the next wake up occurence
     * 
     * On failure, throws an exception or returns Y_NEXTOCCURENCE_INVALID.
     */
    public function get_nextOccurence()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_NEXTOCCURENCE_INVALID;
            }
        }
        return $this->_nextOccurence;
    }

    /**
     * Retrieves a wake up schedule for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     * 
     * This function does not require that the wake up schedule is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method YWakeUpSchedule.isOnline() to test if the wake up schedule is
     * indeed online at a given time. In case of ambiguity when looking for
     * a wake up schedule by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     * 
     * @param func : a string that uniquely characterizes the wake up schedule
     * 
     * @return a YWakeUpSchedule object allowing you to drive the wake up schedule.
     */
    public static function FindWakeUpSchedule($func)
    {
        // $obj                    is a YWakeUpSchedule;
        $obj = YFunction::_FindFromCache('WakeUpSchedule', $func);
        if ($obj == null) {
            $obj = new YWakeUpSchedule($func);
            YFunction::_AddToCache('WakeUpSchedule', $func, $obj);
        }
        return $obj;
    }

    /**
     * Returns all the minutes of each hour that are scheduled for wake up.
     */
    public function get_minutes()
    {
        // $res                    is a long;
        // may throw an exception
        $res = $this->get_minutesB();
        $res = (($res) << (30));
        $res = $res + $this->get_minutesA();
        return $res;
    }

    /**
     * Changes all the minutes where a wake up must take place.
     * 
     * @param bitmap : Minutes 00-59 of each hour scheduled for wake up.
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_minutes($bitmap)
    {
        $this->set_minutesA((($bitmap) & (0x3fffffff)));
        $bitmap = (($bitmap) >> (30));
        return $this->set_minutesB((($bitmap) & (0x3fffffff)));
    }

    public function minutesA()
    { return $this->get_minutesA(); }

    public function setMinutesA($newval)
    { return $this->set_minutesA($newval); }

    public function minutesB()
    { return $this->get_minutesB(); }

    public function setMinutesB($newval)
    { return $this->set_minutesB($newval); }

    public function hours()
    { return $this->get_hours(); }

    public function setHours($newval)
    { return $this->set_hours($newval); }

    public function weekDays()
    { return $this->get_weekDays(); }

    public function setWeekDays($newval)
    { return $this->set_weekDays($newval); }

    public function monthDays()
    { return $this->get_monthDays(); }

    public function setMonthDays($newval)
    { return $this->set_monthDays($newval); }

    public function months()
    { return $this->get_months(); }

    public function setMonths($newval)
    { return $this->set_months($newval); }

    public function nextOccurence()
    { return $this->get_nextOccurence(); }

    /**
     * Continues the enumeration of wake up schedules started using yFirstWakeUpSchedule().
     * 
     * @return a pointer to a YWakeUpSchedule object, corresponding to
     *         a wake up schedule currently online, or a null pointer
     *         if there are no more wake up schedules to enumerate.
     */
    public function nextWakeUpSchedule()
    {   $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if($resolve->errorType != YAPI_SUCCESS) return null;
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if($next_hwid == null) return null;
        return yFindWakeUpSchedule($next_hwid);
    }

    /**
     * Starts the enumeration of wake up schedules currently accessible.
     * Use the method YWakeUpSchedule.nextWakeUpSchedule() to iterate on
     * next wake up schedules.
     * 
     * @return a pointer to a YWakeUpSchedule object, corresponding to
     *         the first wake up schedule currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstWakeUpSchedule()
    {   $next_hwid = YAPI::getFirstHardwareId('WakeUpSchedule');
        if($next_hwid == null) return null;
        return self::FindWakeUpSchedule($next_hwid);
    }

    //--- (end of YWakeUpSchedule implementation)

};

//--- (WakeUpSchedule functions)

/**
 * Retrieves a wake up schedule for a given identifier.
 * The identifier can be specified using several formats:
 * <ul>
 * <li>FunctionLogicalName</li>
 * <li>ModuleSerialNumber.FunctionIdentifier</li>
 * <li>ModuleSerialNumber.FunctionLogicalName</li>
 * <li>ModuleLogicalName.FunctionIdentifier</li>
 * <li>ModuleLogicalName.FunctionLogicalName</li>
 * </ul>
 * 
 * This function does not require that the wake up schedule is online at the time
 * it is invoked. The returned object is nevertheless valid.
 * Use the method YWakeUpSchedule.isOnline() to test if the wake up schedule is
 * indeed online at a given time. In case of ambiguity when looking for
 * a wake up schedule by logical name, no error is notified: the first instance
 * found is returned. The search is performed first by hardware name,
 * then by logical name.
 * 
 * @param func : a string that uniquely characterizes the wake up schedule
 * 
 * @return a YWakeUpSchedule object allowing you to drive the wake up schedule.
 */
function yFindWakeUpSchedule($func)
{
    return YWakeUpSchedule::FindWakeUpSchedule($func);
}

/**
 * Starts the enumeration of wake up schedules currently accessible.
 * Use the method YWakeUpSchedule.nextWakeUpSchedule() to iterate on
 * next wake up schedules.
 * 
 * @return a pointer to a YWakeUpSchedule object, corresponding to
 *         the first wake up schedule currently online, or a null pointer
 *         if there are none.
 */
function yFirstWakeUpSchedule()
{
    return YWakeUpSchedule::FirstWakeUpSchedule();
}

//--- (end of WakeUpSchedule functions)
?>