<?php
/*********************************************************************
 *
 * $Id: yocto_watchdog.php 16241 2014-05-15 15:09:32Z seb $
 *
 * Implements YWatchdog, the high-level API for Watchdog functions
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

//--- (YWatchdog return codes)
//--- (end of YWatchdog return codes)
//--- (YWatchdog definitions)
if(!defined('Y_STATE_A'))                    define('Y_STATE_A',                   0);
if(!defined('Y_STATE_B'))                    define('Y_STATE_B',                   1);
if(!defined('Y_STATE_INVALID'))              define('Y_STATE_INVALID',             -1);
if(!defined('Y_STATEATPOWERON_UNCHANGED'))   define('Y_STATEATPOWERON_UNCHANGED',  0);
if(!defined('Y_STATEATPOWERON_A'))           define('Y_STATEATPOWERON_A',          1);
if(!defined('Y_STATEATPOWERON_B'))           define('Y_STATEATPOWERON_B',          2);
if(!defined('Y_STATEATPOWERON_INVALID'))     define('Y_STATEATPOWERON_INVALID',    -1);
if(!defined('Y_OUTPUT_OFF'))                 define('Y_OUTPUT_OFF',                0);
if(!defined('Y_OUTPUT_ON'))                  define('Y_OUTPUT_ON',                 1);
if(!defined('Y_OUTPUT_INVALID'))             define('Y_OUTPUT_INVALID',            -1);
if(!defined('Y_AUTOSTART_OFF'))              define('Y_AUTOSTART_OFF',             0);
if(!defined('Y_AUTOSTART_ON'))               define('Y_AUTOSTART_ON',              1);
if(!defined('Y_AUTOSTART_INVALID'))          define('Y_AUTOSTART_INVALID',         -1);
if(!defined('Y_RUNNING_OFF'))                define('Y_RUNNING_OFF',               0);
if(!defined('Y_RUNNING_ON'))                 define('Y_RUNNING_ON',                1);
if(!defined('Y_RUNNING_INVALID'))            define('Y_RUNNING_INVALID',           -1);
if(!defined('Y_MAXTIMEONSTATEA_INVALID'))    define('Y_MAXTIMEONSTATEA_INVALID',   YAPI_INVALID_LONG);
if(!defined('Y_MAXTIMEONSTATEB_INVALID'))    define('Y_MAXTIMEONSTATEB_INVALID',   YAPI_INVALID_LONG);
if(!defined('Y_PULSETIMER_INVALID'))         define('Y_PULSETIMER_INVALID',        YAPI_INVALID_LONG);
if(!defined('Y_DELAYEDPULSETIMER_INVALID'))  define('Y_DELAYEDPULSETIMER_INVALID', null);
if(!defined('Y_COUNTDOWN_INVALID'))          define('Y_COUNTDOWN_INVALID',         YAPI_INVALID_LONG);
if(!defined('Y_TRIGGERDELAY_INVALID'))       define('Y_TRIGGERDELAY_INVALID',      YAPI_INVALID_LONG);
if(!defined('Y_TRIGGERDURATION_INVALID'))    define('Y_TRIGGERDURATION_INVALID',   YAPI_INVALID_LONG);
//--- (end of YWatchdog definitions)

//--- (YWatchdog declaration)
/**
 * YWatchdog Class: Watchdog function interface
 * 
 * The watchog function works like a relay and can cause a brief power cut
 * to an appliance after a preset delay to force this appliance to
 * reset. The Watchdog must be called from time to time to reset the
 * timer and prevent the appliance reset.
 * The watchdog can be driven direcly with <i>pulse</i> and <i>delayedpulse</i> methods to switch
 * off an appliance for a given duration.
 */
class YWatchdog extends YFunction
{
    const STATE_A                        = 0;
    const STATE_B                        = 1;
    const STATE_INVALID                  = -1;
    const STATEATPOWERON_UNCHANGED       = 0;
    const STATEATPOWERON_A               = 1;
    const STATEATPOWERON_B               = 2;
    const STATEATPOWERON_INVALID         = -1;
    const MAXTIMEONSTATEA_INVALID        = YAPI_INVALID_LONG;
    const MAXTIMEONSTATEB_INVALID        = YAPI_INVALID_LONG;
    const OUTPUT_OFF                     = 0;
    const OUTPUT_ON                      = 1;
    const OUTPUT_INVALID                 = -1;
    const PULSETIMER_INVALID             = YAPI_INVALID_LONG;
    const DELAYEDPULSETIMER_INVALID      = null;
    const COUNTDOWN_INVALID              = YAPI_INVALID_LONG;
    const AUTOSTART_OFF                  = 0;
    const AUTOSTART_ON                   = 1;
    const AUTOSTART_INVALID              = -1;
    const RUNNING_OFF                    = 0;
    const RUNNING_ON                     = 1;
    const RUNNING_INVALID                = -1;
    const TRIGGERDELAY_INVALID           = YAPI_INVALID_LONG;
    const TRIGGERDURATION_INVALID        = YAPI_INVALID_LONG;
    //--- (end of YWatchdog declaration)

    //--- (YWatchdog attributes)
    protected $_state                    = Y_STATE_INVALID;              // Toggle
    protected $_stateAtPowerOn           = Y_STATEATPOWERON_INVALID;     // ToggleAtPowerOn
    protected $_maxTimeOnStateA          = Y_MAXTIMEONSTATEA_INVALID;    // Time
    protected $_maxTimeOnStateB          = Y_MAXTIMEONSTATEB_INVALID;    // Time
    protected $_output                   = Y_OUTPUT_INVALID;             // OnOff
    protected $_pulseTimer               = Y_PULSETIMER_INVALID;         // Time
    protected $_delayedPulseTimer        = Y_DELAYEDPULSETIMER_INVALID;  // DelayedPulse
    protected $_countdown                = Y_COUNTDOWN_INVALID;          // Time
    protected $_autoStart                = Y_AUTOSTART_INVALID;          // OnOff
    protected $_running                  = Y_RUNNING_INVALID;            // OnOff
    protected $_triggerDelay             = Y_TRIGGERDELAY_INVALID;       // Time
    protected $_triggerDuration          = Y_TRIGGERDURATION_INVALID;    // Time
    //--- (end of YWatchdog attributes)

    function __construct($str_func)
    {
        //--- (YWatchdog constructor)
        parent::__construct($str_func);
        $this->_className = 'Watchdog';

        //--- (end of YWatchdog constructor)
    }

    //--- (YWatchdog implementation)

    function _parseAttr($name, $val)
    {
        switch($name) {
        case 'state':
            $this->_state = intval($val);
            return 1;
        case 'stateAtPowerOn':
            $this->_stateAtPowerOn = intval($val);
            return 1;
        case 'maxTimeOnStateA':
            $this->_maxTimeOnStateA = intval($val);
            return 1;
        case 'maxTimeOnStateB':
            $this->_maxTimeOnStateB = intval($val);
            return 1;
        case 'output':
            $this->_output = intval($val);
            return 1;
        case 'pulseTimer':
            $this->_pulseTimer = intval($val);
            return 1;
        case 'delayedPulseTimer':
            $this->_delayedPulseTimer = $val;
            return 1;
        case 'countdown':
            $this->_countdown = intval($val);
            return 1;
        case 'autoStart':
            $this->_autoStart = intval($val);
            return 1;
        case 'running':
            $this->_running = intval($val);
            return 1;
        case 'triggerDelay':
            $this->_triggerDelay = intval($val);
            return 1;
        case 'triggerDuration':
            $this->_triggerDuration = intval($val);
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Returns the state of the watchdog (A for the idle position, B for the active position).
     * 
     * @return either Y_STATE_A or Y_STATE_B, according to the state of the watchdog (A for the idle
     * position, B for the active position)
     * 
     * On failure, throws an exception or returns Y_STATE_INVALID.
     */
    public function get_state()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_STATE_INVALID;
            }
        }
        return $this->_state;
    }

    /**
     * Changes the state of the watchdog (A for the idle position, B for the active position).
     * 
     * @param newval : either Y_STATE_A or Y_STATE_B, according to the state of the watchdog (A for the
     * idle position, B for the active position)
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_state($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("state",$rest_val);
    }

    /**
     * Returns the state of the watchdog at device startup (A for the idle position, B for the active
     * position, UNCHANGED for no change).
     * 
     * @return a value among Y_STATEATPOWERON_UNCHANGED, Y_STATEATPOWERON_A and Y_STATEATPOWERON_B
     * corresponding to the state of the watchdog at device startup (A for the idle position, B for the
     * active position, UNCHANGED for no change)
     * 
     * On failure, throws an exception or returns Y_STATEATPOWERON_INVALID.
     */
    public function get_stateAtPowerOn()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_STATEATPOWERON_INVALID;
            }
        }
        return $this->_stateAtPowerOn;
    }

    /**
     * Preset the state of the watchdog at device startup (A for the idle position,
     * B for the active position, UNCHANGED for no modification). Remember to call the matching module saveToFlash()
     * method, otherwise this call will have no effect.
     * 
     * @param newval : a value among Y_STATEATPOWERON_UNCHANGED, Y_STATEATPOWERON_A and Y_STATEATPOWERON_B
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_stateAtPowerOn($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("stateAtPowerOn",$rest_val);
    }

    /**
     * Retourne the maximum time (ms) allowed for $THEFUNCTIONS$ to stay in state A before automatically
     * switching back in to B state. Zero means no maximum time.
     * 
     * @return an integer
     * 
     * On failure, throws an exception or returns Y_MAXTIMEONSTATEA_INVALID.
     */
    public function get_maxTimeOnStateA()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_MAXTIMEONSTATEA_INVALID;
            }
        }
        return $this->_maxTimeOnStateA;
    }

    /**
     * Sets the maximum time (ms) allowed for $THEFUNCTIONS$ to stay in state A before automatically
     * switching back in to B state. Use zero for no maximum time.
     * 
     * @param newval : an integer
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_maxTimeOnStateA($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("maxTimeOnStateA",$rest_val);
    }

    /**
     * Retourne the maximum time (ms) allowed for $THEFUNCTIONS$ to stay in state B before automatically
     * switching back in to A state. Zero means no maximum time.
     * 
     * @return an integer
     * 
     * On failure, throws an exception or returns Y_MAXTIMEONSTATEB_INVALID.
     */
    public function get_maxTimeOnStateB()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_MAXTIMEONSTATEB_INVALID;
            }
        }
        return $this->_maxTimeOnStateB;
    }

    /**
     * Sets the maximum time (ms) allowed for $THEFUNCTIONS$ to stay in state B before automatically
     * switching back in to A state. Use zero for no maximum time.
     * 
     * @param newval : an integer
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_maxTimeOnStateB($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("maxTimeOnStateB",$rest_val);
    }

    /**
     * Returns the output state of the watchdog, when used as a simple switch (single throw).
     * 
     * @return either Y_OUTPUT_OFF or Y_OUTPUT_ON, according to the output state of the watchdog, when
     * used as a simple switch (single throw)
     * 
     * On failure, throws an exception or returns Y_OUTPUT_INVALID.
     */
    public function get_output()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_OUTPUT_INVALID;
            }
        }
        return $this->_output;
    }

    /**
     * Changes the output state of the watchdog, when used as a simple switch (single throw).
     * 
     * @param newval : either Y_OUTPUT_OFF or Y_OUTPUT_ON, according to the output state of the watchdog,
     * when used as a simple switch (single throw)
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_output($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("output",$rest_val);
    }

    /**
     * Returns the number of milliseconds remaining before the watchdog is returned to idle position
     * (state A), during a measured pulse generation. When there is no ongoing pulse, returns zero.
     * 
     * @return an integer corresponding to the number of milliseconds remaining before the watchdog is
     * returned to idle position
     *         (state A), during a measured pulse generation
     * 
     * On failure, throws an exception or returns Y_PULSETIMER_INVALID.
     */
    public function get_pulseTimer()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_PULSETIMER_INVALID;
            }
        }
        return $this->_pulseTimer;
    }

    public function set_pulseTimer($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("pulseTimer",$rest_val);
    }

    /**
     * Sets the relay to output B (active) for a specified duration, then brings it
     * automatically back to output A (idle state).
     * 
     * @param ms_duration : pulse duration, in millisecondes
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function pulse($ms_duration)
    {
        $rest_val = strval($ms_duration);
        return $this->_setAttr("pulseTimer",$rest_val);
    }

    public function get_delayedPulseTimer()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_DELAYEDPULSETIMER_INVALID;
            }
        }
        return $this->_delayedPulseTimer;
    }

    public function set_delayedPulseTimer($newval)
    {
        $rest_val = strval($newval["target"]).":".strval($newval["ms"]);
        return $this->_setAttr("delayedPulseTimer",$rest_val);
    }

    /**
     * Schedules a pulse.
     * 
     * @param ms_delay : waiting time before the pulse, in millisecondes
     * @param ms_duration : pulse duration, in millisecondes
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function delayedPulse($ms_delay,$ms_duration)
    {
        $rest_val = strval($ms_delay).":".strval($ms_duration);
        return $this->_setAttr("delayedPulseTimer",$rest_val);
    }

    /**
     * Returns the number of milliseconds remaining before a pulse (delayedPulse() call)
     * When there is no scheduled pulse, returns zero.
     * 
     * @return an integer corresponding to the number of milliseconds remaining before a pulse (delayedPulse() call)
     *         When there is no scheduled pulse, returns zero
     * 
     * On failure, throws an exception or returns Y_COUNTDOWN_INVALID.
     */
    public function get_countdown()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_COUNTDOWN_INVALID;
            }
        }
        return $this->_countdown;
    }

    /**
     * Returns the watchdog runing state at module power on.
     * 
     * @return either Y_AUTOSTART_OFF or Y_AUTOSTART_ON, according to the watchdog runing state at module power on
     * 
     * On failure, throws an exception or returns Y_AUTOSTART_INVALID.
     */
    public function get_autoStart()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_AUTOSTART_INVALID;
            }
        }
        return $this->_autoStart;
    }

    /**
     * Changes the watchdog runningsttae at module power on. Remember to call the
     * saveToFlash() method and then to reboot the module to apply this setting.
     * 
     * @param newval : either Y_AUTOSTART_OFF or Y_AUTOSTART_ON, according to the watchdog runningsttae at
     * module power on
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_autoStart($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("autoStart",$rest_val);
    }

    /**
     * Returns the watchdog running state.
     * 
     * @return either Y_RUNNING_OFF or Y_RUNNING_ON, according to the watchdog running state
     * 
     * On failure, throws an exception or returns Y_RUNNING_INVALID.
     */
    public function get_running()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_RUNNING_INVALID;
            }
        }
        return $this->_running;
    }

    /**
     * Changes the running state of the watchdog.
     * 
     * @param newval : either Y_RUNNING_OFF or Y_RUNNING_ON, according to the running state of the watchdog
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_running($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("running",$rest_val);
    }

    /**
     * Resets the watchdog. When the watchdog is running, this function
     * must be called on a regular basis to prevent the watchog to
     * trigger
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function resetWatchdog()
    {
        $rest_val = '1';
        return $this->_setAttr("running",$rest_val);
    }

    /**
     * Returns  the waiting duration before a reset is automatically triggered by the watchdog, in milliseconds.
     * 
     * @return an integer corresponding to  the waiting duration before a reset is automatically triggered
     * by the watchdog, in milliseconds
     * 
     * On failure, throws an exception or returns Y_TRIGGERDELAY_INVALID.
     */
    public function get_triggerDelay()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_TRIGGERDELAY_INVALID;
            }
        }
        return $this->_triggerDelay;
    }

    /**
     * Changes the waiting delay before a reset is triggered by the watchdog, in milliseconds.
     * 
     * @param newval : an integer corresponding to the waiting delay before a reset is triggered by the
     * watchdog, in milliseconds
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_triggerDelay($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("triggerDelay",$rest_val);
    }

    /**
     * Returns the duration of resets caused by the watchdog, in milliseconds.
     * 
     * @return an integer corresponding to the duration of resets caused by the watchdog, in milliseconds
     * 
     * On failure, throws an exception or returns Y_TRIGGERDURATION_INVALID.
     */
    public function get_triggerDuration()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_TRIGGERDURATION_INVALID;
            }
        }
        return $this->_triggerDuration;
    }

    /**
     * Changes the duration of resets caused by the watchdog, in milliseconds.
     * 
     * @param newval : an integer corresponding to the duration of resets caused by the watchdog, in milliseconds
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_triggerDuration($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("triggerDuration",$rest_val);
    }

    /**
     * Retrieves a watchdog for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     * 
     * This function does not require that the watchdog is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method YWatchdog.isOnline() to test if the watchdog is
     * indeed online at a given time. In case of ambiguity when looking for
     * a watchdog by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     * 
     * @param func : a string that uniquely characterizes the watchdog
     * 
     * @return a YWatchdog object allowing you to drive the watchdog.
     */
    public static function FindWatchdog($func)
    {
        // $obj                    is a YWatchdog;
        $obj = YFunction::_FindFromCache('Watchdog', $func);
        if ($obj == null) {
            $obj = new YWatchdog($func);
            YFunction::_AddToCache('Watchdog', $func, $obj);
        }
        return $obj;
    }

    public function state()
    { return $this->get_state(); }

    public function setState($newval)
    { return $this->set_state($newval); }

    public function stateAtPowerOn()
    { return $this->get_stateAtPowerOn(); }

    public function setStateAtPowerOn($newval)
    { return $this->set_stateAtPowerOn($newval); }

    public function maxTimeOnStateA()
    { return $this->get_maxTimeOnStateA(); }

    public function setMaxTimeOnStateA($newval)
    { return $this->set_maxTimeOnStateA($newval); }

    public function maxTimeOnStateB()
    { return $this->get_maxTimeOnStateB(); }

    public function setMaxTimeOnStateB($newval)
    { return $this->set_maxTimeOnStateB($newval); }

    public function output()
    { return $this->get_output(); }

    public function setOutput($newval)
    { return $this->set_output($newval); }

    public function pulseTimer()
    { return $this->get_pulseTimer(); }

    public function setPulseTimer($newval)
    { return $this->set_pulseTimer($newval); }

    public function delayedPulseTimer()
    { return $this->get_delayedPulseTimer(); }

    public function setDelayedPulseTimer($newval)
    { return $this->set_delayedPulseTimer($newval); }

    public function countdown()
    { return $this->get_countdown(); }

    public function autoStart()
    { return $this->get_autoStart(); }

    public function setAutoStart($newval)
    { return $this->set_autoStart($newval); }

    public function running()
    { return $this->get_running(); }

    public function setRunning($newval)
    { return $this->set_running($newval); }

    public function triggerDelay()
    { return $this->get_triggerDelay(); }

    public function setTriggerDelay($newval)
    { return $this->set_triggerDelay($newval); }

    public function triggerDuration()
    { return $this->get_triggerDuration(); }

    public function setTriggerDuration($newval)
    { return $this->set_triggerDuration($newval); }

    /**
     * Continues the enumeration of watchdog started using yFirstWatchdog().
     * 
     * @return a pointer to a YWatchdog object, corresponding to
     *         a watchdog currently online, or a null pointer
     *         if there are no more watchdog to enumerate.
     */
    public function nextWatchdog()
    {   $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if($resolve->errorType != YAPI_SUCCESS) return null;
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if($next_hwid == null) return null;
        return yFindWatchdog($next_hwid);
    }

    /**
     * Starts the enumeration of watchdog currently accessible.
     * Use the method YWatchdog.nextWatchdog() to iterate on
     * next watchdog.
     * 
     * @return a pointer to a YWatchdog object, corresponding to
     *         the first watchdog currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstWatchdog()
    {   $next_hwid = YAPI::getFirstHardwareId('Watchdog');
        if($next_hwid == null) return null;
        return self::FindWatchdog($next_hwid);
    }

    //--- (end of YWatchdog implementation)

};

//--- (Watchdog functions)

/**
 * Retrieves a watchdog for a given identifier.
 * The identifier can be specified using several formats:
 * <ul>
 * <li>FunctionLogicalName</li>
 * <li>ModuleSerialNumber.FunctionIdentifier</li>
 * <li>ModuleSerialNumber.FunctionLogicalName</li>
 * <li>ModuleLogicalName.FunctionIdentifier</li>
 * <li>ModuleLogicalName.FunctionLogicalName</li>
 * </ul>
 * 
 * This function does not require that the watchdog is online at the time
 * it is invoked. The returned object is nevertheless valid.
 * Use the method YWatchdog.isOnline() to test if the watchdog is
 * indeed online at a given time. In case of ambiguity when looking for
 * a watchdog by logical name, no error is notified: the first instance
 * found is returned. The search is performed first by hardware name,
 * then by logical name.
 * 
 * @param func : a string that uniquely characterizes the watchdog
 * 
 * @return a YWatchdog object allowing you to drive the watchdog.
 */
function yFindWatchdog($func)
{
    return YWatchdog::FindWatchdog($func);
}

/**
 * Starts the enumeration of watchdog currently accessible.
 * Use the method YWatchdog.nextWatchdog() to iterate on
 * next watchdog.
 * 
 * @return a pointer to a YWatchdog object, corresponding to
 *         the first watchdog currently online, or a null pointer
 *         if there are none.
 */
function yFirstWatchdog()
{
    return YWatchdog::FirstWatchdog();
}

//--- (end of Watchdog functions)
?>