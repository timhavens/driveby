<?php
/*********************************************************************
 *
 * $Id: yocto_wireless.php 18013 2014-10-13 09:24:51Z seb $
 *
 * Implements yFindWireless(), the high-level API for Wireless functions
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
 *  THE SOFTWARE AND DOCUMENTATION ARE PROVIDED "AS IS" WITHOUT
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


//--- (generated code: return codes)
//--- (end of generated code: return codes)
//--- (generated code: YWireless definitions)
if(!defined('Y_SECURITY_UNKNOWN'))           define('Y_SECURITY_UNKNOWN',          0);
if(!defined('Y_SECURITY_OPEN'))              define('Y_SECURITY_OPEN',             1);
if(!defined('Y_SECURITY_WEP'))               define('Y_SECURITY_WEP',              2);
if(!defined('Y_SECURITY_WPA'))               define('Y_SECURITY_WPA',              3);
if(!defined('Y_SECURITY_WPA2'))              define('Y_SECURITY_WPA2',             4);
if(!defined('Y_SECURITY_INVALID'))           define('Y_SECURITY_INVALID',          -1);
if(!defined('Y_LINKQUALITY_INVALID'))        define('Y_LINKQUALITY_INVALID',       YAPI_INVALID_UINT);
if(!defined('Y_SSID_INVALID'))               define('Y_SSID_INVALID',              YAPI_INVALID_STRING);
if(!defined('Y_CHANNEL_INVALID'))            define('Y_CHANNEL_INVALID',           YAPI_INVALID_UINT);
if(!defined('Y_MESSAGE_INVALID'))            define('Y_MESSAGE_INVALID',           YAPI_INVALID_STRING);
if(!defined('Y_WLANCONFIG_INVALID'))         define('Y_WLANCONFIG_INVALID',        YAPI_INVALID_STRING);
//--- (end of generated code: YWireless definitions)

//--- (generated code: YWlanRecord definitions)
//--- (end of generated code: YWlanRecord definitions)

//--- (generated code: YWlanRecord declaration)
/**
 * YWlanRecord Class: Description of a wireless network
 * 
 * 
 */
class YWlanRecord
{
    //--- (end of generated code: YWlanRecord declaration)

    //--- (generated code: YWlanRecord attributes)
    protected $_ssid                     = "";                           // str
    protected $_channel                  = 0;                            // int
    protected $_sec                      = "";                           // str
    protected $_rssi                     = 0;                            // int
    //--- (end of generated code: YWlanRecord attributes)

    function __construct($str_json)
    {
        //--- (generated code: YWlanRecord constructor)
        //--- (end of generated code: YWlanRecord constructor)
        
        $loadval = json_decode($str_json, TRUE);
        $this->_ssid = $loadval['ssid'];
        $this->_channel = $loadval['channel'];
        $this->_sec = $loadval['sec'];
        $this->_rssi  = $loadval['rssi'];
    }

    //--- (generated code: YWlanRecord implementation)

    public function get_ssid()
    {
        return $this->_ssid;
    }

    public function get_channel()
    {
        return $this->_channel;
    }

    public function get_security()
    {
        return $this->_sec;
    }

    public function get_linkQuality()
    {
        return $this->_rssi;
    }

    //--- (end of generated code: YWlanRecord implementation)
}

//--- (generated code: YWireless declaration)
/**
 * YWireless Class: Wireless function interface
 * 
 * YWireless functions provides control over wireless network parameters
 * and status for devices that are wireless-enabled.
 */
class YWireless extends YFunction
{
    const LINKQUALITY_INVALID            = YAPI_INVALID_UINT;
    const SSID_INVALID                   = YAPI_INVALID_STRING;
    const CHANNEL_INVALID                = YAPI_INVALID_UINT;
    const SECURITY_UNKNOWN               = 0;
    const SECURITY_OPEN                  = 1;
    const SECURITY_WEP                   = 2;
    const SECURITY_WPA                   = 3;
    const SECURITY_WPA2                  = 4;
    const SECURITY_INVALID               = -1;
    const MESSAGE_INVALID                = YAPI_INVALID_STRING;
    const WLANCONFIG_INVALID             = YAPI_INVALID_STRING;
    //--- (end of generated code: YWireless declaration)

    //--- (generated code: YWireless attributes)
    protected $_linkQuality              = Y_LINKQUALITY_INVALID;        // Percent
    protected $_ssid                     = Y_SSID_INVALID;               // Text
    protected $_channel                  = Y_CHANNEL_INVALID;            // UInt31
    protected $_security                 = Y_SECURITY_INVALID;           // WLANSec
    protected $_message                  = Y_MESSAGE_INVALID;            // Text
    protected $_wlanConfig               = Y_WLANCONFIG_INVALID;         // WLANConfig
    //--- (end of generated code: YWireless attributes)

    function __construct($str_func)
    {
        //--- (generated code: YWireless constructor)
        parent::__construct($str_func);
        $this->_className = 'Wireless';

        //--- (end of generated code: YWireless constructor)
    }

    //--- (generated code: YWireless implementation)

    function _parseAttr($name, $val)
    {
        switch($name) {
        case 'linkQuality':
            $this->_linkQuality = intval($val);
            return 1;
        case 'ssid':
            $this->_ssid = $val;
            return 1;
        case 'channel':
            $this->_channel = intval($val);
            return 1;
        case 'security':
            $this->_security = intval($val);
            return 1;
        case 'message':
            $this->_message = $val;
            return 1;
        case 'wlanConfig':
            $this->_wlanConfig = $val;
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Returns the link quality, expressed in percent.
     * 
     * @return an integer corresponding to the link quality, expressed in percent
     * 
     * On failure, throws an exception or returns Y_LINKQUALITY_INVALID.
     */
    public function get_linkQuality()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_LINKQUALITY_INVALID;
            }
        }
        return $this->_linkQuality;
    }

    /**
     * Returns the wireless network name (SSID).
     * 
     * @return a string corresponding to the wireless network name (SSID)
     * 
     * On failure, throws an exception or returns Y_SSID_INVALID.
     */
    public function get_ssid()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_SSID_INVALID;
            }
        }
        return $this->_ssid;
    }

    /**
     * Returns the 802.11 channel currently used, or 0 when the selected network has not been found.
     * 
     * @return an integer corresponding to the 802.11 channel currently used, or 0 when the selected
     * network has not been found
     * 
     * On failure, throws an exception or returns Y_CHANNEL_INVALID.
     */
    public function get_channel()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_CHANNEL_INVALID;
            }
        }
        return $this->_channel;
    }

    /**
     * Returns the security algorithm used by the selected wireless network.
     * 
     * @return a value among Y_SECURITY_UNKNOWN, Y_SECURITY_OPEN, Y_SECURITY_WEP, Y_SECURITY_WPA and
     * Y_SECURITY_WPA2 corresponding to the security algorithm used by the selected wireless network
     * 
     * On failure, throws an exception or returns Y_SECURITY_INVALID.
     */
    public function get_security()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_SECURITY_INVALID;
            }
        }
        return $this->_security;
    }

    /**
     * Returns the latest status message from the wireless interface.
     * 
     * @return a string corresponding to the latest status message from the wireless interface
     * 
     * On failure, throws an exception or returns Y_MESSAGE_INVALID.
     */
    public function get_message()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_MESSAGE_INVALID;
            }
        }
        return $this->_message;
    }

    public function get_wlanConfig()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_WLANCONFIG_INVALID;
            }
        }
        return $this->_wlanConfig;
    }

    public function set_wlanConfig($newval)
    {
        $rest_val = $newval;
        return $this->_setAttr("wlanConfig",$rest_val);
    }

    /**
     * Retrieves a wireless lan interface for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     * 
     * This function does not require that the wireless lan interface is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method YWireless.isOnline() to test if the wireless lan interface is
     * indeed online at a given time. In case of ambiguity when looking for
     * a wireless lan interface by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     * 
     * @param func : a string that uniquely characterizes the wireless lan interface
     * 
     * @return a YWireless object allowing you to drive the wireless lan interface.
     */
    public static function FindWireless($func)
    {
        // $obj                    is a YWireless;
        $obj = YFunction::_FindFromCache('Wireless', $func);
        if ($obj == null) {
            $obj = new YWireless($func);
            YFunction::_AddToCache('Wireless', $func, $obj);
        }
        return $obj;
    }

    /**
     * Changes the configuration of the wireless lan interface to connect to an existing
     * access point (infrastructure mode).
     * Remember to call the saveToFlash() method and then to reboot the module to apply this setting.
     * 
     * @param ssid : the name of the network to connect to
     * @param securityKey : the network key, as a character string
     * 
     * @return YAPI_SUCCESS when the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function joinNetwork($ssid,$securityKey)
    {
        return $this->set_wlanConfig(sprintf('INFRA:%s\\%s', $ssid, $securityKey));
    }

    /**
     * Changes the configuration of the wireless lan interface to create an ad-hoc
     * wireless network, without using an access point. On the YoctoHub-Wireless-g,
     * it is best to use softAPNetworkInstead(), which emulates an access point
     * (Soft AP) which is more efficient and more widely supported than ad-hoc networks.
     * 
     * When a security key is specified for an ad-hoc network, the network is protected
     * by a WEP40 key (5 characters or 10 hexadecimal digits) or WEP128 key (13 characters
     * or 26 hexadecimal digits). It is recommended to use a well-randomized WEP128 key
     * using 26 hexadecimal digits to maximize security.
     * Remember to call the saveToFlash() method and then to reboot the module
     * to apply this setting.
     * 
     * @param ssid : the name of the network to connect to
     * @param securityKey : the network key, as a character string
     * 
     * @return YAPI_SUCCESS when the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function adhocNetwork($ssid,$securityKey)
    {
        return $this->set_wlanConfig(sprintf('ADHOC:%s\\%s', $ssid, $securityKey));
    }

    /**
     * Changes the configuration of the wireless lan interface to create a new wireless
     * network by emulating a WiFi access point (Soft AP). This function can only be
     * used with the YoctoHub-Wireless-g.
     * 
     * When a security key is specified for a SoftAP network, the network is protected
     * by a WEP40 key (5 characters or 10 hexadecimal digits) or WEP128 key (13 characters
     * or 26 hexadecimal digits). It is recommended to use a well-randomized WEP128 key
     * using 26 hexadecimal digits to maximize security.
     * Remember to call the saveToFlash() method and then to reboot the module to apply this setting.
     * 
     * @param ssid : the name of the network to connect to
     * @param securityKey : the network key, as a character string
     * 
     * @return YAPI_SUCCESS when the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function softAPNetwork($ssid,$securityKey)
    {
        return $this->set_wlanConfig(sprintf('SOFTAP:%s\\%s', $ssid, $securityKey));
    }

    /**
     * Returns a list of YWlanRecord objects that describe detected Wireless networks.
     * This list is not updated when the module is already connected to an acces point (infrastructure mode).
     * To force an update of this list, adhocNetwork() must be called to disconnect
     * the module from the current network. The returned list must be unallocated by the caller.
     * 
     * @return a list of YWlanRecord objects, containing the SSID, channel,
     *         link quality and the type of security of the wireless network.
     * 
     * On failure, throws an exception or returns an empty list.
     */
    public function get_detectedWlans()
    {
        // $json                   is a bin;
        $wlanlist = Array();    // strArr;
        $res = Array();         // YWlanRecordArr;
        // may throw an exception
        $json = $this->_download('wlan.json?by=name');
        $wlanlist = $this->_json_get_array($json);
        while(sizeof($res) > 0) { array_pop($res); };
        foreach($wlanlist as $each) {
            $res[] = new YWlanRecord($each);
        }
        return $res;
    }

    public function linkQuality()
    { return $this->get_linkQuality(); }

    public function ssid()
    { return $this->get_ssid(); }

    public function channel()
    { return $this->get_channel(); }

    public function security()
    { return $this->get_security(); }

    public function message()
    { return $this->get_message(); }

    public function wlanConfig()
    { return $this->get_wlanConfig(); }

    public function setWlanConfig($newval)
    { return $this->set_wlanConfig($newval); }

    /**
     * Continues the enumeration of wireless lan interfaces started using yFirstWireless().
     * 
     * @return a pointer to a YWireless object, corresponding to
     *         a wireless lan interface currently online, or a null pointer
     *         if there are no more wireless lan interfaces to enumerate.
     */
    public function nextWireless()
    {   $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if($resolve->errorType != YAPI_SUCCESS) return null;
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if($next_hwid == null) return null;
        return yFindWireless($next_hwid);
    }

    /**
     * Starts the enumeration of wireless lan interfaces currently accessible.
     * Use the method YWireless.nextWireless() to iterate on
     * next wireless lan interfaces.
     * 
     * @return a pointer to a YWireless object, corresponding to
     *         the first wireless lan interface currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstWireless()
    {   $next_hwid = YAPI::getFirstHardwareId('Wireless');
        if($next_hwid == null) return null;
        return self::FindWireless($next_hwid);
    }

    //--- (end of generated code: YWireless implementation)
};

//--- (generated code: Wireless functions)

/**
 * Retrieves a wireless lan interface for a given identifier.
 * The identifier can be specified using several formats:
 * <ul>
 * <li>FunctionLogicalName</li>
 * <li>ModuleSerialNumber.FunctionIdentifier</li>
 * <li>ModuleSerialNumber.FunctionLogicalName</li>
 * <li>ModuleLogicalName.FunctionIdentifier</li>
 * <li>ModuleLogicalName.FunctionLogicalName</li>
 * </ul>
 * 
 * This function does not require that the wireless lan interface is online at the time
 * it is invoked. The returned object is nevertheless valid.
 * Use the method YWireless.isOnline() to test if the wireless lan interface is
 * indeed online at a given time. In case of ambiguity when looking for
 * a wireless lan interface by logical name, no error is notified: the first instance
 * found is returned. The search is performed first by hardware name,
 * then by logical name.
 * 
 * @param func : a string that uniquely characterizes the wireless lan interface
 * 
 * @return a YWireless object allowing you to drive the wireless lan interface.
 */
function yFindWireless($func)
{
    return YWireless::FindWireless($func);
}

/**
 * Starts the enumeration of wireless lan interfaces currently accessible.
 * Use the method YWireless.nextWireless() to iterate on
 * next wireless lan interfaces.
 * 
 * @return a pointer to a YWireless object, corresponding to
 *         the first wireless lan interface currently online, or a null pointer
 *         if there are none.
 */
function yFirstWireless()
{
    return YWireless::FirstWireless();
}

//--- (end of generated code: Wireless functions)
?>