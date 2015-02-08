<?php
/*********************************************************************
 *
 * $Id: yocto_servo.php 16241 2014-05-15 15:09:32Z seb $
 *
 * Implements YServo, the high-level API for Servo functions
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

//--- (YServo return codes)
//--- (end of YServo return codes)
//--- (YServo definitions)
if(!defined('Y_ENABLED_FALSE'))              define('Y_ENABLED_FALSE',             0);
if(!defined('Y_ENABLED_TRUE'))               define('Y_ENABLED_TRUE',              1);
if(!defined('Y_ENABLED_INVALID'))            define('Y_ENABLED_INVALID',           -1);
if(!defined('Y_ENABLEDATPOWERON_FALSE'))     define('Y_ENABLEDATPOWERON_FALSE',    0);
if(!defined('Y_ENABLEDATPOWERON_TRUE'))      define('Y_ENABLEDATPOWERON_TRUE',     1);
if(!defined('Y_ENABLEDATPOWERON_INVALID'))   define('Y_ENABLEDATPOWERON_INVALID',  -1);
if(!defined('Y_POSITION_INVALID'))           define('Y_POSITION_INVALID',          YAPI_INVALID_INT);
if(!defined('Y_RANGE_INVALID'))              define('Y_RANGE_INVALID',             YAPI_INVALID_UINT);
if(!defined('Y_NEUTRAL_INVALID'))            define('Y_NEUTRAL_INVALID',           YAPI_INVALID_UINT);
if(!defined('Y_MOVE_INVALID'))               define('Y_MOVE_INVALID',              null);
if(!defined('Y_POSITIONATPOWERON_INVALID'))  define('Y_POSITIONATPOWERON_INVALID', YAPI_INVALID_INT);
//--- (end of YServo definitions)

//--- (YServo declaration)
/**
 * YServo Class: Servo function interface
 * 
 * Yoctopuce application programming interface allows you not only to move
 * a servo to a given position, but also to specify the time interval
 * in which the move should be performed. This makes it possible to
 * synchronize two servos involved in a same move.
 */
class YServo extends YFunction
{
    const POSITION_INVALID               = YAPI_INVALID_INT;
    const ENABLED_FALSE                  = 0;
    const ENABLED_TRUE                   = 1;
    const ENABLED_INVALID                = -1;
    const RANGE_INVALID                  = YAPI_INVALID_UINT;
    const NEUTRAL_INVALID                = YAPI_INVALID_UINT;
    const MOVE_INVALID                   = null;
    const POSITIONATPOWERON_INVALID      = YAPI_INVALID_INT;
    const ENABLEDATPOWERON_FALSE         = 0;
    const ENABLEDATPOWERON_TRUE          = 1;
    const ENABLEDATPOWERON_INVALID       = -1;
    //--- (end of YServo declaration)

    //--- (YServo attributes)
    protected $_position                 = Y_POSITION_INVALID;           // Int
    protected $_enabled                  = Y_ENABLED_INVALID;            // Bool
    protected $_range                    = Y_RANGE_INVALID;              // Percent
    protected $_neutral                  = Y_NEUTRAL_INVALID;            // MicroSeconds
    protected $_move                     = Y_MOVE_INVALID;               // Move
    protected $_positionAtPowerOn        = Y_POSITIONATPOWERON_INVALID;  // Int
    protected $_enabledAtPowerOn         = Y_ENABLEDATPOWERON_INVALID;   // Bool
    //--- (end of YServo attributes)

    function __construct($str_func)
    {
        //--- (YServo constructor)
        parent::__construct($str_func);
        $this->_className = 'Servo';

        //--- (end of YServo constructor)
    }

    //--- (YServo implementation)

    function _parseAttr($name, $val)
    {
        switch($name) {
        case 'position':
            $this->_position = intval($val);
            return 1;
        case 'enabled':
            $this->_enabled = intval($val);
            return 1;
        case 'range':
            $this->_range = intval($val);
            return 1;
        case 'neutral':
            $this->_neutral = intval($val);
            return 1;
        case 'move':
            $this->_move = $val;
            return 1;
        case 'positionAtPowerOn':
            $this->_positionAtPowerOn = intval($val);
            return 1;
        case 'enabledAtPowerOn':
            $this->_enabledAtPowerOn = intval($val);
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Returns the current servo position.
     * 
     * @return an integer corresponding to the current servo position
     * 
     * On failure, throws an exception or returns Y_POSITION_INVALID.
     */
    public function get_position()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_POSITION_INVALID;
            }
        }
        return $this->_position;
    }

    /**
     * Changes immediately the servo driving position.
     * 
     * @param newval : an integer corresponding to immediately the servo driving position
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_position($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("position",$rest_val);
    }

    /**
     * Returns the state of the servos.
     * 
     * @return either Y_ENABLED_FALSE or Y_ENABLED_TRUE, according to the state of the servos
     * 
     * On failure, throws an exception or returns Y_ENABLED_INVALID.
     */
    public function get_enabled()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_ENABLED_INVALID;
            }
        }
        return $this->_enabled;
    }

    /**
     * Stops or starts the servo.
     * 
     * @param newval : either Y_ENABLED_FALSE or Y_ENABLED_TRUE
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_enabled($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("enabled",$rest_val);
    }

    /**
     * Returns the current range of use of the servo.
     * 
     * @return an integer corresponding to the current range of use of the servo
     * 
     * On failure, throws an exception or returns Y_RANGE_INVALID.
     */
    public function get_range()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_RANGE_INVALID;
            }
        }
        return $this->_range;
    }

    /**
     * Changes the range of use of the servo, specified in per cents.
     * A range of 100% corresponds to a standard control signal, that varies
     * from 1 [ms] to 2 [ms], When using a servo that supports a double range,
     * from 0.5 [ms] to 2.5 [ms], you can select a range of 200%.
     * Be aware that using a range higher than what is supported by the servo
     * is likely to damage the servo.
     * 
     * @param newval : an integer corresponding to the range of use of the servo, specified in per cents
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_range($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("range",$rest_val);
    }

    /**
     * Returns the duration in microseconds of a neutral pulse for the servo.
     * 
     * @return an integer corresponding to the duration in microseconds of a neutral pulse for the servo
     * 
     * On failure, throws an exception or returns Y_NEUTRAL_INVALID.
     */
    public function get_neutral()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_NEUTRAL_INVALID;
            }
        }
        return $this->_neutral;
    }

    /**
     * Changes the duration of the pulse corresponding to the neutral position of the servo.
     * The duration is specified in microseconds, and the standard value is 1500 [us].
     * This setting makes it possible to shift the range of use of the servo.
     * Be aware that using a range higher than what is supported by the servo is
     * likely to damage the servo.
     * 
     * @param newval : an integer corresponding to the duration of the pulse corresponding to the neutral
     * position of the servo
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_neutral($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("neutral",$rest_val);
    }

    public function get_move()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_MOVE_INVALID;
            }
        }
        return $this->_move;
    }

    public function set_move($newval)
    {
        $rest_val = strval($newval["target"]).":".strval($newval["ms"]);
        return $this->_setAttr("move",$rest_val);
    }

    /**
     * Performs a smooth move at constant speed toward a given position.
     * 
     * @param target      : new position at the end of the move
     * @param ms_duration : total duration of the move, in milliseconds
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function move($target,$ms_duration)
    {
        $rest_val = strval($target).":".strval($ms_duration);
        return $this->_setAttr("move",$rest_val);
    }

    /**
     * Returns the servo position at device power up.
     * 
     * @return an integer corresponding to the servo position at device power up
     * 
     * On failure, throws an exception or returns Y_POSITIONATPOWERON_INVALID.
     */
    public function get_positionAtPowerOn()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_POSITIONATPOWERON_INVALID;
            }
        }
        return $this->_positionAtPowerOn;
    }

    /**
     * Configure the servo position at device power up. Remember to call the matching
     * module saveToFlash() method, otherwise this call will have no effect.
     * 
     * @param newval : an integer
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_positionAtPowerOn($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("positionAtPowerOn",$rest_val);
    }

    /**
     * Returns the servo signal generator state at power up.
     * 
     * @return either Y_ENABLEDATPOWERON_FALSE or Y_ENABLEDATPOWERON_TRUE, according to the servo signal
     * generator state at power up
     * 
     * On failure, throws an exception or returns Y_ENABLEDATPOWERON_INVALID.
     */
    public function get_enabledAtPowerOn()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_ENABLEDATPOWERON_INVALID;
            }
        }
        return $this->_enabledAtPowerOn;
    }

    /**
     * Configure the servo signal generator state at power up. Remember to call the matching module saveToFlash()
     * method, otherwise this call will have no effect.
     * 
     * @param newval : either Y_ENABLEDATPOWERON_FALSE or Y_ENABLEDATPOWERON_TRUE
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_enabledAtPowerOn($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("enabledAtPowerOn",$rest_val);
    }

    /**
     * Retrieves a servo for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     * 
     * This function does not require that the servo is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method YServo.isOnline() to test if the servo is
     * indeed online at a given time. In case of ambiguity when looking for
     * a servo by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     * 
     * @param func : a string that uniquely characterizes the servo
     * 
     * @return a YServo object allowing you to drive the servo.
     */
    public static function FindServo($func)
    {
        // $obj                    is a YServo;
        $obj = YFunction::_FindFromCache('Servo', $func);
        if ($obj == null) {
            $obj = new YServo($func);
            YFunction::_AddToCache('Servo', $func, $obj);
        }
        return $obj;
    }

    public function position()
    { return $this->get_position(); }

    public function setPosition($newval)
    { return $this->set_position($newval); }

    public function enabled()
    { return $this->get_enabled(); }

    public function setEnabled($newval)
    { return $this->set_enabled($newval); }

    public function range()
    { return $this->get_range(); }

    public function setRange($newval)
    { return $this->set_range($newval); }

    public function neutral()
    { return $this->get_neutral(); }

    public function setNeutral($newval)
    { return $this->set_neutral($newval); }

    public function setMove($newval)
    { return $this->set_move($newval); }

    public function positionAtPowerOn()
    { return $this->get_positionAtPowerOn(); }

    public function setPositionAtPowerOn($newval)
    { return $this->set_positionAtPowerOn($newval); }

    public function enabledAtPowerOn()
    { return $this->get_enabledAtPowerOn(); }

    public function setEnabledAtPowerOn($newval)
    { return $this->set_enabledAtPowerOn($newval); }

    /**
     * Continues the enumeration of servos started using yFirstServo().
     * 
     * @return a pointer to a YServo object, corresponding to
     *         a servo currently online, or a null pointer
     *         if there are no more servos to enumerate.
     */
    public function nextServo()
    {   $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if($resolve->errorType != YAPI_SUCCESS) return null;
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if($next_hwid == null) return null;
        return yFindServo($next_hwid);
    }

    /**
     * Starts the enumeration of servos currently accessible.
     * Use the method YServo.nextServo() to iterate on
     * next servos.
     * 
     * @return a pointer to a YServo object, corresponding to
     *         the first servo currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstServo()
    {   $next_hwid = YAPI::getFirstHardwareId('Servo');
        if($next_hwid == null) return null;
        return self::FindServo($next_hwid);
    }

    //--- (end of YServo implementation)

};

//--- (Servo functions)

/**
 * Retrieves a servo for a given identifier.
 * The identifier can be specified using several formats:
 * <ul>
 * <li>FunctionLogicalName</li>
 * <li>ModuleSerialNumber.FunctionIdentifier</li>
 * <li>ModuleSerialNumber.FunctionLogicalName</li>
 * <li>ModuleLogicalName.FunctionIdentifier</li>
 * <li>ModuleLogicalName.FunctionLogicalName</li>
 * </ul>
 * 
 * This function does not require that the servo is online at the time
 * it is invoked. The returned object is nevertheless valid.
 * Use the method YServo.isOnline() to test if the servo is
 * indeed online at a given time. In case of ambiguity when looking for
 * a servo by logical name, no error is notified: the first instance
 * found is returned. The search is performed first by hardware name,
 * then by logical name.
 * 
 * @param func : a string that uniquely characterizes the servo
 * 
 * @return a YServo object allowing you to drive the servo.
 */
function yFindServo($func)
{
    return YServo::FindServo($func);
}

/**
 * Starts the enumeration of servos currently accessible.
 * Use the method YServo.nextServo() to iterate on
 * next servos.
 * 
 * @return a pointer to a YServo object, corresponding to
 *         the first servo currently online, or a null pointer
 *         if there are none.
 */
function yFirstServo()
{
    return YServo::FirstServo();
}

//--- (end of Servo functions)
?>