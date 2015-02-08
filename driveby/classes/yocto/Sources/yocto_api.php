<?php
/*********************************************************************
 *
 * $Id: yocto_api.php 18040 2014-10-14 15:51:09Z seb $
 *
 * High-level programming interface, common to all modules
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

//--- (generated code: YFunction definitions)
// Yoctopuce error codes, also used by default as function return value
define('YAPI_SUCCESS',                 0);     // everything worked all right
define('YAPI_NOT_INITIALIZED',         -1);    // call yInitAPI() first !
define('YAPI_INVALID_ARGUMENT',        -2);    // one of the arguments passed to the function is invalid
define('YAPI_NOT_SUPPORTED',           -3);    // the operation attempted is (currently) not supported
define('YAPI_DEVICE_NOT_FOUND',        -4);    // the requested device is not reachable
define('YAPI_VERSION_MISMATCH',        -5);    // the device firmware is incompatible with this API version
define('YAPI_DEVICE_BUSY',             -6);    // the device is busy with another task and cannot answer
define('YAPI_TIMEOUT',                 -7);    // the device took too long to provide an answer
define('YAPI_IO_ERROR',                -8);    // there was an I/O problem while talking to the device
define('YAPI_NO_MORE_DATA',            -9);    // there is no more data to read from
define('YAPI_EXHAUSTED',               -10);   // you have run out of a limited resource, check the documentation
define('YAPI_DOUBLE_ACCES',            -11);   // you have two process that try to access to the same device
define('YAPI_UNAUTHORIZED',            -12);   // unauthorized access to password-protected device
define('YAPI_RTC_NOT_READY',           -13);   // real-time clock has not been initialized (or time was lost)
define('YAPI_FILE_NOT_FOUND',          -14);   // the file is not found

define('YAPI_INVALID_INT',             0x7fffffff);
define('YAPI_INVALID_UINT',            -1);
define('YAPI_INVALID_LONG',            0x7fffffffffffffff);
define('YAPI_INVALID_DOUBLE',          -66666666.66666666);
define('YAPI_INVALID_STRING',          "!INVALID!");

define('Y_FUNCTIONDESCRIPTOR_INVALID', YAPI_INVALID_STRING);
define('Y_HARDWAREID_INVALID',         YAPI_INVALID_STRING);
define('Y_FUNCTIONID_INVALID',         YAPI_INVALID_STRING);
define('Y_FRIENDLYNAME_INVALID',       YAPI_INVALID_STRING);

if(!defined('Y_LOGICALNAME_INVALID'))        define('Y_LOGICALNAME_INVALID',       YAPI_INVALID_STRING);
if(!defined('Y_ADVERTISEDVALUE_INVALID'))    define('Y_ADVERTISEDVALUE_INVALID',   YAPI_INVALID_STRING);
//--- (end of generated code: YFunction definitions)

//--- (generated code: YMeasure definitions)
//--- (end of generated code: YMeasure definitions)
if(!defined('Y_DATA_INVALID'))               define('Y_DATA_INVALID',              YAPI_INVALID_DOUBLE);
if(!defined('Y_DURATION_INVALID'))           define('Y_DURATION_INVALID',          YAPI_INVALID_INT);

//--- (generated code: YFirmwareUpdate definitions)
//--- (end of generated code: YFirmwareUpdate definitions)

//--- (generated code: YDataStream definitions)
//--- (end of generated code: YDataStream definitions)

//--- (generated code: YDataSet definitions)
//--- (end of generated code: YDataSet definitions)

//--- (generated code: YSensor definitions)
if(!defined('Y_UNIT_INVALID'))               define('Y_UNIT_INVALID',              YAPI_INVALID_STRING);
if(!defined('Y_CURRENTVALUE_INVALID'))       define('Y_CURRENTVALUE_INVALID',      YAPI_INVALID_DOUBLE);
if(!defined('Y_LOWESTVALUE_INVALID'))        define('Y_LOWESTVALUE_INVALID',       YAPI_INVALID_DOUBLE);
if(!defined('Y_HIGHESTVALUE_INVALID'))       define('Y_HIGHESTVALUE_INVALID',      YAPI_INVALID_DOUBLE);
if(!defined('Y_CURRENTRAWVALUE_INVALID'))    define('Y_CURRENTRAWVALUE_INVALID',   YAPI_INVALID_DOUBLE);
if(!defined('Y_LOGFREQUENCY_INVALID'))       define('Y_LOGFREQUENCY_INVALID',      YAPI_INVALID_STRING);
if(!defined('Y_REPORTFREQUENCY_INVALID'))    define('Y_REPORTFREQUENCY_INVALID',   YAPI_INVALID_STRING);
if(!defined('Y_CALIBRATIONPARAM_INVALID'))   define('Y_CALIBRATIONPARAM_INVALID',  YAPI_INVALID_STRING);
if(!defined('Y_RESOLUTION_INVALID'))         define('Y_RESOLUTION_INVALID',        YAPI_INVALID_DOUBLE);
//--- (end of generated code: YSensor definitions)

//--- (generated code: YModule definitions)
if(!defined('Y_PERSISTENTSETTINGS_LOADED'))  define('Y_PERSISTENTSETTINGS_LOADED', 0);
if(!defined('Y_PERSISTENTSETTINGS_SAVED'))   define('Y_PERSISTENTSETTINGS_SAVED',  1);
if(!defined('Y_PERSISTENTSETTINGS_MODIFIED')) define('Y_PERSISTENTSETTINGS_MODIFIED', 2);
if(!defined('Y_PERSISTENTSETTINGS_INVALID')) define('Y_PERSISTENTSETTINGS_INVALID', -1);
if(!defined('Y_BEACON_OFF'))                 define('Y_BEACON_OFF',                0);
if(!defined('Y_BEACON_ON'))                  define('Y_BEACON_ON',                 1);
if(!defined('Y_BEACON_INVALID'))             define('Y_BEACON_INVALID',            -1);
if(!defined('Y_PRODUCTNAME_INVALID'))        define('Y_PRODUCTNAME_INVALID',       YAPI_INVALID_STRING);
if(!defined('Y_SERIALNUMBER_INVALID'))       define('Y_SERIALNUMBER_INVALID',      YAPI_INVALID_STRING);
if(!defined('Y_PRODUCTID_INVALID'))          define('Y_PRODUCTID_INVALID',         YAPI_INVALID_UINT);
if(!defined('Y_PRODUCTRELEASE_INVALID'))     define('Y_PRODUCTRELEASE_INVALID',    YAPI_INVALID_UINT);
if(!defined('Y_FIRMWARERELEASE_INVALID'))    define('Y_FIRMWARERELEASE_INVALID',   YAPI_INVALID_STRING);
if(!defined('Y_LUMINOSITY_INVALID'))         define('Y_LUMINOSITY_INVALID',        YAPI_INVALID_UINT);
if(!defined('Y_UPTIME_INVALID'))             define('Y_UPTIME_INVALID',            YAPI_INVALID_LONG);
if(!defined('Y_USBCURRENT_INVALID'))         define('Y_USBCURRENT_INVALID',        YAPI_INVALID_UINT);
if(!defined('Y_REBOOTCOUNTDOWN_INVALID'))    define('Y_REBOOTCOUNTDOWN_INVALID',   YAPI_INVALID_INT);
if(!defined('Y_USERVAR_INVALID'))            define('Y_USERVAR_INVALID',           YAPI_INVALID_INT);
//--- (end of generated code: YModule definitions)

// yInitAPI constants (not really useful in PHP, but defined for code portability)
define('Y_DETECT_NONE',                  0);
define('Y_DETECT_USB',                   1);
define('Y_DETECT_NET',                   2);
define('Y_DETECT_ALL',                   Y_DETECT_USB | Y_DETECT_NET);

// Calibration types
define('YOCTO_CALIB_TYPE_OFS',           30);

// Maximum device request timeout
define('YAPI_BLOCKING_REQUEST_TIMEOUT',  30000);

//
// Class used to report exceptions within Yocto-API
// Do not instantiate directly
//
class YAPI_Exception extends Exception {}

// Pseudo class used to create structures in PHP
class YAggregate {}

// numeric strpos helper

function Ystrpos($haystack, $needle)
{
    $res = strpos($haystack, $needle);
    if($res === false) $res = -1;
    return $res;
}

//
// Structure used internally to report results of a query. It only uses public attributes.
// Do not instantiate directly
//
class YAPI_YReq
{
    public $hwid       = "";
    public $deviceid   = "";
    public $functionid = "";
    public $errorType;
    public $errorMsg;
    public $result;

    function __construct($str_hwid, $int_errType, $str_errMsg, $obj_result)
    {
        $sep = strpos($str_hwid, ".");
        if($sep !== false) {
            $this->hwid       = $str_hwid;
            $this->deviceid   = substr($str_hwid, 0, $sep);
            $this->functionid = substr($str_hwid, $sep+1);
        }
        $this->errorType  = $int_errType;
        $this->errorMsg   = $str_errMsg;
        $this->result     = $obj_result;
    }
}

//
// YTcpHub Class (used internally)
//
// Instances of this class represent a VirtualHub or a networked Yoctopuce device
// to which we can connect to get access to device functions. For historical reasons,
// this class is mostly used like a structure, rather than a real object.
//
class YTcpHub
{
    // attributes
    public $rooturl;                    // root url of the hub (without auth parameters)
    public $streamaddr;                 // stream address of the hub ("tcp://addr:port")
    public $notifurl;                   // notification file used by this hub
    /** @var  YTcpReq */
    public $notifReq;                   // notification request, or null if not open
    public $notifPos;                   // absolute position in notification stream
    public $devListValidity;            // default validity of updateDeviceList
    public $devListExpires;             // timestamp of next useful updateDeviceList
    /** @var  YTcpReq */
    public $devListReq;                 // updateDeviceList request, or null if not open
    public $serialByYdx;                // serials by hub-specific devYdx
    public $retryDelay;                 // delay before reconnecting in case of error
    public $retryExpires;               // timestamp of next reconnection attempt
    public $missing;                    // list of missing devices during updateDeviceList
    public $writeProtected;             // true if an adminPassword is set
    public $user;                       // user for authentication
    public $callbackCache;              // pre-parsed cache for callback-based API
    public $reuseskt;                   // keep-alive socket to be reused
    protected $realm;                   // hub authentication realm
    protected $pwd;                     // password for authentication
    protected $nonce;                   // lasPrint(t received nonce
    protected $opaque;                  // last received opaque
    protected $ha1;                     // our authentication ha1 string
    protected $nc;                      // nounce usage count

    function __construct($rooturl, $auth)
    {
        $this->rooturl = $rooturl;
        $this->streamaddr = str_replace('http://', 'tcp://', $rooturl);
        $colon = strpos($auth, ':');
        if($colon === false) {
            $this->user = $auth;
            $this->pwd = '';
        } else {
            $this->user = substr($auth, 0, $colon);
            $this->pwd = substr($auth, $colon+1);
        }
        $this->notifurl = 'not.byn';
        $this->notifHandle = null;
        $this->notifPos = -1;
        $this->devListValidity = 500;
        $this->devListExpires = 0;
        $this->serialByYdx = Array();
        $this->retryDelay = 15;
        $this->retryExpires = 0;
        $this->writeProtected = false;
    }


    function verfiyStreamAddr(&$errmsg='')
    {
        if($this->streamaddr == 'tcp://CALLBACK/') {
            $data = file_get_contents('php://input','rb');
            if($data=="") {
                $errmsg = "RegisterHub(callback) used without posting YoctoAPI data";
                Print("\n!YoctoAPI:$errmsg\n");
                $this->callbackCache = Array();
                return -1;
            } else {
                $this->callbackCache = json_decode($data,true);
                if(is_null($this->callbackCache)) {
                    $errmsg = "invalid data:[\n$data\n]";
                    Print("\n!YoctoAPI:$errmsg\n");
                    $this->callbackCache = Array();
                    return -1;
                }
                if($this->pwd != '') {
                    // callback data signed, verify signature
                    if(!isset($this->callbackCache['sign'])) {
                        $errmsg = "missing signature from incoming YoctoHub (callback password required)";
                        Print("\n!YoctoAPI:$errmsg\n");
                        $this->callbackCache = Array();
                        return -1;
                    }
                    $sign = $this->callbackCache['sign'];
                    $salt = $this->pwd;
                    if(strlen($salt) != 32) $salt = md5($salt);
                    $data = str_replace($sign, strtolower($salt), $data);
                    $check = strtolower(md5($data));
                    if($check != $sign) {
                        //Print("Computed signature: $check\n");
                        //Print("Received signature: $sign\n");
                        $errmsg = "invalid signature from incoming YoctoHub (invalid callback password)";
                        Print("\n!YoctoAPI:$errmsg\n");
                        $this->callbackCache = Array();
                        return -1;
                    }
                }
            }
        } else {
            $this->callbackCache = NULL;
        }
        return 0;
    }
    // Update the hub internal variables according
    // to a received header with WWW-Authenticate
    function parseWWWAuthenticate($header)
    {
        $pos = stripos($header, "\r\nWWW-Authenticate:");
        if($pos === false) return;
        $header = substr($header, $pos+19);
        $eol = strpos($header, "\r");
        if($eol !== false) {
            $header = substr($header, 0, $eol);
        }
        $tags = null;
        if(preg_match_all('~(?<tag>\w+)="(?<value>[^"]*)"~m', $header, $tags) == false) {
            return;
        }
        $this->realm = '';
        $this->qop = '';
        $this->nonce = '';
        $this->opaque = '';
        for($i = 0; $i < sizeof($tags['tag']); $i++) {
            if($tags['tag'][$i] == "realm") {
                $this->realm = $tags['value'][$i];
            } else if($tags['tag'][$i] == "qop") {
                $this->qop = $tags['value'][$i];
            } else if($tags['tag'][$i] == "nonce") {
                $this->nonce = $tags['value'][$i];
            } else if($tags['tag'][$i] == "opaque") {
                $this->opaque = $tags['value'][$i];
            }
        }
        $this->nc = 0;
        $this->ha1 = md5($this->user.':'.$this->realm.':'.$this->pwd);
    }

    // Return an Authorization header for a given request
    function getAuthorization($request)
    {
        if($this->user == '' || $this->realm == '') return '';
        $this->nc++;
        $pos = strpos($request, ' ');
        $method = substr($request, 0, $pos);
        $uri = substr($request, $pos+1);
        $nc = sprintf("%08x", $this->nc);
        $cnonce = sprintf("%08x", mt_rand(0,0x7fffffff));
        $ha1 = $this->ha1;
        $ha2 = md5("{$method}:{$uri}");
        $nonce = $this->nonce;
        $response = md5("{$ha1}:{$nonce}:{$nc}:{$cnonce}:auth:{$ha2}");
        $res = 'Authorization: Digest username="'.$this->user.'", realm="'.$this->realm.'",'.
               ' nonce="'.$this->nonce.'", uri="'.$uri.'", qop=auth, nc='.$nc.','.
               ' cnonce="'.$cnonce.'", response="'.$response.'", opaque="'.$this->opaque.'"';
        return "$res\r\n";
    }

    // Return true if a hub is just a virtual cache (for callback mode)
    function isCachedHub()
    {
        return !is_null($this->callbackCache);
    }

    // Execute a query for cached hub (for callback mode)
    function cachedQuery($str_query, $str_body)
    {
        // apply POST remotely
        if(substr($str_query, 0, 5) == 'POST ') {
            $boundary = '???';
            $endb = strpos($str_body, "\r");
            if(substr($str_body, 0, 2)=='--' && $endb > 2 && $endb < 20) {
                $boundary = substr($str_body, 2, $endb-2);
            }
            Printf("\n@YoctoAPI:$str_query %d:%s\n%s", strlen($str_body), $boundary, $str_body);
            return "OK\r\n\r\n";
        }
        if(substr($str_query, 0, 4) != 'GET ')
            return NULL;
        // remove JZON trigger if present (not relevant in callback mode)
        $jzon = strpos($str_query, '?fw=');
        if($jzon !== FALSE && strpos($str_query, '&', $jzon) === FALSE) {
            $str_query = substr($str_query, 0, $jzon);
        }
        // dispatch between cached get and remote set
        if(strpos($str_query, '?') === FALSE ||
           strpos($str_query, '/logs.txt') !== FALSE ||
           strpos($str_query, '/logger.json') !== FALSE ||
           strpos($str_query, '/ping.txt') !== FALSE ||
           strpos($str_query, '/files.json?a=dir') !== FALSE) {
            // read request, load from cache
            $parts = explode(' ',$str_query);
            $url = $parts[1];
            $getmodule = (strpos($url, 'api/module.json') !== FALSE);
            if($getmodule) {
                $url = str_replace('api/module.json','api.json',$url);
            }
            if(!isset($this->callbackCache[$url])) {
                Print("\n!YoctoAPI:$url is not preloaded, adding to list");
                Print("\n@YoctoAPI:+$url\n");
                return NULL;
            }
            // Print("\n[$url found]\n");
            $jsonres = $this->callbackCache[$url];
            if($getmodule) $jsonres = $jsonres['module'];
            if(strpos($str_query, '.json') !== FALSE) {
                $jsonres = json_encode($jsonres);
            }
            return "OK\r\n\r\n$jsonres";
        } else {
            // change request, print to output stream
            Print("\n@YoctoAPI:$str_query\n");
            return "OK\r\n\r\n";
        }
    }
}

//
// YTcpReq Class (used internally)
//
// Instances of this class represent an open TCP connection to a HTTP socket.
// The class handles digest authorization transparently.
//
class YTcpReq
{
    // attributes
    /* @var $hub YTcpHub */
    public $hub;                        // the YTcpHub to which we connect
    public $async;                      // true if the request is async
    public $skt;                        // stream socket
    public $request;                    // request to be sent
    public $reqbody;                    // request body to send, if any
    public $boundary;                   // request body boundary, if used
    public $meta;                       // HTTP headers received in reply
    public $reply;                      // reply buffer
    public $retryCount;                 // number of retries for this request
    // the following attributes should not be taken for granted unless eof() returns true
    public $errorType;                  // status of current connection
    public $errorMsg;                   // last error message
    public $reqcnt;

    public static $totalTcpReqs = 0;

    function __construct($hub, $request, $async, $reqbody='')
    {
        $pos = strpos($request, "\r");
        if($pos !== false) {
            $request = substr($request, 0, $pos);
        }
        $boundary = '';
        if($reqbody != '') {
            do {
                $boundary = sprintf("Zz%06xzZ", mt_rand(0,0xffffff));
            } while(strpos($reqbody, $boundary) !== false);
            $reqbody = "--{$boundary}\r\n{$reqbody}\r\n--{$boundary}--\r\n";
        }
        $this->hub = $hub;
        $this->async = $async;
        $this->request = trim($request);
        $this->reqbody = $reqbody;
        $this->boundary = $boundary;
        $this->meta = '';
        $this->reply = '';
        $this->retryCount = 0;
        $this->errorType = YAPI_IO_ERROR;
        $this->errorMsg = 'could not open connection';
        $this->reqcnt = ++YTcpReq::$totalTcpReqs;
    }

    function eof()
    {
        if(!is_null($this->skt)) {
            // there is still activity going on
            return false;
        }
        if($this->meta != '' && $this->errorType == YAPI_SUCCESS) {
            // connection was done and ended successfully
            return true;
        }
        if($this->retryCount > 3) {
            // connection permanently failed
            return true;
        }
        // connection is expected to be reopened
        return false;
    }

    function newsocket(&$errno, &$errstr, $timeout)
    {
        // for now, use client socket only since server sockets
        // for callbacks are not reliably available on a public server
        return @stream_socket_client($this->hub->streamaddr, $errno, $errstr, $timeout);
    }


    function process(&$errmsg = '')
    {
        if($this->eof()) {
            if($this->errorType != YAPI_SUCCESS) {
                $errmsg = $this->errorMsg;
            }
            return $this->errorType;
        }
        if(!is_null($this->skt) && !is_resource($this->skt)) {
            // connection died, need to reopen
            $this->skt = null;
        }
        if(is_null($this->skt)) {
            // need to reopen connection
            if($this->hub->isCachedHub()) {
                // special handling for "connection-less" callback mode
                $data = $this->hub->cachedQuery($this->request, $this->reqbody);
                if(is_null($data)) {
                    $this->errorType = YAPI_NOT_SUPPORTED;
                    $this->errorMsg = "query is not available in callback mode";
                    $this->retryCount = 99;
                    return YAPI_SUCCESS; // will propagate error later if needed
                }
                $skt = fopen('data:text/plain;base64,'.base64_encode($data), 'rb');
                if ($skt === false) {
                    $this->errorType = YAPI_IO_ERROR;
                    $this->errorMsg = "failed to open data stream";
                    $this->retryCount = 99;
                    return YAPI_SUCCESS; // will propagate error later if needed
                }
                stream_set_blocking($skt, 0);
                $this->skt = $skt;
            } else {
                $skt = null;
                if(!is_null($this->hub->reuseskt)) {
                    $skt = $this->hub->reuseskt;
                    $this->hub->reuseskt = null;
                    if(!is_resource($skt)) {
                        // reusable socket is no more valid
                        $skt = null;
                    }
                }
                if(is_null($skt)) {
                    $errno = 0;
                    $errstr = '';
                    $skt = $this->newsocket($errno, $errstr, YAPI_BLOCKING_REQUEST_TIMEOUT / 1000);
                    if ($skt === false) {
                        $this->errorType = YAPI_IO_ERROR;
                        $this->errorMsg = "failed to open socket ($errno): $errstr";
                        $this->retryCount++;
                        return YAPI_SUCCESS; // will retry later
                    }
                }
                stream_set_blocking($skt, 0);
                $request = $this->request . " \r\n" . // no HTTP/1.1 suffix for light queries
                   $this->hub->getAuthorization($this->request);
                if($this->boundary != '') {
                    $request .= "Content-Type: multipart/form-data; boundary={$this->boundary}\r\n";
                }
                if(substr($this->request,-2) == "&.") {
                    $request .= "\r\n";
                } else {
                    $request .= "Connection: close\r\n\r\n";
                }
                $reqlen = strlen($request);
                if (fwrite($skt, $request, $reqlen) != $reqlen) {
                    fclose($skt);
                    $this->errorType = YAPI_IO_ERROR;
                    $this->errorMsg = "failed to write to socket";
                    $this->retryCount++;
                    return YAPI_SUCCESS; // will retry later
                }
                $this->skt = $skt;
            }
        } else {
            // read anything available on current socket, and process authentication headers
            while(true) {
                $data = fread($this->skt, 8192);
                if($data === false) {
                    $this->errorType = YAPI_IO_ERROR;
                    $this->errorMsg = "failed to read from socket";
                    $this->retryCount++;
                    return YAPI_SUCCESS; // will retry later
                }
                //Printf("[read %d bytes]\n",strlen($data));
                if(strlen($data) == 0) break;
                if($this->reply == '' && strpos($this->meta, "\r\n\r\n") === false) {
                    $this->meta .= $data;
                    $eoh = strpos($this->meta, "\r\n\r\n");
                    if($eoh !== false) {
                        // fully received header
                        $this->reply = substr($this->meta, $eoh+4);
                        $this->meta = substr($this->meta, 0, $eoh+4);
                        $firstline = substr($this->meta, 0, strpos($this->meta, "\r"));
                        if(substr($firstline, 0, 12) == 'HTTP/1.1 401') {
                            // authentication required
                            $this->errorType = YAPI_UNAUTHORIZED;
                            $this->errorMsg = "Authentication required";
                            fclose($this->skt);
                            $this->skt = null;
                            $this->hub->parseWWWAuthenticate($this->meta);
                            if($this->hub->user != '') {
                                $this->meta = '';
                                $this->reply = '';
                                $this->retryCount++;
                            } else {
                                $this->retryCount = 99;
                            }
                            return YAPI_SUCCESS; // will propagate error later if needed
                        }
                    }
                } else {
                    $this->reply .= $data;
                }
                // so far so good
                $this->errorType = YAPI_SUCCESS;
            }
            // write request body, if any, once header is fully received
            if($this->reqbody != '' && strpos($this->meta, "\r\n\r\n") !== false) {
                $bodylen = strlen($this->reqbody);
                $written = fwrite($this->skt, $this->reqbody, $bodylen);
                if($written > 0) {
                    $this->reqbody = substr($this->reqbody, $written);
                }
            }
            if(!is_resource($this->skt)) {
                // socket dropped dead
                $this->skt = null;
            } else if(feof($this->skt)) {
                fclose($this->skt);
                $this->skt = null;
            } else if($this->meta == "0K\r\n\r\n" && $this->reply == "\r\n") {
                if(is_null($this->hub->reuseskt)) {
                    $this->hub->reuseskt = $this->skt;
                } else {
                    fclose($this->skt);
                }
                $this->skt = null;
            }
        }
        return YAPI_SUCCESS;
    }

    function close()
    {
        if($this->skt) fclose($this->skt);
    }
}

//
// YFunctionType Class (used internally)
//
// Instances of this class stores everything we know about a given type of function:
// Mapping between function logical names and Hardware ID as discovered on hubs,
// and existing instances of YFunction (either already connected or simply requested).
// To keep it simple, this implementation separates completely the name resolution
// mechanism, implemented using the yellow pages, and the storage and retrieval of
// existing YFunction instances.
//

class YFunctionType
{
    // private attributes, to be used within yocto_api only
    protected $_className;
    protected $_connectedFns;           // functions requested and available, by Hardware Id
    protected $_requestedFns;           // functions requested but not yet known, by any type of name
    protected $_hwIdByName;             // hash table of function Hardware Id by logical name
    protected $_nameByHwId;             // hash table of function logical name by Hardware Id
    protected $_valueByHwId;            // hash table of function advertised value by logical name
    protected $_baseType;               // default to no abstract base type (generic YFunction)

    function __construct($str_classname)
    {
        if(ord($str_classname[strlen($str_classname)-1]) <= 57) throw new Exception("Invalid function type",-1);
        $this->_className     = $str_classname;
        $this->_connectedFns  = Array();
        $this->_requestedFns  = Array();
        $this->_hwIdByName    = Array();
        $this->_nameByHwId    = Array();
        $this->_valueByHwId   = Array();
        $this->_baseType      = 0;
    }

    // Index a single function given by HardwareId and logical name; store any advertised value
    // Return true iff there was a logical name discrepency
    public function reindexFunction($str_hwid, $str_name, $str_val, $int_basetype)
    {
        $currname = '';
        $res = false;
        if(isset($this->_nameByHwId[$str_hwid])) {
            $currname = $this->_nameByHwId[$str_hwid];
        }
        if($currname == '') {
            if($str_name != '') {
                $this->_nameByHwId[$str_hwid] = $str_name;
                $res = true;
            }
        } else if($currname != $str_name) {
            if($this->_hwIdByName[$currname] == $str_hwid)
                unset($this->_hwIdByName[$currname]);
            if($str_name != '') {
                $this->_nameByHwId[$str_hwid] = $str_name;
            } else {
                unset($this->_nameByHwId[$str_hwid]);
            }
            $res = true;
        }
        if($str_name != '') {
            $this->_hwIdByName[$str_name] = $str_hwid;
        }
        if(!is_null($str_val)) {
            $this->_valueByHwId[$str_hwid] = $str_val;
        } else {
            if(!isset($this->_valueByHwId[$str_hwid])) {
                $this->_valueByHwId[$str_hwid] = '';
            }
        }
        if(!is_null($int_basetype)) {
            if($this->_baseType == 0) {
                $this->_baseType = $int_basetype;
            }
        }
        return $res;
    }

    // Forget a disconnected function given by HardwareId
    public function forgetFunction($str_hwid)
    {
        if(isset($this->_nameByHwId[$str_hwid])) {
            $currname = $this->_nameByHwId[$str_hwid];
            if($currname != '' && $this->_hwIdByName[$currname] == $str_hwid) {
                unset($this->_hwIdByName[$currname]);
            }
            unset($this->_nameByHwId[$str_hwid]);
        }
        if(isset($this->_valueByHwId[$str_hwid])) {
            unset($this->_valueByHwId[$str_hwid]);
        }
    }

    // Find the exact Hardware Id of the specified function, if currently connected
    // If device is not known as connected, return a clean error
    // This function will not cause any network access
    public function resolve($str_func)
    {
        // Try to resolve str_func to a known Function instance, if possible, without any device access
        $dotpos = strpos($str_func, '.');
        if($dotpos === false) {
            // First case: str_func is the logicalname of a function
            if(isset($this->_hwIdByName[$str_func])) {
                return new YAPI_YReq($this->_hwIdByName[$str_func],
                                     YAPI_SUCCESS,
                                     'no error',
                                     $this->_hwIdByName[$str_func]);
            }

            // fallback to assuming that str_func is a logicalname or serial number of a module
            // with an implicit function name (like serial.module for instance)
            $dotpos = strlen($str_func);
            $str_func .= '.'.strtolower($this->_className[0]).substr($this->_className,1);
        }

        // Second case: str_func is in the form: device_id.function_id

        // quick lookup for a known pure hardware id
        if(isset($this->_valueByHwId[$str_func])) {
            return new YAPI_YReq($this->_valueByHwId[$str_func],
                                 YAPI_SUCCESS,
                                 'no error',
                                 $str_func);
        }
        if($dotpos>0){
            // either the device id is a logical name, or the function is unknown
            $devid = substr($str_func, 0, $dotpos);
            $funcid = substr($str_func, $dotpos+1);
            $dev = YAPI::getDevice($devid);
            if(!$dev) {
                return new YAPI_YReq($str_func,
                                     YAPI_DEVICE_NOT_FOUND,
                                     "Device [$devid] not online",
                                     null);
            }
            $serial = $dev->getSerialNumber();
            $res = "$serial.$funcid";
            if(isset($this->_valueByHwId[$res])) {
                return new YAPI_YReq($res,
                                     YAPI_SUCCESS,
                                     'no error',
                                     $res);
            }

            // not found neither, may be funcid is a function logicalname
            $nfun = $dev->functionCount();
            for($i = 0; $i < $nfun; $i++) {
                $res = "$serial.".$dev->functionId($i);
                if(isset($this->_nameByHwId[$res])) {
                    $name = $this->_nameByHwId[$res];
                    if($name == $funcid) {
                        return new YAPI_YReq($res,
                                             YAPI_SUCCESS,
                                             'no error',
                                             $res);
                    }
                }
            }
        } else {
            $serial = '';
            $funcid = substr($str_func, 1);
            // only functionId  (ie ".temperature")
            foreach(array_keys($this->_connectedFns) as $hwid_str){
                $pos = strpos($hwid_str, '.');
                $function = substr($hwid_str, $pos+1);
                //print("search for $funcid in {$this->_className} $function\n");
                if($function == $funcid){
                    return new YAPI_YReq($hwid_str,
                                         YAPI_SUCCESS,
                                         'no error',
                                         $hwid_str);
                }
            }
        }

        return new YAPI_YReq("$serial.$funcid",
                             YAPI_DEVICE_NOT_FOUND,
                             "No function [$funcid] found on device [$serial]",
                             null);
    }

    public function getFriendlyName($str_func)
    {
        $resolved = $this->resolve($str_func);
        if($resolved->errorType != YAPI_SUCCESS) {
            return $resolved;
        }

        if($this->_className =="Module"){
            $friend =$resolved->result;
            if(isset($this->_nameByHwId[$resolved->result]))
                $friend = $this->_nameByHwId[$resolved->result];
            return new YAPI_YReq($resolved->result,
                                 YAPI_SUCCESS,
                                 'no error',
                                 $friend);
        } else {
            $pos = strpos($resolved->result,'.');
            $serial_mod = substr($resolved->result,0,$pos);
            $friend_mod_full = YAPI::getFriendlyNameFunction("Module", $serial_mod)->result;
            $friend_mod = substr($friend_mod_full,0,strpos($friend_mod_full,'.'));
            $friend_func = substr($resolved->result,$pos+1);
            if(isset($this->_nameByHwId[$resolved->result]) && $this->_nameByHwId[$resolved->result]!= '')
                $friend_func = $this->_nameByHwId[$resolved->result];
            return new YAPI_YReq($resolved->result,
                                 YAPI_SUCCESS,
                                 'no error',
                                 $friend_mod.'.'.$friend_func);
        }
    }

    // Retrieve a function object by hardware id, updating the indexes on the fly if needed
    public function setFunction($str_func, $obj_func)
    {
        $funres = $this->resolve($str_func);
        if($funres->errorType == YAPI_SUCCESS) {
            // the function has been located on a device
            $this->_connectedFns[$funres->result] = $obj_func;
        } else {
            // the function is still abstract
            $this->_requestedFns[$str_func] = $obj_func;
        }
    }

    // Retrieve a function object by hardware id, updating the indexes on the fly if needed
    public function getFunction($str_func)
    {
        $funres = $this->resolve($str_func);
        if($funres->errorType == YAPI_SUCCESS) {
            // the function has been located on a device
            if(isset($this->_connectedFns[$funres->result]))
                return $this->_connectedFns[$funres->result];

            if(isset($this->_requestedFns[$str_func])) {
                $req_fn = $this->_requestedFns[$str_func];
                $this->_connectedFns[$funres->result] = $req_fn;
                unset($this->_requestedFns[$str_func]);
                return $req_fn;
            }
        } else {
            // the function is still abstract
            if(isset($this->_requestedFns[$str_func]))
                return $this->_requestedFns[$str_func];
        }
        return null;
    }

    // Stores a function advertised value by hardware id, queue an event if needed
    public function setFunctionValue($str_hwid, $str_pubval)
    {
        if(isset($this->_valueByHwId[$str_hwid]) &&
           $this->_valueByHwId[$str_hwid] == $str_pubval) {
            return;
        }
        $this->_valueByHwId[$str_hwid] = $str_pubval;
        foreach(YFunction::$_ValueCallbackList as $fun) {
            $hwId = $fun->_getHwId();
            if(!$hwId) continue;
            if($hwId == $str_hwid) {
                YAPI::addValueEvent($fun, $str_pubval);
            }
        }
    }

    // Retrieve a function advertised value by hardware id
    public function getFunctionValue($str_hwid)
    {
        return $this->_valueByHwId[$str_hwid];
    }

    // Stores a function advertised value by hardware id, queue an event if needed
    public function setTimedReport($str_hwid, $float_timestamp, $arr_report)
    {
        foreach(YFunction::$_TimedReportCallbackList as $fun) {
            $hwId = $fun->_getHwId();
            if(!$hwId) continue;
            if($hwId == $str_hwid) {
                YAPI::addTimedReportEvent($fun, $float_timestamp, $arr_report);
            }
        }
    }

    // Return the basetype of this function class
    public function getBaseType()
    {
        return $this->_baseType;
    }

    // Find the the hardwareId of the first instance of a given function class
    public function getFirstHardwareId()
    {
        foreach(array_keys($this->_valueByHwId) as $res) {
            return $res;
        }
        return null;
    }

    // Find the hardwareId for the next instance of a given function class
    public function getNextHardwareId($str_hwid)
    {
        foreach(array_keys($this->_valueByHwId) as $iter_hwid) {
            if($str_hwid == "!")
                return $iter_hwid;
            if($str_hwid == $iter_hwid)
                $str_hwid = "!";
        }
        return null; // no more instance found
    }
}

//
// YDevice Class (used internally)
//
// This class is used to store everything we know about connected Yocto-Devices.
// Instances are created when devices are discovered in the white pages
// (or registered manually, for root hubs) and then used to keep track of
// device naming changes. When a device or a function is renamed, this
// object forces the local indexes to be immediately updated, even if not
// yet fully propagated through the yellow pages of the device hub.
//
// In order to regroup multiple function queries on the same physical device,
// this class implements a device-wide API string cache (agnostic of API content).
// This is in addition to the function-specific cache implemented in YFunction.
//

class YDevice
{
    // private attributes, to be used within yocto_api only
    protected $_rootUrl;
    protected $_serialNumber;
    protected $_logicalName;
    protected $_productName;
    protected $_productId;
    protected $_beacon;
    protected $_deviceTime;
    protected $_devYdx;
    protected $_cache;
    protected $_functions;
    /**
     * @var YTcpReq
     */
    protected $_ongoingReq;
    public    $_lastErrorType;
    public    $_lastErrorMsg;

    function __construct($str_rooturl, $obj_wpRec=null, $obj_ypRecs=null)
    {
        $this->_rootUrl       = $str_rooturl;
        $this->_serialNumber  = '';
        $this->_logicalName   = '';
        $this->_productName   = '';
        $this->_productId     = 0;
        $this->_beacon        = 0;
        $this->_devYdx        = -1;
        $this->_cache         = Array('_expiration' => 0, '_json' => '');
        $this->_functions     = Array();
        $this->_lastErrorType = YAPI_SUCCESS;
        $this->_lastErrorMsg  = 'no error';

        if(!is_null($obj_wpRec)) {
            // preload values from white pages, if provided
            $this->_serialNumber = $obj_wpRec['serialNumber'];
            $this->_logicalName  = $obj_wpRec['logicalName'];
            $this->_productName  = $obj_wpRec['productName'];
            $this->_productId    = $obj_wpRec['productId'];
            $this->_beacon       = $obj_wpRec['beacon'];
            $this->_devYdx       = (isset($obj_wpRec['index']) ? $obj_wpRec['index'] : -1);
            $this->_updateFromYP($obj_ypRecs);
            YAPI::reindexDevice($this);
        } else {
            // preload values from device directly
            $this->refresh();
        }
    }

    // Throw an exception, keeping track of it in the object itself
    protected function _throw($int_errType, $str_errMsg, $obj_retVal)
    {
        $this->_lastErrorType = $int_errType;
        $this->_lastErrorMsg = $str_errMsg;

        if(YAPI::$exceptionsDisabled) {
            return $obj_retVal;
        }
        // throw an exception
        throw new YAPI_Exception($str_errMsg, $int_errType);
    }

    // Update device cache and YAPI function lists from yp records
    protected function _updateFromYP($obj_ypRecs)
    {
        $funidx = 0;
        foreach($obj_ypRecs as  $ypRec) {
            foreach($ypRec as $rec) {
                $hwid = $rec['hardwareId'];
                $dotpos = strpos($hwid, '.');
                if(substr($hwid, 0, $dotpos) == $this->_serialNumber) {
                    if(isset($rec['index'])) {
                        $funydx = $rec['index'];
                    } else {
                        $funydx = $funidx;
                    }
                    $this->_functions[$funydx] = Array(substr($hwid, $dotpos+1), $rec["logicalName"]);
                }
            }
        }
    }

    // Return the root URL used to access a device (including the trailing slash)
    public function getRootUrl()
    {
        return $this->_rootUrl;
    }

    // Return the serial number of the device, as found during discovery
    public function getSerialNumber()
    {
        return $this->_serialNumber;
    }

    // Return the logical name of the device, as found during discovery
    public function getLogicalName()
    {
        return $this->_logicalName;
    }

    // Return the product name of the device, as found during discovery
    public function getProductName()
    {
        return $this->_productName;
    }

    // Return the product Id of the device, as found during discovery
    public function getProductId()
    {
        return $this->_productId;
    }

    // Return the beacon state of the device, as found during discovery
    public function getBeacon()
    {
        return $this->_beacon;
    }

    // Return the beacon state of the device, as found during discovery
    public function getDeviceTime()
    {
        return $this->_deviceTime;
    }

    // Return the beacon state of the device, as found during discovery
    public function setDeviceTime($float_timestamp)
    {
        $this->_deviceTime = $float_timestamp;
    }

    // Return the hub-specific devYdx of the device, as found during discovery
    public function getDevYdx()
    {
        return $this->_devYdx;
    }

    // Return a string that describes the device (serial number, logical name or root URL)
    public function describe()
    {
        $res = $this->_rootUrl;
        if($this->_serialNumber != '') {
            $res = $this->_serialNumber;
            if($this->_logicalName != '') {
                $res .= ' ('.($this->_logicalName).')';
            }
        }
        return $this->_productName.' '.$res;
    }

    /**
     * Prepare to run a request on a device (finish any async device before if needed
     *(called by devRequest)
     * @param YTcpReq $tcpreq
     */
    public function prepRequest($tcpreq)
    {
        if(!is_null($this->_ongoingReq)) {
            while(!$this->_ongoingReq->eof()) {
                YAPI::_handleEvents_internal(100);
            }
        }
        $this->_ongoingReq = $tcpreq;
    }

    /**
     * Get the whole REST API string for a device, from cache if possible
     * @return YAPI_YReq
     */
    public function requestAPI()
    {
        if($this->_cache['_expiration'] > YAPI::GetTickCount()) {
            return new YAPI_YReq($this->_serialNumber.".module",
                                 YAPI_SUCCESS, 'no error', $this->_cache['_json']);
        }
        $yreq = YAPI::devRequest($this->_rootUrl, 'GET /api.json');
        if($yreq->errorType != YAPI_SUCCESS) return $yreq;
        $this->_cache['_expiration'] = YAPI::GetTickCount() + YAPI::$defaultCacheValidity;
        $this->_cache['_json'] = $yreq->result;
        return $yreq;
    }

    // Reload a device API (store in cache), and update YAPI function lists accordingly
    // Intended to be called within UpdateDeviceList only
    public function refresh()
    {
        $yreq = $this->requestAPI();
        if($yreq->errorType != YAPI_SUCCESS) {
            return $this->_throw($yreq->errorType, $yreq->errorMsg, $yreq->errorType);
        }
        $loadval = json_decode($yreq->result, true);
        if(json_last_error() != JSON_ERROR_NONE) {
            return $this->_throw(YAPI_IO_ERROR, 'Request failed, could not parse API result for '.$this->_rootUrl,
                                 YAPI_IO_ERROR);
        }
        $this->_cache['_expiration'] = YAPI::GetTickCount() + YAPI::$defaultCacheValidity;
        $this->_cache['_json'] = $yreq->result;

        $reindex = false;
        if($this->_productName == "") {
            // parse module and function names for the first time
            foreach($loadval as $func => $iface) {
                if($func == 'module') {
                    $this->_serialNumber = $iface['serialNumber'];
                    $this->_logicalName  = $iface['logicalName'];
                    $this->_productName  = $iface['productName'];
                    $this->_productId    = $iface['productId'];
                    $this->_beacon       = $iface['beacon'];
                } else if($func == 'services') {
                    $this->_updateFromYP($iface['yellowPages']);
                }
            }
            $reindex = true;
        } else {
            // parse module and refresh names if needed
            foreach($loadval as $func => $iface) {
                if($func == 'module') {
                    if($this->_logicalName != $iface['logicalName']) {
                        $this->_logicalName = $iface['logicalName'];
                        $reindex = true;
                    }
                    $this->_beacon = $iface['beacon'];
                } else if($func != 'services') {
                    if(isset($iface[$func]['logicalName']))
                        $name = $iface[$func]['logicalName'];
                    else
                        $name = $this->_logicalName;
                    if(isset($iface[$func]['advertisedValue'])) {
                        $pubval = $iface[$func]['advertisedValue'];
                        YAPI::setFunctionValue($this->_serialNumber.'.'.$func, $pubval);
                    }
                    foreach($this->_functions as $funydx => $fundef) {
                        if($fundef[0] == $func) {
                            if($fundef[1] != $name) {
                                $this->_functions[$funydx][1] = $name;
                                $reindex = true;
                            }
                            break;
                        }
                    }
                }
            }
        }
        if($reindex) {
            YAPI::reindexDevice($this);
        }
        return YAPI_SUCCESS;
    }

    // Force the REST API string in cache to expire immediately
    public function dropCache()
    {
        $this->_cache['_expiration'] = 0;
    }

    /**
     * Returns the number of functions (beside the "module" interface) available on the module.
     *
     * @return the number of functions on the module
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function functionCount()
    {
        return sizeof($this->_functions);
    }

    /**
     * Retrieves the hardware identifier of the <i>n</i>th function on the module.
     *
     * @param functionIndex : the index of the function for which the information is desired, starting at
     * 0 for the first function.
     *
     * @return a string corresponding to the unambiguous hardware identifier of the requested module function
     *
     * On failure, throws an exception or returns an empty string.
     */
    public function functionId($functionIndex)
    {
        if($functionIndex < sizeof($this->_functions)) {
            return $this->_functions[$functionIndex][0];
        }
        return '';
    }

    /**
     * Retrieves the logical name of the <i>n</i>th function on the module.
     *
     * @param functionIndex : the index of the function for which the information is desired, starting at
     * 0 for the first function.
     *
     * @return a string corresponding to the logical name of the requested module function
     *
     * On failure, throws an exception or returns an empty string.
     */
    public function functionName($functionIndex)
    {
        if($functionIndex < sizeof($this->_functions)) {
            return $this->_functions[$functionIndex][1];
        }
        return '';
    }

    /**
     * Retrieves the advertised value of the <i>n</i>th function on the module.
     *
     * @param functionIndex : the index of the function for which the information is desired, starting at
     * 0 for the first function.
     *
     * @return a short string (up to 6 characters) corresponding to the advertised value of the requested
     * module function
     *
     * On failure, throws an exception or returns an empty string.
     */
    public function functionValue($functionIndex)
    {
        if($functionIndex < sizeof($this->_functions)) {
            return YAPI::getFunctionValue($this->_serialNumber.'.'.$this->_functions[$functionIndex][0]);
        }
        return '';
    }
}

//
// YAPI Context
//
// This class provides the high-level entry points to access Functions, stores
// an indexes instances of the Device object and of FunctionType collections.
//

class YAPI
{
    const INVALID_STRING    = YAPI_INVALID_STRING;
    const INVALID_INT       = YAPI_INVALID_INT;
    const INVALID_UINT      = YAPI_INVALID_UINT;
    const INVALID_DOUBLE    = YAPI_INVALID_DOUBLE;
    const INVALID_LONG      = YAPI_INVALID_LONG;

//--- (generated code: return codes)
    const SUCCESS               = 0;       // everything worked allright
    const NOT_INITIALIZED       = -1;      // call yInitAPI() first !
    const INVALID_ARGUMENT      = -2;      // one of the arguments passed to the function is invalid
    const NOT_SUPPORTED         = -3;      // the operation attempted is (currently) not supported
    const DEVICE_NOT_FOUND      = -4;      // the requested device is not reachable
    const VERSION_MISMATCH      = -5;      // the device firmware is incompatible with this API version
    const DEVICE_BUSY           = -6;      // the device is busy with another task and cannot answer
    const TIMEOUT               = -7;      // the device took too long to provide an answer
    const IO_ERROR              = -8;      // there was an I/O problem while talking to the device
    const NO_MORE_DATA          = -9;      // there is no more data to read from
    const EXHAUSTED             = -10;     // you have run out of a limited ressource, check the documentation
    const DOUBLE_ACCES          = -11;     // you have two process that try to acces to the same device
    const UNAUTHORIZED          = -12;     // unauthorized access to password-protected device
    const RTC_NOT_READY         = -13;     // real-time clock has not been initialized (or time was lost)
//--- (end of generated code: return codes)

    // yInitAPI constants (not really useful in JavaScript)
    const DETECT_NONE           = 0;
    const DETECT_USB            = 1;
    const DETECT_NET            = 2;
    const DETECT_ALL            = 3;

    // Abstract function BaseTypes
    protected static $BASETYPES = Array('Function' => 0,
                                        'Sensor'   => 1);

    /**
     * @var YTcpHub[]
     */
    protected static $_hubs;           // array of root urls
    /**
     * @var YDevice[]
     */
    protected static $_devs;           // hash table of devices, by serial number
    protected static $_snByUrl;        // serial number for each device, by URL
    protected static $_snByName;       // serial number for each device, by name
    /**
     * @var YFunctionType[]
     */
    protected static $_fnByType;       // functions by type
    protected static $_lastErrorType;
    protected static $_lastErrorMsg;
    protected static $_firstArrival;
    protected static $_pendingCallbacks;
    protected static $_arrivalCallback;
    protected static $_namechgCallback;
    protected static $_removalCallback;
    protected static $_data_events;
    /** @var  YTcpReq[] */
    protected static $_pendingRequests;
    protected static $_calibHandlers;
    protected static $_decExp;

    // PUBLIC GLOBAL SETTINGS

    // Default cache validity (in [ms]) before reloading data from device. This saves a lots of trafic.
    // Note that a value under 2 ms makes little sense since a USB bus itself has a 2ms roundtrip period
    public static $defaultCacheValidity = 5;

    // Switch to turn off exceptions and use return codes instead, for source-code compatibility
    // with languages without exception support like C
    public static $exceptionsDisabled = false; // set to true if you want error codes instead of exceptions

    public static function _init()
    {
        // private
        self::$_hubs = Array();
        self::$_devs = Array();
        self::$_snByUrl = Array();
        self::$_snByName = Array();
        self::$_fnByType = Array();
        self::$_lastErrorType = YAPI_SUCCESS;
        self::$_lastErrorMsg = 'no error';
        self::$_firstArrival = true;
        self::$_pendingCallbacks = Array();
        self::$_arrivalCallback = null;
        self::$_namechgCallback = null;
        self::$_removalCallback = null;
        self::$_data_events = Array();
        self::$_pendingRequests = Array();

        self::$_decExp = Array(
            1.0e-6, 1.0e-5, 1.0e-4, 1.0e-3, 1.0e-2, 1.0e-1, 1.0,
            1.0e1, 1.0e2, 1.0e3, 1.0e4, 1.0e5, 1.0e6, 1.0e7, 1.0e8, 1.0e9);

        self::$_fnByType['Module'] = new YFunctionType('Module');

        register_shutdown_function('YAPI::flushConnections');
    }

    // Throw an exception, keeping track of it in the object itself
    protected static function _throw($int_errType, $str_errMsg, $obj_retVal)
    {
        self::$_lastErrorType = $int_errType;
        self::$_lastErrorMsg = $str_errMsg;

        if(self::$exceptionsDisabled) {
            return $obj_retVal;
        }
        // throw an exception
        throw new YAPI_Exception($str_errMsg, $int_errType);
    }

    // Update the list of known devices internally
    public static function _updateDeviceList_internal($bool_forceupdate, $bool_invokecallbacks)
    {
        if(self::$_firstArrival && $bool_invokecallbacks && !is_null(self::$_arrivalCallback)) {
            $bool_forceupdate = true;
        }
        $now = self::GetTickCount();
        if($bool_forceupdate) {
            foreach(self::$_hubs as $hub) {
                $hub->devListExpires = $now;
            }
        }

        // Prepare to scan all expired hubs
        $hubs = Array();
        foreach(self::$_hubs as $hub) {
            if($hub->devListExpires <= $now) {
                $tcpreq = new YTcpReq($hub, 'GET /api.json', false);
                self::$_pendingRequests[] = $tcpreq;
                $hubs[] = $hub;
                $hub->devListReq = $tcpreq;
                $hub->missing = Array();
            }
        }

        // assume all device as unpluged, unless proved wrong
        foreach(self::$_devs as $serial => $dev) {
            $rooturl = $dev->getRootUrl();
            foreach($hubs as $hub) {
                $huburl = $hub->rooturl;
                if(substr($rooturl,0,strlen($huburl)) == $huburl) {
                    $hub->missing[$serial] = true;
                }
            }
        }

        // Wait until all hubs are complete, and process replies as they come
        $timeout = self::GetTickCount() + YAPI_BLOCKING_REQUEST_TIMEOUT;
        while(self::GetTickCount() < $timeout) {
            self::_handleEvents_internal(100);
            $alldone = true;
            foreach ($hubs as $hub) {
                /** @var $hub YTcpHub */
                $req = $hub->devListReq;
                if(!$req->eof()) {
                    $alldone = false;
                    continue;
                }
                if($req->errorType != YAPI_SUCCESS) {
                    // report problems later
                    continue;
                }
                $loadval = json_decode($req->reply, true);
                if (!$loadval) {
                    $req->errorType = YAPI_IO_ERROR;
                    continue;
                }
                if (!isset($loadval['services']) || !isset($loadval['services']['whitePages'])) {
                    $req->errorType = YAPI_INVALID_ARGUMENT;
                    continue;
                }
                if (isset($loadval['network']) && isset($loadval['network']['adminPassword'])) {
                    $hub->writeProtected = ($loadval['network']['adminPassword'] != '');
                }
                $whitePages = $loadval['services']['whitePages'];
                // Reindex all functions from yellow pages
                $refresh = Array();
                $yellowPages = $loadval["services"]["yellowPages"];
                foreach ($yellowPages as $classname => $obj_yprecs) {
                    if (!isset(self::$_fnByType[$classname])) {
                        self::$_fnByType[$classname] = new YFunctionType($classname);
                    }
                    $ftype = self::$_fnByType[$classname];
                    foreach ($obj_yprecs as $yprec) {
                        $hwid = $yprec["hardwareId"];
                        $basetype = (isset($yprec["baseType"]) ? $yprec["baseType"] : null);
                        if ($ftype->reindexFunction($hwid, $yprec["logicalName"], $yprec["advertisedValue"], $basetype)) {
                            // logical name discrepency detected, force a refresh from device
                            $serial = substr($hwid, 0, strpos($hwid, '.'));
                            $refresh[$serial] = true;
                        }
                    }
                }
                // Reindex all devices from white pages
                foreach ($whitePages as $devinfo) {
                    $serial = $devinfo['serialNumber'];
                    $rooturl = substr($devinfo['networkUrl'], 0, -3);
                    if ($rooturl[0] == '/')
                        $rooturl = $hub->rooturl . substr($rooturl, 1);
                    $currdev = null;
                    if (isset(self::$_devs[$serial])) {
                        $currdev = self::$_devs[$serial];
                        if (!is_null(self::$_arrivalCallback) && self::$_firstArrival) {
                            self::$_pendingCallbacks[] = "+$serial";
                        }
                    }
                    if (isset($devinfo['index'])) {
                        $devydx = $devinfo['index'];
                        $hub->serialByYdx[$devydx] = $serial;
                    }
                    if (!isset(self::$_devs[$serial])) {
                        // Add new device
                        new YDevice($rooturl, $devinfo, $loadval["services"]["yellowPages"]);
                        if (!is_null(self::$_arrivalCallback)) {
                            self::$_pendingCallbacks[] = "+$serial";
                        }
                    } else if ($currdev->getLogicalName() != $devinfo['logicalName']) {
                        // Reindex device from its own data
                        $currdev->refresh();
                        if (!is_null(self::$_namechgCallback)) {
                            self::$_pendingCallbacks[] = "/$serial";
                        }
                    } else if (isset($refresh[$serial]) || $currdev->getRootUrl() != $rooturl ||
                            $currdev->getBeacon() != $devinfo['beacon']) {
                        // Reindex device from its own data in case of discrepency
                        $currdev->refresh();
                    }
                    $hub->missing[$serial] = false;
                }

                // Keep track of all unplugged devices on this hub
                foreach ($hub->missing as $serial => $missing) {
                    if ($missing) {
                        if (!is_null(self::$_removalCallback)) {
                            self::$_pendingCallbacks[] = "-$serial";
                        } else {
                            self::forgetDevice(self::$_devs[$serial]);
                        }
                    }
                }

                // enable monitoring for this hub if not yet done
                self::monitorEvents($hub);
                $hub->devListExpires = $now + $hub->devListValidity;
            }
            if($alldone) break;
        }

        // after processing all hubs, invoke pending callbacks if required
        if($bool_invokecallbacks) {
            $nbevents = sizeof(self::$_pendingCallbacks);
            for($i = 0; $i < $nbevents; $i++) {
                $evt = self::$_pendingCallbacks[$i];
                $serial = substr($evt,1);
                switch(substr($evt,0,1)) {
                case '+':
                    if(!is_null(self::$_arrivalCallback)) {
                        $cb = self::$_arrivalCallback;
                        $cb(yFindModule($serial.".module"));
                    }
                    break;
                case '/':
                    if(!is_null(self::$_namechgCallback)) {
                        $cb = self::$_namechgCallback;
                        $cb(yFindModule($serial.".module"));
                    }
                    break;
                case '-':
                    if(!is_null(self::$_removalCallback)) {
                        $cb = self::$_removalCallback;
                        $cb(yFindModule($serial.".module"));
                    }
                    self::forgetDevice(self::$_devs[$serial]);
                    break;
                }
            }
            self::$_pendingCallbacks = array_slice(self::$_pendingCallbacks, $nbevents);
            if(!is_null(self::$_arrivalCallback) && self::$_firstArrival) {
                self::$_firstArrival = false;
            }
        }

        // report any error seen during scan
        foreach ($hubs as $hub) {
            $req = $hub->devListReq;
            if($req->errorType != YAPI_SUCCESS) {
                return new YAPI_YReq("", $req->errorType,
                                     'Error while scanning '.$hub->rooturl.': '.$req->errorMsg,
                                     $req->errorType);
            }
        }
        return new YAPI_YReq("", YAPI_SUCCESS, "no error", YAPI_SUCCESS);
    }

    public static function _handleEvents_internal($int_maxwait)
    {
        $something_done = false;

        // start event monitoring if needed
        foreach(self::$_hubs as $hub) {
            $req = $hub->notifReq;
            if($req) {
                if($req->eof()) {
                    Printf("Event channel at eof, reopen\n");
                    $something_done = true;
                    $hub->notifReq = $req = null;
                    self::monitorEvents($hub);
                }
            } else if($hub->retryExpires > 0 && $hub->retryExpires <= self::GetTickCount()) {
                Printf("RetryExpires, calling monitorEvents\n");
                $something_done = true;
                self::monitorEvents($hub);
            }
        }

        // monitor all pending requests
        $streams = Array();
        foreach(self::$_pendingRequests as $req) {
            if(is_null($req->skt) || !is_resource($req->skt)) {
                $req->process();
            }
            if(!is_null($req->skt) && is_resource($req->skt)) {
                $streams[] = $req->skt;
            }
        }

        if(sizeof($streams) == 0) {
            usleep($int_maxwait*1000);
            return false;
        }
        $wr = NULL;
        $ex = NULL;
        if(false === ($select_res = stream_select($streams, $wr, $ex, 0, $int_maxwait * 1000))) {
            Printf("stream_select error\n");
            return false;
        }
        for($idx = 0; $idx < sizeof(self::$_pendingRequests); $idx++) {
            $req = self::$_pendingRequests[$idx];
            $hub = $req->hub;
            // generic request processing
            $req->process();
            if($req->eof()) {
                array_splice(self::$_pendingRequests, $idx, 1);
            }
            // handle notification channel
            if ($req === $hub->notifReq) {
                $linepos = strpos($req->reply, "\n");
                while($linepos !== false) {
                    $ev = trim(substr($req->reply, 0, $linepos));
                    $req->reply = substr($req->reply, $linepos+1);
                    $linepos = strpos($req->reply, "\n");
                    $firstCode = substr($ev, 0, 1);
                    if (strlen($ev) >= 3 && $firstCode >= 'v' && $firstCode <= 'z') {
                        // function value ydx (tiny notification)
                        $hub->devListValidity = 10000;
                        $hub->retryDelay = 15;
                        if ($hub->notifPos >= 0) {
                            $hub->notifPos += strlen($ev) + 1;
                        }
                        $devydx = ord($ev[1]) - 65; // from 'A'
                        $funydx = ord($ev[2]) - 48; // from '0'
                        if ($funydx >= 64) { // high bit of devydx is on second character
                            $funydx -= 64;
                            $devydx += 128;
                        }
                        if (isset($hub->serialByYdx[$devydx])) {
                            $serial = $hub->serialByYdx[$devydx];
                            if(isset(self::$_devs[$serial])) {
                                $funcid = ($funydx == 0xf ? 'time' : self::$_devs[$serial]->functionId($funydx));
                                if ($funcid != "") {
                                    $value = substr($ev, 3);
                                    if($firstCode == 'y') {
                                        // function value ydx (tiny notification)
                                        $value = explode("\0", $value);
                                        $value = $value[0];
                                        YAPI::setFunctionValue($serial . '.' . $funcid, $value);
                                    } else if($firstCode != 'w') { // always true, just to be safe
                                        // timed value report
                                        $arr = Array($firstCode == 'x' ? 0 : ($firstCode == 'z' ? 1 : 2));
                                        for($pos = 0; $pos < strlen($value); $pos += 2) {
                                            $arr[] = hexdec(substr($value, $pos, 2));
                                        }
                                        $dev = self::$_devs[$serial];
                                        if($funcid == 'time') {
                                            $time = $arr[1]+0x100*$arr[2]+0x10000*$arr[3]+0x1000000*$arr[4];
                                            $dev->setDeviceTime($time + $arr[5] / 250.0);
                                        } else {
                                            YAPI::setTimedReport($serial . '.' . $funcid, $dev->getDeviceTime(), $arr);
                                        }
                                    }
                                }
                            }
                        }
                    } else if (strlen($ev) == 3 && $firstCode == 'w') {
                        // log notification
                    } else if (strlen($ev) > 5 && substr($ev, 0, 4) == 'YN01') {
                        $hub->devListValidity = 10000;
                        $hub->retryDelay = 15;
                        if ($hub->notifPos >= 0) {
                            $hub->notifPos += strlen($ev) + 1;
                        }
                        $notype = substr($ev, 4, 1);
                        if ($notype == '@') {
                            $hub->notifPos = intVal(substr($ev, 5));
                        } else
                            switch (intVal($notype)) {
                                case 0: // device name change, or arrival
                                case 2: // device plug/unplug
                                case 4: // function name change
                                case 8: // function name change (ydx)
                                    $hub->devListExpires = 0;
                                    break;
                                case 5: // function value (long notification)
                                    $parts = explode(',', substr($ev, 5));
                                    $value = explode("\0", $parts[2]);
                                    YAPI::setFunctionValue($parts[0] . '.' . $parts[1], $value[0]);
                                    break;
                            }
                    } else {
                        // oops, bad notification ? be safe until a good one comes
                        $hub->devListValidity = 500;
                        $hub->devListExpires = 0;
                        $hub->notifPos = -1;
                    }
                }
            }
        }

        return $something_done;
    }

    public static function flushConnections()
    {
        foreach(self::$_pendingRequests as $req) {
            if($req->async) {
                while(!$req->eof()) {
                    self::_handleEvents_internal(200);
                }
            }
        }
    }

    public static function monitorEvents($hub)
    {
        /** @var $hub YTcpHub */
        if(!is_null($hub->notifReq)) return;
        if($hub->retryExpires > self::GetTickCount()) return;
        if($hub->isCachedHub()) return;

        $url = $hub->notifurl.'?len=0';
        if($hub->notifPos >= 0) $url .= '&abs='.$hub->notifPos;
        $req = new YTcpReq($hub, 'GET /'.$url, false);
        $errmsg = '';
        if($req->process($errmsg) != YAPI_SUCCESS) {
            if($hub->retryDelay == 0) {
                $hub->retryDelay = 15;
            } else if($hub->retryDelay < 15000) {
                $hub->retryDelay = 2 * $hub->retryDelay;
            }
            $hub->retryExpires = self::GetTickCount() + $hub->retryDelay;
            return;
        }
        self::$_pendingRequests[] = $req;
        $hub->notifReq = $req;
    }

    // Convert Yoctopuce 16-bit decimal floats to standard double-precision floats
    //
    public static function _decimalToDouble($val)
    {
        $negate = false;

        if($val == 0) return 0.0;
        if($val > 32767) {
            $negate = true;
            $val = 65536-$val;
        } else if($val < 0) {
            $negate = true;
            $val = -$val;
        }
        $decexp = self::$_decExp[$val >> 11];
        if($decexp >= 1.0) {
            $res = ($val & 2047) * $decexp;
        } else {
            $res = ($val & 2047) / round(1.0/$decexp);
        }

        return ($negate ? -$res : $res);
    }

    // Convert standard double-precision floats to Yoctopuce 16-bit decimal floats
    //
    public static function _doubleToDecimal($val)
    {
        $negate = false;

        if($val == 0.0) {
            return 0;
        }
        if($val < 0) {
            $negate = true;
            $val = -$val;
        }
        $comp = $val / 1999.0;
        $decpow = 0;
        while($comp > self::$_decExp[$decpow] && $decpow < 15) {
            $decpow++;
        }
        $mant = $val / self::$_decExp[$decpow];
        if($decpow == 15 && $mant > 2047.0) {
            $res = (15 << 11) + 2047; // overflow
        } else {
            $res = ($decpow << 11) + round($mant);
        }
        return ($negate ? -$res : $res);
    }

    // Return a the calibration handler for a given type
    public static function _getCalibrationHandler($calibType)
    {
        if(!isset(self::$_calibHandlers[strVal($calibType)])) {
            return null;
        }
        return self::$_calibHandlers[strVal($calibType)];
    }

    // Parse an array of u16 encoded in a base64-like string with memory-based compresssion
    public static function _decodeWords($data)
    {
        $datalen = strlen($data);
        $udata = Array();
        for($i = 0; $i < $datalen;) {
            $c = $data[$i];
            if($c == '*') {
                $val = 0;
                $i++;
            } else if($c == 'X') {
                $val = 0xffff;
                $i++;
            } else if($c == 'Y') {
                $val = 0x7fff;
                $i++;
            } else if($c >= 'a') {
                $srcpos = sizeof($udata)-1-(ord($data[$i++])-97);
                if($srcpos < 0) {
                    $val = 0;
                } else {
                    $val = $udata[$srcpos];
                }
            } else {
                if($i+2 > $datalen) return YAPI_IO_ERROR;
                $val = ord($data[$i++]) - 48;
                $val += (ord($data[$i++]) - 48) << 5;
                if($data[$i] == 'z') $data[$i] = '\\';
                $val += (ord($data[$i++]) - 48) << 10;
            }
            $udata[] = $val;
        }
        return $udata;
    }

    // Parse an array of u16 encoded in a base64-like string with memory-based compresssion
    public static function _decodeFloats($data)
    {
        $datalen = strlen($data);
        $idata = Array();
        $p = 0;
        while ($p < $datalen) {
            $val = 0;
            $sign = 1;
            $dec = 0;
            $decInc = 0;
            $c = $data[$p++];
            while($c != '-' && ($c < '0' || $c > '9')) {
                if($p >= $datalen) {
                    return $idata;
                }
                $c = $data[$p++];
            }
            if($c == '-') {
                if($p >= $datalen) {
                    return $idata;
                }
                $sign = -$sign;
                $c = $data[$p++];
            }
            while(($c >= '0' && $c <= '9') || $c == '.') {
                if($c == '.') {
                    $decInc = 1;
                } else if($dec < 3) {
                    $val = $val * 10 + (ord($c) - 48);
                    $dec += $decInc;
                }
                if($p < $datalen) {
                    $c = $data[$p++];
                } else {
                    $c = '\0';
                }
            }
            if($dec < 3) {
                if($dec == 0) $val *= 1000;
                else if($dec == 1) $val *= 100;
                else $val *= 10;
            }
            $idata[] = $sign*$val;
        }
        return $idata;
    }

    /**
     * Return a Device object for a specified URL, serial number or logical device name
     * This function will not cause any network access
     * @param string a specified URL, serial number or logical device name
     * @return YDevice
     */
    public static function getDevice($str_device)
    {
        $dev = null;

        if(substr($str_device, 0, 7) == 'http://') {
            if(isset(self::$_snByUrl[$str_device])) {
                $serial = self::$_snByUrl[$str_device];
                if(isset(self::$_devs[$serial])) {
                    $dev = self::$_devs[$serial];
                }
            }
        } else {
            // lookup by serial
            if(isset(self::$_devs[$str_device])) {
                $dev = self::$_devs[$str_device];
            } else {
                // fallback to lookup by logical name
                if(isset(self::$_snByName[$str_device])) {
                    $serial = self::$_snByName[$str_device];
                    $dev = self::$_devs[$serial];
                }
            }
        }
        return $dev;
    }

    // Return the class name for a given function ID or full Hardware Id
    // Also make sure that the function type is registered in the API
    public static function functionClass($str_funcid)
    {
        $dotpos = strpos($str_funcid, '.');
        if($dotpos !== false) $str_funcid = substr($str_funcid, $dotpos+1);
        $classlen = strlen($str_funcid);
        while(ord($str_funcid[$classlen-1]) <= 57) {
            $classlen--;
        }
        $classname = strtoupper($str_funcid[0]).substr($str_funcid,1,$classlen-1);
        if(!isset(self::$_fnByType[$classname])) {
            self::$_fnByType[$classname] = new YFunctionType($classname);
        }

        return $classname;
    }

    // Reindex a device in YAPI after a name change detected by device refresh
    public static function reindexDevice($obj_dev)
    {
        /** @var $obj_dev YDevice */
        $rootUrl = $obj_dev->getRootUrl();
        $serial = $obj_dev->getSerialNumber();
        $lname = $obj_dev->getLogicalName();
        self::$_devs[$serial] = $obj_dev;
        self::$_snByUrl[$rootUrl] = $serial;
        if($lname != '') self::$_snByName[$lname] = $serial;
        self::$_fnByType['Module']->reindexFunction("$serial.module", $lname, null, null);
        $count = $obj_dev->functionCount();
        for($i = 0; $i < $count; $i++) {
            $funcid = $obj_dev->functionId($i);
            $funcname = $obj_dev->functionName($i);
            $classname = self::functionClass($funcid);
            self::$_fnByType[$classname]->reindexFunction("$serial.$funcid", $funcname, null, null);
        }
    }

    // Remove a device from YAPI after an unplug detected by device refresh
    public static function forgetDevice($obj_dev)
    {
        /** @var $obj_dev YDevice */
        $rootUrl = $obj_dev->getRootUrl();
        $serial = $obj_dev->getSerialNumber();
        $lname = $obj_dev->getLogicalName();
        unset(self::$_devs[$serial]);
        unset(self::$_snByUrl[$rootUrl]);
        if(isset(self::$_snByName[$lname]) && self::$_snByName[$lname] == $serial) {
            unset(self::$_snByName[$lname]);
        }
        self::$_fnByType['Module']->forgetFunction("$serial.module");
        $count = $obj_dev->functionCount();
        for($i = 0; $i < $count; $i++) {
            $funcid = $obj_dev->functionId($i);
            $classname = self::functionClass($funcid);
            self::$_fnByType[$classname]->forgetFunction("$serial.$funcid");
        }
    }

    /**
     * Find the best known identifier (hardware Id) for a given function
     * @return YAPI_YReq
     */
    public static function resolveFunction($str_className, $str_func)
    {
        if(!isset(self::$BASETYPES[$str_className])) {
            // using a regular function type
            if(!isset(self::$_fnByType[$str_className]))
                self::$_fnByType[$str_className] = new YFunctionType($str_className);
            return self::$_fnByType[$str_className]->resolve($str_func);
        }
        // using an abstract baseType
        $baseType = self::$BASETYPES[$str_className];
        $res = null;
        foreach(self::$_fnByType as $str_className => $funtype) {
            if($funtype->getBaseType() == $baseType) {
                $res = $funtype->resolve($str_func);
                if($res->errorType == YAPI_SUCCESS) return $res;
            }
        }
        return new YAPI_YReq($str_func,
                             YAPI_DEVICE_NOT_FOUND,
                             "No $str_className [$str_func] found (old firmware?)",
                             null);
    }

    // return a firendly name for of a given function
    public static function getFriendlyNameFunction($str_className, $str_func)
    {
        if(!isset(self::$BASETYPES[$str_className])) {
            // using a regular function type
            if(!isset(self::$_fnByType[$str_className]))
                self::$_fnByType[$str_className] = new YFunctionType($str_className);
            return self::$_fnByType[$str_className]->getFriendlyName($str_func);
        }
        // using an abstract baseType
        $baseType = self::$BASETYPES[$str_className];
        $res = null;
        foreach(self::$_fnByType as $str_className => $funtype) {
            if($funtype->getBaseType() == $baseType) {
                $res = $funtype->getFriendlyName($str_func);
                if($res->errorType == YAPI_SUCCESS) return $res;
            }
        }
        return new YAPI_YReq($str_func,
                             YAPI_DEVICE_NOT_FOUND,
                             "No $str_className [$str_func] found (old firmware?)",
                             null);
    }


    // Retrieve a function object by hardware id, updating the indexes on the fly if needed
    public static function setFunction($str_className, $str_func, $obj_func)
    {
        if(!isset(self::$_fnByType[$str_className]))
            self::$_fnByType[$str_className] = new YFunctionType($str_className);
        self::$_fnByType[$str_className]->setFunction($str_func, $obj_func);
    }

    // Retrieve a function object by hardware id, updating the indexes on the fly if needed
    public static function getFunction($str_className, $str_func)
    {
        if(is_null(self::$_hubs)) self::_init();

        if(!isset(self::$_fnByType[$str_className]))
            self::$_fnByType[$str_className] = new YFunctionType($str_className);
        return self::$_fnByType[$str_className]->getFunction($str_func);
    }

    // Set a function advertised value by hardware id
    public static function setFunctionValue($str_hwid, $str_pubval)
    {
        $classname = self::functionClass($str_hwid);
        self::$_fnByType[$classname]->setFunctionValue($str_hwid, $str_pubval);
    }

    // Set add a timed value report for a function
    public static function setTimedReport($str_hwid, $float_timestamp, $arr_report)
    {
        $classname = self::functionClass($str_hwid);
        self::$_fnByType[$classname]->setTimedReport($str_hwid, $float_timestamp, $arr_report);
    }

    // Retrieve a function advertised value by hardware id
    public static function getFunctionValue($str_hwid)
    {
        $classname = self::functionClass($str_hwid);
        return self::$_fnByType[$classname]->getFunctionValue($str_hwid);
    }

    // Queue a function value event
    public static function addValueEvent($obj_func, $str_newval)
    {
        self::$_data_events[] = Array($obj_func, $str_newval);
    }

    // Queue a function value event
    public static function addTimedReportEvent($obj_func, $float_timestamp, $arr_report)
    {
        self::$_data_events[] = Array($obj_func, $float_timestamp, $arr_report);
    }

    // Find the hardwareId for the first instance of a given function class
    public static function getFirstHardwareId($str_className)
    {
        if(is_null(self::$_hubs)) self::_init();

        if(!isset(self::$BASETYPES[$str_className])) {
            // enumeration of a regular function type
            if(!isset(self::$_fnByType[$str_className]))
                self::$_fnByType[$str_className] = new YFunctionType($str_className);
            return self::$_fnByType[$str_className]->getFirstHardwareId();
        }
        // enumeration of an abstract class
        $baseType = self::$BASETYPES[$str_className];
        $res = null;
        foreach(self::$_fnByType as $funtype) {
            if($funtype->getBaseType() == $baseType) {
                $res = $funtype->getFirstHardwareId();
                if(!is_null($res)) return $res;
            }
        }
        return null;
    }

    // Find the hardwareId for the next instance of a given function class
    public static function getNextHardwareId($str_className, $str_hwid)
    {
        if(!isset(self::$BASETYPES[$str_className])) {
            // enumeration of a regular function type
            return self::$_fnByType[$str_className]->getNextHardwareId($str_hwid);
        }

        // enumeration of an abstract class
        $baseType = self::$BASETYPES[$str_className];
        $prevclass = self::functionClass($str_hwid);
        $res = self::$_fnByType[$prevclass]->getNextHardwareId($str_hwid);
        if(!is_null($res)) return $res;
        foreach(self::$_fnByType as $str_className => $funtype) {
            if($prevclass != "") {
                if($str_className != $prevclass) continue;
                $prevclass = "";
                continue;
            }
            if($funtype->getBaseType() == $baseType) {
                $res = $funtype->getFirstHardwareId();
                if(!is_null($res)) return $res;
            }
        }
        return $res;
    }

    /**
     * Perform an HTTP request on a device, by URL or identifier.
     * When loading the REST API from a device by identifier, the device cache will be used
     * @param $str_device
     * @param $str_request
     * @param bool $async
     * @param string $body
     * @return YAPI_YReq a strucure including errorType, errorMsg and result
     */
    public static function devRequest($str_device, $str_request, $async=false, $body='')
    {
        $lines = explode("\n", $str_request);
        $dev = null;
        $baseUrl = $str_device;
        if(substr($str_device, 0, 7) == 'http://') {
            if(substr($baseUrl, -1) != '/') $baseUrl .= '/';
            if(isset(self::$_snByUrl[$baseUrl])) {
                $serial = self::$_snByUrl[$baseUrl];
                if(isset(self::$_devs[$serial])) {
                    $dev = self::$_devs[$serial];
                }
            }
        } else {
            $dev = self::getDevice($str_device);
            if(!$dev) {
                return new YAPI_YReq("", YAPI_DEVICE_NOT_FOUND,
                                     "Device [$str_device] not online",
                                     null);
            }
            // use the device cache when loading the whole API
            if($lines[0] == 'GET /api.json') {
                return $dev->requestAPI();
            }
            $baseUrl = $dev->getRootUrl();
        }
        // map str_device to a URL
        $words = explode(' ', $lines[0]);
        if(sizeof($words) < 2) {
            return new YAPI_YReq("", YAPI_INVALID_ARGUMENT,
                                 'Invalid request, not enough words; expected a method name and a URL',
                                 null);
        } else if(sizeof($words) > 2) {
            return new YAPI_YReq("", YAPI_INVALID_ARGUMENT,
                                 'Invalid request, too many words; make sure the URL is URI-encoded',
                                 null);
        }
        $method = $words[0];
        $devUrl = $words[1];
        if(substr($devUrl,0,1) == '/') $devUrl = substr($devUrl, 1);
        $baseUrl = str_replace('http://', '', $baseUrl);
        $pos = strpos($baseUrl, '/');
        if($pos !== false) {
            $devUrl = substr($baseUrl, $pos).$devUrl;
            $baseUrl = substr($baseUrl, 0, $pos);
        } else {
            $devUrl = "/$devUrl";
        }
        $rooturl = "http://$baseUrl/";
        if(!isset(self::$_hubs[$rooturl])) {
            return new YAPI_YReq("", YAPI_DEVICE_NOT_FOUND, 'No hub registered on '.$baseUrl, null);
        }
        $hub = self::$_hubs[$rooturl];
        if($async && $hub->writeProtected && $hub->user != 'admin') {
            // async query, make sure the hub is not write-protected
            return new YAPI_YReq("", YAPI_UNAUTHORIZED,
                                 'Access denied: admin credentials required',
                                 null);
        }
        $tcpreq = new YTcpReq($hub, "$method $devUrl", $async, $body);
        if(!is_null($dev)) {
            $dev->prepRequest($tcpreq);
        }
        if($tcpreq->process() != YAPI_SUCCESS) {
            return new YAPI_YReq("", $tcpreq->errorType, $tcpreq->errorMsg, null);
        }
        self::$_pendingRequests[] = $tcpreq;
        if(!$async) {
            // normal query, wait for completion until timeout
            $timeout = YAPI::GetTickCount() + YAPI_BLOCKING_REQUEST_TIMEOUT;
            do {
                self::_handleEvents_internal(100);
            } while(!$tcpreq->eof() && YAPI::GetTickCount() < $timeout);
            if(!$tcpreq->eof()) {
                $tcpreq->close();
                return new YAPI_YReq("", YAPI_TIMEOUT,
                                     'Timeout waiting for device reply',
                                     null);
            }
            if ($tcpreq->errorType == YAPI_UNAUTHORIZED) {
                return new YAPI_YReq("", YAPI_UNAUTHORIZED,
                                     'Access denied, authorization required',
                                     null);
            } else if ($tcpreq->errorType != YAPI_SUCCESS) {
                return new YAPI_YReq("", $tcpreq->errorType,
                                     'Network error while reading from device',
                                     null);
            }
            if(strpos($tcpreq->meta, "OK\r\n") === 0) {
                return new YAPI_YReq("", YAPI_SUCCESS,
                                     'no error',
                                     $tcpreq->reply);
            }
            if(strpos($tcpreq->meta, "0K\r\n") === 0) {
                return new YAPI_YReq("", YAPI_SUCCESS,
                                     'no error',
                                     $tcpreq->reply);
            }
            $matches = null;
            if(!preg_match('/^HTTP[^ ]* (?P<status>\d+) (?P<statusmsg>.)+$/', $tcpreq->meta, $matches)) {
                return new YAPI_YReq("", YAPI_IO_ERROR,
                                     'Unexpected HTTP response header: '.$tcpreq->meta,
                                     null);
            }
            if($matches['status'] != '200' && $matches['status'] != '304') {
                return new YAPI_YReq("", YAPI_IO_ERROR,
                                     'Received HTTP status '.$matches['status'].' ('.$matches['statusmsg'].')',
                                     null);
            }
        }

        return new YAPI_YReq("", YAPI_SUCCESS,
                             'no error',
                             $tcpreq->reply);
    }

    /**
     * Load and parse the REST API for a function given by class name and identifier, possibly applying changes
     * Device cache will be preloaded when loading function "module" and leveraged for other modules
     * @return YAPI_YReq
     */
    public static function funcRequest($str_className, $str_func, $str_extra)
    {
        $resolve = self::resolveFunction($str_className, $str_func);
        if($resolve->errorType != YAPI_SUCCESS) {
            if($resolve->errorType == YAPI_DEVICE_NOT_FOUND && sizeof(self::$_hubs) == 0) {
                // when USB is supported, check if no USB device is connected before outputing this message
                $resolve->errorMsg = "Impossible to contact any device because no hub has been registered";
            } else {
                $resolve = self::_updateDeviceList_internal(true, false);
                if($resolve->errorType != YAPI_SUCCESS) {
                    return $resolve;
                }
                $resolve = self::resolveFunction($str_className, $str_func);
            }
            if($resolve->errorType != YAPI_SUCCESS) {
                return $resolve;
            }
        }
        $str_func = $resolve->result;
        $dotpos = strpos($str_func, '.');
        $devid = substr($str_func,0,$dotpos);
        $funcid = substr($str_func,$dotpos+1);
        $dev = self::getDevice($devid);
        if(!$dev) {
            // try to force a device list update to check if the device arrived in between
            $resolve = self::_updateDeviceList_internal(true, false);
            if($resolve->errorType != YAPI_SUCCESS) {
                return $resolve;
            }
            $dev = self::getDevice($devid);
            if(!$dev) {
                return new YAPI_YReq("{$devid}.{$funcid}", YAPI_DEVICE_NOT_FOUND,
                                     "Device [$devid] not online",
                                     null);
            }
        }
        $loadval = false;
        if($str_extra == '') {
            // use a cached API string, without reloading unless module is requested
            $yreq = $dev->requestAPI();
            if(!is_null($yreq)) {
                $yreq->hwid = "{$devid}.{$funcid}";
                $yreq->deviceid  = $devid;
                $yreq->functionid = $funcid;
                if($yreq->errorType != YAPI_SUCCESS) return $yreq;
                $loadval = json_decode($yreq->result, true);
                $loadval = $loadval[$funcid];
            }
        } else {
            $dev->dropCache();
            $yreq = new YAPI_YReq("{$devid}.{$funcid}", YAPI_NOT_INITIALIZED, "dummy", null);
        }
        if(!$loadval) {
            // request specified function only to minimize traffic
            if($str_extra == "") {
                $httpreq = "GET /api/{$funcid}.json";
                $yreq = self::devRequest($devid, $httpreq);
                $yreq->hwid = "{$devid}.{$funcid}";
                $yreq->deviceid  = $devid;
                $yreq->functionid = $funcid;
                if($yreq->errorType != YAPI_SUCCESS) return $yreq;
                $loadval = json_decode($yreq->result, true);
            } else {
                $httpreq = "GET /api/{$funcid}{$str_extra}";
                $yreq = self::devRequest($devid, $httpreq, true);
                $yreq->hwid = "{$devid}.{$funcid}";
                $yreq->deviceid  = $devid;
                $yreq->functionid = $funcid;
                return $yreq;
            }
        }
        if(!$loadval) {
            return new YAPI_YReq("{$devid}.{$funcid}", YAPI_IO_ERROR,
                                 "Request failed, could not parse API value for function $str_func",
                                 null);
        }
        $yreq->result = $loadval;
        return $yreq;
    }

    // Perform an HTTP request on a device and return the result string
    // Throw an exception (or return YAPI_ERROR_STRING on error)
    public static function HTTPRequest($str_device, $str_request)
    {
        $res = self::devRequest($str_device, $str_request);
        if($res->errorType != YAPI_SUCCESS) {
            return self::_throw($res->errorType, $res->errorMsg, null);
        }
        return $res->result;
    }

    /**
     * Returns the version identifier for the Yoctopuce library in use.
     * The version is a string in the form "Major.Minor.Build",
     * for instance "1.01.5535". For languages using an external
     * DLL (for instance C#, VisualBasic or Delphi), the character string
     * includes as well the DLL version, for instance
     * "1.01.5535 (1.01.5439)".
     * 
     * If you want to verify in your code that the library version is
     * compatible with the version that you have used during development,
     * verify that the major number is strictly equal and that the minor
     * number is greater or equal. The build number is not relevant
     * with respect to the library compatibility.
     * 
     * @return a character string describing the library version.
     */
    public static function GetAPIVersion()
    {
        return "1.10.18176";
    }

    /**
     * Initializes the Yoctopuce programming library explicitly.
     * It is not strictly needed to call yInitAPI(), as the library is
     * automatically  initialized when calling yRegisterHub() for the
     * first time.
     * 
     * When Y_DETECT_NONE is used as detection mode,
     * you must explicitly use yRegisterHub() to point the API to the
     * VirtualHub on which your devices are connected before trying to access them.
     * 
     * @param mode : an integer corresponding to the type of automatic
     *         device detection to use. Possible values are
     *         Y_DETECT_NONE, Y_DETECT_USB, Y_DETECT_NET,
     *         and Y_DETECT_ALL.
     * @param errmsg : a string passed by reference to receive any error message.
     * 
     * @return YAPI_SUCCESS when the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public static function InitAPI($mode=Y_DETECT_NET, &$errmsg='')
    {
        if(is_null(self::$_hubs)) self::_init();
        $errmsg = '';

        return YAPI_SUCCESS;
    }

    /**
     * Frees dynamically allocated memory blocks used by the Yoctopuce library.
     * It is generally not required to call this function, unless you
     * want to free all dynamically allocated memory blocks in order to
     * track a memory leak for instance.
     * You should not call any other library function after calling
     * yFreeAPI(), or your program will crash.
     */
    public static function FreeAPI()
    {
        // clear all caches
        self::_init();
    }

    /**
     * Disables the use of exceptions to report runtime errors.
     * When exceptions are disabled, every function returns a specific
     * error value which depends on its type and which is documented in
     * this reference manual.
     */
    public static function DisableExceptions()
    {
        if(is_null(self::$_hubs)) self::_init();

        self::$exceptionsDisabled = true;
    }

    /**
     * Re-enables the use of exceptions for runtime error handling.
     * Be aware than when exceptions are enabled, every function that fails
     * triggers an exception. If the exception is not caught by the user code,
     * it  either fires the debugger or aborts (i.e. crash) the program.
     * On failure, throws an exception or returns a negative error code.
     */
    public static function EnableExceptions()
    {
        if(is_null(self::$_hubs)) self::_init();

        self::$exceptionsDisabled = false;
    }

    private static function _parseRegisteredURL($str_url, &$rooturl, &$auth)
    {
        if(substr($str_url, 0, 7) == 'http://') {
            $str_url = substr($str_url, 7);
        }
        while(substr($str_url, -1) == '/') {
            $str_url = substr($str_url, 0, -1);
        }
        $authpos = strpos($str_url, '@');
        if ($authpos === false) {
            $auth = '';
        } else {
            $auth = substr($str_url, 0, $authpos);
            $str_url = substr($str_url, $authpos+1);
        }
        if(strcasecmp(substr($str_url,0,8),"callback")==0) {
            $rooturl = "http://".strtoupper($str_url)."/";
        } else {
            if(strpos($str_url, ':') === false) {
                $str_url .= ':4444';
            }
            $rooturl = "http://{$str_url}/";
        }
    }

    /**
     * Setup the Yoctopuce library to use modules connected on a given machine. The
     * parameter will determine how the API will work. Use the following values:
     * 
     * <b>usb</b>: When the usb keyword is used, the API will work with
     * devices connected directly to the USB bus. Some programming languages such a Javascript,
     * PHP, and Java don't provide direct access to USB hardware, so usb will
     * not work with these. In this case, use a VirtualHub or a networked YoctoHub (see below).
     * 
     * <b><i>x.x.x.x</i></b> or <b><i>hostname</i></b>: The API will use the devices connected to the
     * host with the given IP address or hostname. That host can be a regular computer
     * running a VirtualHub, or a networked YoctoHub such as YoctoHub-Ethernet or
     * YoctoHub-Wireless. If you want to use the VirtualHub running on you local
     * computer, use the IP address 127.0.0.1.
     * 
     * <b>callback</b>: that keyword make the API run in "<i>HTTP Callback</i>" mode.
     * This a special mode allowing to take control of Yoctopuce devices
     * through a NAT filter when using a VirtualHub or a networked YoctoHub. You only
     * need to configure your hub to call your server script on a regular basis.
     * This mode is currently available for PHP and Node.JS only.
     * 
     * Be aware that only one application can use direct USB access at a
     * given time on a machine. Multiple access would cause conflicts
     * while trying to access the USB modules. In particular, this means
     * that you must stop the VirtualHub software before starting
     * an application that uses direct USB access. The workaround
     * for this limitation is to setup the library to use the VirtualHub
     * rather than direct USB access.
     * 
     * If access control has been activated on the hub, virtual or not, you want to
     * reach, the URL parameter should look like:
     * 
     * http://username:password@address:port
     * 
     * You can call <i>RegisterHub</i> several times to connect to several machines.
     * 
     * @param url : a string containing either "usb","callback" or the
     *         root URL of the hub to monitor
     * @param errmsg : a string passed by reference to receive any error message.
     * 
     * @return YAPI_SUCCESS when the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public static function RegisterHub($url,&$errmsg='')
    {
        if(is_null(self::$_hubs)) self::_init();

        $rooturl = $url;
        $auth = '';
        self::_parseRegisteredURL($url, $rooturl, $auth);

        // Test hub
        $tcphub = new YTcpHub($rooturl, $auth);
        if($tcphub->verfiyStreamAddr($errmsg)<0){
            return self::_throw(YAPI_IO_ERROR, $errmsg, YAPI_IO_ERROR);
        }
        $tcpreq = new YTcpReq($tcphub, "GET /api/module.json", false);
        if($tcpreq->process($errmsg) != YAPI_SUCCESS) {
            return self::_throw($tcpreq->errorType, $errmsg, $tcpreq->errorType);
        }
        self::$_pendingRequests[] = $tcpreq;
        $timeout = YAPI::GetTickCount() + YAPI_BLOCKING_REQUEST_TIMEOUT;
        do {
            self::_handleEvents_internal(100);
        } while (!$tcpreq->eof() && YAPI::GetTickCount() < $timeout);
        if (!$tcpreq->eof()) {
            $tcpreq->close();
            $errmsg = 'Timeout waiting for device reply';
            return self::_throw(YAPI_TIMEOUT,$errmsg , YAPI_TIMEOUT);
        }
        if ($tcpreq->errorType == YAPI_UNAUTHORIZED) {
            $errmsg = 'Access denied, authorization required';
            return self::_throw(YAPI_UNAUTHORIZED, $errmsg, YAPI_UNAUTHORIZED);
        } else if ($tcpreq->errorType != YAPI_SUCCESS) {
            $errmsg = 'Network error while testing hub';
            return self::_throw($tcpreq->errorType, $errmsg, $tcpreq->errorType);
        }

        // Add hub to known list
        if(!isset(self::$_hubs[$rooturl])) {
            self::$_hubs[$rooturl] = $tcphub;
        }

        // Register device list
        $yreq = self::_updateDeviceList_internal(true, false);
        if($yreq->errorType != YAPI_SUCCESS) {
            $errmsg = $yreq->errorMsg;
            return self::_throw($yreq->errorType, $yreq->errorMsg, $yreq->errorType);
        }

        return YAPI_SUCCESS;
    }

    /**
     * Fault-tolerant alternative to RegisterHub(). This function has the same
     * purpose and same arguments as RegisterHub(), but does not trigger
     * an error when the selected hub is not available at the time of the function call.
     * This makes it possible to register a network hub independently of the current
     * connectivity, and to try to contact it only when a device is actively needed.
     * 
     * @param url : a string containing either "usb","callback" or the
     *         root URL of the hub to monitor
     * @param errmsg : a string passed by reference to receive any error message.
     * 
     * @return YAPI_SUCCESS when the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public static function PreregisterHub($url,&$errmsg='')
    {
        if(is_null(self::$_hubs)) self::_init();

        $rooturl = $url;
        $auth = '';
        self::_parseRegisteredURL($url, $rooturl, $auth);

        // Add hub to known list
        if(!isset(self::$_hubs[$rooturl])) {
            self::$_hubs[$rooturl] = new YTcpHub($rooturl, $auth);
            if(self::$_hubs[$rooturl]->verfiyStreamAddr($errmsg)<0){
                return self::_throw(YAPI_IO_ERROR, $errmsg, YAPI_IO_ERROR);
            }
        }

        return YAPI_SUCCESS;
    }


    /**
     * Setup the Yoctopuce library to no more use modules connected on a previously
     * registered machine with RegisterHub.
     * 
     * @param url : a string containing either "usb" or the
     *         root URL of the hub to monitor
     */

    public static function UnregisterHub($url)
    {
        if (is_null(self::$_hubs))
            return;

        $rooturl = $url;
        $auth = '';
        self::_parseRegisteredURL($url, $str_url, $auth);
        $new_hubs = array();
        for ($i = 0; $i < sizeof(self::$_hubs); $i++) {
            if (self::$_hubs[$i]['rooturl'] == $str_url) {
                // remove all connected devices
                foreach (self::$_hubs[$i]['serialByYdx'] as $serial) {
                    self::forgetDevice(self::$_devs[$serial]);
                }
            } else {
                $new_hubs[] = self::$_hubs[$i];
            }
        }
        self::$_hubs = $new_hubs;
    }


    /**
     * Triggers a (re)detection of connected Yoctopuce modules.
     * The library searches the machines or USB ports previously registered using
     * yRegisterHub(), and invokes any user-defined callback function
     * in case a change in the list of connected devices is detected.
     * 
     * This function can be called as frequently as desired to refresh the device list
     * and to make the application aware of hot-plug events.
     * 
     * @param errmsg : a string passed by reference to receive any error message.
     * 
     * @return YAPI_SUCCESS when the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public static function UpdateDeviceList(&$errmsg='')
    {
        $yreq = self::_updateDeviceList_internal(false, true);
        if($yreq->errorType != YAPI_SUCCESS) {
            $errmsg = $yreq->errorMsg;
            return self::_throw($yreq->errorType, $yreq->errorMsg, $yreq->errorType);
        }
        return YAPI_SUCCESS;
    }

    /**
     * Maintains the device-to-library communication channel.
     * If your program includes significant loops, you may want to include
     * a call to this function to make sure that the library takes care of
     * the information pushed by the modules on the communication channels.
     * This is not strictly necessary, but it may improve the reactivity
     * of the library for the following commands.
     * 
     * This function may signal an error in case there is a communication problem
     * while contacting a module.
     * 
     * @param errmsg : a string passed by reference to receive any error message.
     * 
     * @return YAPI_SUCCESS when the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public static function HandleEvents(&$errmsg='')
    {
        // monitor hubs for events
        while(self::_handleEvents_internal(0)) {}

        // handle pending events
        $nEvents = sizeof(self::$_data_events);
        for($i = 0; $i < $nEvents; $i++) {
            $evt = self::$_data_events[$i];
            if(is_string($evt[1])) {
                /** @var $fun YFunction */
                $fun = $evt[0];
                // event object is an advertised value
                $fun->_invokeValueCallback($evt[1]);
            } else {
                /** @var $ysensor YSensor */
                $ysensor = $evt[0];
                // event object is an array of bytes (encoded timed report)
                /** @noinspection PhpUndefinedMethodInspection */
                $dev = YAPI::getDevice($ysensor->get_module()->get_serialNumber());
                if(!is_null($dev)) {
                    $report = $ysensor->_decodeTimedReport($evt[1],$evt[2]);
                    $ysensor->_invokeTimedReportCallback($report);
                }
            }
        }
        self::$_data_events = array_slice(self::$_data_events, $nEvents);
        $errmsg = '';

        return YAPI_SUCCESS;
    }

    /**
     * Pauses the execution flow for a specified duration.
     * This function implements a passive waiting loop, meaning that it does not
     * consume CPU cycles significantly. The processor is left available for
     * other threads and processes. During the pause, the library nevertheless
     * reads from time to time information from the Yoctopuce modules by
     * calling yHandleEvents(), in order to stay up-to-date.
     * 
     * This function may signal an error in case there is a communication problem
     * while contacting a module.
     * 
     * @param ms_duration : an integer corresponding to the duration of the pause,
     *         in milliseconds.
     * @param errmsg : a string passed by reference to receive any error message.
     * 
     * @return YAPI_SUCCESS when the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public static function Sleep($ms_duration, &$errmsg='')
    {
        $end = YAPI::GetTickCount() + $ms_duration;
        self::HandleEvents($errmsg);
        $remain = $end - YAPI::GetTickCount();
        while($remain > 0) {
            if($remain > 999) $remain = 999;
            self::_handleEvents_internal($remain);
            self::HandleEvents($errmsg);
            $remain = $end - YAPI::GetTickCount();
        }
        $errmsg = '';

        return YAPI_SUCCESS;
    }

    /**
     * Returns the current value of a monotone millisecond-based time counter.
     * This counter can be used to compute delays in relation with
     * Yoctopuce devices, which also uses the millisecond as timebase.
     * 
     * @return a long integer corresponding to the millisecond counter.
     */
    public static function GetTickCount()
    {
        return round(microtime(true) * 1000);
    }

    /**
     * Checks if a given string is valid as logical name for a module or a function.
     * A valid logical name has a maximum of 19 characters, all among
     * A..Z, a..z, 0..9, _, and -.
     * If you try to configure a logical name with an incorrect string,
     * the invalid characters are ignored.
     * 
     * @param name : a string containing the name to check.
     * 
     * @return true if the name is valid, false otherwise.
     */
    public static function CheckLogicalName($name)
    {
        if($name == '') return true;
        if(!$name) return false;
        if(strlen($name) > 19) return false;
        return preg_match('/^[A-Za-z0-9_\-]*$/', $name);
    }

    /**
     * Register a callback function, to be called each time
     * a device is plugged. This callback will be invoked while yUpdateDeviceList
     * is running. You will have to call this function on a regular basis.
     * 
     * @param arrivalCallback : a procedure taking a YModule parameter, or null
     *         to unregister a previously registered  callback.
     */
    public static function RegisterDeviceArrivalCallback($arrivalCallback)
    {
        self::$_arrivalCallback = $arrivalCallback;
    }

    /**
     * Register a device logical name change callback
     */
    public static function RegisterDeviceChangeCallback($changeCallback)
    {
        self::$_namechgCallback = $changeCallback;
    }

    /**
     * Register a callback function, to be called each time
     * a device is unplugged. This callback will be invoked while yUpdateDeviceList
     * is running. You will have to call this function on a regular basis.
     * 
     * @param removalCallback : a procedure taking a YModule parameter, or null
     *         to unregister a previously registered  callback.
     */
    public static function RegisterDeviceRemovalCallback($removalCallback)
    {
        self::$_removalCallback = $removalCallback;
    }

    // Register a new value calibration handler for a given calibration type
    //
    public static function RegisterCalibrationHandler($calibrationType, $calibrationHandler)
    {
        self::$_calibHandlers[$calibrationType] = $calibrationHandler;
    }

    // Standard value calibration handler (n-point linear error correction)
    //
    public static function LinearCalibrationHandler($float_rawValue, $int_calibType, $arr_calibParams,
                                                    $arr_calibRawValues, $arr_calibRefValues)
    {
        $x   = $arr_calibRawValues[0];
        $adj = $arr_calibRefValues[0] - $x;
        $i   = 0;

        if($int_calibType < YOCTO_CALIB_TYPE_OFS) {
            // calibration types n=1..10 are meant for linear calibration using n points
            $npt = min($int_calibType % 10, sizeof($arr_calibRawValues), sizeof($arr_calibRefValues));
        } else {
            $npt = sizeof($arr_calibRefValues);
        }
        while($float_rawValue > $arr_calibRawValues[$i] && ++$i < $npt) {
            $x2   = $x;
            $adj2 = $adj;

            $x   = $arr_calibRawValues[$i];
            $adj = $arr_calibRefValues[$i] - $x;

            if($float_rawValue < $x && $x > $x2) {
                $adj = $adj2 + ($adj - $adj2) * ($float_rawValue - $x2) / ($x - $x2);
            }
        }
        return $float_rawValue + $adj;
    }


}

//--- (generated code: YMeasure declaration)
/**
 * YMeasure Class: Measured value
 * 
 * YMeasure objects are used within the API to represent
 * a value measured at a specified time. These objects are
 * used in particular in conjunction with the YDataSet class.
 */
class YMeasure
{
    //--- (end of generated code: YMeasure declaration)
    const DATA_INVALID = YAPI_INVALID_DOUBLE;

    //--- (generated code: YMeasure attributes)
    protected $_start                    = 0;                            // float
    protected $_end                      = 0;                            // float
    protected $_minVal                   = 0;                            // float
    protected $_avgVal                   = 0;                            // float
    protected $_maxVal                   = 0;                            // float
    //--- (end of generated code: YMeasure attributes)

    public function __construct($float_start, $float_end, $float_minVal, $float_avgVal, $float_maxVal)
    {
        //--- (generated code: YMeasure constructor)
        //--- (end of generated code: YMeasure constructor)

        $this->_start                        = $float_start;
        $this->_end                          = $float_end;
        $this->_minVal                       = $float_minVal;
        $this->_avgVal                       = $float_avgVal;
        $this->_maxVal                       = $float_maxVal;
    }

    //--- (generated code: YMeasure implementation)

    /**
     * Returns the start time of the measure, relative to the Jan 1, 1970 UTC
     * (Unix timestamp). When the recording rate is higher then 1 sample
     * per second, the timestamp may have a fractional part.
     * 
     * @return an floating point number corresponding to the number of seconds
     *         between the Jan 1, 1970 UTC and the beginning of this measure.
     */
    public function get_startTimeUTC()
    {
        return $this->_start;
    }

    /**
     * Returns the end time of the measure, relative to the Jan 1, 1970 UTC
     * (Unix timestamp). When the recording rate is higher than 1 sample
     * per second, the timestamp may have a fractional part.
     * 
     * @return an floating point number corresponding to the number of seconds
     *         between the Jan 1, 1970 UTC and the end of this measure.
     */
    public function get_endTimeUTC()
    {
        return $this->_end;
    }

    /**
     * Returns the smallest value observed during the time interval
     * covered by this measure.
     * 
     * @return a floating-point number corresponding to the smallest value observed.
     */
    public function get_minValue()
    {
        return $this->_minVal;
    }

    /**
     * Returns the average value observed during the time interval
     * covered by this measure.
     * 
     * @return a floating-point number corresponding to the average value observed.
     */
    public function get_averageValue()
    {
        return $this->_avgVal;
    }

    /**
     * Returns the largest value observed during the time interval
     * covered by this measure.
     * 
     * @return a floating-point number corresponding to the largest value observed.
     */
    public function get_maxValue()
    {
        return $this->_maxVal;
    }

    //--- (end of generated code: YMeasure implementation)
}

//--- (generated code: YFirmwareUpdate declaration)
/**
 * YFirmwareUpdate Class: Control interface for the firmware update process
 * 
 * The YFirmwareUpdate class let you control the firmware update of a Yoctopuce
 * module. This class should not be instantiate directly, instead the method
 * updateFirmware should be called to get an instance of YFirmwareUpdate.
 */
class YFirmwareUpdate
{
    //--- (end of generated code: YFirmwareUpdate declaration)
    const DATA_INVALID = YAPI_INVALID_DOUBLE;

    //--- (generated code: YFirmwareUpdate attributes)
    protected $_serial                   = "";                           // str
    protected $_settings                 = "";                           // bin
    protected $_firmwarepath             = "";                           // str
    protected $_progress_msg             = "";                           // str
    protected $_progress_c               = 0;                            // int
    protected $_progress                 = 0;                            // int
    protected $_restore_step             = 0;                            // int
    //--- (end of generated code: YFirmwareUpdate attributes)

    public function __construct($serial, $path, $settings)
    {
        //--- (generated code: YFirmwareUpdate constructor)
        //--- (end of generated code: YFirmwareUpdate constructor)
        $this->_serial = $serial;
        $this->_firmwarepath = $path;
        $this->_settings = $settings;
    }

    public function _processMore($i)
    {
        //not yet implemented
        $this->_progress = -1;
        $this->_progress_msg = "Not supported in PHP";
    }

    //--- (generated code: YFirmwareUpdate implementation)

    //cannot be generated for PHP:
    //public function _processMore($newupdate)

    public function get_progress()
    {
        $this->_processMore(0);
        return $this->_progress;
    }

    /**
     * Returns the last progress message of the firmware update process. If an error occur during the
     * firmware update process the error message is returned
     * 
     * @return an string  with the last progress message, or the error message.
     */
    public function get_progressMessage()
    {
        return $this->_progress_msg;
    }

    /**
     * Start the firmware update process. This method start the firmware update process in background. This method
     * return immediately. The progress of the firmware update can be monitored with methods get_progress()
     * and get_progressMessage().
     * 
     * @return an integer in the range 0 to 100 (percentage of completion),
     *         or a negative error code in case of failure.
     * 
     * On failure returns a negative error code.
     */
    public function startUpdate()
    {
        $this->_progress = 0;
        $this->_progress_c = 0;
        $this->_processMore(1);
        return $this->_progress;
    }

    //--- (end of generated code: YFirmwareUpdate implementation)
}

//--- (generated code: YDataStream declaration)
/**
 * YDataStream Class: Unformatted data sequence
 * 
 * YDataStream objects represent bare recorded measure sequences,
 * exactly as found within the data logger present on Yoctopuce
 * sensors.
 * 
 * In most cases, it is not necessary to use YDataStream objects
 * directly, as the YDataSet objects (returned by the
 * get_recordedData() method from sensors and the
 * get_dataSets() method from the data logger) provide
 * a more convenient interface.
 */
class YDataStream
{
    //--- (end of generated code: YDataStream declaration)
    const DATA_INVALID = YAPI_INVALID_DOUBLE;

    //--- (generated code: YDataStream attributes)
    protected $_parent                   = null;                         // YFunction
    protected $_runNo                    = 0;                            // int
    protected $_utcStamp                 = 0;                            // u32
    protected $_nCols                    = 0;                            // int
    protected $_nRows                    = 0;                            // int
    protected $_duration                 = 0;                            // int
    protected $_columnNames              = Array();                      // strArr
    protected $_functionId               = "";                           // str
    protected $_isClosed                 = 0;                            // bool
    protected $_isAvg                    = 0;                            // bool
    protected $_isScal                   = 0;                            // bool
    protected $_isScal32                 = 0;                            // bool
    protected $_decimals                 = 0;                            // int
    protected $_offset                   = 0;                            // float
    protected $_scale                    = 0;                            // float
    protected $_samplesPerHour           = 0;                            // int
    protected $_minVal                   = 0;                            // float
    protected $_avgVal                   = 0;                            // float
    protected $_maxVal                   = 0;                            // float
    protected $_decexp                   = 0;                            // float
    protected $_caltyp                   = 0;                            // int
    protected $_calpar                   = Array();                      // intArr
    protected $_calraw                   = Array();                      // floatArr
    protected $_calref                   = Array();                      // floatArr
    protected $_values                   = Array();                      // floatArrArr
    //--- (end of generated code: YDataStream attributes)

    public function __construct($obj_parent, $obj_dataset = null, $encoded = null)
    {
        //--- (generated code: YDataStream constructor)
        //--- (end of generated code: YDataStream constructor)
        $this->_parent = $obj_parent;
        $this->_calhdl = null;
        if(!is_null($obj_dataset)) {
            $this->_initFromDataSet($obj_dataset, $encoded);
        }
    }

    //--- (generated code: YDataStream implementation)

    public function _initFromDataSet($dataset,$encoded)
    {
        // $val                    is a int;
        // $i                      is a int;
        // $maxpos                 is a int;
        // $iRaw                   is a int;
        // $iRef                   is a int;
        // $fRaw                   is a float;
        // $fRef                   is a float;
        // $duration_float         is a float;
        $iCalib = Array();      // intArr;
        // decode sequence header to extract data
        $this->_runNo = $encoded[0] + ((($encoded[1]) << (16)));
        $this->_utcStamp = $encoded[2] + ((($encoded[3]) << (16)));
        $val = $encoded[4];
        $this->_isAvg = ((($val) & (0x100)) == 0);
        $this->_samplesPerHour = (($val) & (0xff));
        if ((($val) & (0x100)) != 0) {
            $this->_samplesPerHour = $this->_samplesPerHour * 3600;
        } else {
            if ((($val) & (0x200)) != 0) {
                $this->_samplesPerHour = $this->_samplesPerHour * 60;
            }
        }
        $val = $encoded[5];
        if ($val > 32767) {
            $val = $val - 65536;
        }
        $this->_decimals = $val;
        $this->_offset = $val;
        $this->_scale = $encoded[6];
        $this->_isScal = ($this->_scale != 0);
        $this->_isScal32 = (sizeof($encoded) >= 14);
        $val = $encoded[7];
        $this->_isClosed = ($val != 0xffff);
        if ($val == 0xffff) {
            $val = 0;
        }
        $this->_nRows = $val;
        $duration_float = $this->_nRows * 3600 / $this->_samplesPerHour;
        $this->_duration = round($duration_float);
        // precompute decoding parameters
        $this->_decexp = 1.0;
        if ($this->_scale == 0) {
            $i = 0;
            while ($i < $this->_decimals) {
                $this->_decexp = $this->_decexp * 10.0;
                $i = $i + 1;
            }
        }
        $iCalib = $dataset->get_calibration();
        $this->_caltyp = $iCalib[0];
        if ($this->_caltyp != 0) {
            $this->_calhdl = YAPI::_getCalibrationHandler($this->_caltyp);
            $maxpos = sizeof($iCalib);
            while(sizeof($this->_calpar) > 0) { array_pop($this->_calpar); };
            while(sizeof($this->_calraw) > 0) { array_pop($this->_calraw); };
            while(sizeof($this->_calref) > 0) { array_pop($this->_calref); };
            if ($this->_isScal32) {
                $i = 1;
                while ($i < $maxpos) {
                    $this->_calpar[] = $iCalib[$i];
                    $i = $i + 1;
                }
                $i = 1;
                while ($i + 1 < $maxpos) {
                    $fRaw = $iCalib[$i];
                    $fRaw = $fRaw / 1000.0;
                    $fRef = $iCalib[$i + 1];
                    $fRef = $fRef / 1000.0;
                    $this->_calraw[] = $fRaw;
                    $this->_calref[] = $fRef;
                    $i = $i + 2;
                }
            } else {
                $i = 1;
                while ($i + 1 < $maxpos) {
                    $iRaw = $iCalib[$i];
                    $iRef = $iCalib[$i + 1];
                    $this->_calpar[] = $iRaw;
                    $this->_calpar[] = $iRef;
                    if ($this->_isScal) {
                        $fRaw = $iRaw;
                        $fRaw = ($fRaw - $this->_offset) / $this->_scale;
                        $fRef = $iRef;
                        $fRef = ($fRef - $this->_offset) / $this->_scale;
                        $this->_calraw[] = $fRaw;
                        $this->_calref[] = $fRef;
                    } else {
                        $this->_calraw[] = YAPI::_decimalToDouble($iRaw);
                        $this->_calref[] = YAPI::_decimalToDouble($iRef);
                    }
                    $i = $i + 2;
                }
            }
        }
        // preload column names for backward-compatibility
        $this->_functionId = $dataset->get_functionId();
        if ($this->_isAvg) {
            while(sizeof($this->_columnNames) > 0) { array_pop($this->_columnNames); };
            $this->_columnNames[] = sprintf('%s_min', $this->_functionId);
            $this->_columnNames[] = sprintf('%s_avg', $this->_functionId);
            $this->_columnNames[] = sprintf('%s_max', $this->_functionId);
            $this->_nCols = 3;
        } else {
            while(sizeof($this->_columnNames) > 0) { array_pop($this->_columnNames); };
            $this->_columnNames[] = $this->_functionId;
            $this->_nCols = 1;
        }
        // decode min/avg/max values for the sequence
        if ($this->_nRows > 0) {
            if ($this->_isScal32) {
                $this->_avgVal = $this->_decodeAvg($encoded[8] + ((((($encoded[9]) ^ (0x8000))) << (16))), 1);
                $this->_minVal = $this->_decodeVal($encoded[10] + ((($encoded[11]) << (16))));
                $this->_maxVal = $this->_decodeVal($encoded[12] + ((($encoded[13]) << (16))));
            } else {
                $this->_minVal = $this->_decodeVal($encoded[8]);
                $this->_maxVal = $this->_decodeVal($encoded[9]);
                $this->_avgVal = $this->_decodeAvg($encoded[10] + ((($encoded[11]) << (16))), $this->_nRows);
            }
        }
        return 0;
    }

    public function parse($sdata)
    {
        // $idx                    is a int;
        $udat = Array();        // intArr;
        $dat = Array();         // floatArr;
        // may throw an exception
        $udat = YAPI::_decodeWords($this->_parent->_json_get_string($sdata));
        while(sizeof($this->_values) > 0) { array_pop($this->_values); };
        $idx = 0;
        if ($this->_isAvg) {
            while ($idx + 3 < sizeof($udat)) {
                while(sizeof($dat) > 0) { array_pop($dat); };
                if ($this->_isScal32) {
                    $dat[] = $this->_decodeVal($udat[$idx + 2] + ((($udat[$idx + 3]) << (16))));
                    $dat[] = $this->_decodeAvg($udat[$idx] + ((((($udat[$idx + 1]) ^ (0x8000))) << (16))), 1);
                    $dat[] = $this->_decodeVal($udat[$idx + 4] + ((($udat[$idx + 5]) << (16))));
                    $idx = $idx + 6;
                } else {
                    $dat[] = $this->_decodeVal($udat[$idx]);
                    $dat[] = $this->_decodeAvg($udat[$idx + 2] + ((($udat[$idx + 3]) << (16))), 1);
                    $dat[] = $this->_decodeVal($udat[$idx + 1]);
                    $idx = $idx + 4;
                }
                $this->_values[] = $dat;
            }
        } else {
            if ($this->_isScal && !($this->_isScal32)) {
                while ($idx < sizeof($udat)) {
                    while(sizeof($dat) > 0) { array_pop($dat); };
                    $dat[] = $this->_decodeVal($udat[$idx]);
                    $this->_values[] = $dat;
                    $idx = $idx + 1;
                }
            } else {
                while ($idx + 1 < sizeof($udat)) {
                    while(sizeof($dat) > 0) { array_pop($dat); };
                    $dat[] = $this->_decodeAvg($udat[$idx] + ((((($udat[$idx + 1]) ^ (0x8000))) << (16))), 1);
                    $this->_values[] = $dat;
                    $idx = $idx + 2;
                }
            }
        }
        
        $this->_nRows = sizeof($this->_values);
        return YAPI_SUCCESS;
    }

    public function get_url()
    {
        // $url                    is a str;
        $url = sprintf('logger.json?id=%s&run=%d&utc=%u',
                       $this->_functionId,$this->_runNo,$this->_utcStamp);
        return $url;
    }

    public function loadStream()
    {
        return $this->parse($this->_parent->_download($this->get_url()));
    }

    public function _decodeVal($w)
    {
        // $val                    is a float;
        $val = $w;
        if ($this->_isScal32) {
            $val = $val / 1000.0;
        } else {
            if ($this->_isScal) {
                $val = ($val - $this->_offset) / $this->_scale;
            } else {
                $val = YAPI::_decimalToDouble($w);
            }
        }
        if ($this->_caltyp != 0) {
            $val = call_user_func($this->_calhdl, $val, $this->_caltyp, $this->_calpar, $this->_calraw, $this->_calref);
        }
        return $val;
    }

    public function _decodeAvg($dw,$count)
    {
        // $val                    is a float;
        $val = $dw;
        if ($this->_isScal32) {
            $val = $val / 1000.0;
        } else {
            if ($this->_isScal) {
                $val = ($val / (100 * $count) - $this->_offset) / $this->_scale;
            } else {
                $val = $val / ($count * $this->_decexp);
            }
        }
        if ($this->_caltyp != 0) {
            $val = call_user_func($this->_calhdl, $val, $this->_caltyp, $this->_calpar, $this->_calraw, $this->_calref);
        }
        return $val;
    }

    public function isClosed()
    {
        return $this->_isClosed;
    }

    /**
     * Returns the run index of the data stream. A run can be made of
     * multiple datastreams, for different time intervals.
     * 
     * @return an unsigned number corresponding to the run index.
     */
    public function get_runIndex()
    {
        return $this->_runNo;
    }

    /**
     * Returns the relative start time of the data stream, measured in seconds.
     * For recent firmwares, the value is relative to the present time,
     * which means the value is always negative.
     * If the device uses a firmware older than version 13000, value is
     * relative to the start of the time the device was powered on, and
     * is always positive.
     * If you need an absolute UTC timestamp, use get_startTimeUTC().
     * 
     * @return an unsigned number corresponding to the number of seconds
     *         between the start of the run and the beginning of this data
     *         stream.
     */
    public function get_startTime()
    {
        return $this->_utcStamp - time();
    }

    /**
     * Returns the start time of the data stream, relative to the Jan 1, 1970.
     * If the UTC time was not set in the datalogger at the time of the recording
     * of this data stream, this method returns 0.
     * 
     * @return an unsigned number corresponding to the number of seconds
     *         between the Jan 1, 1970 and the beginning of this data
     *         stream (i.e. Unix time representation of the absolute time).
     */
    public function get_startTimeUTC()
    {
        return $this->_utcStamp;
    }

    /**
     * Returns the number of milliseconds between two consecutive
     * rows of this data stream. By default, the data logger records one row
     * per second, but the recording frequency can be changed for
     * each device function
     * 
     * @return an unsigned number corresponding to a number of milliseconds.
     */
    public function get_dataSamplesIntervalMs()
    {
        return intVal((3600000) / ($this->_samplesPerHour));
    }

    public function get_dataSamplesInterval()
    {
        return 3600.0 / $this->_samplesPerHour;
    }

    /**
     * Returns the number of data rows present in this stream.
     * 
     * If the device uses a firmware older than version 13000,
     * this method fetches the whole data stream from the device
     * if not yet done, which can cause a little delay.
     * 
     * @return an unsigned number corresponding to the number of rows.
     * 
     * On failure, throws an exception or returns zero.
     */
    public function get_rowCount()
    {
        if (($this->_nRows != 0) && $this->_isClosed) {
            return $this->_nRows;
        }
        $this->loadStream();
        return $this->_nRows;
    }

    /**
     * Returns the number of data columns present in this stream.
     * The meaning of the values present in each column can be obtained
     * using the method get_columnNames().
     * 
     * If the device uses a firmware older than version 13000,
     * this method fetches the whole data stream from the device
     * if not yet done, which can cause a little delay.
     * 
     * @return an unsigned number corresponding to the number of columns.
     * 
     * On failure, throws an exception or returns zero.
     */
    public function get_columnCount()
    {
        if ($this->_nCols != 0) {
            return $this->_nCols;
        }
        $this->loadStream();
        return $this->_nCols;
    }

    /**
     * Returns the title (or meaning) of each data column present in this stream.
     * In most case, the title of the data column is the hardware identifier
     * of the sensor that produced the data. For streams recorded at a lower
     * recording rate, the dataLogger stores the min, average and max value
     * during each measure interval into three columns with suffixes _min,
     * _avg and _max respectively.
     * 
     * If the device uses a firmware older than version 13000,
     * this method fetches the whole data stream from the device
     * if not yet done, which can cause a little delay.
     * 
     * @return a list containing as many strings as there are columns in the
     *         data stream.
     * 
     * On failure, throws an exception or returns an empty array.
     */
    public function get_columnNames()
    {
        if (sizeof($this->_columnNames) != 0) {
            return $this->_columnNames;
        }
        $this->loadStream();
        return $this->_columnNames;
    }

    /**
     * Returns the smallest measure observed within this stream.
     * If the device uses a firmware older than version 13000,
     * this method will always return Y_DATA_INVALID.
     * 
     * @return a floating-point number corresponding to the smallest value,
     *         or Y_DATA_INVALID if the stream is not yet complete (still recording).
     * 
     * On failure, throws an exception or returns Y_DATA_INVALID.
     */
    public function get_minValue()
    {
        return $this->_minVal;
    }

    /**
     * Returns the average of all measures observed within this stream.
     * If the device uses a firmware older than version 13000,
     * this method will always return Y_DATA_INVALID.
     * 
     * @return a floating-point number corresponding to the average value,
     *         or Y_DATA_INVALID if the stream is not yet complete (still recording).
     * 
     * On failure, throws an exception or returns Y_DATA_INVALID.
     */
    public function get_averageValue()
    {
        return $this->_avgVal;
    }

    /**
     * Returns the largest measure observed within this stream.
     * If the device uses a firmware older than version 13000,
     * this method will always return Y_DATA_INVALID.
     * 
     * @return a floating-point number corresponding to the largest value,
     *         or Y_DATA_INVALID if the stream is not yet complete (still recording).
     * 
     * On failure, throws an exception or returns Y_DATA_INVALID.
     */
    public function get_maxValue()
    {
        return $this->_maxVal;
    }

    /**
     * Returns the approximate duration of this stream, in seconds.
     * 
     * @return the number of seconds covered by this stream.
     * 
     * On failure, throws an exception or returns Y_DURATION_INVALID.
     */
    public function get_duration()
    {
        if ($this->_isClosed) {
            return $this->_duration;
        }
        return time() - $this->_utcStamp;
    }

    /**
     * Returns the whole data set contained in the stream, as a bidimensional
     * table of numbers.
     * The meaning of the values present in each column can be obtained
     * using the method get_columnNames().
     * 
     * This method fetches the whole data stream from the device,
     * if not yet done.
     * 
     * @return a list containing as many elements as there are rows in the
     *         data stream. Each row itself is a list of floating-point
     *         numbers.
     * 
     * On failure, throws an exception or returns an empty array.
     */
    public function get_dataRows()
    {
        if ((sizeof($this->_values) == 0) || !($this->_isClosed)) {
            $this->loadStream();
        }
        return $this->_values;
    }

    /**
     * Returns a single measure from the data stream, specified by its
     * row and column index.
     * The meaning of the values present in each column can be obtained
     * using the method get_columnNames().
     * 
     * This method fetches the whole data stream from the device,
     * if not yet done.
     * 
     * @param row : row index
     * @param col : column index
     * 
     * @return a floating-point number
     * 
     * On failure, throws an exception or returns Y_DATA_INVALID.
     */
    public function get_data($row,$col)
    {
        if ((sizeof($this->_values) == 0) || !($this->_isClosed)) {
            $this->loadStream();
        }
        if ($row >= sizeof($this->_values)) {
            return Y_DATA_INVALID;
        }
        if ($col >= sizeof($this->_values[$row])) {
            return Y_DATA_INVALID;
        }
        return $this->_values[$row][$col];
    }

    //--- (end of generated code: YDataStream implementation)
}

//--- (generated code: YDataSet declaration)
/**
 * YDataSet Class: Recorded data sequence
 * 
 * YDataSet objects make it possible to retrieve a set of recorded measures
 * for a given sensor and a specified time interval. They can be used
 * to load data points with a progress report. When the YDataSet object is
 * instantiated by the get_recordedData()  function, no data is
 * yet loaded from the module. It is only when the loadMore()
 * method is called over and over than data will be effectively loaded
 * from the dataLogger.
 * 
 * A preview of available measures is available using the function
 * get_preview() as soon as loadMore() has been called
 * once. Measures themselves are available using function get_measures()
 * when loaded by subsequent calls to loadMore().
 * 
 * This class can only be used on devices that use a recent firmware,
 * as YDataSet objects are not supported by firmwares older than version 13000.
 */
class YDataSet
{
    //--- (end of generated code: YDataSet declaration)
    const DATA_INVALID = YAPI_INVALID_DOUBLE;

    //--- (generated code: YDataSet attributes)
    protected $_parent                   = null;                         // YFunction
    protected $_hardwareId               = "";                           // str
    protected $_functionId               = "";                           // str
    protected $_unit                     = "";                           // str
    protected $_startTime                = 0;                            // u32
    protected $_endTime                  = 0;                            // u32
    protected $_progress                 = 0;                            // int
    protected $_calib                    = Array();                      // intArr
    protected $_streams                  = Array();                      // YDataStreamArr
    protected $_summary                  = null;                         // YMeasure
    protected $_preview                  = Array();                      // YMeasureArr
    protected $_measures                 = Array();                      // YMeasureArr
    //--- (end of generated code: YDataSet attributes)

    public function __construct($obj_parent, $str_vararg, $str_unit = null, $u32_startTime = null, $u32_endTime = null)
    {
        //--- (generated code: YDataSet constructor)
        //--- (end of generated code: YDataSet constructor)
        $this->_summary = new YMeasure(0, 0, 0, 0, 0);
        if(is_null($str_unit)) {
            // 1st version of constructor, called from YDataLogger
            $str_json = $str_vararg;

            $this->_parent     = $obj_parent;
            $this->_startTime = 0;
            $this->_endTime   = 0;
            $this->_parse($str_json);
        } else {
            // 2nd version of constructor, called from YFunction
            $str_functionId = $str_vararg;

            $this->_parent     = $obj_parent;
            $this->_functionId = $str_functionId;
            $this->_unit       = $str_unit;
            $this->_startTime  = $u32_startTime;
            $this->_endTime    = $u32_endTime;
            $this->_progress   = -1;
        }
    }

    //--- (generated code: YDataSet implementation)

    public function get_calibration()
    {
        return $this->_calib;
    }

    public function processMore($progress,$data)
    {
        // $stream                 is a YDataStream;
        $dataRows = Array();    // floatArrArr;
        // $strdata                is a str;
        // $tim                    is a float;
        // $itv                    is a float;
        // $nCols                  is a int;
        // $minCol                 is a int;
        // $avgCol                 is a int;
        // $maxCol                 is a int;
        // may throw an exception
        if ($progress != $this->_progress) {
            return $this->_progress;
        }
        if ($this->_progress < 0) {
            $strdata = $data;
            if ($strdata == '{}') {
                $this->_parent->_throw(YAPI_VERSION_MISMATCH, 'device firmware is too old');
                return YAPI_VERSION_MISMATCH;
            }
            return $this->_parse($strdata);
        }
        $stream = $this->_streams[$this->_progress];
        $stream->parse($data);
        $dataRows = $stream->get_dataRows();
        $this->_progress = $this->_progress + 1;
        if (sizeof($dataRows) == 0) {
            return $this->get_progress();
        }
        $tim = $stream->get_startTimeUTC();
        $itv = $stream->get_dataSamplesInterval();
        if ($tim < $itv) {
            $tim = $itv;
        }
        $nCols = sizeof($dataRows[0]);
        $minCol = 0;
        if ($nCols > 2) {
            $avgCol = 1;
        } else {
            $avgCol = 0;
        }
        if ($nCols > 2) {
            $maxCol = 2;
        } else {
            $maxCol = 0;
        }
        
        foreach($dataRows as $each) {
            if (($tim >= $this->_startTime) && (($this->_endTime == 0) || ($tim <= $this->_endTime))) {
                $this->_measures[] = new YMeasure($tim - $itv, $tim, $each[$minCol], $each[$avgCol], $each[$maxCol]);
            }
            $tim = $tim + $itv;
        }
        
        return $this->get_progress();
    }

    public function get_privateDataStreams()
    {
        return $this->_streams;
    }

    /**
     * Returns the unique hardware identifier of the function who performed the measures,
     * in the form SERIAL.FUNCTIONID. The unique hardware identifier is composed of the
     * device serial number and of the hardware identifier of the function
     * (for example THRMCPL1-123456.temperature1)
     * 
     * @return a string that uniquely identifies the function (ex: THRMCPL1-123456.temperature1)
     * 
     * On failure, throws an exception or returns  Y_HARDWAREID_INVALID.
     */
    public function get_hardwareId()
    {
        // $mo                     is a YModule;
        if (!($this->_hardwareId == '')) {
            return $this->_hardwareId;
        }
        $mo = $this->_parent->get_module();
        $this->_hardwareId = sprintf('%s.%s', $mo->get_serialNumber(), $this->get_functionId());
        return $this->_hardwareId;
    }

    /**
     * Returns the hardware identifier of the function that performed the measure,
     * without reference to the module. For example temperature1.
     * 
     * @return a string that identifies the function (ex: temperature1)
     */
    public function get_functionId()
    {
        return $this->_functionId;
    }

    /**
     * Returns the measuring unit for the measured value.
     * 
     * @return a string that represents a physical unit.
     * 
     * On failure, throws an exception or returns  Y_UNIT_INVALID.
     */
    public function get_unit()
    {
        return $this->_unit;
    }

    /**
     * Returns the start time of the dataset, relative to the Jan 1, 1970.
     * When the YDataSet is created, the start time is the value passed
     * in parameter to the get_dataSet() function. After the
     * very first call to loadMore(), the start time is updated
     * to reflect the timestamp of the first measure actually found in the
     * dataLogger within the specified range.
     * 
     * @return an unsigned number corresponding to the number of seconds
     *         between the Jan 1, 1970 and the beginning of this data
     *         set (i.e. Unix time representation of the absolute time).
     */
    public function get_startTimeUTC()
    {
        return $this->_startTime;
    }

    /**
     * Returns the end time of the dataset, relative to the Jan 1, 1970.
     * When the YDataSet is created, the end time is the value passed
     * in parameter to the get_dataSet() function. After the
     * very first call to loadMore(), the end time is updated
     * to reflect the timestamp of the last measure actually found in the
     * dataLogger within the specified range.
     * 
     * @return an unsigned number corresponding to the number of seconds
     *         between the Jan 1, 1970 and the end of this data
     *         set (i.e. Unix time representation of the absolute time).
     */
    public function get_endTimeUTC()
    {
        return $this->_endTime;
    }

    /**
     * Returns the progress of the downloads of the measures from the data logger,
     * on a scale from 0 to 100. When the object is instantiated by get_dataSet,
     * the progress is zero. Each time loadMore() is invoked, the progress
     * is updated, to reach the value 100 only once all measures have been loaded.
     * 
     * @return an integer in the range 0 to 100 (percentage of completion).
     */
    public function get_progress()
    {
        if ($this->_progress < 0) {
            return 0;
        }
        // index not yet loaded
        if ($this->_progress >= sizeof($this->_streams)) {
            return 100;
        }
        return intVal((1 + (1 + $this->_progress) * 98 ) / ((1 + sizeof($this->_streams))));
    }

    /**
     * Loads the the next block of measures from the dataLogger, and updates
     * the progress indicator.
     * 
     * @return an integer in the range 0 to 100 (percentage of completion),
     *         or a negative error code in case of failure.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function loadMore()
    {
        // $url                    is a str;
        // $stream                 is a YDataStream;
        if ($this->_progress < 0) {
            $url = sprintf('logger.json?id=%s',$this->_functionId);
        } else {
            if ($this->_progress >= sizeof($this->_streams)) {
                return 100;
            } else {
                $stream = $this->_streams[$this->_progress];
                $url = $stream->get_url();
            }
        }
        return $this->processMore($this->_progress, $this->_parent->_download($url));
    }

    /**
     * Returns an YMeasure object which summarizes the whole
     * DataSet. In includes the following information:
     * - the start of a time interval
     * - the end of a time interval
     * - the minimal value observed during the time interval
     * - the average value observed during the time interval
     * - the maximal value observed during the time interval
     * 
     * This summary is available as soon as loadMore() has
     * been called for the first time.
     * 
     * @return an YMeasure object
     */
    public function get_summary()
    {
        return $this->_summary;
    }

    /**
     * Returns a condensed version of the measures that can
     * retrieved in this YDataSet, as a list of YMeasure
     * objects. Each item includes:
     * - the start of a time interval
     * - the end of a time interval
     * - the minimal value observed during the time interval
     * - the average value observed during the time interval
     * - the maximal value observed during the time interval
     * 
     * This preview is available as soon as loadMore() has
     * been called for the first time.
     * 
     * @return a table of records, where each record depicts the
     *         measured values during a time interval
     * 
     * On failure, throws an exception or returns an empty array.
     */
    public function get_preview()
    {
        return $this->_preview;
    }

    /**
     * Returns all measured values currently available for this DataSet,
     * as a list of YMeasure objects. Each item includes:
     * - the start of the measure time interval
     * - the end of the measure time interval
     * - the minimal value observed during the time interval
     * - the average value observed during the time interval
     * - the maximal value observed during the time interval
     * 
     * Before calling this method, you should call loadMore()
     * to load data from the device. You may have to call loadMore()
     * several time until all rows are loaded, but you can start
     * looking at available data rows before the load is complete.
     * 
     * The oldest measures are always loaded first, and the most
     * recent measures will be loaded last. As a result, timestamps
     * are normally sorted in ascending order within the measure table,
     * unless there was an unexpected adjustment of the datalogger UTC
     * clock.
     * 
     * @return a table of records, where each record depicts the
     *         measured value for a given time interval
     * 
     * On failure, throws an exception or returns an empty array.
     */
    public function get_measures()
    {
        return $this->_measures;
    }

    //--- (end of generated code: YDataSet implementation)

    // YDataSet parser for stream list
    public function _parse($str_json)
    {
        $summaryMinVal    = 9e1000;
        $summaryMaxVal    = -9e1000;
        $summaryTotalTime = 0;
        $summaryTotalAvg  = 0;
        $loadval = json_decode($str_json, true);

        $this->_functionId = $loadval['id'];
        $this->_unit       = $loadval['unit'];
        if(isset($loadval['calib'])) {
            $this->_calib  = YAPI::_decodeFloats($loadval['calib']);
            $this->_calib[0] = intVal($this->_calib[0] / 1000);
        } else {
            $this->_calib  = YAPI::_decodeWords($loadval['cal']);
        }
        $this->_summary    = new YMeasure(0,0,0,0,0);
        $this->_streams    = Array();
        $this->_preview    = Array();
        $this->_measures   = Array();
        for($i = 0; $i < sizeof($loadval['streams']); $i++) {
            /** @var $stream YDataStream */
            $stream = $this->_parent->_findDataStream($this, $loadval['streams'][$i]);
            if($this->_startTime > 0 && $stream->get_startTimeUTC() + $stream->get_duration() <= $this->_startTime) {
                // this stream is too early, drop it
            } else if($this->_endTime > 0 && $stream->get_startTimeUTC() > $this->_endTime) {
                // this stream is too late, drop it
            } else {
                $this->_streams[] = $stream;
                if($stream->isClosed() && $stream->get_startTimeUTC() >= $this->_startTime &&
                ($this->_endTime == 0 || $stream->get_startTimeUTC() + $stream->get_duration() <= $this->_endTime)) {
                    if ($summaryMinVal > $stream->get_minValue())
                        $summaryMinVal = $stream->get_minValue();
                    if ($summaryMaxVal < $stream->get_maxValue())
                        $summaryMaxVal = $stream->get_maxValue();
                    $summaryTotalAvg  += $stream->get_averageValue() * $stream->get_duration();
                    $summaryTotalTime += $stream->get_duration();

                    $rec = new YMeasure($stream->get_startTimeUTC(),
                                        $stream->get_startTimeUTC() + $stream->get_duration(),
                                        $stream->get_minValue(),
                                        $stream->get_averageValue(),
                                        $stream->get_maxValue());
                    $this->_preview[] = $rec;
                }
            }
        }
        if((sizeof($this->_streams) > 0) && ($summaryTotalTime>0)) {
            // update time boundaries with actual data
            $stream = $this->_streams[sizeof($this->_streams)-1];
            $endtime = $stream->get_startTimeUTC() + $stream->get_duration();
            $startTime = $this->_streams[0]->get_startTimeUTC() - $stream->get_dataSamplesIntervalMs()/1000;
            if($this->_startTime < $startTime) {
                $this->_startTime = $startTime;
            }
            if($this->_endTime == 0 || $this->_endTime > $endtime) {
                $this->_endTime = $endtime;
            }
            $this->_summary = new YMeasure($this->_startTime,$this->_endTime,
                                           $summaryMinVal,$summaryTotalAvg/$summaryTotalTime,$summaryMaxVal);
        }
        $this->_progress = 0;
        return $this->get_progress();
    }
}


//--- (generated code: YFunction declaration)
/**
 * YFunction Class: Common function interface
 * 
 * This is the parent class for all public objects representing device functions documented in
 * the high-level programming API. This abstract class does all the real job, but without
 * knowledge of the specific function attributes.
 * 
 * Instantiating a child class of YFunction does not cause any communication.
 * The instance simply keeps track of its function identifier, and will dynamically bind
 * to a matching device at the time it is really being used to read or set an attribute.
 * In order to allow true hot-plug replacement of one device by another, the binding stay
 * dynamic through the life of the object.
 * 
 * The YFunction class implements a generic high-level cache for the attribute values of
 * the specified function, pre-parsed from the REST API string.
 */
class YFunction
{
    const LOGICALNAME_INVALID            = YAPI_INVALID_STRING;
    const ADVERTISEDVALUE_INVALID        = YAPI_INVALID_STRING;
    //--- (end of generated code: YFunction declaration)
    /** @var YFunction[] */
    public static $_TimedReportCallbackList = Array();
    /** @var YFunction[] */
    public static $_ValueCallbackList   = Array();

    protected $_className                = 'Function';
    protected $_func;
    protected $_lastErrorType            = YAPI_SUCCESS;
    protected $_lastErrorMsg             = 'no error';
    protected $_dataStreams;
    protected $_userData                 = NULL;
    protected $_cache;
    //--- (generated code: YFunction attributes)
    protected $_logicalName              = Y_LOGICALNAME_INVALID;        // Text
    protected $_advertisedValue          = Y_ADVERTISEDVALUE_INVALID;    // PubText
    protected $_valueCallbackFunction    = null;                         // YFunctionValueCallback
    protected $_cacheExpiration          = 0;                            // ulong
    protected $_serial                   = "";                           // str
    protected $_funId                    = "";                           // str
    protected $_hwId                     = "";                           // str
    //--- (end of generated code: YFunction attributes)

    function __construct($str_func)
    {
        $this->_func          = $str_func;
        $this->_cache         = Array('_expiration' => 0);
        $this->_dataStreams   = Array();

        //--- (generated code: YFunction constructor)
        //--- (end of generated code: YFunction constructor)
    }

    // internal helper for YFunctionType
    function _getHwId()
    {
        return $this->_hwId;
    }

    //--- (generated code: YFunction implementation)

    function _parseAttr($name, $val)
    {
        switch($name) {
        case '_expiration':
            $this->_cacheExpiration = $val;
            return 1;
        case 'logicalName':
            $this->_logicalName = $val;
            return 1;
        case 'advertisedValue':
            $this->_advertisedValue = $val;
            return 1;
        }
        return 0;
    }

    /**
     * Returns the logical name of the function.
     * 
     * @return a string corresponding to the logical name of the function
     * 
     * On failure, throws an exception or returns Y_LOGICALNAME_INVALID.
     */
    public function get_logicalName()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_LOGICALNAME_INVALID;
            }
        }
        return $this->_logicalName;
    }

    /**
     * Changes the logical name of the function. You can use yCheckLogicalName()
     * prior to this call to make sure that your parameter is valid.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     * 
     * @param newval : a string corresponding to the logical name of the function
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_logicalName($newval)
    {
        if (!YAPI::CheckLogicalName($newval))
            return $this->_throw(YAPI_INVALID_ARGUMENT,'Invalid name :'.$newval);
        $rest_val = $newval;
        return $this->_setAttr("logicalName",$rest_val);
    }

    /**
     * Returns the current value of the function (no more than 6 characters).
     * 
     * @return a string corresponding to the current value of the function (no more than 6 characters)
     * 
     * On failure, throws an exception or returns Y_ADVERTISEDVALUE_INVALID.
     */
    public function get_advertisedValue()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_ADVERTISEDVALUE_INVALID;
            }
        }
        return $this->_advertisedValue;
    }

    /**
     * Retrieves a function for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     * 
     * This function does not require that the function is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method YFunction.isOnline() to test if the function is
     * indeed online at a given time. In case of ambiguity when looking for
     * a function by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     * 
     * @param func : a string that uniquely characterizes the function
     * 
     * @return a YFunction object allowing you to drive the function.
     */
    public static function FindFunction($func)
    {
        // $obj                    is a YFunction;
        $obj = YFunction::_FindFromCache('Function', $func);
        if ($obj == null) {
            $obj = new YFunction($func);
            YFunction::_AddToCache('Function', $func, $obj);
        }
        return $obj;
    }

    /**
     * Registers the callback function that is invoked on every change of advertised value.
     * The callback is invoked only during the execution of ySleep or yHandleEvents.
     * This provides control over the time when the callback is triggered. For good responsiveness, remember to call
     * one of these two functions periodically. To unregister a callback, pass a null pointer as argument.
     * 
     * @param callback : the callback function to call, or a null pointer. The callback function should take two
     *         arguments: the function object of which the value has changed, and the character string describing
     *         the new advertised value.
     * @noreturn
     */
    public function registerValueCallback($callback)
    {
        // $val                    is a str;
        if (!is_null($callback)) {
            YFunction::_UpdateValueCallbackList($this, true);
        } else {
            YFunction::_UpdateValueCallbackList($this, false);
        }
        $this->_valueCallbackFunction = $callback;
        // Immediately invoke value callback with current value
        if (!is_null($callback) && $this->isOnline()) {
            $val = $this->_advertisedValue;
            if (!($val == '')) {
                $this->_invokeValueCallback($val);
            }
        }
        return 0;
    }

    public function _invokeValueCallback($value)
    {
        if (!is_null($this->_valueCallbackFunction)) {
            call_user_func($this->_valueCallbackFunction, $this, $value);
        } else {
        }
        return 0;
    }

    public function _parserHelper()
    {
        return 0;
    }

    public function logicalName()
    { return $this->get_logicalName(); }

    public function setLogicalName($newval)
    { return $this->set_logicalName($newval); }

    public function advertisedValue()
    { return $this->get_advertisedValue(); }

    /**
     * comment from .yc definition
     */
    public function nextFunction()
    {   $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if($resolve->errorType != YAPI_SUCCESS) return null;
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if($next_hwid == null) return null;
        return yFindFunction($next_hwid);
    }

    /**
     * comment from .yc definition
     */
    public static function FirstFunction()
    {   $next_hwid = YAPI::getFirstHardwareId('Function');
        if($next_hwid == null) return null;
        return self::FindFunction($next_hwid);
    }

    //--- (end of generated code: YFunction implementation)

    public static function _FindFromCache($className, $func)
    {
        return YAPI::getFunction($className, $func);
    }

    public static function _AddToCache($className, $func, $obj)
    {
        YAPI::setFunction($className, $func, $obj);
    }

    public static function _ClearCache()
    {
        YAPI::_init();
    }

    /**
     * internal function
     * @param YFunction $obj_func
     * @param bool $bool_add
     */
    public static function _UpdateValueCallbackList($obj_func, $bool_add)
    {
        $index = array_search($obj_func, self::$_ValueCallbackList);
        if ($bool_add) {
            $obj_func->isOnline();
            if($index === false) {
                self::$_ValueCallbackList[] = $obj_func;
            }
        } else if($index !== false) {
            array_splice(self::$_ValueCallbackList, $index, 1);
        }
    }

    /**
     * internal function
     * @param YFunction $obj_func
     * @param bool $bool_add
     */
    public static function _UpdateTimedReportCallbackList($obj_func, $bool_add)
    {
        $index = array_search($obj_func, self::$_TimedReportCallbackList);
        if ($bool_add) {
            $obj_func->isOnline();
            if($index === false) {
                self::$_TimedReportCallbackList[] = $obj_func;
            }
        } else if($index !== false) {
            array_splice(self::$_TimedReportCallbackList, $index, 1);
        }
    }

    // Throw an exception, keeping track of it in the object itself
    public function _throw($int_errType, $str_errMsg, $obj_retVal=null)
    {
        $this->_lastErrorType = $int_errType;
        $this->_lastErrorMsg = $str_errMsg;

        if(YAPI::$exceptionsDisabled) {
            return $obj_retVal;
        }
        // throw an exception
        throw new YAPI_Exception($str_errMsg, $int_errType);
    }

    /**
     * Returns a short text that describes unambiguously the instance of the function in the form
     * TYPE(NAME)=SERIAL&#46;FUNCTIONID.
     * More precisely,
     * TYPE       is the type of the function,
     * NAME       it the name used for the first access to the function,
     * SERIAL     is the serial number of the module if the module is connected or "unresolved", and
     * FUNCTIONID is  the hardware identifier of the function if the module is connected.
     * For example, this method returns Relay(MyCustomName.relay1)=RELAYLO1-123456.relay1 if the
     * module is already connected or Relay(BadCustomeName.relay1)=unresolved if the module has
     * not yet been connected. This method does not trigger any USB or TCP transaction and can therefore be used in
     * a debugger.
     * 
     * @return a string that describes the function
     *         (ex: Relay(MyCustomName.relay1)=RELAYLO1-123456.relay1)
     */
    public function describe()
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if($resolve->errorType != YAPI_SUCCESS && $resolve->result != $this->_func) {
            return $this->_className."({$this->_func})=unresolved";
        }
        return $this->_className."({$this->_func})={$resolve->result}";
    }

    /**
     * Returns the unique hardware identifier of the function in the form SERIAL.FUNCTIONID.
     * The unique hardware identifier is composed of the device serial
     * number and of the hardware identifier of the function (for example RELAYLO1-123456.relay1).
     * 
     * @return a string that uniquely identifies the function (ex: RELAYLO1-123456.relay1)
     * 
     * On failure, throws an exception or returns  Y_HARDWAREID_INVALID.
     */
    public function get_hardwareId()
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if($resolve->errorType != YAPI_SUCCESS) {
            $this->isOnline();
            $resolve = YAPI::resolveFunction($this->_className, $this->_func);
            if($resolve->errorType != YAPI_SUCCESS) {
                return $this->_throw($resolve->errorType, $resolve->errorMsg, Y_HARDWAREID_INVALID);
            }
        }
        return $resolve->result;
    }

    /**
     * Returns the hardware identifier of the function, without reference to the module. For example
     * relay1
     * 
     * @return a string that identifies the function (ex: relay1)
     * 
     * On failure, throws an exception or returns  Y_FUNCTIONID_INVALID.
     */
    public function get_functionId()
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if($resolve->errorType != YAPI_SUCCESS) {
            $this->isOnline();
            $resolve = YAPI::resolveFunction($this->_className, $this->_func);
            if($resolve->errorType != YAPI_SUCCESS) {
                return $this->_throw($resolve->errorType, $resolve->errorMsg, Y_FUNCTIONID_INVALID);
            }
        }
        return substr($resolve->result,strpos($resolve->result,'.')+1);
    }

    /**
     * Returns a global identifier of the function in the format MODULE_NAME&#46;FUNCTION_NAME.
     * The returned string uses the logical names of the module and of the function if they are defined,
     * otherwise the serial number of the module and the hardware identifier of the function
     * (for example: MyCustomName.relay1)
     * 
     * @return a string that uniquely identifies the function using logical names
     *         (ex: MyCustomName.relay1)
     * 
     * On failure, throws an exception or returns  Y_FRIENDLYNAME_INVALID.
     */
    public function get_friendlyName()
    {
        $resolve = YAPI::getFriendlyNameFunction($this->_className, $this->_func);
        if($resolve->errorType != YAPI_SUCCESS) {
            $this->isOnline();
            $resolve = YAPI::getFriendlyNameFunction($this->_className, $this->_func);
            if($resolve->errorType != YAPI_SUCCESS) {
                return $this->_throw($resolve->errorType, $resolve->errorMsg, Y_FRIENDLYNAME_INVALID);
            }
        }
        return $resolve->result;
    }


    // Store and parse a an API request for current function
    //
    protected function _parse($yreq, $msValidity)
    {
        // save the whole structure for backward-compatibility
        $yreq->result["_expiration"] = YAPI::GetTickCount() + $msValidity;
        $this->_serial = $yreq->deviceid;
        $this->_funId  = $yreq->functionid;
        $this->_hwId   = $yreq->hwid;
        $this->_cache  = $yreq->result;
        // process each attribute in turn for class-oriented processing
        foreach($yreq->result as $key => $val) {
            $this->_parseAttr($key, $val);
        }
        $this->_parserHelper();
    }

    // Return the value of an attribute from function cache, after reloading it from device if needed
    // Note: the function cache is a typed (parsed) cache, contrarily to the agnostic device cache
    protected function _getAttr($str_attr)
    {
        if($this->_cache['_expiration'] <= YAPI::GetTickCount()) {
            // no valid cached value, reload from device
            if($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) return null;
        }
        if(!isset($this->_cache[$str_attr])) {
            $this->_throw(YAPI_VERSION_MISMATCH, 'No such attribute $str_attr in function', null);
        }
        return $this->_cache[$str_attr];
    }

    // Return the value of an attribute from function cache, after loading it from device if never done
    protected function _getFixedAttr($str_attr)
    {
        if($this->_cache['_expiration'] == 0) {
            // no cached value, load from device
            if($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) return null;
        }
        if(!isset($this->_cache[$str_attr])) {
            $this->_throw(YAPI_VERSION_MISMATCH, "No such attribute $str_attr in function", null);
        }
        return $this->_cache[$str_attr];
    }

    protected function _escapeAttr($str_newval)
    {
        // urlencode according to RFC 3986 instead of php default RFC 1738
        $safecodes = array('%21','%23','%24','%27','%28','%29','%2A','%2C','%2F','%3A','%3B','%40','%3F','%5B','%5D');
        $safechars = array('!',  "#",  "$",  "'",  "(",  ")",  '*',  ",",  "/",  ":",  ";",  "@",  "?",  "[",  "]");
        return str_replace($safecodes, $safechars, urlencode($str_newval));
    }


    // Change the value of an attribute on a device, and update cache on the fly
    // Note: the function cache is a typed (parsed) cache, contrarily to the agnostic device cache
    protected function _setAttr($str_attr, $str_newval)
    {
        if(!isset($str_newval)) {
            $this->_throw(YAPI_INVALID_ARGUMENT, "Undefined value to set for attribute $str_attr", null);
        }
        // urlencode according to RFC 3986 instead of php default RFC 1738
        $safecodes = array('%21','%23','%24','%27','%28','%29','%2A','%2C','%2F','%3A','%3B','%40','%3F','%5B','%5D');
        $safechars = array('!',  "#",  "$",  "'",  "(",  ")",  '*',  ",",  "/",  ":",  ";",  "@",  "?",  "[",  "]");
        $attrname = str_replace($safecodes, $safechars, urlencode($str_attr));
        $extra = "/$attrname?$attrname=" . $this->_escapeAttr($str_newval) . "&.";
        $yreq = YAPI::funcRequest($this->_className, $this->_func, $extra);
        if($this->_cache['_expiration'] != 0){
            $this->_cache['_expiration'] = YAPI::GetTickCount();
        }
        if($yreq->errorType != YAPI_SUCCESS) {
            return $this->_throw($yreq->errorType, $yreq->errorMsg, $yreq->errorType);
        }
        return YAPI_SUCCESS;
    }

    // Execute an arbitrary HTTP GET request on the device and return the binary content
    //
    public function _download($str_path)
    {
        // get the device serial number
        /** @noinspection PhpUndefinedMethodInspection */
        $devid = $this->module()->get_serialNumber();
        if($devid == Y_SERIALNUMBER_INVALID) {
            return '';
        }
        $yreq = YAPI::devRequest($devid, "GET /$str_path");
        if($yreq->errorType != YAPI_SUCCESS) {
            return $this->_throw($yreq->errorType, $yreq->errorMsg, '');
        }
        return $yreq->result;
    }

    // Upload a file to the filesystem, to the specified full path name.
    // If a file already exists with the same path name, its content is overwritten.
    //
    public function _upload($str_path, $bin_content)
    {
        // get the device serial number
        /** @noinspection PhpUndefinedMethodInspection */
        $devid = $this->module()->get_serialNumber();
        if($devid == Y_SERIALNUMBER_INVALID) {
            return $this->get_errorType();
        }
        if(is_array($bin_content)) {
            $bin_content = call_user_func_array('pack', array_merge(array("C*"), $bin_content));
        }
        $httpreq = 'POST /upload.html';
    	$body = "Content-Disposition: form-data; name=\"$str_path\"; filename=\"api\"\r\n".
                "Content-Type: application/octet-stream\r\n".
                "Content-Transfer-Encoding: binary\r\n\r\n".$bin_content;
        $yreq = YAPI::devRequest($devid, $httpreq, true, $body);
        if($yreq->errorType != YAPI_SUCCESS) {
            return $yreq->errorType;
        }
        return YAPI_SUCCESS;
    }

    // Get a value from a JSON buffer
    //
    public function _json_get_key($bin_jsonbuff, $str_key)
    {
        $loadval = json_decode($bin_jsonbuff, true);
        if(isset($loadval[$str_key])) {
            return $loadval[$str_key];
        }
        return "";
    }

    // Get a string from a JSON buffer
    //
    public function _json_get_string($bin_jsonbuff)
    {
        return json_decode($bin_jsonbuff, true);
    }

    // Get an array of strings from a JSON buffer
    //
    public function _json_get_array($bin_jsonbuff)
    {
        $loadval = json_decode($bin_jsonbuff, true);
        $res = Array();
        foreach($loadval as $record) {
            $res[] = json_encode($record);
        }
        return $res;
    }

    /**
     * Method used to cache DataStream objects (new DataLogger)
     * @param YDataSet $obj_dataset
     * @param string $str_def
     * @return YDataStream
     */
    public function _findDataStream($obj_dataset, $str_def)
    {
        $key = $obj_dataset->get_functionId().":".$str_def;
        if(isset($this->_dataStreams[$key]))
            return $this->_dataStreams[$key];

        $newDataStream = new YDataStream($this, $obj_dataset, YAPI::_decodeWords($str_def));
        $this->_dataStreams[$key] = $newDataStream;
        return $newDataStream;
    }

    public function _getValueCallback()
    {
        return $this->_valueCallbackFunction;
    }

    /**
     * Checks if the function is currently reachable, without raising any error.
     * If there is a cached value for the function in cache, that has not yet
     * expired, the device is considered reachable.
     * No exception is raised if there is an error while trying to contact the
     * device hosting the function.
     * 
     * @return true if the function can be reached, and false otherwise
     */
    public function isOnline()
    {
        // A valid value in cache means that the device is online
        if($this->_cache['_expiration'] > YAPI::GetTickCount()) return true;

        // Check that the function is available without throwing exceptions
        $yreq = YAPI::funcRequest($this->_className, $this->_func, '');
        if($yreq->errorType != YAPI_SUCCESS) {
            return false;
        }
        // save result in cache anyway
        $this->_parse($yreq, YAPI::$defaultCacheValidity);

        return true;
    }

    /**
     * Returns the numerical error code of the latest error with the function.
     * This method is mostly useful when using the Yoctopuce library with
     * exceptions disabled.
     * 
     * @return a number corresponding to the code of the latest error that occurred while
     *         using the function object
     */
    public function get_errorType()
    {
        return $this->_lastErrorType;
    }
    public function errorType()
    {
        return $this->_lastErrorType;
    }
    public function errType()
    {
        return $this->_lastErrorType;
    }

    /**
     * Returns the error message of the latest error with the function.
     * This method is mostly useful when using the Yoctopuce library with
     * exceptions disabled.
     * 
     * @return a string corresponding to the latest error message that occured while
     *         using the function object
     */
    public function get_errorMessage()
    {
        return $this->_lastErrorMsg;
    }
    public function errorMessage()
    {
        return $this->_lastErrorMsg;
    }
    public function errMessage()
    {
        return $this->_lastErrorMsg;
    }

    /**
     * Preloads the function cache with a specified validity duration.
     * By default, whenever accessing a device, all function attributes
     * are kept in cache for the standard duration (5 ms). This method can be
     * used to temporarily mark the cache as valid for a longer period, in order
     * to reduce network traffic for instance.
     * 
     * @param msValidity : an integer corresponding to the validity attributed to the
     *         loaded function parameters, in milliseconds
     * 
     * @return YAPI_SUCCESS when the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function load($msValidity)
    {
        $yreq = YAPI::funcRequest($this->_className, $this->_func, '');
        if($yreq->errorType != YAPI_SUCCESS) {
            return $this->_throw($yreq->errorType, $yreq->errorMsg, $yreq->errorType);
        }
        $this->_parse($yreq, $msValidity);

        return YAPI_SUCCESS;
    }

    /**
     * Gets the YModule object for the device on which the function is located.
     * If the function cannot be located on any module, the returned instance of
     * YModule is not shown as on-line.
     * 
     * @return an instance of YModule
     */
    public function get_module()
    {
        // try to resolve the function name to a device id without query
        if($this->_serial != '') {
            return yFindModule($this->_serial.'.module');
        }
        $hwid = $this->_func;
        if(strpos($hwid, '.') === FALSE) {
            $resolve = YAPI::resolveFunction($this->_className, $this->_func);
            if($resolve->errorType == YAPI_SUCCESS) $hwid = $resolve->result;
        }
        $dotidx = strpos($hwid, '.');
        if($dotidx !== FALSE) {
            // resolution worked
            return yFindModule(substr($hwid, 0, $dotidx).'.module');
        }

        // device not resolved for now, force a communication for a last chance resolution
        if($this->load(YAPI::$defaultCacheValidity) == YAPI_SUCCESS) {
            $resolve = YAPI::resolveFunction($this->_className, $this->_func);
            if($resolve->errorType == YAPI_SUCCESS) $hwid = $resolve->result;
        }
        $dotidx = strpos($hwid, '.');
        if($dotidx !== FALSE) {
            // resolution worked
            return yFindModule(substr($hwid, 0, $dotidx).'.module');
        }
        // return a true yFindModule object even if it is not a module valid for communicating
        return yFindModule('module_of_'.$this->_className.'_'.$this->_func);
    }
    public function module()
    { return $this->get_module(); }

    /**
     * Returns a unique identifier of type YFUN_DESCR corresponding to the function.
     * This identifier can be used to test if two instances of YFunction reference the same
     * physical function on the same physical device.
     * 
     * @return an identifier of type YFUN_DESCR.
     * 
     * If the function has never been contacted, the returned value is Y_FUNCTIONDESCRIPTOR_INVALID.
     */
    public function get_functionDescriptor()
    {
        // try to resolve the function name to a device id without query
        $hwid = $this->_func;
        if(strpos($hwid, '.') === FALSE) {
            $resolve = YAPI::resolveFunction($this->_className, $this->_func);
            if($resolve->errorType != YAPI_SUCCESS) $hwid = $resolve->result;
        }
        $dotidx = strpos($hwid, '.');
        if($dotidx !== FALSE) {
            // resolution worked
            return $hwid;
        }
        return Y_FUNCTIONDESCRIPTOR_INVALID;
    }
    public function getFunctionDescriptor()
    { return $this->get_functionDescriptor(); }

    /**
     * Returns the value of the userData attribute, as previously stored using method
     * set_userData.
     * This attribute is never touched directly by the API, and is at disposal of the caller to
     * store a context.
     * 
     * @return the object stored previously by the caller.
     */
    public function get_userData()
    {
        return $this->_userData;
    }
    public function userData()
    {
        return $this->_userData;
    }

    /**
     * Stores a user context provided as argument in the userData attribute of the function.
     * This attribute is never touched by the API, and is at disposal of the caller to store a context.
     * 
     * @param data : any kind of object to be stored
     * @noreturn
     */
    public function set_userData($data)
    {
        $this->_userData = $data;
    }
    public function setUserData($data)
    {
        $this->_userData = $data;
    }
}

//--- (generated code: YSensor declaration)
/**
 * YSensor Class: Sensor function interface
 * 
 * The Yoctopuce application programming interface allows you to read an instant
 * measure of the sensor, as well as the minimal and maximal values observed.
 */
class YSensor extends YFunction
{
    const UNIT_INVALID                   = YAPI_INVALID_STRING;
    const CURRENTVALUE_INVALID           = YAPI_INVALID_DOUBLE;
    const LOWESTVALUE_INVALID            = YAPI_INVALID_DOUBLE;
    const HIGHESTVALUE_INVALID           = YAPI_INVALID_DOUBLE;
    const CURRENTRAWVALUE_INVALID        = YAPI_INVALID_DOUBLE;
    const LOGFREQUENCY_INVALID           = YAPI_INVALID_STRING;
    const REPORTFREQUENCY_INVALID        = YAPI_INVALID_STRING;
    const CALIBRATIONPARAM_INVALID       = YAPI_INVALID_STRING;
    const RESOLUTION_INVALID             = YAPI_INVALID_DOUBLE;
    //--- (end of generated code: YSensor declaration)
    const DATA_INVALID                   = YAPI_INVALID_DOUBLE;

    //--- (generated code: YSensor attributes)
    protected $_unit                     = Y_UNIT_INVALID;               // Text
    protected $_currentValue             = Y_CURRENTVALUE_INVALID;       // MeasureVal
    protected $_lowestValue              = Y_LOWESTVALUE_INVALID;        // MeasureVal
    protected $_highestValue             = Y_HIGHESTVALUE_INVALID;       // MeasureVal
    protected $_currentRawValue          = Y_CURRENTRAWVALUE_INVALID;    // MeasureVal
    protected $_logFrequency             = Y_LOGFREQUENCY_INVALID;       // YFrequency
    protected $_reportFrequency          = Y_REPORTFREQUENCY_INVALID;    // YFrequency
    protected $_calibrationParam         = Y_CALIBRATIONPARAM_INVALID;   // CalibParams
    protected $_resolution               = Y_RESOLUTION_INVALID;         // MeasureVal
    protected $_timedReportCallbackSensor = null;                         // YSensorTimedReportCallback
    protected $_prevTimedReport          = 0;                            // float
    protected $_iresol                   = 0;                            // float
    protected $_offset                   = 0;                            // float
    protected $_scale                    = 0;                            // float
    protected $_decexp                   = 0;                            // float
    protected $_isScal                   = 0;                            // bool
    protected $_isScal32                 = 0;                            // bool
    protected $_caltyp                   = 0;                            // int
    protected $_calpar                   = Array();                      // intArr
    protected $_calraw                   = Array();                      // floatArr
    protected $_calref                   = Array();                      // floatArr
    protected $_calhdl                   = null;                         // yCalibrationHandler
    //--- (end of generated code: YSensor attributes)

    function __construct($str_func)
    {
        //--- (YSensor constructor)
        parent::__construct($str_func);
        $this->_className = 'Sensor';

        //--- (end of YSensor constructor)
    }

    public function _getTimedReportCallback()
    {
        return $this->_timedReportCallbackSensor;
    }

    //--- (generated code: YSensor implementation)

    function _parseAttr($name, $val)
    {
        switch($name) {
        case 'unit':
            $this->_unit = $val;
            return 1;
        case 'currentValue':
            $this->_currentValue = round($val * 1000.0 / 65536.0) / 1000.0;
            return 1;
        case 'lowestValue':
            $this->_lowestValue = round($val * 1000.0 / 65536.0) / 1000.0;
            return 1;
        case 'highestValue':
            $this->_highestValue = round($val * 1000.0 / 65536.0) / 1000.0;
            return 1;
        case 'currentRawValue':
            $this->_currentRawValue = round($val * 1000.0 / 65536.0) / 1000.0;
            return 1;
        case 'logFrequency':
            $this->_logFrequency = $val;
            return 1;
        case 'reportFrequency':
            $this->_reportFrequency = $val;
            return 1;
        case 'calibrationParam':
            $this->_calibrationParam = $val;
            return 1;
        case 'resolution':
            $this->_resolution = round($val * 1000.0 / 65536.0) / 1000.0;
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Returns the measuring unit for the measure.
     * 
     * @return a string corresponding to the measuring unit for the measure
     * 
     * On failure, throws an exception or returns Y_UNIT_INVALID.
     */
    public function get_unit()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_UNIT_INVALID;
            }
        }
        return $this->_unit;
    }

    /**
     * Returns the current value of the measure, in the specified unit, as a floating point number.
     * 
     * @return a floating point number corresponding to the current value of the measure, in the specified
     * unit, as a floating point number
     * 
     * On failure, throws an exception or returns Y_CURRENTVALUE_INVALID.
     */
    public function get_currentValue()
    {
        // $res                    is a float;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_CURRENTVALUE_INVALID;
            }
        }
        $res = $this->_applyCalibration($this->_currentRawValue);
        if ($res == Y_CURRENTVALUE_INVALID) {
            $res = $this->_currentValue;
        }
        $res = $res * $this->_iresol;
        return round($res) / $this->_iresol;
    }

    /**
     * Changes the recorded minimal value observed.
     * 
     * @param newval : a floating point number corresponding to the recorded minimal value observed
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_lowestValue($newval)
    {
        $rest_val = strval(round($newval * 65536.0));
        return $this->_setAttr("lowestValue",$rest_val);
    }

    /**
     * Returns the minimal value observed for the measure since the device was started.
     * 
     * @return a floating point number corresponding to the minimal value observed for the measure since
     * the device was started
     * 
     * On failure, throws an exception or returns Y_LOWESTVALUE_INVALID.
     */
    public function get_lowestValue()
    {
        // $res                    is a float;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_LOWESTVALUE_INVALID;
            }
        }
        $res = $this->_lowestValue * $this->_iresol;
        return round($res) / $this->_iresol;
    }

    /**
     * Changes the recorded maximal value observed.
     * 
     * @param newval : a floating point number corresponding to the recorded maximal value observed
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_highestValue($newval)
    {
        $rest_val = strval(round($newval * 65536.0));
        return $this->_setAttr("highestValue",$rest_val);
    }

    /**
     * Returns the maximal value observed for the measure since the device was started.
     * 
     * @return a floating point number corresponding to the maximal value observed for the measure since
     * the device was started
     * 
     * On failure, throws an exception or returns Y_HIGHESTVALUE_INVALID.
     */
    public function get_highestValue()
    {
        // $res                    is a float;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_HIGHESTVALUE_INVALID;
            }
        }
        $res = $this->_highestValue * $this->_iresol;
        return round($res) / $this->_iresol;
    }

    /**
     * Returns the uncalibrated, unrounded raw value returned by the sensor, in the specified unit, as a
     * floating point number.
     * 
     * @return a floating point number corresponding to the uncalibrated, unrounded raw value returned by
     * the sensor, in the specified unit, as a floating point number
     * 
     * On failure, throws an exception or returns Y_CURRENTRAWVALUE_INVALID.
     */
    public function get_currentRawValue()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_CURRENTRAWVALUE_INVALID;
            }
        }
        return $this->_currentRawValue;
    }

    /**
     * Returns the datalogger recording frequency for this function, or "OFF"
     * when measures are not stored in the data logger flash memory.
     * 
     * @return a string corresponding to the datalogger recording frequency for this function, or "OFF"
     *         when measures are not stored in the data logger flash memory
     * 
     * On failure, throws an exception or returns Y_LOGFREQUENCY_INVALID.
     */
    public function get_logFrequency()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_LOGFREQUENCY_INVALID;
            }
        }
        return $this->_logFrequency;
    }

    /**
     * Changes the datalogger recording frequency for this function.
     * The frequency can be specified as samples per second,
     * as sample per minute (for instance "15/m") or in samples per
     * hour (eg. "4/h"). To disable recording for this function, use
     * the value "OFF".
     * 
     * @param newval : a string corresponding to the datalogger recording frequency for this function
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_logFrequency($newval)
    {
        $rest_val = $newval;
        return $this->_setAttr("logFrequency",$rest_val);
    }

    /**
     * Returns the timed value notification frequency, or "OFF" if timed
     * value notifications are disabled for this function.
     * 
     * @return a string corresponding to the timed value notification frequency, or "OFF" if timed
     *         value notifications are disabled for this function
     * 
     * On failure, throws an exception or returns Y_REPORTFREQUENCY_INVALID.
     */
    public function get_reportFrequency()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_REPORTFREQUENCY_INVALID;
            }
        }
        return $this->_reportFrequency;
    }

    /**
     * Changes the timed value notification frequency for this function.
     * The frequency can be specified as samples per second,
     * as sample per minute (for instance "15/m") or in samples per
     * hour (eg. "4/h"). To disable timed value notifications for this
     * function, use the value "OFF".
     * 
     * @param newval : a string corresponding to the timed value notification frequency for this function
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_reportFrequency($newval)
    {
        $rest_val = $newval;
        return $this->_setAttr("reportFrequency",$rest_val);
    }

    public function get_calibrationParam()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_CALIBRATIONPARAM_INVALID;
            }
        }
        return $this->_calibrationParam;
    }

    public function set_calibrationParam($newval)
    {
        $rest_val = $newval;
        return $this->_setAttr("calibrationParam",$rest_val);
    }

    /**
     * Changes the resolution of the measured physical values. The resolution corresponds to the numerical precision
     * when displaying value. It does not change the precision of the measure itself.
     * 
     * @param newval : a floating point number corresponding to the resolution of the measured physical values
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_resolution($newval)
    {
        $rest_val = strval(round($newval * 65536.0));
        return $this->_setAttr("resolution",$rest_val);
    }

    /**
     * Returns the resolution of the measured values. The resolution corresponds to the numerical precision
     * of the measures, which is not always the same as the actual precision of the sensor.
     * 
     * @return a floating point number corresponding to the resolution of the measured values
     * 
     * On failure, throws an exception or returns Y_RESOLUTION_INVALID.
     */
    public function get_resolution()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_RESOLUTION_INVALID;
            }
        }
        return $this->_resolution;
    }

    /**
     * Retrieves a sensor for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     * 
     * This function does not require that the sensor is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method YSensor.isOnline() to test if the sensor is
     * indeed online at a given time. In case of ambiguity when looking for
     * a sensor by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     * 
     * @param func : a string that uniquely characterizes the sensor
     * 
     * @return a YSensor object allowing you to drive the sensor.
     */
    public static function FindSensor($func)
    {
        // $obj                    is a YSensor;
        $obj = YFunction::_FindFromCache('Sensor', $func);
        if ($obj == null) {
            $obj = new YSensor($func);
            YFunction::_AddToCache('Sensor', $func, $obj);
        }
        return $obj;
    }

    public function _parserHelper()
    {
        // $position               is a int;
        // $maxpos                 is a int;
        $iCalib = Array();      // intArr;
        // $iRaw                   is a int;
        // $iRef                   is a int;
        // $fRaw                   is a float;
        // $fRef                   is a float;
        $this->_caltyp = -1;
        $this->_scale = -1;
        $this->_isScal32 = false;
        while(sizeof($this->_calpar) > 0) { array_pop($this->_calpar); };
        while(sizeof($this->_calraw) > 0) { array_pop($this->_calraw); };
        while(sizeof($this->_calref) > 0) { array_pop($this->_calref); };
        // Store inverted resolution, to provide better rounding
        if ($this->_resolution > 0) {
            $this->_iresol = round(1.0 / $this->_resolution);
        } else {
            $this->_iresol = 10000;
            $this->_resolution = 0.0001;
        }
        // Old format: supported when there is no calibration
        if ($this->_calibrationParam == '' || $this->_calibrationParam == '0') {
            $this->_caltyp = 0;
            return 0;
        }
        if (Ystrpos($this->_calibrationParam,',') >= 0) {
            $iCalib = YAPI::_decodeFloats($this->_calibrationParam);
            $this->_caltyp = intVal(($iCalib[0]) / (1000));
            if ($this->_caltyp > 0) {
                if ($this->_caltyp < YOCTO_CALIB_TYPE_OFS) {
                    $this->_caltyp = -1;
                    return 0;
                }
                $this->_calhdl = YAPI::_getCalibrationHandler($this->_caltyp);
                if (!(!is_null($this->_calhdl))) {
                    $this->_caltyp = -1;
                    return 0;
                }
            }
            $this->_isScal = true;
            $this->_isScal32 = true;
            $this->_offset = 0;
            $this->_scale = 1000;
            $maxpos = sizeof($iCalib);
            while(sizeof($this->_calpar) > 0) { array_pop($this->_calpar); };
            $position = 1;
            while ($position < $maxpos) {
                $this->_calpar[] = $iCalib[$position];
                $position = $position + 1;
            }
            while(sizeof($this->_calraw) > 0) { array_pop($this->_calraw); };
            while(sizeof($this->_calref) > 0) { array_pop($this->_calref); };
            $position = 1;
            while ($position + 1 < $maxpos) {
                $fRaw = $iCalib[$position];
                $fRaw = $fRaw / 1000.0;
                $fRef = $iCalib[$position + 1];
                $fRef = $fRef / 1000.0;
                $this->_calraw[] = $fRaw;
                $this->_calref[] = $fRef;
                $position = $position + 2;
            }
        } else {
            $iCalib = YAPI::_decodeWords($this->_calibrationParam);
            if (sizeof($iCalib) < 2) {
                $this->_caltyp = -1;
                return 0;
            }
            $this->_isScal = ($iCalib[1] > 0);
            if ($this->_isScal) {
                $this->_offset = $iCalib[0];
                if ($this->_offset > 32767) {
                    $this->_offset = $this->_offset - 65536;
                }
                $this->_scale = $iCalib[1];
                $this->_decexp = 0;
            } else {
                $this->_offset = 0;
                $this->_scale = 1;
                $this->_decexp = 1.0;
                $position = $iCalib[0];
                while ($position > 0) {
                    $this->_decexp = $this->_decexp * 10;
                    $position = $position - 1;
                }
            }
            if (sizeof($iCalib) == 2) {
                $this->_caltyp = 0;
                return 0;
            }
            $this->_caltyp = $iCalib[2];
            $this->_calhdl = YAPI::_getCalibrationHandler($this->_caltyp);
            if ($this->_caltyp <= 10) {
                $maxpos = $this->_caltyp;
            } else {
                if ($this->_caltyp <= 20) {
                    $maxpos = $this->_caltyp - 10;
                } else {
                    $maxpos = 5;
                }
            }
            $maxpos = 3 + 2 * $maxpos;
            if ($maxpos > sizeof($iCalib)) {
                $maxpos = sizeof($iCalib);
            }
            while(sizeof($this->_calpar) > 0) { array_pop($this->_calpar); };
            while(sizeof($this->_calraw) > 0) { array_pop($this->_calraw); };
            while(sizeof($this->_calref) > 0) { array_pop($this->_calref); };
            $position = 3;
            while ($position + 1 < $maxpos) {
                $iRaw = $iCalib[$position];
                $iRef = $iCalib[$position + 1];
                $this->_calpar[] = $iRaw;
                $this->_calpar[] = $iRef;
                if ($this->_isScal) {
                    $fRaw = $iRaw;
                    $fRaw = ($fRaw - $this->_offset) / $this->_scale;
                    $fRef = $iRef;
                    $fRef = ($fRef - $this->_offset) / $this->_scale;
                    $this->_calraw[] = $fRaw;
                    $this->_calref[] = $fRef;
                } else {
                    $this->_calraw[] = YAPI::_decimalToDouble($iRaw);
                    $this->_calref[] = YAPI::_decimalToDouble($iRef);
                }
                $position = $position + 2;
            }
        }
        return 0;
    }

    /**
     * Retrieves a DataSet object holding historical data for this
     * sensor, for a specified time interval. The measures will be
     * retrieved from the data logger, which must have been turned
     * on at the desired time. See the documentation of the DataSet
     * class for information on how to get an overview of the
     * recorded data, and how to load progressively a large set
     * of measures from the data logger.
     * 
     * This function only works if the device uses a recent firmware,
     * as DataSet objects are not supported by firmwares older than
     * version 13000.
     * 
     * @param startTime : the start of the desired measure time interval,
     *         as a Unix timestamp, i.e. the number of seconds since
     *         January 1, 1970 UTC. The special value 0 can be used
     *         to include any meaasure, without initial limit.
     * @param endTime : the end of the desired measure time interval,
     *         as a Unix timestamp, i.e. the number of seconds since
     *         January 1, 1970 UTC. The special value 0 can be used
     *         to include any meaasure, without ending limit.
     * 
     * @return an instance of YDataSet, providing access to historical
     *         data. Past measures can be loaded progressively
     *         using methods from the YDataSet object.
     */
    public function get_recordedData($startTime,$endTime)
    {
        // $funcid                 is a str;
        // $funit                  is a str;
        // may throw an exception
        $funcid = $this->get_functionId();
        $funit = $this->get_unit();
        return new YDataSet($this, $funcid, $funit, $startTime, $endTime);
    }

    /**
     * Registers the callback function that is invoked on every periodic timed notification.
     * The callback is invoked only during the execution of ySleep or yHandleEvents.
     * This provides control over the time when the callback is triggered. For good responsiveness, remember to call
     * one of these two functions periodically. To unregister a callback, pass a null pointer as argument.
     * 
     * @param callback : the callback function to call, or a null pointer. The callback function should take two
     *         arguments: the function object of which the value has changed, and an YMeasure object describing
     *         the new advertised value.
     * @noreturn
     */
    public function registerTimedReportCallback($callback)
    {
        if (!is_null($callback)) {
            YFunction::_UpdateTimedReportCallbackList($this, true);
        } else {
            YFunction::_UpdateTimedReportCallbackList($this, false);
        }
        $this->_timedReportCallbackSensor = $callback;
        return 0;
    }

    public function _invokeTimedReportCallback($value)
    {
        if (!is_null($this->_timedReportCallbackSensor)) {
            call_user_func($this->_timedReportCallbackSensor, $this, $value);
        } else {
        }
        return 0;
    }

    /**
     * Configures error correction data points, in particular to compensate for
     * a possible perturbation of the measure caused by an enclosure. It is possible
     * to configure up to five correction points. Correction points must be provided
     * in ascending order, and be in the range of the sensor. The device will automatically
     * perform a linear interpolation of the error correction between specified
     * points. Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     * 
     * For more information on advanced capabilities to refine the calibration of
     * sensors, please contact support@yoctopuce.com.
     * 
     * @param rawValues : array of floating point numbers, corresponding to the raw
     *         values returned by the sensor for the correction points.
     * @param refValues : array of floating point numbers, corresponding to the corrected
     *         values for the correction points.
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function calibrateFromPoints($rawValues,$refValues)
    {
        // $rest_val               is a str;
        // may throw an exception
        $rest_val = $this->_encodeCalibrationPoints($rawValues, $refValues);
        return $this->_setAttr('calibrationParam', $rest_val);
    }

    /**
     * Retrieves error correction data points previously entered using the method
     * calibrateFromPoints.
     * 
     * @param rawValues : array of floating point numbers, that will be filled by the
     *         function with the raw sensor values for the correction points.
     * @param refValues : array of floating point numbers, that will be filled by the
     *         function with the desired values for the correction points.
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function loadCalibrationPoints(&$rawValues,&$refValues)
    {
        while(sizeof($rawValues) > 0) { array_pop($rawValues); };
        while(sizeof($refValues) > 0) { array_pop($refValues); };
        // Load function parameters if not yet loaded
        if ($this->_scale == 0) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return YAPI_DEVICE_NOT_FOUND;
            }
        }
        if ($this->_caltyp < 0) {
            $this->_throw(YAPI_NOT_SUPPORTED, 'Calibration parameters format mismatch. Please upgrade your library or firmware.');
            return YAPI_NOT_SUPPORTED;
        }
        while(sizeof($rawValues) > 0) { array_pop($rawValues); };
        while(sizeof($refValues) > 0) { array_pop($refValues); };
        foreach($this->_calraw as $each) {
            $rawValues[] = $each;
        }
        foreach($this->_calref as $each) {
            $refValues[] = $each;
        }
        return YAPI_SUCCESS;
    }

    public function _encodeCalibrationPoints($rawValues,$refValues)
    {
        // $res                    is a str;
        // $npt                    is a int;
        // $idx                    is a int;
        // $iRaw                   is a int;
        // $iRef                   is a int;
        $npt = sizeof($rawValues);
        if ($npt != sizeof($refValues)) {
            $this->_throw(YAPI_INVALID_ARGUMENT, 'Invalid calibration parameters (size mismatch)');
            return YAPI_INVALID_STRING;
        }
        // Shortcut when building empty calibration parameters
        if ($npt == 0) {
            return '0';
        }
        // Load function parameters if not yet loaded
        if ($this->_scale == 0) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return YAPI_INVALID_STRING;
            }
        }
        // Detect old firmware
        if (($this->_caltyp < 0) || ($this->_scale < 0)) {
            $this->_throw(YAPI_NOT_SUPPORTED, 'Calibration parameters format mismatch. Please upgrade your library or firmware.');
            return '0';
        }
        if ($this->_isScal32) {
            $res = sprintf('%d', YOCTO_CALIB_TYPE_OFS);
            $idx = 0;
            while ($idx < $npt) {
                $res = sprintf('%s,%F,%F', $res, $rawValues[$idx], $refValues[$idx]);
                $idx = $idx + 1;
            }
        } else {
            if ($this->_isScal) {
                $res = sprintf('%d', $npt);
                $idx = 0;
                while ($idx < $npt) {
                    $iRaw = round($rawValues[$idx] * $this->_scale + $this->_offset);
                    $iRef = round($refValues[$idx] * $this->_scale + $this->_offset);
                    $res = sprintf('%s,%d,%d', $res, $iRaw, $iRef);
                    $idx = $idx + 1;
                }
            } else {
                $res = sprintf('%d', 10 + $npt);
                $idx = 0;
                while ($idx < $npt) {
                    $iRaw = YAPI::_doubleToDecimal($rawValues[$idx]);
                    $iRef = YAPI::_doubleToDecimal($refValues[$idx]);
                    $res = sprintf('%s,%d,%d', $res, $iRaw, $iRef);
                    $idx = $idx + 1;
                }
            }
        }
        return $res;
    }

    public function _applyCalibration($rawValue)
    {
        if ($rawValue == Y_CURRENTVALUE_INVALID) {
            return Y_CURRENTVALUE_INVALID;
        }
        if ($this->_caltyp == 0) {
            return $rawValue;
        }
        if ($this->_caltyp < 0) {
            return Y_CURRENTVALUE_INVALID;
        }
        if (!(!is_null($this->_calhdl))) {
            return Y_CURRENTVALUE_INVALID;
        }
        return call_user_func($this->_calhdl, $rawValue, $this->_caltyp, $this->_calpar, $this->_calraw, $this->_calref);
    }

    public function _decodeTimedReport($timestamp,$report)
    {
        // $i                      is a int;
        // $byteVal                is a int;
        // $poww                   is a int;
        // $minRaw                 is a int;
        // $avgRaw                 is a int;
        // $maxRaw                 is a int;
        // $sublen                 is a int;
        // $difRaw                 is a int;
        // $startTime              is a float;
        // $endTime                is a float;
        // $minVal                 is a float;
        // $avgVal                 is a float;
        // $maxVal                 is a float;
        $startTime = $this->_prevTimedReport;
        $endTime = $timestamp;
        $this->_prevTimedReport = $endTime;
        if ($startTime == 0) {
            $startTime = $endTime;
        }
        if ($report[0] == 2) {
            if (sizeof($report) <= 5) {
                $poww = 1;
                $avgRaw = 0;
                $byteVal = 0;
                $i = 1;
                while ($i < sizeof($report)) {
                    $byteVal = $report[$i];
                    $avgRaw = $avgRaw + $poww * $byteVal;
                    $poww = $poww * 0x100;
                    $i = $i + 1;
                }
                if ((($byteVal) & (0x80)) != 0) {
                    $avgRaw = $avgRaw - $poww;
                }
                $avgVal = $avgRaw / 1000.0;
                if ($this->_caltyp != 0) {
                    if (!is_null($this->_calhdl)) {
                        $avgVal = call_user_func($this->_calhdl, $avgVal, $this->_caltyp, $this->_calpar, $this->_calraw, $this->_calref);
                    }
                }
                $minVal = $avgVal;
                $maxVal = $avgVal;
            } else {
                $sublen = 1 + (($report[1]) & (3));
                $poww = 1;
                $avgRaw = 0;
                $byteVal = 0;
                $i = 2;
                while (($sublen > 0) && ($i < sizeof($report))) {
                    $byteVal = $report[$i];
                    $avgRaw = $avgRaw + $poww * $byteVal;
                    $poww = $poww * 0x100;
                    $i = $i + 1;
                    $sublen = $sublen - 1;
                }
                if ((($byteVal) & (0x80)) != 0) {
                    $avgRaw = $avgRaw - $poww;
                }
                $sublen = 1 + (((($report[1]) >> (2))) & (3));
                $poww = 1;
                $difRaw = 0;
                while (($sublen > 0) && ($i < sizeof($report))) {
                    $byteVal = $report[$i];
                    $difRaw = $avgRaw + $poww * $byteVal;
                    $poww = $poww * 0x100;
                    $i = $i + 1;
                    $sublen = $sublen - 1;
                }
                $minRaw = $avgRaw - $difRaw;
                $sublen = 1 + (((($report[1]) >> (4))) & (3));
                $poww = 1;
                $difRaw = 0;
                while (($sublen > 0) && ($i < sizeof($report))) {
                    $byteVal = $report[$i];
                    $difRaw = $avgRaw + $poww * $byteVal;
                    $poww = $poww * 0x100;
                    $i = $i + 1;
                    $sublen = $sublen - 1;
                }
                $maxRaw = $avgRaw + $difRaw;
                $avgVal = $avgRaw / 1000.0;
                $minVal = $minRaw / 1000.0;
                $maxVal = $maxRaw / 1000.0;
                if ($this->_caltyp != 0) {
                    if (!is_null($this->_calhdl)) {
                        $avgVal = call_user_func($this->_calhdl, $avgVal, $this->_caltyp, $this->_calpar, $this->_calraw, $this->_calref);
                        $minVal = call_user_func($this->_calhdl, $minVal, $this->_caltyp, $this->_calpar, $this->_calraw, $this->_calref);
                        $maxVal = call_user_func($this->_calhdl, $maxVal, $this->_caltyp, $this->_calpar, $this->_calraw, $this->_calref);
                    }
                }
            }
        } else {
            if ($report[0] == 0) {
                $poww = 1;
                $avgRaw = 0;
                $byteVal = 0;
                $i = 1;
                while ($i < sizeof($report)) {
                    $byteVal = $report[$i];
                    $avgRaw = $avgRaw + $poww * $byteVal;
                    $poww = $poww * 0x100;
                    $i = $i + 1;
                }
                if ($this->_isScal) {
                    $avgVal = $this->_decodeVal($avgRaw);
                } else {
                    if ((($byteVal) & (0x80)) != 0) {
                        $avgRaw = $avgRaw - $poww;
                    }
                    $avgVal = $this->_decodeAvg($avgRaw);
                }
                $minVal = $avgVal;
                $maxVal = $avgVal;
            } else {
                $minRaw = $report[1] + 0x100 * $report[2];
                $maxRaw = $report[3] + 0x100 * $report[4];
                $avgRaw = $report[5] + 0x100 * $report[6] + 0x10000 * $report[7];
                $byteVal = $report[8];
                if ((($byteVal) & (0x80)) == 0) {
                    $avgRaw = $avgRaw + 0x1000000 * $byteVal;
                } else {
                    $avgRaw = $avgRaw - 0x1000000 * (0x100 - $byteVal);
                }
                $minVal = $this->_decodeVal($minRaw);
                $avgVal = $this->_decodeAvg($avgRaw);
                $maxVal = $this->_decodeVal($maxRaw);
            }
        }
        return new YMeasure($startTime, $endTime, $minVal, $avgVal, $maxVal);
    }

    public function _decodeVal($w)
    {
        // $val                    is a float;
        $val = $w;
        if ($this->_isScal) {
            $val = ($val - $this->_offset) / $this->_scale;
        } else {
            $val = YAPI::_decimalToDouble($w);
        }
        if ($this->_caltyp != 0) {
            if (!is_null($this->_calhdl)) {
                $val = call_user_func($this->_calhdl, $val, $this->_caltyp, $this->_calpar, $this->_calraw, $this->_calref);
            }
        }
        return $val;
    }

    public function _decodeAvg($dw)
    {
        // $val                    is a float;
        $val = $dw;
        if ($this->_isScal) {
            $val = ($val / 100 - $this->_offset) / $this->_scale;
        } else {
            $val = $val / $this->_decexp;
        }
        if ($this->_caltyp != 0) {
            if (!is_null($this->_calhdl)) {
                $val = call_user_func($this->_calhdl, $val, $this->_caltyp, $this->_calpar, $this->_calraw, $this->_calref);
            }
        }
        return $val;
    }

    public function unit()
    { return $this->get_unit(); }

    public function currentValue()
    { return $this->get_currentValue(); }

    public function setLowestValue($newval)
    { return $this->set_lowestValue($newval); }

    public function lowestValue()
    { return $this->get_lowestValue(); }

    public function setHighestValue($newval)
    { return $this->set_highestValue($newval); }

    public function highestValue()
    { return $this->get_highestValue(); }

    public function currentRawValue()
    { return $this->get_currentRawValue(); }

    public function logFrequency()
    { return $this->get_logFrequency(); }

    public function setLogFrequency($newval)
    { return $this->set_logFrequency($newval); }

    public function reportFrequency()
    { return $this->get_reportFrequency(); }

    public function setReportFrequency($newval)
    { return $this->set_reportFrequency($newval); }

    public function calibrationParam()
    { return $this->get_calibrationParam(); }

    public function setCalibrationParam($newval)
    { return $this->set_calibrationParam($newval); }

    public function setResolution($newval)
    { return $this->set_resolution($newval); }

    public function resolution()
    { return $this->get_resolution(); }

    /**
     * Continues the enumeration of sensors started using yFirstSensor().
     * 
     * @return a pointer to a YSensor object, corresponding to
     *         a sensor currently online, or a null pointer
     *         if there are no more sensors to enumerate.
     */
    public function nextSensor()
    {   $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if($resolve->errorType != YAPI_SUCCESS) return null;
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if($next_hwid == null) return null;
        return yFindSensor($next_hwid);
    }

    /**
     * Starts the enumeration of sensors currently accessible.
     * Use the method YSensor.nextSensor() to iterate on
     * next sensors.
     * 
     * @return a pointer to a YSensor object, corresponding to
     *         the first sensor currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstSensor()
    {   $next_hwid = YAPI::getFirstHardwareId('Sensor');
        if($next_hwid == null) return null;
        return self::FindSensor($next_hwid);
    }

    //--- (end of generated code: YSensor implementation)
}

//--- (generated code: YModule declaration)
/**
 * YModule Class: Module control interface
 * 
 * This interface is identical for all Yoctopuce USB modules.
 * It can be used to control the module global parameters, and
 * to enumerate the functions provided by each module.
 */
class YModule extends YFunction
{
    const PRODUCTNAME_INVALID            = YAPI_INVALID_STRING;
    const SERIALNUMBER_INVALID           = YAPI_INVALID_STRING;
    const PRODUCTID_INVALID              = YAPI_INVALID_UINT;
    const PRODUCTRELEASE_INVALID         = YAPI_INVALID_UINT;
    const FIRMWARERELEASE_INVALID        = YAPI_INVALID_STRING;
    const PERSISTENTSETTINGS_LOADED      = 0;
    const PERSISTENTSETTINGS_SAVED       = 1;
    const PERSISTENTSETTINGS_MODIFIED    = 2;
    const PERSISTENTSETTINGS_INVALID     = -1;
    const LUMINOSITY_INVALID             = YAPI_INVALID_UINT;
    const BEACON_OFF                     = 0;
    const BEACON_ON                      = 1;
    const BEACON_INVALID                 = -1;
    const UPTIME_INVALID                 = YAPI_INVALID_LONG;
    const USBCURRENT_INVALID             = YAPI_INVALID_UINT;
    const REBOOTCOUNTDOWN_INVALID        = YAPI_INVALID_INT;
    const USERVAR_INVALID                = YAPI_INVALID_INT;
    //--- (end of generated code: YModule declaration)

    //--- (generated code: YModule attributes)
    protected $_productName              = Y_PRODUCTNAME_INVALID;        // Text
    protected $_serialNumber             = Y_SERIALNUMBER_INVALID;       // Text
    protected $_productId                = Y_PRODUCTID_INVALID;          // XWord
    protected $_productRelease           = Y_PRODUCTRELEASE_INVALID;     // XWord
    protected $_firmwareRelease          = Y_FIRMWARERELEASE_INVALID;    // Text
    protected $_persistentSettings       = Y_PERSISTENTSETTINGS_INVALID; // FlashSettings
    protected $_luminosity               = Y_LUMINOSITY_INVALID;         // Percent
    protected $_beacon                   = Y_BEACON_INVALID;             // OnOff
    protected $_upTime                   = Y_UPTIME_INVALID;             // Time
    protected $_usbCurrent               = Y_USBCURRENT_INVALID;         // UsedCurrent
    protected $_rebootCountdown          = Y_REBOOTCOUNTDOWN_INVALID;    // Int
    protected $_userVar                  = Y_USERVAR_INVALID;            // Int
    protected $_logCallback              = null;                         // YModuleLogCallback
    //--- (end of generated code: YModule attributes)

    function __construct($str_func)
    {
        //--- (generated code: YModule constructor)
        parent::__construct($str_func);
        $this->_className = 'Module';

        //--- (end of generated code: YModule constructor)
    }

    // Return the internal device object hosting the function
    protected function _getDev()
    {
        $devid = $this->_func;
        $dotidx = strpos($devid, '.');
        if($dotidx !== false) $devid = substr($devid, 0, $dotidx);
        $dev = YAPI::getDevice($devid);
        if(is_null($dev)) {
            $this->_throw(YAPI_DEVICE_NOT_FOUND, "Device [$devid] is not online", null);
        }
        return $dev;
    }

    /**
     * Returns the number of functions (beside the "module" interface) available on the module.
     * 
     * @return the number of functions on the module
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function functionCount()
    {
        $dev = $this->_getDev();
        return $dev->functionCount();
    }

    /**
     * Retrieves the hardware identifier of the <i>n</i>th function on the module.
     * 
     * @param functionIndex : the index of the function for which the information is desired, starting at
     * 0 for the first function.
     * 
     * @return a string corresponding to the unambiguous hardware identifier of the requested module function
     * 
     * On failure, throws an exception or returns an empty string.
     */
    public function functionId($functionIndex)
    {
        $dev = $this->_getDev();
        return $dev->functionId($functionIndex);
    }

    /**
     * Retrieves the logical name of the <i>n</i>th function on the module.
     * 
     * @param functionIndex : the index of the function for which the information is desired, starting at
     * 0 for the first function.
     * 
     * @return a string corresponding to the logical name of the requested module function
     * 
     * On failure, throws an exception or returns an empty string.
     */
    public function functionName($functionIndex)
    {
        $devid = $this->_func;
        $dotidx = strpos($devid, '.');
        if($dotidx !== FALSE) $devid = substr($devid, 0, $dotidx);
        $dev = YAPI::getDevice($devid);
        return $dev->functionName($functionIndex);
    }

    /**
     * Retrieves the advertised value of the <i>n</i>th function on the module.
     * 
     * @param functionIndex : the index of the function for which the information is desired, starting at
     * 0 for the first function.
     * 
     * @return a short string (up to 6 characters) corresponding to the advertised value of the requested
     * module function
     * 
     * On failure, throws an exception or returns an empty string.
     */
    public function functionValue($functionIndex)
    {
        $dev = $this->_getDev();
        return $dev->functionValue($functionIndex);
    }

    /**
     * Test if the byn file is valid for this module. This method is useful to test if the module need to be updated.
     * It's possible to pass an directory instead of a file. In this case this method return the path of
     * the most recent
     * appropriate byn file. If the parameter onlynew is true the function will discard firmware that are
     * older or equal to
     * the installed firmware.
     * 
     * @param path    : the path of a byn file or a directory that contain byn files
     * @param onlynew : return only files that are strictly newer
     * 
     * @return : the path of the byn file to use or a empty string if no byn files match the requirement
     * 
     * On failure, throws an exception or returns a string that start with "error:".
     */
    public function checkFirmware($path,$onlynew)
    {
        if ($path == "http://www.yoctopuce.com" || $path == "www.yoctopuce.com") {
            $serial = $this->get_serialNumber();
            $yoctopuce_infos = file_get_contents('http://www.yoctopuce.com/FR/common/getLastFirmwareLink.php?serial=' . $serial);
            if ($yoctopuce_infos === false) {
                return 'error: Unable to get last firmware info from www.yoctopuce.com';
            }
            $jsonData = json_decode($yoctopuce_infos,true);
            if (!array_key_exists('link',$jsonData) || !array_key_exists('version',$jsonData)) {
                return 'error: Invalid JSON response from www.yoctopuce.com';
            }
            $link = $jsonData['link'];
            $version = $jsonData['version'];
            if($onlynew) {
                if($version > $this->get_firmwareRelease()) {
                    return $link;
                }
            } else {
                return $link;
            }
            return '';
        }else {
            return 'error: Not yet supported in PHP';
        }
    }

    protected function _flattenJsonStruct($jsoncomplex)
    {
        $decoded = json_decode($jsoncomplex);
        if ($decoded == null) {
            $this->_throw(YAPI_INVALID_ARGUMENT, 'Invalid json structure');
            return "";
        }
        $attrs = array();
        foreach ($decoded as $function_name => $fuction_attrs) {
            if ($function_name == "services")
                continue;
            foreach ($fuction_attrs as $attr_name => $attr_value) {
                if(is_object($attr_value)) {
                    // skip complext attributes (move and pulse)
                    continue;
                }
                $flat = $function_name . '/' . $attr_name . '=' . $attr_value;
                $attrs[] = $flat;
            }
        }
        return json_encode($attrs);
    }

    //--- (generated code: YModule implementation)

    function _parseAttr($name, $val)
    {
        switch($name) {
        case 'productName':
            $this->_productName = $val;
            return 1;
        case 'serialNumber':
            $this->_serialNumber = $val;
            return 1;
        case 'productId':
            $this->_productId = intval($val);
            return 1;
        case 'productRelease':
            $this->_productRelease = intval($val);
            return 1;
        case 'firmwareRelease':
            $this->_firmwareRelease = $val;
            return 1;
        case 'persistentSettings':
            $this->_persistentSettings = intval($val);
            return 1;
        case 'luminosity':
            $this->_luminosity = intval($val);
            return 1;
        case 'beacon':
            $this->_beacon = intval($val);
            return 1;
        case 'upTime':
            $this->_upTime = intval($val);
            return 1;
        case 'usbCurrent':
            $this->_usbCurrent = intval($val);
            return 1;
        case 'rebootCountdown':
            $this->_rebootCountdown = intval($val);
            return 1;
        case 'userVar':
            $this->_userVar = intval($val);
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Returns the commercial name of the module, as set by the factory.
     * 
     * @return a string corresponding to the commercial name of the module, as set by the factory
     * 
     * On failure, throws an exception or returns Y_PRODUCTNAME_INVALID.
     */
    public function get_productName()
    {
        // $dev                    is a YDevice;
        if ($this->_cacheExpiration == 0) {
            $dev = $this->_getDev();
            if (!($dev == null)) {
                return $dev->getProductName();
            }
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_PRODUCTNAME_INVALID;
            }
        }
        return $this->_productName;
    }

    /**
     * Returns the serial number of the module, as set by the factory.
     * 
     * @return a string corresponding to the serial number of the module, as set by the factory
     * 
     * On failure, throws an exception or returns Y_SERIALNUMBER_INVALID.
     */
    public function get_serialNumber()
    {
        // $dev                    is a YDevice;
        if ($this->_cacheExpiration == 0) {
            $dev = $this->_getDev();
            if (!($dev == null)) {
                return $dev->getSerialNumber();
            }
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_SERIALNUMBER_INVALID;
            }
        }
        return $this->_serialNumber;
    }

    /**
     * Returns the USB device identifier of the module.
     * 
     * @return an integer corresponding to the USB device identifier of the module
     * 
     * On failure, throws an exception or returns Y_PRODUCTID_INVALID.
     */
    public function get_productId()
    {
        // $dev                    is a YDevice;
        if ($this->_cacheExpiration == 0) {
            $dev = $this->_getDev();
            if (!($dev == null)) {
                return $dev->getProductId();
            }
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_PRODUCTID_INVALID;
            }
        }
        return $this->_productId;
    }

    /**
     * Returns the hardware release version of the module.
     * 
     * @return an integer corresponding to the hardware release version of the module
     * 
     * On failure, throws an exception or returns Y_PRODUCTRELEASE_INVALID.
     */
    public function get_productRelease()
    {
        if ($this->_cacheExpiration == 0) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_PRODUCTRELEASE_INVALID;
            }
        }
        return $this->_productRelease;
    }

    /**
     * Returns the version of the firmware embedded in the module.
     * 
     * @return a string corresponding to the version of the firmware embedded in the module
     * 
     * On failure, throws an exception or returns Y_FIRMWARERELEASE_INVALID.
     */
    public function get_firmwareRelease()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_FIRMWARERELEASE_INVALID;
            }
        }
        return $this->_firmwareRelease;
    }

    /**
     * Returns the current state of persistent module settings.
     * 
     * @return a value among Y_PERSISTENTSETTINGS_LOADED, Y_PERSISTENTSETTINGS_SAVED and
     * Y_PERSISTENTSETTINGS_MODIFIED corresponding to the current state of persistent module settings
     * 
     * On failure, throws an exception or returns Y_PERSISTENTSETTINGS_INVALID.
     */
    public function get_persistentSettings()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_PERSISTENTSETTINGS_INVALID;
            }
        }
        return $this->_persistentSettings;
    }

    public function set_persistentSettings($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("persistentSettings",$rest_val);
    }

    /**
     * Returns the luminosity of the  module informative leds (from 0 to 100).
     * 
     * @return an integer corresponding to the luminosity of the  module informative leds (from 0 to 100)
     * 
     * On failure, throws an exception or returns Y_LUMINOSITY_INVALID.
     */
    public function get_luminosity()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_LUMINOSITY_INVALID;
            }
        }
        return $this->_luminosity;
    }

    /**
     * Changes the luminosity of the module informative leds. The parameter is a
     * value between 0 and 100.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     * 
     * @param newval : an integer corresponding to the luminosity of the module informative leds
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_luminosity($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("luminosity",$rest_val);
    }

    /**
     * Returns the state of the localization beacon.
     * 
     * @return either Y_BEACON_OFF or Y_BEACON_ON, according to the state of the localization beacon
     * 
     * On failure, throws an exception or returns Y_BEACON_INVALID.
     */
    public function get_beacon()
    {
        // $dev                    is a YDevice;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            $dev = $this->_getDev();
            if (!($dev == null)) {
                return $dev->getBeacon();
            }
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_BEACON_INVALID;
            }
        }
        return $this->_beacon;
    }

    /**
     * Turns on or off the module localization beacon.
     * 
     * @param newval : either Y_BEACON_OFF or Y_BEACON_ON
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_beacon($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("beacon",$rest_val);
    }

    /**
     * Returns the number of milliseconds spent since the module was powered on.
     * 
     * @return an integer corresponding to the number of milliseconds spent since the module was powered on
     * 
     * On failure, throws an exception or returns Y_UPTIME_INVALID.
     */
    public function get_upTime()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_UPTIME_INVALID;
            }
        }
        return $this->_upTime;
    }

    /**
     * Returns the current consumed by the module on the USB bus, in milli-amps.
     * 
     * @return an integer corresponding to the current consumed by the module on the USB bus, in milli-amps
     * 
     * On failure, throws an exception or returns Y_USBCURRENT_INVALID.
     */
    public function get_usbCurrent()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_USBCURRENT_INVALID;
            }
        }
        return $this->_usbCurrent;
    }

    /**
     * Returns the remaining number of seconds before the module restarts, or zero when no
     * reboot has been scheduled.
     * 
     * @return an integer corresponding to the remaining number of seconds before the module restarts, or zero when no
     *         reboot has been scheduled
     * 
     * On failure, throws an exception or returns Y_REBOOTCOUNTDOWN_INVALID.
     */
    public function get_rebootCountdown()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_REBOOTCOUNTDOWN_INVALID;
            }
        }
        return $this->_rebootCountdown;
    }

    public function set_rebootCountdown($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("rebootCountdown",$rest_val);
    }

    /**
     * Returns the value previously stored in this attribute.
     * On startup and after a device reboot, the value is always reset to zero.
     * 
     * @return an integer corresponding to the value previously stored in this attribute
     * 
     * On failure, throws an exception or returns Y_USERVAR_INVALID.
     */
    public function get_userVar()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_USERVAR_INVALID;
            }
        }
        return $this->_userVar;
    }

    /**
     * Returns the value previously stored in this attribute.
     * On startup and after a device reboot, the value is always reset to zero.
     * 
     * @param newval : an integer
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_userVar($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("userVar",$rest_val);
    }

    /**
     * Allows you to find a module from its serial number or from its logical name.
     * 
     * This function does not require that the module is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method YModule.isOnline() to test if the module is
     * indeed online at a given time. In case of ambiguity when looking for
     * a module by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     * 
     * @param func : a string containing either the serial number or
     *         the logical name of the desired module
     * 
     * @return a YModule object allowing you to drive the module
     *         or get additional information on the module.
     */
    public static function FindModule($func)
    {
        // $obj                    is a YModule;
        $obj = YFunction::_FindFromCache('Module', $func);
        if ($obj == null) {
            $obj = new YModule($func);
            YFunction::_AddToCache('Module', $func, $obj);
        }
        return $obj;
    }

    /**
     * Saves current settings in the nonvolatile memory of the module.
     * Warning: the number of allowed save operations during a module life is
     * limited (about 100000 cycles). Do not call this function within a loop.
     * 
     * @return YAPI_SUCCESS when the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function saveToFlash()
    {
        return $this->set_persistentSettings(Y_PERSISTENTSETTINGS_SAVED);
    }

    /**
     * Reloads the settings stored in the nonvolatile memory, as
     * when the module is powered on.
     * 
     * @return YAPI_SUCCESS when the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function revertFromFlash()
    {
        return $this->set_persistentSettings(Y_PERSISTENTSETTINGS_LOADED);
    }

    /**
     * Schedules a simple module reboot after the given number of seconds.
     * 
     * @param secBeforeReboot : number of seconds before rebooting
     * 
     * @return YAPI_SUCCESS when the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function reboot($secBeforeReboot)
    {
        return $this->set_rebootCountdown($secBeforeReboot);
    }

    /**
     * Schedules a module reboot into special firmware update mode.
     * 
     * @param secBeforeReboot : number of seconds before rebooting
     * 
     * @return YAPI_SUCCESS when the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function triggerFirmwareUpdate($secBeforeReboot)
    {
        return $this->set_rebootCountdown(-$secBeforeReboot);
    }

    //cannot be generated for PHP:
    //public function checkFirmware($path,$onlynew)

    /**
     * Prepare a firmware upgrade of the module. This method return a object YFirmwareUpdate which
     * will handle the firmware upgrade process.
     * 
     * @param path : the path of the byn file to use.
     * 
     * @return : A object YFirmwareUpdate.
     */
    public function updateFirmware($path)
    {
        // $serial                 is a str;
        // $settings               is a bin;
        // may throw an exception
        $serial = $this->get_serialNumber();
        $settings = $this->get_allSettings();
        return new YFirmwareUpdate($serial, $path, $settings);
    }

    /**
     * Returns all the setting of the module. Useful to backup all the logical name and calibrations parameters
     * of a connected module.
     * 
     * @return a binary buffer with all settings.
     * 
     * On failure, throws an exception or returns  YAPI_INVALID_STRING.
     */
    public function get_allSettings()
    {
        return $this->_download('api.json');
    }

    //cannot be generated for PHP:
    //public function _flattenJsonStruct($jsoncomplex)

    public function calibVersion($cparams)
    {
        if ($cparams == '0,') {
            return 3;
        }
        if (Ystrpos($cparams,',') >= 0) {
            if (Ystrpos($cparams,' ') > 0) {
                return 3;
            } else {
                return 1;
            }
        }
        if ($cparams == '' || $cparams == '0') {
            return 1;
        }
        if ((strlen($cparams) < 2) || (Ystrpos($cparams,'.') >= 0)) {
            return 0;
        } else {
            return 2;
        }
    }

    public function calibScale($unit_name,$sensorType)
    {
        if ($unit_name == 'g' || $unit_name == 'gauss' || $unit_name == 'W') {
            return 1000;
        }
        if ($unit_name == 'C') {
            if ($sensorType == '') {
                return 16;
            }
            if (intVal($sensorType) < 8) {
                return 16;
            } else {
                return 100;
            }
        }
        if ($unit_name == 'm' || $unit_name == 'deg') {
            return 10;
        }
        return 1;
    }

    public function calibOffset($unit_name)
    {
        if ($unit_name == '% RH' || $unit_name == 'mbar' || $unit_name == 'lx') {
            return 0;
        }
        return 32767;
    }

    public function calibConvert($param,$calibrationParam,$unit_name,$sensorType)
    {
        // $paramVer               is a int;
        // $funVer                 is a int;
        // $funScale               is a int;
        // $funOffset              is a int;
        // $paramScale             is a int;
        // $paramOffset            is a int;
        $words = Array();       // intArr;
        $words_str = Array();   // strArr;
        $calibData = Array();   // floatArr;
        $iCalib = Array();      // intArr;
        // $calibType              is a int;
        // $i                      is a int;
        // $maxSize                is a int;
        // $ratio                  is a float;
        // $nPoints                is a int;
        // $wordVal                is a float;
        // Initial guess for parameter encoding
        $paramVer = $this->calibVersion($param);
        $funVer = $this->calibVersion($calibrationParam);
        $funScale = $this->calibScale($unit_name, $sensorType);
        $funOffset = $this->calibOffset($unit_name);
        $paramScale = $funScale;
        $paramOffset = $funOffset;
        if ($funVer < 3) {
            if ($funVer == 2) {
                $words = YAPI::_decodeWords($calibrationParam);
                if (($words[0] == 1366) && ($words[1] == 12500)) {
                    $funScale = 1;
                    $funOffset = 0;
                } else {
                    $funScale = $words[1];
                    $funOffset = $words[0];
                }
            } else {
                if ($funVer == 1) {
                    if ($calibrationParam == '' || (intVal($calibrationParam) > 10)) {
                        $funScale = 0;
                    }
                }
            }
        }
        while(sizeof($calibData) > 0) { array_pop($calibData); };
        $calibType = 0;
        if ($paramVer < 3) {
            if ($paramVer == 2) {
                $words = YAPI::_decodeWords($param);
                if (($words[0] == 1366) && ($words[1] == 12500)) {
                    $paramScale = 1;
                    $paramOffset = 0;
                } else {
                    $paramScale = $words[1];
                    $paramOffset = $words[0];
                }
                if ((sizeof($words) >= 3) && ($words[2] > 0)) {
                    $maxSize = 3 + 2 * (($words[2]) % (10));
                    if ($maxSize > sizeof($words)) {
                        $maxSize = sizeof($words);
                    }
                    $i = 3;
                    while ($i < $maxSize) {
                        $calibData[] = $words[$i];
                        $i = $i + 1;
                    }
                }
            } else {
                if ($paramVer == 1) {
                    $words_str = explode(',', $param);
                    foreach($words_str as $each) {
                        $words[] = intVal($each);
                    }
                    if ($param == '' || ($words[0] > 10)) {
                        $paramScale = 0;
                    }
                    if ((sizeof($words) > 0) && ($words[0] > 0)) {
                        $maxSize = 1 + 2 * (($words[0]) % (10));
                        if ($maxSize > sizeof($words)) {
                            $maxSize = sizeof($words);
                        }
                        $i = 1;
                        while ($i < $maxSize) {
                            $calibData[] = $words[$i];
                            $i = $i + 1;
                        }
                    }
                } else {
                    if ($paramVer == 0) {
                        $ratio = floatval($param);
                        if ($ratio > 0) {
                            $calibData[] = 0.0;
                            $calibData[] = 0.0;
                            $calibData[] = round(65535 / $ratio);
                            $calibData[] = 65535.0;
                        }
                    }
                }
            }
            $i = 0;
            while ($i < sizeof($calibData)) {
                if ($paramScale > 0) {
                    $calibData[$i] = ($calibData[$i] - $paramOffset) / $paramScale;
                } else {
                    $calibData[$i] = YAPI::_decimalToDouble(round($calibData[$i]));
                }
                $i = $i + 1;
            }
        } else {
            $iCalib = YAPI::_decodeFloats($param);
            $calibType = round($iCalib[0] / 1000.0);
            if ($calibType >= 30) {
                $calibType = $calibType - 30;
            }
            $i = 1;
            while ($i < sizeof($iCalib)) {
                $calibData[] = $iCalib[$i] / 1000.0;
                $i = $i + 1;
            }
        }
        if ($funVer >= 3) {
            if (sizeof($calibData) == 0) {
                $param = '0,';
            } else {
                $param = 30 + $calibType;
                $i = 0;
                while ($i < sizeof($calibData)) {
                    if ((($i) & (1)) > 0) {
                        $param = $param . ':';
                    } else {
                        $param = $param . ' ';
                    }
                    $param = $param . round($calibData[$i] * 1000.0 / 1000.0);
                    $i = $i + 1;
                }
                $param = $param . ',';
            }
        } else {
            if ($funVer >= 1) {
                $nPoints = intVal((sizeof($calibData)) / (2));
                $param = $nPoints;
                $i = 0;
                while ($i < 2 * $nPoints) {
                    if ($funScale == 0) {
                        $wordVal = YAPI::_doubleToDecimal(round($calibData[$i]));
                    } else {
                        $wordVal = $calibData[$i] * $funScale + $funOffset;
                    }
                    $param = $param . ',' . round($wordVal);
                    $i = $i + 1;
                }
            } else {
                if (sizeof($calibData) == 4) {
                    $param = round(1000 * ($calibData[3] - $calibData[1]) / $calibData[2] - $calibData[0]);
                }
            }
        }
        return $param;
    }

    /**
     * Restore all the setting of the module. Useful to restore all the logical name and calibrations parameters
     * of a module from a backup.
     * 
     * @param settings : a binary buffer with all settings.
     * 
     * @return YAPI_SUCCESS when the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_allSettings($settings)
    {
        $restoreLast = Array(); // strArr;
        // $old_json_flat          is a bin;
        $old_dslist = Array();  // strArr;
        $old_jpath = Array();   // strArr;
        $old_jpath_len = Array(); // intArr;
        $old_val_arr = Array(); // strArr;
        // $actualSettings         is a bin;
        $new_dslist = Array();  // strArr;
        $new_jpath = Array();   // strArr;
        $new_jpath_len = Array(); // intArr;
        $new_val_arr = Array(); // strArr;
        // $cpos                   is a int;
        // $eqpos                  is a int;
        // $leng                   is a int;
        // $i                      is a int;
        // $j                      is a int;
        // $njpath                 is a str;
        // $jpath                  is a str;
        // $fun                    is a str;
        // $attr                   is a str;
        // $value                  is a str;
        // $url                    is a str;
        // $tmp                    is a str;
        // $new_calib              is a str;
        // $sensorType             is a str;
        // $unit_name              is a str;
        // $newval                 is a str;
        // $oldval                 is a str;
        // $old_calib              is a str;
        // $do_update              is a bool;
        // $found                  is a bool;
        $oldval = '';
        $newval = '';
        $old_json_flat = $this->_flattenJsonStruct($settings);
        $old_dslist = $this->_json_get_array($old_json_flat);
        foreach($old_dslist as $each) {
            $each = $this->_json_get_string($each);
            $leng = strlen($each);
            $eqpos = Ystrpos($each,'=');
            if (($eqpos < 0) || ($leng == 0)) {
                $this->_throw(YAPI_INVALID_ARGUMENT, 'Invalid settings');
                return YAPI_INVALID_ARGUMENT;
            }
            $jpath = substr($each,  0, $eqpos);
            $eqpos = $eqpos + 1;
            $value = substr($each,  $eqpos, $leng - $eqpos);
            $old_jpath[] = $jpath;
            $old_jpath_len[] = strlen($jpath);
            $old_val_arr[] = $value;
        }
        // may throw an exception
        $actualSettings = $this->_download('api.json');
        $actualSettings = $this->_flattenJsonStruct($actualSettings);
        $new_dslist = $this->_json_get_array($actualSettings);
        foreach($new_dslist as $each) {
            $each = $this->_json_get_string($each);
            $leng = strlen($each);
            $eqpos = Ystrpos($each,'=');
            if (($eqpos < 0) || ($leng == 0)) {
                $this->_throw(YAPI_INVALID_ARGUMENT, 'Invalid settings');
                return YAPI_INVALID_ARGUMENT;
            }
            $jpath = substr($each,  0, $eqpos);
            $eqpos = $eqpos + 1;
            $value = substr($each,  $eqpos, $leng - $eqpos);
            $new_jpath[] = $jpath;
            $new_jpath_len[] = strlen($jpath);
            $new_val_arr[] = $value;
        }
        $i = 0;
        while ($i < sizeof($new_jpath)) {
            $njpath = $new_jpath[$i];
            $leng = strlen($njpath);
            $cpos = Ystrpos($njpath,'/');
            if (($cpos < 0) || ($leng == 0)) {
                continue;
            }
            $fun = substr($njpath,  0, $cpos);
            $cpos = $cpos + 1;
            $attr = substr($njpath,  $cpos, $leng - $cpos);
            $do_update = true;
            if ($fun == 'services') {
                $do_update = false;
            }
            if (($do_update) && ($attr == 'firmwareRelease')) {
                $do_update = false;
            }
            if (($do_update) && ($attr == 'usbCurrent')) {
                $do_update = false;
            }
            if (($do_update) && ($attr == 'upTime')) {
                $do_update = false;
            }
            if (($do_update) && ($attr == 'persistentSettings')) {
                $do_update = false;
            }
            if (($do_update) && ($attr == 'adminPassword')) {
                $do_update = false;
            }
            if (($do_update) && ($attr == 'userPassword')) {
                $do_update = false;
            }
            if (($do_update) && ($attr == 'rebootCountdown')) {
                $do_update = false;
            }
            if (($do_update) && ($attr == 'advertisedValue')) {
                $do_update = false;
            }
            if (($do_update) && ($attr == 'poeCurrent')) {
                $do_update = false;
            }
            if (($do_update) && ($attr == 'readiness')) {
                $do_update = false;
            }
            if (($do_update) && ($attr == 'ipAddress')) {
                $do_update = false;
            }
            if (($do_update) && ($attr == 'subnetMask')) {
                $do_update = false;
            }
            if (($do_update) && ($attr == 'router')) {
                $do_update = false;
            }
            if (($do_update) && ($attr == 'linkQuality')) {
                $do_update = false;
            }
            if (($do_update) && ($attr == 'ssid')) {
                $do_update = false;
            }
            if (($do_update) && ($attr == 'channel')) {
                $do_update = false;
            }
            if (($do_update) && ($attr == 'security')) {
                $do_update = false;
            }
            if (($do_update) && ($attr == 'message')) {
                $do_update = false;
            }
            if (($do_update) && ($attr == 'currentValue')) {
                $do_update = false;
            }
            if (($do_update) && ($attr == 'currentRawValue')) {
                $do_update = false;
            }
            if (($do_update) && ($attr == 'currentRunIndex')) {
                $do_update = false;
            }
            if (($do_update) && ($attr == 'pulseTimer')) {
                $do_update = false;
            }
            if (($do_update) && ($attr == 'lastTimePressed')) {
                $do_update = false;
            }
            if (($do_update) && ($attr == 'lastTimeReleased')) {
                $do_update = false;
            }
            if (($do_update) && ($attr == 'filesCount')) {
                $do_update = false;
            }
            if (($do_update) && ($attr == 'freeSpace')) {
                $do_update = false;
            }
            if (($do_update) && ($attr == 'timeUTC')) {
                $do_update = false;
            }
            if (($do_update) && ($attr == 'rtcTime')) {
                $do_update = false;
            }
            if (($do_update) && ($attr == 'unixTime')) {
                $do_update = false;
            }
            if (($do_update) && ($attr == 'dateTime')) {
                $do_update = false;
            }
            if (($do_update) && ($attr == 'rawValue')) {
                $do_update = false;
            }
            if (($do_update) && ($attr == 'lastMsg')) {
                $do_update = false;
            }
            if (($do_update) && ($attr == 'delayedPulseTimer')) {
                $do_update = false;
            }
            if (($do_update) && ($attr == 'rxCount')) {
                $do_update = false;
            }
            if (($do_update) && ($attr == 'txCount')) {
                $do_update = false;
            }
            if (($do_update) && ($attr == 'msgCount')) {
                $do_update = false;
            }
            if ($do_update) {
                $do_update = false;
                $newval = $new_val_arr[$i];
                $j = 0;
                $found = false;
                while (($j < sizeof($old_jpath)) && !($found)) {
                    if (($new_jpath_len[$i] == $old_jpath_len[$j]) && ($new_jpath[$i] == $old_jpath[$j])) {
                        $found = true;
                        $oldval = $old_val_arr[$j];
                        if (!($newval == $oldval)) {
                            $do_update = true;
                        }
                    }
                    $j = $j + 1;
                }
            }
            if ($do_update) {
                if ($attr == 'calibrationParam') {
                    $old_calib = '';
                    $unit_name = '';
                    $sensorType = '';
                    $new_calib = $newval;
                    $j = 0;
                    $found = false;
                    while (($j < sizeof($old_jpath)) && !($found)) {
                        if (($new_jpath_len[$i] == $old_jpath_len[$j]) && ($new_jpath[$i] == $old_jpath[$j])) {
                            $found = true;
                            $old_calib = $old_val_arr[$j];
                        }
                        $j = $j + 1;
                    }
                    $tmp = $fun . '/unit';
                    $j = 0;
                    $found = false;
                    while (($j < sizeof($new_jpath)) && !($found)) {
                        if ($tmp == $new_jpath[$j]) {
                            $found = true;
                            $unit_name = $new_jpath[$j];
                        }
                        $j = $j + 1;
                    }
                    $tmp = $fun . '/sensorType';
                    $j = 0;
                    $found = false;
                    while (($j < sizeof($new_jpath)) && !($found)) {
                        if ($tmp == $new_jpath[$j]) {
                            $found = true;
                            $sensorType = $new_jpath[$j];
                        }
                        $j = $j + 1;
                    }
                    $newval = $this->calibConvert($new_val_arr[$i], $old_calib, $unit_name, $sensorType);
                    $url = 'api/' . $fun . '.json?' . $attr . '=' . $this->_escapeAttr($newval);
                    $this->_download($url);
                } else {
                    $url = 'api/' . $fun . '.json?' . $attr . '=' . $this->_escapeAttr($oldval);
                    if ($attr == 'resolution') {
                        $restoreLast[] = $url;
                    } else {
                        $this->_download($url);
                    }
                }
            }
            $i = $i + 1;
        }
        foreach($restoreLast as $each) {
            $this->_download($each);
        }
        return YAPI_SUCCESS;
    }

    /**
     * Downloads the specified built-in file and returns a binary buffer with its content.
     * 
     * @param pathname : name of the new file to load
     * 
     * @return a binary buffer with the file content
     * 
     * On failure, throws an exception or returns  YAPI_INVALID_STRING.
     */
    public function download($pathname)
    {
        return $this->_download($pathname);
    }

    /**
     * Returns the icon of the module. The icon is a PNG image and does not
     * exceeds 1536 bytes.
     * 
     * @return a binary buffer with module icon, in png format.
     *         On failure, throws an exception or returns  YAPI_INVALID_STRING.
     */
    public function get_icon2d()
    {
        return $this->_download('icon2d.png');
    }

    /**
     * Returns a string with last logs of the module. This method return only
     * logs that are still in the module.
     * 
     * @return a string with last logs of the module.
     *         On failure, throws an exception or returns  YAPI_INVALID_STRING.
     */
    public function get_lastLogs()
    {
        // $content                is a bin;
        // may throw an exception
        $content = $this->_download('logs.txt');
        return $content;
    }

    public function productName()
    { return $this->get_productName(); }

    public function serialNumber()
    { return $this->get_serialNumber(); }

    public function productId()
    { return $this->get_productId(); }

    public function productRelease()
    { return $this->get_productRelease(); }

    public function firmwareRelease()
    { return $this->get_firmwareRelease(); }

    public function persistentSettings()
    { return $this->get_persistentSettings(); }

    public function setPersistentSettings($newval)
    { return $this->set_persistentSettings($newval); }

    public function luminosity()
    { return $this->get_luminosity(); }

    public function setLuminosity($newval)
    { return $this->set_luminosity($newval); }

    public function beacon()
    { return $this->get_beacon(); }

    public function setBeacon($newval)
    { return $this->set_beacon($newval); }

    public function upTime()
    { return $this->get_upTime(); }

    public function usbCurrent()
    { return $this->get_usbCurrent(); }

    public function rebootCountdown()
    { return $this->get_rebootCountdown(); }

    public function setRebootCountdown($newval)
    { return $this->set_rebootCountdown($newval); }

    public function userVar()
    { return $this->get_userVar(); }

    public function setUserVar($newval)
    { return $this->set_userVar($newval); }

    /**
     * Continues the module enumeration started using yFirstModule().
     * 
     * @return a pointer to a YModule object, corresponding to
     *         the next module found, or a null pointer
     *         if there are no more modules to enumerate.
     */
    public function nextModule()
    {   $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if($resolve->errorType != YAPI_SUCCESS) return null;
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if($next_hwid == null) return null;
        return yFindModule($next_hwid);
    }

    /**
     * Starts the enumeration of modules currently accessible.
     * Use the method YModule.nextModule() to iterate on the
     * next modules.
     * 
     * @return a pointer to a YModule object, corresponding to
     *         the first module currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstModule()
    {   $next_hwid = YAPI::getFirstHardwareId('Module');
        if($next_hwid == null) return null;
        return self::FindModule($next_hwid);
    }

    //--- (end of generated code: YModule implementation)
};

/**
 * Returns the version identifier for the Yoctopuce library in use.
 * The version is a string in the form "Major.Minor.Build",
 * for instance "1.01.5535". For languages using an external
 * DLL (for instance C#, VisualBasic or Delphi), the character string
 * includes as well the DLL version, for instance
 * "1.01.5535 (1.01.5439)".
 * 
 * If you want to verify in your code that the library version is
 * compatible with the version that you have used during development,
 * verify that the major number is strictly equal and that the minor
 * number is greater or equal. The build number is not relevant
 * with respect to the library compatibility.
 * 
 * @return a character string describing the library version.
 */
function yGetAPIVersion()
{
    return YAPI::GetAPIVersion();
}

/**
 * Initializes the Yoctopuce programming library explicitly.
 * It is not strictly needed to call yInitAPI(), as the library is
 * automatically  initialized when calling yRegisterHub() for the
 * first time.
 * 
 * When Y_DETECT_NONE is used as detection mode,
 * you must explicitly use yRegisterHub() to point the API to the
 * VirtualHub on which your devices are connected before trying to access them.
 * 
 * @param mode : an integer corresponding to the type of automatic
 *         device detection to use. Possible values are
 *         Y_DETECT_NONE, Y_DETECT_USB, Y_DETECT_NET,
 *         and Y_DETECT_ALL.
 * @param errmsg : a string passed by reference to receive any error message.
 * 
 * @return YAPI_SUCCESS when the call succeeds.
 * 
 * On failure, throws an exception or returns a negative error code.
 */
function yInitAPI($mode=0,&$errmsg="")
{
    return YAPI::InitAPI($mode,$errmsg);
}

/**
 * Frees dynamically allocated memory blocks used by the Yoctopuce library.
 * It is generally not required to call this function, unless you
 * want to free all dynamically allocated memory blocks in order to
 * track a memory leak for instance.
 * You should not call any other library function after calling
 * yFreeAPI(), or your program will crash.
 */
function yFreeAPI()
{
    YAPI::FreeAPI();
}

/**
 * Disables the use of exceptions to report runtime errors.
 * When exceptions are disabled, every function returns a specific
 * error value which depends on its type and which is documented in
 * this reference manual.
 */
function yDisableExceptions()
{
    YAPI::DisableExceptions();
}

/**
 * Re-enables the use of exceptions for runtime error handling.
 * Be aware than when exceptions are enabled, every function that fails
 * triggers an exception. If the exception is not caught by the user code,
 * it  either fires the debugger or aborts (i.e. crash) the program.
 * On failure, throws an exception or returns a negative error code.
 */
function yEnableExceptions()
{
    YAPI::EnableExceptions();
}

/**
 * Setup the Yoctopuce library to use modules connected on a given machine. The
 * parameter will determine how the API will work. Use the following values:
 * 
 * <b>usb</b>: When the usb keyword is used, the API will work with
 * devices connected directly to the USB bus. Some programming languages such a Javascript,
 * PHP, and Java don't provide direct access to USB hardware, so usb will
 * not work with these. In this case, use a VirtualHub or a networked YoctoHub (see below).
 * 
 * <b><i>x.x.x.x</i></b> or <b><i>hostname</i></b>: The API will use the devices connected to the
 * host with the given IP address or hostname. That host can be a regular computer
 * running a VirtualHub, or a networked YoctoHub such as YoctoHub-Ethernet or
 * YoctoHub-Wireless. If you want to use the VirtualHub running on you local
 * computer, use the IP address 127.0.0.1.
 * 
 * <b>callback</b>: that keyword make the API run in "<i>HTTP Callback</i>" mode.
 * This a special mode allowing to take control of Yoctopuce devices
 * through a NAT filter when using a VirtualHub or a networked YoctoHub. You only
 * need to configure your hub to call your server script on a regular basis.
 * This mode is currently available for PHP and Node.JS only.
 * 
 * Be aware that only one application can use direct USB access at a
 * given time on a machine. Multiple access would cause conflicts
 * while trying to access the USB modules. In particular, this means
 * that you must stop the VirtualHub software before starting
 * an application that uses direct USB access. The workaround
 * for this limitation is to setup the library to use the VirtualHub
 * rather than direct USB access.
 * 
 * If access control has been activated on the hub, virtual or not, you want to
 * reach, the URL parameter should look like:
 * 
 * http://username:password@address:port
 * 
 * You can call <i>RegisterHub</i> several times to connect to several machines.
 * 
 * @param url : a string containing either "usb","callback" or the
 *         root URL of the hub to monitor
 * @param errmsg : a string passed by reference to receive any error message.
 * 
 * @return YAPI_SUCCESS when the call succeeds.
 * 
 * On failure, throws an exception or returns a negative error code.
 */
function yRegisterHub($url,&$errmsg="")
{
    return YAPI::RegisterHub($url,$errmsg);
}


function yPreregisterHub($url,&$errmsg="")
{
    return YAPI::PreregisterHub($url,$errmsg);
}

/**
 * Setup the Yoctopuce library to no more use modules connected on a previously
 * registered machine with RegisterHub.
 * 
 * @param url : a string containing either "usb" or the
 *         root URL of the hub to monitor
 */
function yUnregisterHub($url)
{
    YAPI::UnregisterHub($url);
}




/**
 * Triggers a (re)detection of connected Yoctopuce modules.
 * The library searches the machines or USB ports previously registered using
 * yRegisterHub(), and invokes any user-defined callback function
 * in case a change in the list of connected devices is detected.
 * 
 * This function can be called as frequently as desired to refresh the device list
 * and to make the application aware of hot-plug events.
 * 
 * @param errmsg : a string passed by reference to receive any error message.
 * 
 * @return YAPI_SUCCESS when the call succeeds.
 * 
 * On failure, throws an exception or returns a negative error code.
 */
function yUpdateDeviceList(&$errmsg="")
{
    return YAPI::UpdateDeviceList($errmsg);
}

/**
 * Maintains the device-to-library communication channel.
 * If your program includes significant loops, you may want to include
 * a call to this function to make sure that the library takes care of
 * the information pushed by the modules on the communication channels.
 * This is not strictly necessary, but it may improve the reactivity
 * of the library for the following commands.
 * 
 * This function may signal an error in case there is a communication problem
 * while contacting a module.
 * 
 * @param errmsg : a string passed by reference to receive any error message.
 * 
 * @return YAPI_SUCCESS when the call succeeds.
 * 
 * On failure, throws an exception or returns a negative error code.
 */
function yHandleEvents(&$errmsg="")
{
    return YAPI::HandleEvents($errmsg);
}

/**
 * Pauses the execution flow for a specified duration.
 * This function implements a passive waiting loop, meaning that it does not
 * consume CPU cycles significantly. The processor is left available for
 * other threads and processes. During the pause, the library nevertheless
 * reads from time to time information from the Yoctopuce modules by
 * calling yHandleEvents(), in order to stay up-to-date.
 * 
 * This function may signal an error in case there is a communication problem
 * while contacting a module.
 * 
 * @param ms_duration : an integer corresponding to the duration of the pause,
 *         in milliseconds.
 * @param errmsg : a string passed by reference to receive any error message.
 * 
 * @return YAPI_SUCCESS when the call succeeds.
 * 
 * On failure, throws an exception or returns a negative error code.
 */
function ySleep($ms_duration, &$errmsg="")
{
    return YAPI::Sleep($ms_duration, $errmsg);
}

/**
 * Returns the current value of a monotone millisecond-based time counter.
 * This counter can be used to compute delays in relation with
 * Yoctopuce devices, which also uses the millisecond as timebase.
 * 
 * @return a long integer corresponding to the millisecond counter.
 */
function yGetTickCount()
{
    return YAPI::GetTickCount();
}

/**
 * Checks if a given string is valid as logical name for a module or a function.
 * A valid logical name has a maximum of 19 characters, all among
 * A..Z, a..z, 0..9, _, and -.
 * If you try to configure a logical name with an incorrect string,
 * the invalid characters are ignored.
 * 
 * @param name : a string containing the name to check.
 * 
 * @return true if the name is valid, false otherwise.
 */
function yCheckLogicalName($name)
{
    return YAPI::CheckLogicalName($name);
}

/**
 * Register a callback function, to be called each time
 * a device is plugged. This callback will be invoked while yUpdateDeviceList
 * is running. You will have to call this function on a regular basis.
 * 
 * @param arrivalCallback : a procedure taking a YModule parameter, or null
 *         to unregister a previously registered  callback.
 */
function yRegisterDeviceArrivalCallback($arrivalCallback)
{
    YAPI::RegisterDeviceArrivalCallback($arrivalCallback);
}

/**
 * Register a device logical name change callback
 */
function yRegisterDeviceChangeCallback($changeCallback)
{
    YAPI::RegisterDeviceChangeCallback($changeCallback);
}

/**
 * Register a callback function, to be called each time
 * a device is unplugged. This callback will be invoked while yUpdateDeviceList
 * is running. You will have to call this function on a regular basis.
 * 
 * @param removalCallback : a procedure taking a YModule parameter, or null
 *         to unregister a previously registered  callback.
 */
function yRegisterDeviceRemovalCallback($removalCallback)
{
    YAPI::RegisterDeviceRemovalCallback($removalCallback);
}

// Register a new value calibration handler for a given calibration type
//
function yRegisterCalibrationHandler($int_calibrationType, $calibrationHandler)
{
    YAPI::RegisterCalibrationHandler($int_calibrationType, $calibrationHandler);
}

// Standard value calibration handler (n-point linear error correction)
//
function yLinearCalibrationHandler($int_calibType, $float_rawValue, $arr_calibParams,
                                   $arr_calibRawValues, $arr_calibRefValues)
{
    return YAPI::LinearCalibrationHandler($int_calibType, $float_rawValue, $arr_calibParams,
                                          $arr_calibRawValues, $arr_calibRefValues);
}

for($yHdlrIdx = 1; $yHdlrIdx <= 20; $yHdlrIdx++) {
    yRegisterCalibrationHandler($yHdlrIdx, 'yLinearCalibrationHandler');
}
yRegisterCalibrationHandler(YOCTO_CALIB_TYPE_OFS, 'yLinearCalibrationHandler');

//--- (generated code: Sensor functions)

/**
 * Retrieves a sensor for a given identifier.
 * The identifier can be specified using several formats:
 * <ul>
 * <li>FunctionLogicalName</li>
 * <li>ModuleSerialNumber.FunctionIdentifier</li>
 * <li>ModuleSerialNumber.FunctionLogicalName</li>
 * <li>ModuleLogicalName.FunctionIdentifier</li>
 * <li>ModuleLogicalName.FunctionLogicalName</li>
 * </ul>
 * 
 * This function does not require that the sensor is online at the time
 * it is invoked. The returned object is nevertheless valid.
 * Use the method YSensor.isOnline() to test if the sensor is
 * indeed online at a given time. In case of ambiguity when looking for
 * a sensor by logical name, no error is notified: the first instance
 * found is returned. The search is performed first by hardware name,
 * then by logical name.
 * 
 * @param func : a string that uniquely characterizes the sensor
 * 
 * @return a YSensor object allowing you to drive the sensor.
 */
function yFindSensor($func)
{
    return YSensor::FindSensor($func);
}

/**
 * Starts the enumeration of sensors currently accessible.
 * Use the method YSensor.nextSensor() to iterate on
 * next sensors.
 * 
 * @return a pointer to a YSensor object, corresponding to
 *         the first sensor currently online, or a null pointer
 *         if there are none.
 */
function yFirstSensor()
{
    return YSensor::FirstSensor();
}

//--- (end of generated code: Sensor functions)

//--- (generated code: Module functions)

/**
 * Allows you to find a module from its serial number or from its logical name.
 * 
 * This function does not require that the module is online at the time
 * it is invoked. The returned object is nevertheless valid.
 * Use the method YModule.isOnline() to test if the module is
 * indeed online at a given time. In case of ambiguity when looking for
 * a module by logical name, no error is notified: the first instance
 * found is returned. The search is performed first by hardware name,
 * then by logical name.
 * 
 * @param func : a string containing either the serial number or
 *         the logical name of the desired module
 * 
 * @return a YModule object allowing you to drive the module
 *         or get additional information on the module.
 */
function yFindModule($func)
{
    return YModule::FindModule($func);
}

/**
 * Starts the enumeration of modules currently accessible.
 * Use the method YModule.nextModule() to iterate on the
 * next modules.
 * 
 * @return a pointer to a YModule object, corresponding to
 *         the first module currently online, or a null pointer
 *         if there are none.
 */
function yFirstModule()
{
    return YModule::FirstModule();
}

//--- (end of generated code: Module functions)


?>