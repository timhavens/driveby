<?php
/*********************************************************************
 *
 * $Id: yocto_motor.php 17370 2014-08-29 16:48:56Z seb $
 *
 * Implements YMotor, the high-level API for Motor functions
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

//--- (YMotor return codes)
//--- (end of YMotor return codes)
//--- (YMotor definitions)
if(!defined('Y_MOTORSTATUS_IDLE'))           define('Y_MOTORSTATUS_IDLE',          0);
if(!defined('Y_MOTORSTATUS_BRAKE'))          define('Y_MOTORSTATUS_BRAKE',         1);
if(!defined('Y_MOTORSTATUS_FORWD'))          define('Y_MOTORSTATUS_FORWD',         2);
if(!defined('Y_MOTORSTATUS_BACKWD'))         define('Y_MOTORSTATUS_BACKWD',        3);
if(!defined('Y_MOTORSTATUS_LOVOLT'))         define('Y_MOTORSTATUS_LOVOLT',        4);
if(!defined('Y_MOTORSTATUS_HICURR'))         define('Y_MOTORSTATUS_HICURR',        5);
if(!defined('Y_MOTORSTATUS_HIHEAT'))         define('Y_MOTORSTATUS_HIHEAT',        6);
if(!defined('Y_MOTORSTATUS_FAILSF'))         define('Y_MOTORSTATUS_FAILSF',        7);
if(!defined('Y_MOTORSTATUS_INVALID'))        define('Y_MOTORSTATUS_INVALID',       -1);
if(!defined('Y_DRIVINGFORCE_INVALID'))       define('Y_DRIVINGFORCE_INVALID',      YAPI_INVALID_DOUBLE);
if(!defined('Y_BRAKINGFORCE_INVALID'))       define('Y_BRAKINGFORCE_INVALID',      YAPI_INVALID_DOUBLE);
if(!defined('Y_CUTOFFVOLTAGE_INVALID'))      define('Y_CUTOFFVOLTAGE_INVALID',     YAPI_INVALID_DOUBLE);
if(!defined('Y_OVERCURRENTLIMIT_INVALID'))   define('Y_OVERCURRENTLIMIT_INVALID',  YAPI_INVALID_INT);
if(!defined('Y_FREQUENCY_INVALID'))          define('Y_FREQUENCY_INVALID',         YAPI_INVALID_DOUBLE);
if(!defined('Y_STARTERTIME_INVALID'))        define('Y_STARTERTIME_INVALID',       YAPI_INVALID_INT);
if(!defined('Y_FAILSAFETIMEOUT_INVALID'))    define('Y_FAILSAFETIMEOUT_INVALID',   YAPI_INVALID_UINT);
if(!defined('Y_COMMAND_INVALID'))            define('Y_COMMAND_INVALID',           YAPI_INVALID_STRING);
//--- (end of YMotor definitions)

//--- (YMotor declaration)
/**
 * YMotor Class: Motor function interface
 * 
 * Yoctopuce application programming interface allows you to drive the
 * power sent to the motor to make it turn both ways, but also to drive accelerations
 * and decelerations. The motor will then accelerate automatically: you will not
 * have to monitor it. The API also allows to slow down the motor by shortening
 * its terminals: the motor will then act as an electromagnetic brake.
 */
class YMotor extends YFunction
{
    const MOTORSTATUS_IDLE               = 0;
    const MOTORSTATUS_BRAKE              = 1;
    const MOTORSTATUS_FORWD              = 2;
    const MOTORSTATUS_BACKWD             = 3;
    const MOTORSTATUS_LOVOLT             = 4;
    const MOTORSTATUS_HICURR             = 5;
    const MOTORSTATUS_HIHEAT             = 6;
    const MOTORSTATUS_FAILSF             = 7;
    const MOTORSTATUS_INVALID            = -1;
    const DRIVINGFORCE_INVALID           = YAPI_INVALID_DOUBLE;
    const BRAKINGFORCE_INVALID           = YAPI_INVALID_DOUBLE;
    const CUTOFFVOLTAGE_INVALID          = YAPI_INVALID_DOUBLE;
    const OVERCURRENTLIMIT_INVALID       = YAPI_INVALID_INT;
    const FREQUENCY_INVALID              = YAPI_INVALID_DOUBLE;
    const STARTERTIME_INVALID            = YAPI_INVALID_INT;
    const FAILSAFETIMEOUT_INVALID        = YAPI_INVALID_UINT;
    const COMMAND_INVALID                = YAPI_INVALID_STRING;
    //--- (end of YMotor declaration)

    //--- (YMotor attributes)
    protected $_motorStatus              = Y_MOTORSTATUS_INVALID;        // MotorState
    protected $_drivingForce             = Y_DRIVINGFORCE_INVALID;       // MeasureVal
    protected $_brakingForce             = Y_BRAKINGFORCE_INVALID;       // MeasureVal
    protected $_cutOffVoltage            = Y_CUTOFFVOLTAGE_INVALID;      // MeasureVal
    protected $_overCurrentLimit         = Y_OVERCURRENTLIMIT_INVALID;   // Int
    protected $_frequency                = Y_FREQUENCY_INVALID;          // MeasureVal
    protected $_starterTime              = Y_STARTERTIME_INVALID;        // Int
    protected $_failSafeTimeout          = Y_FAILSAFETIMEOUT_INVALID;    // UInt31
    protected $_command                  = Y_COMMAND_INVALID;            // Text
    //--- (end of YMotor attributes)

    function __construct($str_func)
    {
        //--- (YMotor constructor)
        parent::__construct($str_func);
        $this->_className = 'Motor';

        //--- (end of YMotor constructor)
    }

    //--- (YMotor implementation)

    function _parseAttr($name, $val)
    {
        switch($name) {
        case 'motorStatus':
            $this->_motorStatus = intval($val);
            return 1;
        case 'drivingForce':
            $this->_drivingForce = round($val * 1000.0 / 65536.0) / 1000.0;
            return 1;
        case 'brakingForce':
            $this->_brakingForce = round($val * 1000.0 / 65536.0) / 1000.0;
            return 1;
        case 'cutOffVoltage':
            $this->_cutOffVoltage = round($val * 1000.0 / 65536.0) / 1000.0;
            return 1;
        case 'overCurrentLimit':
            $this->_overCurrentLimit = intval($val);
            return 1;
        case 'frequency':
            $this->_frequency = round($val * 1000.0 / 65536.0) / 1000.0;
            return 1;
        case 'starterTime':
            $this->_starterTime = intval($val);
            return 1;
        case 'failSafeTimeout':
            $this->_failSafeTimeout = intval($val);
            return 1;
        case 'command':
            $this->_command = $val;
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Return the controller state. Possible states are:
     * IDLE   when the motor is stopped/in free wheel, ready to start;
     * FORWD  when the controller is driving the motor forward;
     * BACKWD when the controller is driving the motor backward;
     * BRAKE  when the controller is braking;
     * LOVOLT when the controller has detected a low voltage condition;
     * HICURR when the controller has detected an overcurrent condition;
     * HIHEAT when the controller has detected an overheat condition;
     * FAILSF when the controller switched on the failsafe security.
     * 
     * When an error condition occurred (LOVOLT, HICURR, HIHEAT, FAILSF), the controller
     * status must be explicitly reset using the resetStatus function.
     * 
     * @return a value among Y_MOTORSTATUS_IDLE, Y_MOTORSTATUS_BRAKE, Y_MOTORSTATUS_FORWD,
     * Y_MOTORSTATUS_BACKWD, Y_MOTORSTATUS_LOVOLT, Y_MOTORSTATUS_HICURR, Y_MOTORSTATUS_HIHEAT and Y_MOTORSTATUS_FAILSF
     * 
     * On failure, throws an exception or returns Y_MOTORSTATUS_INVALID.
     */
    public function get_motorStatus()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_MOTORSTATUS_INVALID;
            }
        }
        return $this->_motorStatus;
    }

    public function set_motorStatus($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("motorStatus",$rest_val);
    }

    /**
     * Changes immediately the power sent to the motor. The value is a percentage between -100%
     * to 100%. If you want go easy on your mechanics and avoid excessive current consumption,
     * try to avoid brutal power changes. For example, immediate transition from forward full power
     * to reverse full power is a very bad idea. Each time the driving power is modified, the
     * braking power is set to zero.
     * 
     * @param newval : a floating point number corresponding to immediately the power sent to the motor
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_drivingForce($newval)
    {
        $rest_val = strval(round($newval * 65536.0));
        return $this->_setAttr("drivingForce",$rest_val);
    }

    /**
     * Returns the power sent to the motor, as a percentage between -100% and +100%.
     * 
     * @return a floating point number corresponding to the power sent to the motor, as a percentage
     * between -100% and +100%
     * 
     * On failure, throws an exception or returns Y_DRIVINGFORCE_INVALID.
     */
    public function get_drivingForce()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_DRIVINGFORCE_INVALID;
            }
        }
        return $this->_drivingForce;
    }

    /**
     * Changes immediately the braking force applied to the motor (in percents).
     * The value 0 corresponds to no braking (free wheel). When the braking force
     * is changed, the driving power is set to zero. The value is a percentage.
     * 
     * @param newval : a floating point number corresponding to immediately the braking force applied to
     * the motor (in percents)
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_brakingForce($newval)
    {
        $rest_val = strval(round($newval * 65536.0));
        return $this->_setAttr("brakingForce",$rest_val);
    }

    /**
     * Returns the braking force applied to the motor, as a percentage.
     * The value 0 corresponds to no braking (free wheel).
     * 
     * @return a floating point number corresponding to the braking force applied to the motor, as a percentage
     * 
     * On failure, throws an exception or returns Y_BRAKINGFORCE_INVALID.
     */
    public function get_brakingForce()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_BRAKINGFORCE_INVALID;
            }
        }
        return $this->_brakingForce;
    }

    /**
     * Changes the threshold voltage under which the controller automatically switches to error state
     * and prevents further current draw. This setting prevent damage to a battery that can
     * occur when drawing current from an "empty" battery.
     * Note that whatever the cutoff threshold, the controller switches to undervoltage
     * error state if the power supply goes under 3V, even for a very brief time.
     * 
     * @param newval : a floating point number corresponding to the threshold voltage under which the
     * controller automatically switches to error state
     *         and prevents further current draw
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_cutOffVoltage($newval)
    {
        $rest_val = strval(round($newval * 65536.0));
        return $this->_setAttr("cutOffVoltage",$rest_val);
    }

    /**
     * Returns the threshold voltage under which the controller automatically switches to error state
     * and prevents further current draw. This setting prevents damage to a battery that can
     * occur when drawing current from an "empty" battery.
     * 
     * @return a floating point number corresponding to the threshold voltage under which the controller
     * automatically switches to error state
     *         and prevents further current draw
     * 
     * On failure, throws an exception or returns Y_CUTOFFVOLTAGE_INVALID.
     */
    public function get_cutOffVoltage()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_CUTOFFVOLTAGE_INVALID;
            }
        }
        return $this->_cutOffVoltage;
    }

    /**
     * Returns the current threshold (in mA) above which the controller automatically
     * switches to error state. A zero value means that there is no limit.
     * 
     * @return an integer corresponding to the current threshold (in mA) above which the controller automatically
     *         switches to error state
     * 
     * On failure, throws an exception or returns Y_OVERCURRENTLIMIT_INVALID.
     */
    public function get_overCurrentLimit()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_OVERCURRENTLIMIT_INVALID;
            }
        }
        return $this->_overCurrentLimit;
    }

    /**
     * Changes the current threshold (in mA) above which the controller automatically
     * switches to error state. A zero value means that there is no limit. Note that whatever the
     * current limit is, the controller switches to OVERCURRENT status if the current
     * goes above 32A, even for a very brief time.
     * 
     * @param newval : an integer corresponding to the current threshold (in mA) above which the
     * controller automatically
     *         switches to error state
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_overCurrentLimit($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("overCurrentLimit",$rest_val);
    }

    /**
     * Changes the PWM frequency used to control the motor. Low frequency is usually
     * more efficient and may help the motor to start, but an audible noise might be
     * generated. A higher frequency reduces the noise, but more energy is converted
     * into heat.
     * 
     * @param newval : a floating point number corresponding to the PWM frequency used to control the motor
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_frequency($newval)
    {
        $rest_val = strval(round($newval * 65536.0));
        return $this->_setAttr("frequency",$rest_val);
    }

    /**
     * Returns the PWM frequency used to control the motor.
     * 
     * @return a floating point number corresponding to the PWM frequency used to control the motor
     * 
     * On failure, throws an exception or returns Y_FREQUENCY_INVALID.
     */
    public function get_frequency()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_FREQUENCY_INVALID;
            }
        }
        return $this->_frequency;
    }

    /**
     * Returns the duration (in ms) during which the motor is driven at low frequency to help
     * it start up.
     * 
     * @return an integer corresponding to the duration (in ms) during which the motor is driven at low
     * frequency to help
     *         it start up
     * 
     * On failure, throws an exception or returns Y_STARTERTIME_INVALID.
     */
    public function get_starterTime()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_STARTERTIME_INVALID;
            }
        }
        return $this->_starterTime;
    }

    /**
     * Changes the duration (in ms) during which the motor is driven at low frequency to help
     * it start up.
     * 
     * @param newval : an integer corresponding to the duration (in ms) during which the motor is driven
     * at low frequency to help
     *         it start up
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_starterTime($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("starterTime",$rest_val);
    }

    /**
     * Returns the delay in milliseconds allowed for the controller to run autonomously without
     * receiving any instruction from the control process. When this delay has elapsed,
     * the controller automatically stops the motor and switches to FAILSAFE error.
     * Failsafe security is disabled when the value is zero.
     * 
     * @return an integer corresponding to the delay in milliseconds allowed for the controller to run
     * autonomously without
     *         receiving any instruction from the control process
     * 
     * On failure, throws an exception or returns Y_FAILSAFETIMEOUT_INVALID.
     */
    public function get_failSafeTimeout()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_FAILSAFETIMEOUT_INVALID;
            }
        }
        return $this->_failSafeTimeout;
    }

    /**
     * Changes the delay in milliseconds allowed for the controller to run autonomously without
     * receiving any instruction from the control process. When this delay has elapsed,
     * the controller automatically stops the motor and switches to FAILSAFE error.
     * Failsafe security is disabled when the value is zero.
     * 
     * @param newval : an integer corresponding to the delay in milliseconds allowed for the controller to
     * run autonomously without
     *         receiving any instruction from the control process
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_failSafeTimeout($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("failSafeTimeout",$rest_val);
    }

    public function get_command()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_COMMAND_INVALID;
            }
        }
        return $this->_command;
    }

    public function set_command($newval)
    {
        $rest_val = $newval;
        return $this->_setAttr("command",$rest_val);
    }

    /**
     * Retrieves a motor for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     * 
     * This function does not require that the motor is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method YMotor.isOnline() to test if the motor is
     * indeed online at a given time. In case of ambiguity when looking for
     * a motor by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     * 
     * @param func : a string that uniquely characterizes the motor
     * 
     * @return a YMotor object allowing you to drive the motor.
     */
    public static function FindMotor($func)
    {
        // $obj                    is a YMotor;
        $obj = YFunction::_FindFromCache('Motor', $func);
        if ($obj == null) {
            $obj = new YMotor($func);
            YFunction::_AddToCache('Motor', $func, $obj);
        }
        return $obj;
    }

    /**
     * Rearms the controller failsafe timer. When the motor is running and the failsafe feature
     * is active, this function should be called periodically to prove that the control process
     * is running properly. Otherwise, the motor is automatically stopped after the specified
     * timeout. Calling a motor <i>set</i> function implicitely rearms the failsafe timer.
     */
    public function keepALive()
    {
        return $this->set_command('K');
    }

    /**
     * Reset the controller state to IDLE. This function must be invoked explicitely
     * after any error condition is signaled.
     */
    public function resetStatus()
    {
        return $this->set_motorStatus(Y_MOTORSTATUS_IDLE);
    }

    /**
     * Changes progressively the power sent to the moteur for a specific duration.
     * 
     * @param targetPower : desired motor power, in percents (between -100% and +100%)
     * @param delay : duration (in ms) of the transition
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function drivingForceMove($targetPower,$delay)
    {
        return $this->set_command(sprintf('P%d,%d',round($targetPower*10),$delay));
    }

    /**
     * Changes progressively the braking force applied to the motor for a specific duration.
     * 
     * @param targetPower : desired braking force, in percents
     * @param delay : duration (in ms) of the transition
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function brakingForceMove($targetPower,$delay)
    {
        return $this->set_command(sprintf('B%d,%d',round($targetPower*10),$delay));
    }

    public function motorStatus()
    { return $this->get_motorStatus(); }

    public function setMotorStatus($newval)
    { return $this->set_motorStatus($newval); }

    public function setDrivingForce($newval)
    { return $this->set_drivingForce($newval); }

    public function drivingForce()
    { return $this->get_drivingForce(); }

    public function setBrakingForce($newval)
    { return $this->set_brakingForce($newval); }

    public function brakingForce()
    { return $this->get_brakingForce(); }

    public function setCutOffVoltage($newval)
    { return $this->set_cutOffVoltage($newval); }

    public function cutOffVoltage()
    { return $this->get_cutOffVoltage(); }

    public function overCurrentLimit()
    { return $this->get_overCurrentLimit(); }

    public function setOverCurrentLimit($newval)
    { return $this->set_overCurrentLimit($newval); }

    public function setFrequency($newval)
    { return $this->set_frequency($newval); }

    public function frequency()
    { return $this->get_frequency(); }

    public function starterTime()
    { return $this->get_starterTime(); }

    public function setStarterTime($newval)
    { return $this->set_starterTime($newval); }

    public function failSafeTimeout()
    { return $this->get_failSafeTimeout(); }

    public function setFailSafeTimeout($newval)
    { return $this->set_failSafeTimeout($newval); }

    public function command()
    { return $this->get_command(); }

    public function setCommand($newval)
    { return $this->set_command($newval); }

    /**
     * Continues the enumeration of motors started using yFirstMotor().
     * 
     * @return a pointer to a YMotor object, corresponding to
     *         a motor currently online, or a null pointer
     *         if there are no more motors to enumerate.
     */
    public function nextMotor()
    {   $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if($resolve->errorType != YAPI_SUCCESS) return null;
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if($next_hwid == null) return null;
        return yFindMotor($next_hwid);
    }

    /**
     * Starts the enumeration of motors currently accessible.
     * Use the method YMotor.nextMotor() to iterate on
     * next motors.
     * 
     * @return a pointer to a YMotor object, corresponding to
     *         the first motor currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstMotor()
    {   $next_hwid = YAPI::getFirstHardwareId('Motor');
        if($next_hwid == null) return null;
        return self::FindMotor($next_hwid);
    }

    //--- (end of YMotor implementation)

};

//--- (Motor functions)

/**
 * Retrieves a motor for a given identifier.
 * The identifier can be specified using several formats:
 * <ul>
 * <li>FunctionLogicalName</li>
 * <li>ModuleSerialNumber.FunctionIdentifier</li>
 * <li>ModuleSerialNumber.FunctionLogicalName</li>
 * <li>ModuleLogicalName.FunctionIdentifier</li>
 * <li>ModuleLogicalName.FunctionLogicalName</li>
 * </ul>
 * 
 * This function does not require that the motor is online at the time
 * it is invoked. The returned object is nevertheless valid.
 * Use the method YMotor.isOnline() to test if the motor is
 * indeed online at a given time. In case of ambiguity when looking for
 * a motor by logical name, no error is notified: the first instance
 * found is returned. The search is performed first by hardware name,
 * then by logical name.
 * 
 * @param func : a string that uniquely characterizes the motor
 * 
 * @return a YMotor object allowing you to drive the motor.
 */
function yFindMotor($func)
{
    return YMotor::FindMotor($func);
}

/**
 * Starts the enumeration of motors currently accessible.
 * Use the method YMotor.nextMotor() to iterate on
 * next motors.
 * 
 * @return a pointer to a YMotor object, corresponding to
 *         the first motor currently online, or a null pointer
 *         if there are none.
 */
function yFirstMotor()
{
    return YMotor::FirstMotor();
}

//--- (end of Motor functions)
?>