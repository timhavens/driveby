<?php
/*********************************************************************
 *
 * $Id: yocto_serialport.php 18172 2014-10-27 15:40:02Z seb $
 *
 * Implements YSerialPort, the high-level API for SerialPort functions
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

//--- (YSerialPort return codes)
//--- (end of YSerialPort return codes)
//--- (YSerialPort definitions)
if(!defined('Y_SERIALMODE_INVALID'))         define('Y_SERIALMODE_INVALID',        YAPI_INVALID_STRING);
if(!defined('Y_PROTOCOL_INVALID'))           define('Y_PROTOCOL_INVALID',          YAPI_INVALID_STRING);
if(!defined('Y_RXCOUNT_INVALID'))            define('Y_RXCOUNT_INVALID',           YAPI_INVALID_UINT);
if(!defined('Y_TXCOUNT_INVALID'))            define('Y_TXCOUNT_INVALID',           YAPI_INVALID_UINT);
if(!defined('Y_ERRCOUNT_INVALID'))           define('Y_ERRCOUNT_INVALID',          YAPI_INVALID_UINT);
if(!defined('Y_RXMSGCOUNT_INVALID'))         define('Y_RXMSGCOUNT_INVALID',        YAPI_INVALID_UINT);
if(!defined('Y_TXMSGCOUNT_INVALID'))         define('Y_TXMSGCOUNT_INVALID',        YAPI_INVALID_UINT);
if(!defined('Y_LASTMSG_INVALID'))            define('Y_LASTMSG_INVALID',           YAPI_INVALID_STRING);
if(!defined('Y_COMMAND_INVALID'))            define('Y_COMMAND_INVALID',           YAPI_INVALID_STRING);
//--- (end of YSerialPort definitions)

//--- (YSerialPort declaration)
/**
 * YSerialPort Class: SerialPort function interface
 * 
 * The SerialPort function interface allows you to fully drive a Yoctopuce
 * serial port, to send and receive data, and to configure communication
 * parameters (baud rate, bit count, parity, flow control and protocol).
 * Note that Yoctopuce serial ports are not exposed as virtual COM ports.
 * They are meant to be used in the same way as all Yoctopuce devices.
 */
class YSerialPort extends YFunction
{
    const SERIALMODE_INVALID             = YAPI_INVALID_STRING;
    const PROTOCOL_INVALID               = YAPI_INVALID_STRING;
    const RXCOUNT_INVALID                = YAPI_INVALID_UINT;
    const TXCOUNT_INVALID                = YAPI_INVALID_UINT;
    const ERRCOUNT_INVALID               = YAPI_INVALID_UINT;
    const RXMSGCOUNT_INVALID             = YAPI_INVALID_UINT;
    const TXMSGCOUNT_INVALID             = YAPI_INVALID_UINT;
    const LASTMSG_INVALID                = YAPI_INVALID_STRING;
    const COMMAND_INVALID                = YAPI_INVALID_STRING;
    //--- (end of YSerialPort declaration)

    //--- (YSerialPort attributes)
    protected $_serialMode               = Y_SERIALMODE_INVALID;         // SerialMode
    protected $_protocol                 = Y_PROTOCOL_INVALID;           // Protocol
    protected $_rxCount                  = Y_RXCOUNT_INVALID;            // UInt31
    protected $_txCount                  = Y_TXCOUNT_INVALID;            // UInt31
    protected $_errCount                 = Y_ERRCOUNT_INVALID;           // UInt31
    protected $_rxMsgCount               = Y_RXMSGCOUNT_INVALID;         // UInt31
    protected $_txMsgCount               = Y_TXMSGCOUNT_INVALID;         // UInt31
    protected $_lastMsg                  = Y_LASTMSG_INVALID;            // Text
    protected $_command                  = Y_COMMAND_INVALID;            // Text
    protected $_rxptr                    = 0;                            // int
    //--- (end of YSerialPort attributes)

    function __construct($str_func)
    {
        //--- (YSerialPort constructor)
        parent::__construct($str_func);
        $this->_className = 'SerialPort';

        //--- (end of YSerialPort constructor)
    }

    //--- (YSerialPort implementation)

    function _parseAttr($name, $val)
    {
        switch($name) {
        case 'serialMode':
            $this->_serialMode = $val;
            return 1;
        case 'protocol':
            $this->_protocol = $val;
            return 1;
        case 'rxCount':
            $this->_rxCount = intval($val);
            return 1;
        case 'txCount':
            $this->_txCount = intval($val);
            return 1;
        case 'errCount':
            $this->_errCount = intval($val);
            return 1;
        case 'rxMsgCount':
            $this->_rxMsgCount = intval($val);
            return 1;
        case 'txMsgCount':
            $this->_txMsgCount = intval($val);
            return 1;
        case 'lastMsg':
            $this->_lastMsg = $val;
            return 1;
        case 'command':
            $this->_command = $val;
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Returns the serial port communication parameters, as a string such as
     * "9600,8N1". The string includes the baud rate, the number of data bits,
     * the parity, and the number of stop bits. An optional suffix is included
     * if flow control is active: "CtsRts" for hardware handshake, "XOnXOff"
     * for logical flow control and "Simplex" for acquiring a shared bus using
     * the RTS line (as used by some RS485 adapters for instance).
     * 
     * @return a string corresponding to the serial port communication parameters, as a string such as
     *         "9600,8N1"
     * 
     * On failure, throws an exception or returns Y_SERIALMODE_INVALID.
     */
    public function get_serialMode()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_SERIALMODE_INVALID;
            }
        }
        return $this->_serialMode;
    }

    /**
     * Changes the serial port communication parameters, with a string such as
     * "9600,8N1". The string includes the baud rate, the number of data bits,
     * the parity, and the number of stop bits. An optional suffix can be added
     * to enable flow control: "CtsRts" for hardware handshake, "XOnXOff"
     * for logical flow control and "Simplex" for acquiring a shared bus using
     * the RTS line (as used by some RS485 adapters for instance).
     * 
     * @param newval : a string corresponding to the serial port communication parameters, with a string such as
     *         "9600,8N1"
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_serialMode($newval)
    {
        $rest_val = $newval;
        return $this->_setAttr("serialMode",$rest_val);
    }

    /**
     * Returns the type of protocol used over the serial line, as a string.
     * Possible values are "Line" for ASCII messages separated by CR and/or LF,
     * "Frame:[timeout]ms" for binary messages separated by a delay time,
     * "Modbus-ASCII" for MODBUS messages in ASCII mode,
     * "Modbus-RTU" for MODBUS messages in RTU mode,
     * "Char" for a continuous ASCII stream or
     * "Byte" for a continuous binary stream.
     * 
     * @return a string corresponding to the type of protocol used over the serial line, as a string
     * 
     * On failure, throws an exception or returns Y_PROTOCOL_INVALID.
     */
    public function get_protocol()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_PROTOCOL_INVALID;
            }
        }
        return $this->_protocol;
    }

    /**
     * Changes the type of protocol used over the serial line.
     * Possible values are "Line" for ASCII messages separated by CR and/or LF,
     * "Frame:[timeout]ms" for binary messages separated by a delay time,
     * "Modbus-ASCII" for MODBUS messages in ASCII mode,
     * "Modbus-RTU" for MODBUS messages in RTU mode,
     * "Char" for a continuous ASCII stream or
     * "Byte" for a continuous binary stream.
     * 
     * @param newval : a string corresponding to the type of protocol used over the serial line
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_protocol($newval)
    {
        $rest_val = $newval;
        return $this->_setAttr("protocol",$rest_val);
    }

    /**
     * Returns the total number of bytes received since last reset.
     * 
     * @return an integer corresponding to the total number of bytes received since last reset
     * 
     * On failure, throws an exception or returns Y_RXCOUNT_INVALID.
     */
    public function get_rxCount()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_RXCOUNT_INVALID;
            }
        }
        return $this->_rxCount;
    }

    /**
     * Returns the total number of bytes transmitted since last reset.
     * 
     * @return an integer corresponding to the total number of bytes transmitted since last reset
     * 
     * On failure, throws an exception or returns Y_TXCOUNT_INVALID.
     */
    public function get_txCount()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_TXCOUNT_INVALID;
            }
        }
        return $this->_txCount;
    }

    /**
     * Returns the total number of communication errors detected since last reset.
     * 
     * @return an integer corresponding to the total number of communication errors detected since last reset
     * 
     * On failure, throws an exception or returns Y_ERRCOUNT_INVALID.
     */
    public function get_errCount()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_ERRCOUNT_INVALID;
            }
        }
        return $this->_errCount;
    }

    /**
     * Returns the total number of messages received since last reset.
     * 
     * @return an integer corresponding to the total number of messages received since last reset
     * 
     * On failure, throws an exception or returns Y_RXMSGCOUNT_INVALID.
     */
    public function get_rxMsgCount()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_RXMSGCOUNT_INVALID;
            }
        }
        return $this->_rxMsgCount;
    }

    /**
     * Returns the total number of messages send since last reset.
     * 
     * @return an integer corresponding to the total number of messages send since last reset
     * 
     * On failure, throws an exception or returns Y_TXMSGCOUNT_INVALID.
     */
    public function get_txMsgCount()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_TXMSGCOUNT_INVALID;
            }
        }
        return $this->_txMsgCount;
    }

    /**
     * Returns the latest message fully received (for Line, Frame and Modbus protocols).
     * 
     * @return a string corresponding to the latest message fully received (for Line, Frame and Modbus protocols)
     * 
     * On failure, throws an exception or returns Y_LASTMSG_INVALID.
     */
    public function get_lastMsg()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_LASTMSG_INVALID;
            }
        }
        return $this->_lastMsg;
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
     * Retrieves a serial port for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     * 
     * This function does not require that the serial port is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method YSerialPort.isOnline() to test if the serial port is
     * indeed online at a given time. In case of ambiguity when looking for
     * a serial port by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     * 
     * @param func : a string that uniquely characterizes the serial port
     * 
     * @return a YSerialPort object allowing you to drive the serial port.
     */
    public static function FindSerialPort($func)
    {
        // $obj                    is a YSerialPort;
        $obj = YFunction::_FindFromCache('SerialPort', $func);
        if ($obj == null) {
            $obj = new YSerialPort($func);
            YFunction::_AddToCache('SerialPort', $func, $obj);
        }
        return $obj;
    }

    public function sendCommand($text)
    {
        return $this->set_command($text);
    }

    /**
     * Clears the serial port buffer and resets counters to zero.
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function reset()
    {
        $this->_rxptr = 0;
        // may throw an exception
        return $this->sendCommand('Z');
    }

    /**
     * Manually sets the state of the RTS line. This function has no effect when
     * hardware handshake is enabled, as the RTS line is driven automatically.
     * 
     * @param val : 1 to turn RTS on, 0 to turn RTS off
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_RTS($val)
    {
        return $this->sendCommand(sprintf('R%d',$val));
    }

    /**
     * Read the level of the CTS line. The CTS line is usually driven by
     * the RTS signal of the connected serial device.
     * 
     * @return 1 if the CTS line is high, 0 if the CTS line is low.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function get_CTS()
    {
        // $buff                   is a bin;
        // $res                    is a int;
        // may throw an exception
        $buff = $this->_download('cts.txt');
        if (!(strlen($buff) == 1)) return $this->_throw( YAPI_IO_ERROR, 'invalid CTS reply',YAPI_IO_ERROR);
        $res = $buff[0] - 48;
        return $res;
    }

    /**
     * Sends an ASCII string to the serial port, as is.
     * 
     * @param text : the text string to send
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function writeStr($text)
    {
        // $buff                   is a bin;
        // $bufflen                is a int;
        // $idx                    is a int;
        // $ch                     is a int;
        $buff = $text;
        $bufflen = strlen($buff);
        if ($bufflen < 100) {
            $ch = 0x20;
            $idx = 0;
            while (($idx < $bufflen) && ($ch != 0)) {
                $ch = $buff[$idx];
                if (($ch >= 0x20) && ($ch < 0x7f)) {
                    $idx = $idx + 1;
                } else {
                    $ch = 0;
                }
            }
            if ($idx >= $bufflen) {
                return $this->sendCommand(sprintf('+%s',$text));
            }
        }
        // send string using file upload
        return $this->_upload('txdata', $buff);
    }

    /**
     * Sends a binary buffer to the serial port, as is.
     * 
     * @param buff : the binary buffer to send
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function writeBin($buff)
    {
        return $this->_upload('txdata', $buff);
    }

    /**
     * Sends a byte sequence (provided as a list of bytes) to the serial port.
     * 
     * @param byteList : a list of byte codes
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function writeArray($byteList)
    {
        // $buff                   is a bin;
        // $bufflen                is a int;
        // $idx                    is a int;
        // $hexb                   is a int;
        // $res                    is a int;
        $bufflen = sizeof($byteList);
        $buff = str_repeat(' ',$bufflen);
        $idx = 0;
        while ($idx < $bufflen) {
            $hexb = $byteList[$idx];
            $buff[$idx] = $hexb;
            $idx = $idx + 1;
        }
        // may throw an exception
        $res = $this->_upload('txdata', $buff);
        return $res;
    }

    /**
     * Sends a byte sequence (provided as a hexadecimal string) to the serial port.
     * 
     * @param hexString : a string of hexadecimal byte codes
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function writeHex($hexString)
    {
        // $buff                   is a bin;
        // $bufflen                is a int;
        // $idx                    is a int;
        // $hexb                   is a int;
        // $res                    is a int;
        $bufflen = strlen($hexString);
        if ($bufflen < 100) {
            return $this->sendCommand(sprintf('$%s',$hexString));
        }
        $bufflen = (($bufflen) >> (1));
        $buff = str_repeat(' ',$bufflen);
        $idx = 0;
        while ($idx < $bufflen) {
            $hexb = hexdec(substr($hexString,  2 * $idx, 2));
            $buff[$idx] = $hexb;
            $idx = $idx + 1;
        }
        // may throw an exception
        $res = $this->_upload('txdata', $buff);
        return $res;
    }

    /**
     * Sends an ASCII string to the serial port, followed by a line break (CR LF).
     * 
     * @param text : the text string to send
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function writeLine($text)
    {
        // $buff                   is a bin;
        // $bufflen                is a int;
        // $idx                    is a int;
        // $ch                     is a int;
        $buff = sprintf('%s\r\n', $text);
        $bufflen = strlen($buff)-2;
        if ($bufflen < 100) {
            $ch = 0x20;
            $idx = 0;
            while (($idx < $bufflen) && ($ch != 0)) {
                $ch = $buff[$idx];
                if (($ch >= 0x20) && ($ch < 0x7f)) {
                    $idx = $idx + 1;
                } else {
                    $ch = 0;
                }
            }
            if ($idx >= $bufflen) {
                return $this->sendCommand(sprintf('!%s',$text));
            }
        }
        // send string using file upload
        return $this->_upload('txdata', $buff);
    }

    /**
     * Sends a MODBUS message (provided as a hexadecimal string) to the serial port.
     * The message must start with the slave address. The MODBUS CRC/LRC is
     * automatically added by the function. This function does not wait for a reply.
     * 
     * @param hexString : a hexadecimal message string, including device address but no CRC/LRC
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function writeMODBUS($hexString)
    {
        return $this->sendCommand(sprintf(':%s',$hexString));
    }

    /**
     * Reads data from the receive buffer as a string, starting at current stream position.
     * If data at current stream position is not available anymore in the receive buffer, the
     * function performs a short read.
     * 
     * @param nChars : the maximum number of characters to read
     * 
     * @return a string with receive buffer contents
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function readStr($nChars)
    {
        // $buff                   is a bin;
        // $bufflen                is a int;
        // $mult                   is a int;
        // $endpos                 is a int;
        // $startpos               is a int;
        // $missing                is a int;
        // $res                    is a str;
        if ($nChars > 65535) {
            $nChars = 65535;
        }
        // may throw an exception
        $buff = $this->_download(sprintf('rxdata.bin?pos=%d&len=%d', $this->_rxptr, $nChars));
        $bufflen = strlen($buff) - 1;
        $endpos = 0;
        $mult = 1;
        while (($bufflen > 0) && ($buff[$bufflen] != 64)) {
            $endpos = $endpos + $mult * ($buff[$bufflen] - 48);
            $mult = $mult * 10;
            $bufflen = $bufflen - 1;
        }
        $startpos = (($endpos - $bufflen) & (0x7fffffff));
        if ($startpos != $this->_rxptr) {
            $missing = (($startpos - $this->_rxptr) & (0x7fffffff));
            if ($missing > $nChars) {
                $nChars = 0;
                $this->_rxptr = $startpos;
            } else {
                $nChars = $nChars - $missing;
            }
        }
        if ($nChars > $bufflen) {
            $nChars = $bufflen;
        }
        $this->_rxptr = $endpos - ($bufflen - $nChars);
        $res = substr($buff,  0, $nChars);
        return $res;
    }

    /**
     * Reads data from the receive buffer as a hexadecimal string, starting at current stream position.
     * If data at current stream position is not available anymore in the receive buffer, the
     * function performs a short read.
     * 
     * @param nBytes : the maximum number of bytes to read
     * 
     * @return a string with receive buffer contents, encoded in hexadecimal
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function readHex($nBytes)
    {
        // $buff                   is a bin;
        // $bufflen                is a int;
        // $mult                   is a int;
        // $endpos                 is a int;
        // $startpos               is a int;
        // $missing                is a int;
        // $ofs                    is a int;
        // $res                    is a str;
        if ($nBytes > 65535) {
            $nBytes = 65535;
        }
        // may throw an exception
        $buff = $this->_download(sprintf('rxdata.bin?pos=%d&len=%d', $this->_rxptr, $nBytes));
        $bufflen = strlen($buff)-1;
        $endpos = 0;
        $mult = 1;
        while (($bufflen > 0) && ($buff[$bufflen] != 64)) {
            $endpos = $endpos + $mult * ($buff[$bufflen] - 48);
            $mult = $mult * 10;
            $bufflen = $bufflen - 1;
        }
        $startpos = (($endpos - $bufflen) & (0x7fffffff));
        if ($startpos != $this->_rxptr) {
            $missing = (($startpos - $this->_rxptr) & (0x7fffffff));
            if ($missing > $nBytes) {
                $nBytes = 0;
                $this->_rxptr = $startpos;
            } else {
                $nBytes = $nBytes - $missing;
            }
        }
        if ($nBytes > $bufflen) {
            $nBytes = $bufflen;
        }
        $this->_rxptr = $endpos - ($bufflen - $nBytes);
        $res = '';
        $ofs = 0;
        while ($ofs+3 < $nBytes) {
            $res = sprintf('%s%02x%02x%02x%02x', $res, $buff[$ofs], $buff[$ofs+1], $buff[$ofs+2], $buff[$ofs+3]);
            $ofs = $ofs + 4;
        }
        while ($ofs < $nBytes) {
            $res = sprintf('%s%02x', $res, $buff[$ofs]);
            $ofs = $ofs + 1;
        }
        return $res;
    }

    /**
     * Reads a single line (or message) from the receive buffer, starting at current stream position.
     * This function is intended to be used when the serial port is configured for a message protocol,
     * such as 'Line' mode or MODBUS protocols.
     * 
     * If data at current stream position is not available anymore in the receive buffer,
     * the function returns the oldest available line and moves the stream position just after.
     * If no new full line is received, the function returns an empty line.
     * 
     * @return a string with a single line of text
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function readLine()
    {
        // $url                    is a str;
        // $msgbin                 is a bin;
        $msgarr = Array();      // strArr;
        // $msglen                 is a int;
        // $res                    is a str;
        // may throw an exception
        $url = sprintf('rxmsg.json?pos=%d&len=1&maxw=1', $this->_rxptr);
        $msgbin = $this->_download($url);
        $msgarr = $this->_json_get_array($msgbin);
        $msglen = sizeof($msgarr);
        if ($msglen == 0) {
            return '';
        }
        // last element of array is the new position
        $msglen = $msglen - 1;
        $this->_rxptr = intVal($msgarr[$msglen]);
        if ($msglen == 0) {
            return '';
        }
        $res = $this->_json_get_string($msgarr[0]);
        return $res;
    }

    /**
     * Searches for incoming messages in the serial port receive buffer matching a given pattern,
     * starting at current position. This function will only compare and return printable characters
     * in the message strings. Binary protocols are handled as hexadecimal strings.
     * 
     * The search returns all messages matching the expression provided as argument in the buffer.
     * If no matching message is found, the search waits for one up to the specified maximum timeout
     * (in milliseconds).
     * 
     * @param pattern : a limited regular expression describing the expected message format,
     *         or an empty string if all messages should be returned (no filtering).
     *         When using binary protocols, the format applies to the hexadecimal
     *         representation of the message.
     * @param maxWait : the maximum number of milliseconds to wait for a message if none is found
     *         in the receive buffer.
     * 
     * @return an array of strings containing the messages found, if any.
     *         Binary messages are converted to hexadecimal representation.
     * 
     * On failure, throws an exception or returns an empty array.
     */
    public function readMessages($pattern,$maxWait)
    {
        // $url                    is a str;
        // $msgbin                 is a bin;
        $msgarr = Array();      // strArr;
        // $msglen                 is a int;
        $res = Array();         // strArr;
        // $idx                    is a int;
        // may throw an exception
        $url = sprintf('rxmsg.json?pos=%d&maxw=%d&pat=%s', $this->_rxptr, $maxWait, $pattern);
        $msgbin = $this->_download($url);
        $msgarr = $this->_json_get_array($msgbin);
        $msglen = sizeof($msgarr);
        if ($msglen == 0) {
            return $res;
        }
        // last element of array is the new position
        $msglen = $msglen - 1;
        $this->_rxptr = intVal($msgarr[$msglen]);
        $idx = 0;
        while ($idx < $msglen) {
            $res[] = $this->_json_get_string($msgarr[$idx]);
            $idx = $idx + 1;
        }
        return $res;
    }

    /**
     * Changes the current internal stream position to the specified value. This function
     * does not affect the device, it only changes the value stored in the YSerialPort object
     * for the next read operations.
     * 
     * @param absPos : the absolute position index for next read operations.
     * 
     * @return nothing.
     */
    public function read_seek($absPos)
    {
        $this->_rxptr = $absPos;
        return YAPI_SUCCESS;
    }

    /**
     * Returns the current absolute stream position pointer of the YSerialPort object.
     * 
     * @return the absolute position index for next read operations.
     */
    public function read_tell()
    {
        return $this->_rxptr;
    }

    /**
     * Sends a text line query to the serial port, and reads the reply, if any.
     * This function is intended to be used when the serial port is configured for 'Line' protocol.
     * 
     * @param query : the line query to send (without CR/LF)
     * @param maxWait : the maximum number of milliseconds to wait for a reply.
     * 
     * @return the next text line received after sending the text query, as a string.
     *         Additional lines can be obtained by calling readLine or readMessages.
     * 
     * On failure, throws an exception or returns an empty array.
     */
    public function queryLine($query,$maxWait)
    {
        // $url                    is a str;
        // $msgbin                 is a bin;
        $msgarr = Array();      // strArr;
        // $msglen                 is a int;
        // $res                    is a str;
        // may throw an exception
        $url = sprintf('rxmsg.json?len=1&maxw=%d&cmd=!%s', $maxWait, $query);
        $msgbin = $this->_download($url);
        $msgarr = $this->_json_get_array($msgbin);
        $msglen = sizeof($msgarr);
        if ($msglen == 0) {
            return '';
        }
        // last element of array is the new position
        $msglen = $msglen - 1;
        $this->_rxptr = intVal($msgarr[$msglen]);
        if ($msglen == 0) {
            return '';
        }
        $res = $this->_json_get_string($msgarr[0]);
        return $res;
    }

    /**
     * Sends a message to a specified MODBUS slave connected to the serial port, and reads the
     * reply, if any. The message is the PDU, provided as a vector of bytes.
     * 
     * @param slaveNo : the address of the slave MODBUS device to query
     * @param pduBytes : the message to send (PDU), as a vector of bytes. The first byte of the
     *         PDU is the MODBUS function code.
     * 
     * @return the received reply, as a vector of bytes.
     * 
     * On failure, throws an exception or returns an empty array (or a MODBUS error reply).
     */
    public function queryMODBUS($slaveNo,$pduBytes)
    {
        // $funCode                is a int;
        // $nib                    is a int;
        // $i                      is a int;
        // $cmd                    is a str;
        // $url                    is a str;
        // $pat                    is a str;
        // $msgs                   is a bin;
        $reps = Array();        // strArr;
        // $rep                    is a str;
        $res = Array();         // intArr;
        // $replen                 is a int;
        // $hexb                   is a int;
        $funCode = $pduBytes[0];
        $nib = (($funCode) >> (4));
        $pat = sprintf('%02x[%x%x]%x.*', $slaveNo, $nib, ($nib+8), (($funCode) & (15)));
        $cmd = sprintf('%02x%02x', $slaveNo, $funCode);
        $i = 1;
        while ($i < sizeof($pduBytes)) {
            $cmd = sprintf('%s%02x', $cmd, (($pduBytes[$i]) & (0xff)));
            $i = $i + 1;
        }
        // may throw an exception
        $url = sprintf('rxmsg.json?cmd=:%s&pat=:%s', $cmd, $pat);
        $msgs = $this->_download($url);
        $reps = $this->_json_get_array($msgs);
        if (!(sizeof($reps) > 1)) return $this->_throw( YAPI_IO_ERROR, 'no reply from slave',$res);
        if (sizeof($reps) > 1) {
            $rep = $this->_json_get_string($reps[0]);
            $replen = ((strlen($rep) - 3) >> (1));
            $i = 0;
            while ($i < $replen) {
                $hexb = hexdec(substr($rep, 2 * $i + 3, 2));
                $res[] = $hexb;
                $i = $i + 1;
            }
            if ($res[0] != $funCode) {
                $i = $res[1];
                if (!($i > 1)) return $this->_throw( YAPI_NOT_SUPPORTED, 'MODBUS error: unsupported function code',$res);
                if (!($i > 2)) return $this->_throw( YAPI_INVALID_ARGUMENT, 'MODBUS error: illegal data address',$res);
                if (!($i > 3)) return $this->_throw( YAPI_INVALID_ARGUMENT, 'MODBUS error: illegal data value',$res);
                if (!($i > 4)) return $this->_throw( YAPI_INVALID_ARGUMENT, 'MODBUS error: failed to execute function',$res);
            }
        }
        return $res;
    }

    /**
     * Reads one or more contiguous internal bits (or coil status) from a MODBUS serial device.
     * This method uses the MODBUS function code 0x01 (Read Coils).
     * 
     * @param slaveNo : the address of the slave MODBUS device to query
     * @param pduAddr : the relative address of the first bit/coil to read (zero-based)
     * @param nBits : the number of bits/coils to read
     * 
     * @return a vector of integers, each corresponding to one bit.
     * 
     * On failure, throws an exception or returns an empty array.
     */
    public function modbusReadBits($slaveNo,$pduAddr,$nBits)
    {
        $pdu = Array();         // intArr;
        $reply = Array();       // intArr;
        $res = Array();         // intArr;
        // $bitpos                 is a int;
        // $idx                    is a int;
        // $val                    is a int;
        // $mask                   is a int;
        $pdu[] = 0x01;
        $pdu[] = (($pduAddr) >> (8));
        $pdu[] = (($pduAddr) & (0xff));
        $pdu[] = (($nBits) >> (8));
        $pdu[] = (($nBits) & (0xff));
        // may throw an exception
        $reply = $this->queryMODBUS($slaveNo, $pdu);
        if (sizeof($reply) == 0) {
            return $res;
        }
        if ($reply[0] != $pdu[0]) {
            return $res;
        }
        $bitpos = 0;
        $idx = 2;
        $val = $reply[$idx];
        $mask = 1;
        while ($bitpos < $nBits) {
            if ((($val) & ($mask)) == 0) {
                $res[] = 0;
            } else {
                $res[] = 1;
            }
            $bitpos = $bitpos + 1;
            if ($mask == 0x80) {
                $idx = $idx + 1;
                $val = $reply[$idx];
                $mask = 1;
            } else {
                $mask = (($mask) << (1));
            }
        }
        return $res;
    }

    /**
     * Reads one or more contiguous input bits (or discrete inputs) from a MODBUS serial device.
     * This method uses the MODBUS function code 0x02 (Read Discrete Inputs).
     * 
     * @param slaveNo : the address of the slave MODBUS device to query
     * @param pduAddr : the relative address of the first bit/input to read (zero-based)
     * @param nBits : the number of bits/inputs to read
     * 
     * @return a vector of integers, each corresponding to one bit.
     * 
     * On failure, throws an exception or returns an empty array.
     */
    public function modbusReadInputBits($slaveNo,$pduAddr,$nBits)
    {
        $pdu = Array();         // intArr;
        $reply = Array();       // intArr;
        $res = Array();         // intArr;
        // $bitpos                 is a int;
        // $idx                    is a int;
        // $val                    is a int;
        // $mask                   is a int;
        $pdu[] = 0x02;
        $pdu[] = (($pduAddr) >> (8));
        $pdu[] = (($pduAddr) & (0xff));
        $pdu[] = (($nBits) >> (8));
        $pdu[] = (($nBits) & (0xff));
        // may throw an exception
        $reply = $this->queryMODBUS($slaveNo, $pdu);
        if (sizeof($reply) == 0) {
            return $res;
        }
        if ($reply[0] != $pdu[0]) {
            return $res;
        }
        $bitpos = 0;
        $idx = 2;
        $val = $reply[$idx];
        $mask = 1;
        while ($bitpos < $nBits) {
            if ((($val) & ($mask)) == 0) {
                $res[] = 0;
            } else {
                $res[] = 1;
            }
            $bitpos = $bitpos + 1;
            if ($mask == 0x80) {
                $idx = $idx + 1;
                $val = $reply[$idx];
                $mask = 1;
            } else {
                $mask = (($mask) << (1));
            }
        }
        return $res;
    }

    /**
     * Reads one or more contiguous internal registers (holding registers) from a MODBUS serial device.
     * This method uses the MODBUS function code 0x03 (Read Holding Registers).
     * 
     * @param slaveNo : the address of the slave MODBUS device to query
     * @param pduAddr : the relative address of the first holding register to read (zero-based)
     * @param nWords : the number of holding registers to read
     * 
     * @return a vector of integers, each corresponding to one 16-bit register value.
     * 
     * On failure, throws an exception or returns an empty array.
     */
    public function modbusReadRegisters($slaveNo,$pduAddr,$nWords)
    {
        $pdu = Array();         // intArr;
        $reply = Array();       // intArr;
        $res = Array();         // intArr;
        // $regpos                 is a int;
        // $idx                    is a int;
        // $val                    is a int;
        $pdu[] = 0x03;
        $pdu[] = (($pduAddr) >> (8));
        $pdu[] = (($pduAddr) & (0xff));
        $pdu[] = (($nWords) >> (8));
        $pdu[] = (($nWords) & (0xff));
        // may throw an exception
        $reply = $this->queryMODBUS($slaveNo, $pdu);
        if (sizeof($reply) == 0) {
            return $res;
        }
        if ($reply[0] != $pdu[0]) {
            return $res;
        }
        $regpos = 0;
        $idx = 2;
        while ($regpos < $nWords) {
            $val = (($reply[$idx]) << (8));
            $idx = $idx + 1;
            $val = $val + $reply[$idx];
            $idx = $idx + 1;
            $res[] = $val;
            $regpos = $regpos + 1;
        }
        return $res;
    }

    /**
     * Reads one or more contiguous input registers (read-only registers) from a MODBUS serial device.
     * This method uses the MODBUS function code 0x04 (Read Input Registers).
     * 
     * @param slaveNo : the address of the slave MODBUS device to query
     * @param pduAddr : the relative address of the first input register to read (zero-based)
     * @param nWords : the number of input registers to read
     * 
     * @return a vector of integers, each corresponding to one 16-bit input value.
     * 
     * On failure, throws an exception or returns an empty array.
     */
    public function modbusReadInputRegisters($slaveNo,$pduAddr,$nWords)
    {
        $pdu = Array();         // intArr;
        $reply = Array();       // intArr;
        $res = Array();         // intArr;
        // $regpos                 is a int;
        // $idx                    is a int;
        // $val                    is a int;
        $pdu[] = 0x04;
        $pdu[] = (($pduAddr) >> (8));
        $pdu[] = (($pduAddr) & (0xff));
        $pdu[] = (($nWords) >> (8));
        $pdu[] = (($nWords) & (0xff));
        // may throw an exception
        $reply = $this->queryMODBUS($slaveNo, $pdu);
        if (sizeof($reply) == 0) {
            return $res;
        }
        if ($reply[0] != $pdu[0]) {
            return $res;
        }
        $regpos = 0;
        $idx = 2;
        while ($regpos < $nWords) {
            $val = (($reply[$idx]) << (8));
            $idx = $idx + 1;
            $val = $val + $reply[$idx];
            $idx = $idx + 1;
            $res[] = $val;
            $regpos = $regpos + 1;
        }
        return $res;
    }

    /**
     * Sets a single internal bit (or coil) on a MODBUS serial device.
     * This method uses the MODBUS function code 0x05 (Write Single Coil).
     * 
     * @param slaveNo : the address of the slave MODBUS device to drive
     * @param pduAddr : the relative address of the bit/coil to set (zero-based)
     * @param value : the value to set (0 for OFF state, non-zero for ON state)
     * 
     * @return the number of bits/coils affected on the device (1)
     * 
     * On failure, throws an exception or returns zero.
     */
    public function modbusWriteBit($slaveNo,$pduAddr,$value)
    {
        $pdu = Array();         // intArr;
        $reply = Array();       // intArr;
        // $res                    is a int;
        $res = 0;
        if ($value != 0) {
            $value = 0xff;
        }
        $pdu[] = 0x05;
        $pdu[] = (($pduAddr) >> (8));
        $pdu[] = (($pduAddr) & (0xff));
        $pdu[] = $value;
        $pdu[] = 0x00;
        // may throw an exception
        $reply = $this->queryMODBUS($slaveNo, $pdu);
        if (sizeof($reply) == 0) {
            return $res;
        }
        if ($reply[0] != $pdu[0]) {
            return $res;
        }
        $res = 1;
        return $res;
    }

    /**
     * Sets several contiguous internal bits (or coils) on a MODBUS serial device.
     * This method uses the MODBUS function code 0x0f (Write Multiple Coils).
     * 
     * @param slaveNo : the address of the slave MODBUS device to drive
     * @param pduAddr : the relative address of the first bit/coil to set (zero-based)
     * @param bits : the vector of bits to be set (one integer per bit)
     * 
     * @return the number of bits/coils affected on the device
     * 
     * On failure, throws an exception or returns zero.
     */
    public function modbusWriteBits($slaveNo,$pduAddr,$bits)
    {
        // $nBits                  is a int;
        // $nBytes                 is a int;
        // $bitpos                 is a int;
        // $val                    is a int;
        // $mask                   is a int;
        $pdu = Array();         // intArr;
        $reply = Array();       // intArr;
        // $res                    is a int;
        $res = 0;
        $nBits = sizeof($bits);
        $nBytes = ((($nBits + 7)) >> (3));
        $pdu[] = 0x0f;
        $pdu[] = (($pduAddr) >> (8));
        $pdu[] = (($pduAddr) & (0xff));
        $pdu[] = (($nBits) >> (8));
        $pdu[] = (($nBits) & (0xff));
        $pdu[] = $nBytes;
        $bitpos = 0;
        $val = 0;
        $mask = 1;
        while ($bitpos < $nBits) {
            if ($bits[$bitpos] != 0) {
                $val = (($val) | ($mask));
            }
            $bitpos = $bitpos + 1;
            if ($mask == 0x80) {
                $pdu[] = $val;
                $val = 0;
                $mask = 1;
            } else {
                $mask = (($mask) << (1));
            }
        }
        if ($mask != 1) {
            $pdu[] = $val;
        }
        // may throw an exception
        $reply = $this->queryMODBUS($slaveNo, $pdu);
        if (sizeof($reply) == 0) {
            return $res;
        }
        if ($reply[0] != $pdu[0]) {
            return $res;
        }
        $res = (($reply[3]) << (8));
        $res = $res + $reply[4];
        return $res;
    }

    /**
     * Sets a single internal register (or holding register) on a MODBUS serial device.
     * This method uses the MODBUS function code 0x06 (Write Single Register).
     * 
     * @param slaveNo : the address of the slave MODBUS device to drive
     * @param pduAddr : the relative address of the register to set (zero-based)
     * @param value : the 16 bit value to set
     * 
     * @return the number of registers affected on the device (1)
     * 
     * On failure, throws an exception or returns zero.
     */
    public function modbusWriteRegister($slaveNo,$pduAddr,$value)
    {
        $pdu = Array();         // intArr;
        $reply = Array();       // intArr;
        // $res                    is a int;
        $res = 0;
        if ($value != 0) {
            $value = 0xff;
        }
        $pdu[] = 0x06;
        $pdu[] = (($pduAddr) >> (8));
        $pdu[] = (($pduAddr) & (0xff));
        $pdu[] = (($value) >> (8));
        $pdu[] = (($value) & (0xff));
        // may throw an exception
        $reply = $this->queryMODBUS($slaveNo, $pdu);
        if (sizeof($reply) == 0) {
            return $res;
        }
        if ($reply[0] != $pdu[0]) {
            return $res;
        }
        $res = 1;
        return $res;
    }

    /**
     * Sets several contiguous internal registers (or holding registers) on a MODBUS serial device.
     * This method uses the MODBUS function code 0x10 (Write Multiple Registers).
     * 
     * @param slaveNo : the address of the slave MODBUS device to drive
     * @param pduAddr : the relative address of the first internal register to set (zero-based)
     * @param values : the vector of 16 bit values to set
     * 
     * @return the number of registers affected on the device
     * 
     * On failure, throws an exception or returns zero.
     */
    public function modbusWriteRegisters($slaveNo,$pduAddr,$values)
    {
        // $nWords                 is a int;
        // $nBytes                 is a int;
        // $regpos                 is a int;
        // $val                    is a int;
        $pdu = Array();         // intArr;
        $reply = Array();       // intArr;
        // $res                    is a int;
        $res = 0;
        $nWords = sizeof($values);
        $nBytes = 2 * $nWords;
        $pdu[] = 0x10;
        $pdu[] = (($pduAddr) >> (8));
        $pdu[] = (($pduAddr) & (0xff));
        $pdu[] = (($nWords) >> (8));
        $pdu[] = (($nWords) & (0xff));
        $pdu[] = $nBytes;
        $regpos = 0;
        while ($regpos < $nWords) {
            $val = $values[$regpos];
            $pdu[] = (($val) >> (8));
            $pdu[] = (($val) & (0xff));
            $regpos = $regpos + 1;
        }
        // may throw an exception
        $reply = $this->queryMODBUS($slaveNo, $pdu);
        if (sizeof($reply) == 0) {
            return $res;
        }
        if ($reply[0] != $pdu[0]) {
            return $res;
        }
        $res = (($reply[3]) << (8));
        $res = $res + $reply[4];
        return $res;
    }

    /**
     * Sets several contiguous internal registers (holding registers) on a MODBUS serial device,
     * then performs a contiguous read of a set of (possibly different) internal registers.
     * This method uses the MODBUS function code 0x17 (Read/Write Multiple Registers).
     * 
     * @param slaveNo : the address of the slave MODBUS device to drive
     * @param pduWriteAddr : the relative address of the first internal register to set (zero-based)
     * @param values : the vector of 16 bit values to set
     * @param pduReadAddr : the relative address of the first internal register to read (zero-based)
     * @param nReadWords : the number of 16 bit values to read
     * 
     * @return a vector of integers, each corresponding to one 16-bit register value read.
     * 
     * On failure, throws an exception or returns an empty array.
     */
    public function modbusWriteAndReadRegisters($slaveNo,$pduWriteAddr,$values,$pduReadAddr,$nReadWords)
    {
        // $nWriteWords            is a int;
        // $nBytes                 is a int;
        // $regpos                 is a int;
        // $val                    is a int;
        // $idx                    is a int;
        $pdu = Array();         // intArr;
        $reply = Array();       // intArr;
        $res = Array();         // intArr;
        $nWriteWords = sizeof($values);
        $nBytes = 2 * $nWriteWords;
        $pdu[] = 0x17;
        $pdu[] = (($pduReadAddr) >> (8));
        $pdu[] = (($pduReadAddr) & (0xff));
        $pdu[] = (($nReadWords) >> (8));
        $pdu[] = (($nReadWords) & (0xff));
        $pdu[] = (($pduWriteAddr) >> (8));
        $pdu[] = (($pduWriteAddr) & (0xff));
        $pdu[] = (($nWriteWords) >> (8));
        $pdu[] = (($nWriteWords) & (0xff));
        $pdu[] = $nBytes;
        $regpos = 0;
        while ($regpos < $nWriteWords) {
            $val = $values[$regpos];
            $pdu[] = (($val) >> (8));
            $pdu[] = (($val) & (0xff));
            $regpos = $regpos + 1;
        }
        // may throw an exception
        $reply = $this->queryMODBUS($slaveNo, $pdu);
        if (sizeof($reply) == 0) {
            return $res;
        }
        if ($reply[0] != $pdu[0]) {
            return $res;
        }
        $regpos = 0;
        $idx = 2;
        while ($regpos < $nReadWords) {
            $val = (($reply[$idx]) << (8));
            $idx = $idx + 1;
            $val = $val + $reply[$idx];
            $idx = $idx + 1;
            $res[] = $val;
            $regpos = $regpos + 1;
        }
        return $res;
    }

    public function serialMode()
    { return $this->get_serialMode(); }

    public function setSerialMode($newval)
    { return $this->set_serialMode($newval); }

    public function protocol()
    { return $this->get_protocol(); }

    public function setProtocol($newval)
    { return $this->set_protocol($newval); }

    public function rxCount()
    { return $this->get_rxCount(); }

    public function txCount()
    { return $this->get_txCount(); }

    public function errCount()
    { return $this->get_errCount(); }

    public function rxMsgCount()
    { return $this->get_rxMsgCount(); }

    public function txMsgCount()
    { return $this->get_txMsgCount(); }

    public function lastMsg()
    { return $this->get_lastMsg(); }

    public function command()
    { return $this->get_command(); }

    public function setCommand($newval)
    { return $this->set_command($newval); }

    /**
     * Continues the enumeration of serial ports started using yFirstSerialPort().
     * 
     * @return a pointer to a YSerialPort object, corresponding to
     *         a serial port currently online, or a null pointer
     *         if there are no more serial ports to enumerate.
     */
    public function nextSerialPort()
    {   $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if($resolve->errorType != YAPI_SUCCESS) return null;
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if($next_hwid == null) return null;
        return yFindSerialPort($next_hwid);
    }

    /**
     * Starts the enumeration of serial ports currently accessible.
     * Use the method YSerialPort.nextSerialPort() to iterate on
     * next serial ports.
     * 
     * @return a pointer to a YSerialPort object, corresponding to
     *         the first serial port currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstSerialPort()
    {   $next_hwid = YAPI::getFirstHardwareId('SerialPort');
        if($next_hwid == null) return null;
        return self::FindSerialPort($next_hwid);
    }

    //--- (end of YSerialPort implementation)

};

//--- (SerialPort functions)

/**
 * Retrieves a serial port for a given identifier.
 * The identifier can be specified using several formats:
 * <ul>
 * <li>FunctionLogicalName</li>
 * <li>ModuleSerialNumber.FunctionIdentifier</li>
 * <li>ModuleSerialNumber.FunctionLogicalName</li>
 * <li>ModuleLogicalName.FunctionIdentifier</li>
 * <li>ModuleLogicalName.FunctionLogicalName</li>
 * </ul>
 * 
 * This function does not require that the serial port is online at the time
 * it is invoked. The returned object is nevertheless valid.
 * Use the method YSerialPort.isOnline() to test if the serial port is
 * indeed online at a given time. In case of ambiguity when looking for
 * a serial port by logical name, no error is notified: the first instance
 * found is returned. The search is performed first by hardware name,
 * then by logical name.
 * 
 * @param func : a string that uniquely characterizes the serial port
 * 
 * @return a YSerialPort object allowing you to drive the serial port.
 */
function yFindSerialPort($func)
{
    return YSerialPort::FindSerialPort($func);
}

/**
 * Starts the enumeration of serial ports currently accessible.
 * Use the method YSerialPort.nextSerialPort() to iterate on
 * next serial ports.
 * 
 * @return a pointer to a YSerialPort object, corresponding to
 *         the first serial port currently online, or a null pointer
 *         if there are none.
 */
function yFirstSerialPort()
{
    return YSerialPort::FirstSerialPort();
}

//--- (end of SerialPort functions)
?>