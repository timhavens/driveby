<?php
/*********************************************************************
 *
 * $Id: yocto_digitalio.php 16241 2014-05-15 15:09:32Z seb $
 *
 * Implements YDigitalIO, the high-level API for DigitalIO functions
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

//--- (YDigitalIO return codes)
//--- (end of YDigitalIO return codes)
//--- (YDigitalIO definitions)
if(!defined('Y_OUTPUTVOLTAGE_USB_5V'))       define('Y_OUTPUTVOLTAGE_USB_5V',      0);
if(!defined('Y_OUTPUTVOLTAGE_USB_3V'))       define('Y_OUTPUTVOLTAGE_USB_3V',      1);
if(!defined('Y_OUTPUTVOLTAGE_EXT_V'))        define('Y_OUTPUTVOLTAGE_EXT_V',       2);
if(!defined('Y_OUTPUTVOLTAGE_INVALID'))      define('Y_OUTPUTVOLTAGE_INVALID',     -1);
if(!defined('Y_PORTSTATE_INVALID'))          define('Y_PORTSTATE_INVALID',         YAPI_INVALID_UINT);
if(!defined('Y_PORTDIRECTION_INVALID'))      define('Y_PORTDIRECTION_INVALID',     YAPI_INVALID_UINT);
if(!defined('Y_PORTOPENDRAIN_INVALID'))      define('Y_PORTOPENDRAIN_INVALID',     YAPI_INVALID_UINT);
if(!defined('Y_PORTPOLARITY_INVALID'))       define('Y_PORTPOLARITY_INVALID',      YAPI_INVALID_UINT);
if(!defined('Y_PORTSIZE_INVALID'))           define('Y_PORTSIZE_INVALID',          YAPI_INVALID_UINT);
if(!defined('Y_COMMAND_INVALID'))            define('Y_COMMAND_INVALID',           YAPI_INVALID_STRING);
//--- (end of YDigitalIO definitions)

//--- (YDigitalIO declaration)
/**
 * YDigitalIO Class: Digital IO function interface
 * 
 * The Yoctopuce application programming interface allows you to switch the state of each
 * bit of the I/O port. You can switch all bits at once, or one by one. The library
 * can also automatically generate short pulses of a determined duration. Electrical behavior
 * of each I/O can be modified (open drain and reverse polarity).
 */
class YDigitalIO extends YFunction
{
    const PORTSTATE_INVALID              = YAPI_INVALID_UINT;
    const PORTDIRECTION_INVALID          = YAPI_INVALID_UINT;
    const PORTOPENDRAIN_INVALID          = YAPI_INVALID_UINT;
    const PORTPOLARITY_INVALID           = YAPI_INVALID_UINT;
    const PORTSIZE_INVALID               = YAPI_INVALID_UINT;
    const OUTPUTVOLTAGE_USB_5V           = 0;
    const OUTPUTVOLTAGE_USB_3V           = 1;
    const OUTPUTVOLTAGE_EXT_V            = 2;
    const OUTPUTVOLTAGE_INVALID          = -1;
    const COMMAND_INVALID                = YAPI_INVALID_STRING;
    //--- (end of YDigitalIO declaration)

    //--- (YDigitalIO attributes)
    protected $_portState                = Y_PORTSTATE_INVALID;          // BitByte
    protected $_portDirection            = Y_PORTDIRECTION_INVALID;      // BitByte
    protected $_portOpenDrain            = Y_PORTOPENDRAIN_INVALID;      // BitByte
    protected $_portPolarity             = Y_PORTPOLARITY_INVALID;       // BitByte
    protected $_portSize                 = Y_PORTSIZE_INVALID;           // UInt31
    protected $_outputVoltage            = Y_OUTPUTVOLTAGE_INVALID;      // IOVoltage
    protected $_command                  = Y_COMMAND_INVALID;            // Text
    //--- (end of YDigitalIO attributes)

    function __construct($str_func)
    {
        //--- (YDigitalIO constructor)
        parent::__construct($str_func);
        $this->_className = 'DigitalIO';

        //--- (end of YDigitalIO constructor)
    }

    //--- (YDigitalIO implementation)

    function _parseAttr($name, $val)
    {
        switch($name) {
        case 'portState':
            $this->_portState = intval($val);
            return 1;
        case 'portDirection':
            $this->_portDirection = intval($val);
            return 1;
        case 'portOpenDrain':
            $this->_portOpenDrain = intval($val);
            return 1;
        case 'portPolarity':
            $this->_portPolarity = intval($val);
            return 1;
        case 'portSize':
            $this->_portSize = intval($val);
            return 1;
        case 'outputVoltage':
            $this->_outputVoltage = intval($val);
            return 1;
        case 'command':
            $this->_command = $val;
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Returns the digital IO port state: bit 0 represents input 0, and so on.
     * 
     * @return an integer corresponding to the digital IO port state: bit 0 represents input 0, and so on
     * 
     * On failure, throws an exception or returns Y_PORTSTATE_INVALID.
     */
    public function get_portState()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_PORTSTATE_INVALID;
            }
        }
        return $this->_portState;
    }

    /**
     * Changes the digital IO port state: bit 0 represents input 0, and so on. This function has no effect
     * on bits configured as input in portDirection.
     * 
     * @param newval : an integer corresponding to the digital IO port state: bit 0 represents input 0, and so on
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_portState($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("portState",$rest_val);
    }

    /**
     * Returns the IO direction of all bits of the port: 0 makes a bit an input, 1 makes it an output.
     * 
     * @return an integer corresponding to the IO direction of all bits of the port: 0 makes a bit an
     * input, 1 makes it an output
     * 
     * On failure, throws an exception or returns Y_PORTDIRECTION_INVALID.
     */
    public function get_portDirection()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_PORTDIRECTION_INVALID;
            }
        }
        return $this->_portDirection;
    }

    /**
     * Changes the IO direction of all bits of the port: 0 makes a bit an input, 1 makes it an output.
     * Remember to call the saveToFlash() method  to make sure the setting is kept after a reboot.
     * 
     * @param newval : an integer corresponding to the IO direction of all bits of the port: 0 makes a bit
     * an input, 1 makes it an output
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_portDirection($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("portDirection",$rest_val);
    }

    /**
     * Returns the electrical interface for each bit of the port. For each bit set to 0  the matching I/O
     * works in the regular,
     * intuitive way, for each bit set to 1, the I/O works in reverse mode.
     * 
     * @return an integer corresponding to the electrical interface for each bit of the port
     * 
     * On failure, throws an exception or returns Y_PORTOPENDRAIN_INVALID.
     */
    public function get_portOpenDrain()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_PORTOPENDRAIN_INVALID;
            }
        }
        return $this->_portOpenDrain;
    }

    /**
     * Changes the electrical interface for each bit of the port. 0 makes a bit a regular input/output, 1 makes
     * it an open-drain (open-collector) input/output. Remember to call the
     * saveToFlash() method  to make sure the setting is kept after a reboot.
     * 
     * @param newval : an integer corresponding to the electrical interface for each bit of the port
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_portOpenDrain($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("portOpenDrain",$rest_val);
    }

    /**
     * Returns the polarity of all the bits of the port.  For each bit set to 0, the matching I/O works the regular,
     * intuitive way; for each bit set to 1, the I/O works in reverse mode.
     * 
     * @return an integer corresponding to the polarity of all the bits of the port
     * 
     * On failure, throws an exception or returns Y_PORTPOLARITY_INVALID.
     */
    public function get_portPolarity()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_PORTPOLARITY_INVALID;
            }
        }
        return $this->_portPolarity;
    }

    /**
     * Changes the polarity of all the bits of the port: 0 makes a bit an input, 1 makes it an output.
     * Remember to call the saveToFlash() method  to make sure the setting will be kept after a reboot.
     * 
     * @param newval : an integer corresponding to the polarity of all the bits of the port: 0 makes a bit
     * an input, 1 makes it an output
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_portPolarity($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("portPolarity",$rest_val);
    }

    /**
     * Returns the number of bits implemented in the I/O port.
     * 
     * @return an integer corresponding to the number of bits implemented in the I/O port
     * 
     * On failure, throws an exception or returns Y_PORTSIZE_INVALID.
     */
    public function get_portSize()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_PORTSIZE_INVALID;
            }
        }
        return $this->_portSize;
    }

    /**
     * Returns the voltage source used to drive output bits.
     * 
     * @return a value among Y_OUTPUTVOLTAGE_USB_5V, Y_OUTPUTVOLTAGE_USB_3V and Y_OUTPUTVOLTAGE_EXT_V
     * corresponding to the voltage source used to drive output bits
     * 
     * On failure, throws an exception or returns Y_OUTPUTVOLTAGE_INVALID.
     */
    public function get_outputVoltage()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_OUTPUTVOLTAGE_INVALID;
            }
        }
        return $this->_outputVoltage;
    }

    /**
     * Changes the voltage source used to drive output bits.
     * Remember to call the saveToFlash() method  to make sure the setting is kept after a reboot.
     * 
     * @param newval : a value among Y_OUTPUTVOLTAGE_USB_5V, Y_OUTPUTVOLTAGE_USB_3V and
     * Y_OUTPUTVOLTAGE_EXT_V corresponding to the voltage source used to drive output bits
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_outputVoltage($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("outputVoltage",$rest_val);
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
     * Retrieves a digital IO port for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     * 
     * This function does not require that the digital IO port is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method YDigitalIO.isOnline() to test if the digital IO port is
     * indeed online at a given time. In case of ambiguity when looking for
     * a digital IO port by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     * 
     * @param func : a string that uniquely characterizes the digital IO port
     * 
     * @return a YDigitalIO object allowing you to drive the digital IO port.
     */
    public static function FindDigitalIO($func)
    {
        // $obj                    is a YDigitalIO;
        $obj = YFunction::_FindFromCache('DigitalIO', $func);
        if ($obj == null) {
            $obj = new YDigitalIO($func);
            YFunction::_AddToCache('DigitalIO', $func, $obj);
        }
        return $obj;
    }

    /**
     * Sets a single bit of the I/O port.
     * 
     * @param bitno : the bit number; lowest bit has index 0
     * @param bitstate : the state of the bit (1 or 0)
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_bitState($bitno,$bitstate)
    {
        if (!($bitstate >= 0)) return $this->_throw( YAPI_INVALID_ARGUMENT, 'invalid bitstate',YAPI_INVALID_ARGUMENT);
        if (!($bitstate <= 1)) return $this->_throw( YAPI_INVALID_ARGUMENT, 'invalid bitstate',YAPI_INVALID_ARGUMENT);
        return $this->set_command(sprintf('%c%d',82+$bitstate, $bitno));
    }

    /**
     * Returns the state of a single bit of the I/O port.
     * 
     * @param bitno : the bit number; lowest bit has index 0
     * 
     * @return the bit state (0 or 1)
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function get_bitState($bitno)
    {
        // $portVal                is a int;
        $portVal = $this->get_portState();
        return (((($portVal) >> ($bitno))) & (1));
    }

    /**
     * Reverts a single bit of the I/O port.
     * 
     * @param bitno : the bit number; lowest bit has index 0
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function toggle_bitState($bitno)
    {
        return $this->set_command(sprintf('T%d', $bitno));
    }

    /**
     * Changes  the direction of a single bit from the I/O port.
     * 
     * @param bitno : the bit number; lowest bit has index 0
     * @param bitdirection : direction to set, 0 makes the bit an input, 1 makes it an output.
     *         Remember to call the   saveToFlash() method to make sure the setting is kept after a reboot.
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_bitDirection($bitno,$bitdirection)
    {
        if (!($bitdirection >= 0)) return $this->_throw( YAPI_INVALID_ARGUMENT, 'invalid direction',YAPI_INVALID_ARGUMENT);
        if (!($bitdirection <= 1)) return $this->_throw( YAPI_INVALID_ARGUMENT, 'invalid direction',YAPI_INVALID_ARGUMENT);
        return $this->set_command(sprintf('%c%d',73+6*$bitdirection, $bitno));
    }

    /**
     * Returns the direction of a single bit from the I/O port (0 means the bit is an input, 1  an output).
     * 
     * @param bitno : the bit number; lowest bit has index 0
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function get_bitDirection($bitno)
    {
        // $portDir                is a int;
        $portDir = $this->get_portDirection();
        return (((($portDir) >> ($bitno))) & (1));
    }

    /**
     * Changes the polarity of a single bit from the I/O port.
     * 
     * @param bitno : the bit number; lowest bit has index 0.
     * @param bitpolarity : polarity to set, 0 makes the I/O work in regular mode, 1 makes the I/O  works
     * in reverse mode.
     *         Remember to call the   saveToFlash() method to make sure the setting is kept after a reboot.
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_bitPolarity($bitno,$bitpolarity)
    {
        if (!($bitpolarity >= 0)) return $this->_throw( YAPI_INVALID_ARGUMENT, 'invalid bitpolarity',YAPI_INVALID_ARGUMENT);
        if (!($bitpolarity <= 1)) return $this->_throw( YAPI_INVALID_ARGUMENT, 'invalid bitpolarity',YAPI_INVALID_ARGUMENT);
        return $this->set_command(sprintf('%c%d',110+4*$bitpolarity, $bitno));
    }

    /**
     * Returns the polarity of a single bit from the I/O port (0 means the I/O works in regular mode, 1
     * means the I/O  works in reverse mode).
     * 
     * @param bitno : the bit number; lowest bit has index 0
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function get_bitPolarity($bitno)
    {
        // $portPol                is a int;
        $portPol = $this->get_portPolarity();
        return (((($portPol) >> ($bitno))) & (1));
    }

    /**
     * Changes  the electrical interface of a single bit from the I/O port.
     * 
     * @param bitno : the bit number; lowest bit has index 0
     * @param opendrain : 0 makes a bit a regular input/output, 1 makes
     *         it an open-drain (open-collector) input/output. Remember to call the
     *         saveToFlash() method to make sure the setting is kept after a reboot.
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_bitOpenDrain($bitno,$opendrain)
    {
        if (!($opendrain >= 0)) return $this->_throw( YAPI_INVALID_ARGUMENT, 'invalid state',YAPI_INVALID_ARGUMENT);
        if (!($opendrain <= 1)) return $this->_throw( YAPI_INVALID_ARGUMENT, 'invalid state',YAPI_INVALID_ARGUMENT);
        return $this->set_command(sprintf('%c%d',100-32*$opendrain, $bitno));
    }

    /**
     * Returns the type of electrical interface of a single bit from the I/O port. (0 means the bit is an
     * input, 1  an output).
     * 
     * @param bitno : the bit number; lowest bit has index 0
     * 
     * @return   0 means the a bit is a regular input/output, 1 means the bit is an open-drain
     *         (open-collector) input/output.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function get_bitOpenDrain($bitno)
    {
        // $portOpenDrain          is a int;
        $portOpenDrain = $this->get_portOpenDrain();
        return (((($portOpenDrain) >> ($bitno))) & (1));
    }

    /**
     * Triggers a pulse on a single bit for a specified duration. The specified bit
     * will be turned to 1, and then back to 0 after the given duration.
     * 
     * @param bitno : the bit number; lowest bit has index 0
     * @param ms_duration : desired pulse duration in milliseconds. Be aware that the device time
     *         resolution is not guaranteed up to the millisecond.
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function pulse($bitno,$ms_duration)
    {
        return $this->set_command(sprintf('Z%d,0,%d', $bitno,$ms_duration));
    }

    /**
     * Schedules a pulse on a single bit for a specified duration. The specified bit
     * will be turned to 1, and then back to 0 after the given duration.
     * 
     * @param bitno : the bit number; lowest bit has index 0
     * @param ms_delay : waiting time before the pulse, in milliseconds
     * @param ms_duration : desired pulse duration in milliseconds. Be aware that the device time
     *         resolution is not guaranteed up to the millisecond.
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function delayedPulse($bitno,$ms_delay,$ms_duration)
    {
        return $this->set_command(sprintf('Z%d,%d,%d',$bitno,$ms_delay,$ms_duration));
    }

    public function portState()
    { return $this->get_portState(); }

    public function setPortState($newval)
    { return $this->set_portState($newval); }

    public function portDirection()
    { return $this->get_portDirection(); }

    public function setPortDirection($newval)
    { return $this->set_portDirection($newval); }

    public function portOpenDrain()
    { return $this->get_portOpenDrain(); }

    public function setPortOpenDrain($newval)
    { return $this->set_portOpenDrain($newval); }

    public function portPolarity()
    { return $this->get_portPolarity(); }

    public function setPortPolarity($newval)
    { return $this->set_portPolarity($newval); }

    public function portSize()
    { return $this->get_portSize(); }

    public function outputVoltage()
    { return $this->get_outputVoltage(); }

    public function setOutputVoltage($newval)
    { return $this->set_outputVoltage($newval); }

    public function command()
    { return $this->get_command(); }

    public function setCommand($newval)
    { return $this->set_command($newval); }

    /**
     * Continues the enumeration of digital IO ports started using yFirstDigitalIO().
     * 
     * @return a pointer to a YDigitalIO object, corresponding to
     *         a digital IO port currently online, or a null pointer
     *         if there are no more digital IO ports to enumerate.
     */
    public function nextDigitalIO()
    {   $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if($resolve->errorType != YAPI_SUCCESS) return null;
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if($next_hwid == null) return null;
        return yFindDigitalIO($next_hwid);
    }

    /**
     * Starts the enumeration of digital IO ports currently accessible.
     * Use the method YDigitalIO.nextDigitalIO() to iterate on
     * next digital IO ports.
     * 
     * @return a pointer to a YDigitalIO object, corresponding to
     *         the first digital IO port currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstDigitalIO()
    {   $next_hwid = YAPI::getFirstHardwareId('DigitalIO');
        if($next_hwid == null) return null;
        return self::FindDigitalIO($next_hwid);
    }

    //--- (end of YDigitalIO implementation)

};

//--- (DigitalIO functions)

/**
 * Retrieves a digital IO port for a given identifier.
 * The identifier can be specified using several formats:
 * <ul>
 * <li>FunctionLogicalName</li>
 * <li>ModuleSerialNumber.FunctionIdentifier</li>
 * <li>ModuleSerialNumber.FunctionLogicalName</li>
 * <li>ModuleLogicalName.FunctionIdentifier</li>
 * <li>ModuleLogicalName.FunctionLogicalName</li>
 * </ul>
 * 
 * This function does not require that the digital IO port is online at the time
 * it is invoked. The returned object is nevertheless valid.
 * Use the method YDigitalIO.isOnline() to test if the digital IO port is
 * indeed online at a given time. In case of ambiguity when looking for
 * a digital IO port by logical name, no error is notified: the first instance
 * found is returned. The search is performed first by hardware name,
 * then by logical name.
 * 
 * @param func : a string that uniquely characterizes the digital IO port
 * 
 * @return a YDigitalIO object allowing you to drive the digital IO port.
 */
function yFindDigitalIO($func)
{
    return YDigitalIO::FindDigitalIO($func);
}

/**
 * Starts the enumeration of digital IO ports currently accessible.
 * Use the method YDigitalIO.nextDigitalIO() to iterate on
 * next digital IO ports.
 * 
 * @return a pointer to a YDigitalIO object, corresponding to
 *         the first digital IO port currently online, or a null pointer
 *         if there are none.
 */
function yFirstDigitalIO()
{
    return YDigitalIO::FirstDigitalIO();
}

//--- (end of DigitalIO functions)
?>