<?php
/*********************************************************************
 *
 * $Id: yocto_datalogger.php 18014 2014-10-13 09:25:58Z seb $
 *
 * Implements yFindDataLogger(), the high-level API for DataLogger functions
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

//--- (generated code: YDataLogger definitions)
if(!defined('Y_RECORDING_OFF'))              define('Y_RECORDING_OFF',             0);
if(!defined('Y_RECORDING_ON'))               define('Y_RECORDING_ON',              1);
if(!defined('Y_RECORDING_INVALID'))          define('Y_RECORDING_INVALID',         -1);
if(!defined('Y_AUTOSTART_OFF'))              define('Y_AUTOSTART_OFF',             0);
if(!defined('Y_AUTOSTART_ON'))               define('Y_AUTOSTART_ON',              1);
if(!defined('Y_AUTOSTART_INVALID'))          define('Y_AUTOSTART_INVALID',         -1);
if(!defined('Y_BEACONDRIVEN_OFF'))           define('Y_BEACONDRIVEN_OFF',          0);
if(!defined('Y_BEACONDRIVEN_ON'))            define('Y_BEACONDRIVEN_ON',           1);
if(!defined('Y_BEACONDRIVEN_INVALID'))       define('Y_BEACONDRIVEN_INVALID',      -1);
if(!defined('Y_CLEARHISTORY_FALSE'))         define('Y_CLEARHISTORY_FALSE',        0);
if(!defined('Y_CLEARHISTORY_TRUE'))          define('Y_CLEARHISTORY_TRUE',         1);
if(!defined('Y_CLEARHISTORY_INVALID'))       define('Y_CLEARHISTORY_INVALID',      -1);
if(!defined('Y_CURRENTRUNINDEX_INVALID'))    define('Y_CURRENTRUNINDEX_INVALID',   YAPI_INVALID_UINT);
if(!defined('Y_TIMEUTC_INVALID'))            define('Y_TIMEUTC_INVALID',           YAPI_INVALID_LONG);
//--- (end of generated code: YDataLogger definitions)

/**
 * YOldDataStream Class: Sequence of measured data, stored by the data logger
 * 
 * A data stream is a small collection of consecutive measures for a set
 * of sensors. A few properties are available directly from the object itself
 * (they are preloaded at instantiation time), while most other properties and
 * the actual data are loaded on demand when accessed for the first time.
 */
class YOldDataStream extends YDataStream
{
    const DATA_INVALID = Y_INVALID_FLOAT;

    protected $_dataLogger = null;
    protected $_interval   = 0;
    protected $_timeStamp  = 0;

    function __construct($parent, $run, $stamp, $utc=-1, $itv=0)
    {
        parent::__construct($parent);
        
        $this->_dataLogger = $parent;
        $this->_runNo      = $run;
        $this->_timeStamp  = $stamp;
        $this->_utcStamp   = $utc;
        $this->_interval   = $itv;
        $this->_samplesPerHour = ($itv == 0 ? 3600 : 3600 / $this->_interval);
        $this->_isClosed   = 1;
        $this->_minVal     = Y_INVALID_FLOAT;
        $this->_avgVal     = Y_INVALID_FLOAT;
        $this->_maxVal     = Y_INVALID_FLOAT;
    }
    
    // Internal function to preload all values into object
    //
    public function loadStream()
    {
        $coldiv = null;
        $coltyp = null;
        $colscl = null;
        $colofs = null;
        $calhdl = null;
        $caltyp = null;
        $calpar = null;
        $calraw = null;
        $calref = null;

        $loadval = null;
        $retcode = $this->_dataLogger->getData($this->_runNo, $this->_timeStamp, $loadval);
        if($retcode != YAPI_SUCCESS) {
            return $retcode;
        }
        if(isset($loadval['time']))     $this->_timeStamp = $loadval['time'];
        if(isset($loadval['UTC']))      $this->_utcStamp  = $loadval['UTC'];
        if(isset($loadval['interval'])) $this->_interval  = $loadval['interval'];
        if(isset($loadval['nRows']))    $this->_nRows     = $loadval['nRows'];
        if(isset($loadval['keys'])) {
            $this->_columnNames = $loadval['keys'];
            if($this->_nCols == 0) {
                $this->_nCols = sizeof($this->_columnNames);
            } else if($this->_nCols != sizeof($this->_columnNames)) {
                $this->_nCols = 0;
                return YAPI_IO_ERROR;
            }
        }
        if(isset($loadval['div'])) {
            $coldiv = $loadval['div'];
            if($this->_nCols == 0) {
                $this->_nCols = sizeof($coldiv);
            } else if($this->_nCols != sizeof($coldiv)) {
                $this->_nCols = 0;
                return YAPI_IO_ERROR;
            }
        }
        if(isset($loadval['type'])) {
            $coltyp = $loadval['type'];
            if($this->_nCols == 0) {
                $this->_nCols = sizeof($coltyp);
            } else if($this->_nCols != sizeof($coltyp)) {
                $this->_nCols = 0;
                return YAPI_IO_ERROR;
            }
        }
        if(isset($loadval['scal'])) {
            $colscl = $loadval['scal'];
            $colofs = Array();
            if($this->_nCols == 0) {
                $this->_nCols = sizeof($colscl);
            } else if($this->_nCols != sizeof($colscl)) {
                $this->_nCols = 0;
                return YAPI_IO_ERROR;
            }
            for($i = 0; $i < sizeof($colscl); $i++) {
                $colscl[$i] /= 65536.0;
                $colofs[$i] = ($coltyp[$i] != 0 ? -32767 : 0);
            }
        } else {
            $colscl = Array();
            $colofs = Array();
            for($i = 0; $i < sizeof($coldiv); $i++) {
                $colscl[$i] = 1.0 / $coldiv[$i];
                $colofs[$i] = ($coltyp[$i] != 0 ? -32767 : 0);
            }
        }
        if(isset($loadval['cal'])) {
            $calhdl = Array();
            $caltyp = Array();
            $calpar = Array();
            $calraw = Array();
            $calref = Array();
            for($c = 0; $c < $this->_nCols; $c++) {
                $params = $loadval['cal'][$c];
                if(!$params) continue;
                $params = explode(',', $params);
                if(sizeof($params) < 11) continue;
                $calhdl[$c] = YAPI::getCalibrationHandler($params[0]);
                if(is_null($calhdl[$c])) continue;
                $caltyp[$c] = intVal($params[0]);
                $calpar[$c] = Array();
                $calraw[$c] = Array();
                $calref[$c] = Array();
                for($i = 1; $i < sizeof($params); $i += 2) {
                    $calpar[$c][$i-1] = intVal($params[$i]);
                    $calpar[$c][$i]   = intVal($params[$i+1]);
                    if($caltyp[$c] <= 10) {
                        $calraw[$c][$i>>1] = ($calpar[$c][$i-1] + $colofs[$c]) / $coldiv[$c];
                        $calref[$c][$i>>1] = ($calpar[$c][$i]   + $colofs[$c]) / $coldiv[$c];
                    } else {
                        $calraw[$c][$i>>1] = YAPI::decimalToDouble($calpar[$c][$i-1]);
                        $calref[$c][$i>>1] = YAPI::decimalToDouble($calpar[$c][$i]);
                    }
                }
            }
        }
        if(isset($loadval['data'])) {
            if($this->_nCols == 0 || is_null($coldiv) || is_null($coltyp)) {
                return YAPI_IO_ERROR;
            }
            if(is_string($loadval['data'])) {
                $data = $loadval['data'];
                $datalen = strlen($data);
                $udata = Array();
                for($i = 0; $i < $datalen;) {
                    if($data[$i] >= 'a') {
                        $srcpos = sizeof($udata)-1-(ord($data[$i++])-97);
                        if($srcpos < 0) return YAPI_IO_ERROR;
                        $udata[] = $udata[$srcpos];
                    } else {
                        if($i+2 > $datalen) return YAPI_IO_ERROR;
                        $val = ord($data[$i++]) - 48;
                        $val += (ord($data[$i++]) - 48) << 5;
                        if($data[$i] == 'z') $data[$i] = '\\';
                        $val += (ord($data[$i++]) - 48) << 10;
                        $udata[] = $val;
                    }
                }
                $loadval['data'] = $udata;
            }
            $this->_values = Array();
            $dat = Array();
            $c = 0;
            foreach($loadval['data'] as $val) {
                if($coltyp[$c] < 2) {
                    $val = ($val + $colofs[$c]) * $colscl[$c];
                } else {
                    $val = YAPI::decimalToDouble($val-32767);
                }
                if(!is_null($calhdl) && isset($calhdl[$c])) {                    
                    // use post-calibration function                    
                    if($caltyp[$c] <= 10) {
                        $val = call_user_func($calhdl[$c], ($val+$colofs[$c])/$coldiv[$c], $caltyp[$c], 
                                              $calpar[$c], $calraw[$c], $calref[$c]);
                    } else if($caltyp[$c] > 20) {
                        $val = call_user_func($calhdl[$c], $val, $caltyp[$c], 
                                              $calpar[$c], $calraw[$c], $calref[$c]);                        
                    }
                }
                $dat[] = $val;
                if(++$c == $this->_nCols) {
                    $this->_values[] = $dat;
                    $dat = Array();
                    $c = 0;
                }
            }
        }
        return YAPI_SUCCESS;
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
        return $this->_timeStamp;
    }
    public function startTime()
    {
        return $this->_timeStamp;
    }

    /**
     * Returns the number of seconds elapsed between  two consecutive
     * rows of this data stream. By default, the data logger records one row
     * per second, but there might be alternative streams at lower resolution
     * created by summarizing the original stream for archiving purposes.
     * 
     * This method does not cause any access to the device, as the value
     * is preloaded in the object at instantiation time.
     * 
     * @return an unsigned number corresponding to a number of seconds.
     */
    public function get_dataSamplesInterval()
    {
        if($this->_interval == 0) $this->loadStream();
        return $this->_interval;
    }
    public function dataSamplesInterval()
    {
        if($this->_interval == 0) $this->loadStream();
        return $this->_interval;
    }
};


//--- (generated code: YDataLogger declaration)
/**
 * YDataLogger Class: DataLogger function interface
 * 
 * Yoctopuce sensors include a non-volatile memory capable of storing ongoing measured
 * data automatically, without requiring a permanent connection to a computer.
 * The DataLogger function controls the global parameters of the internal data
 * logger.
 */
class YDataLogger extends YFunction
{
    const CURRENTRUNINDEX_INVALID        = YAPI_INVALID_UINT;
    const TIMEUTC_INVALID                = YAPI_INVALID_LONG;
    const RECORDING_OFF                  = 0;
    const RECORDING_ON                   = 1;
    const RECORDING_INVALID              = -1;
    const AUTOSTART_OFF                  = 0;
    const AUTOSTART_ON                   = 1;
    const AUTOSTART_INVALID              = -1;
    const BEACONDRIVEN_OFF               = 0;
    const BEACONDRIVEN_ON                = 1;
    const BEACONDRIVEN_INVALID           = -1;
    const CLEARHISTORY_FALSE             = 0;
    const CLEARHISTORY_TRUE              = 1;
    const CLEARHISTORY_INVALID           = -1;
    //--- (end of generated code: YDataLogger declaration)

    //--- (generated code: YDataLogger attributes)
    protected $_currentRunIndex          = Y_CURRENTRUNINDEX_INVALID;    // UInt31
    protected $_timeUTC                  = Y_TIMEUTC_INVALID;            // UTCTime
    protected $_recording                = Y_RECORDING_INVALID;          // OnOff
    protected $_autoStart                = Y_AUTOSTART_INVALID;          // OnOff
    protected $_beaconDriven             = Y_BEACONDRIVEN_INVALID;       // OnOff
    protected $_clearHistory             = Y_CLEARHISTORY_INVALID;       // Bool
    //--- (end of generated code: YDataLogger attributes)
    protected $dataLoggerURL = null;

    function __construct($str_func)
    {
        //--- (generated code: YDataLogger constructor)
        parent::__construct($str_func);
        $this->_className = 'DataLogger';

        //--- (end of generated code: YDataLogger constructor)
    }

    // Internal function to retrieve datalogger memory
    //
    public function getData($runIdx, $timeIdx, &$loadval)
    {
        if(is_null($this->dataLoggerURL)) {
            $this->dataLoggerURL = "/logger.json";
        }

        // get the device serial number
        $devid = $this->module()->get_serialNumber();
        if($devid == Y_SERIALNUMBER_INVALID) {
            return $this->get_errorType();
        }
        $httpreq = "GET ".$this->dataLoggerURL;
        if(!is_null($timeIdx)) {
            $httpreq .= "?run={$runIdx}&time={$timeIdx}";
        }
        $yreq = YAPI::devRequest($devid, $httpreq);
        if($yreq->errorType != YAPI_SUCCESS) {
            if(strpos($yreq->errorMsg, 'HTTP status 404') !== false && $this->dataLoggerURL != "/dataLogger.json") {
                $this->dataLoggerURL = "/dataLogger.json";
                return $this->getData($runIdx, $timeIdx, $loadval);
            }
            return $yreq->errorType;
        }
        $loadval = json_decode($yreq->result, true);

        return YAPI_SUCCESS;
    }

    /**
     * Builds a list of all data streams hold by the data logger (legacy method).
     * The caller must pass by reference an empty array to hold YDataStream
     * objects, and the function fills it with objects describing available
     * data sequences.
     * 
     * This is the old way to retrieve data from the DataLogger.
     * For new applications, you should rather use get_dataSets()
     * method, or call directly get_recordedData() on the
     * sensor object.
     * 
     * @param v : an array of YDataStream objects to be filled in
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function get_dataStreams(&$v)
    {
        $v = Array();
        $loadval = null;
        $retcode = $this->getData(null, null, $loadval);
        if($retcode != YAPI_SUCCESS) {
            return $retcode;
        }
        if(sizeof($loadval) == 0) {
            return YAPI_SUCCESS;
        }
        if(!isset($loadval[0]['id'])) {
            // old datalogger format: [runIdx, timerel, utc, interval]
            foreach($loadval as $arr) {
                if(sizeof($arr) < 4) {
                    return $this->_throw(YAPI_IO_ERROR, "Unexpected JSON reply format", YAPI_IO_ERROR);
                }
                $v[] = new YOldDataStream($this,$arr[0],$arr[1],$arr[2],$arr[3]);
            }    
        } else {
            // new datalogger format: {"id":"...","unit":"...","streams":["...",...]}
            $sets = $this->parse_dataSets(json_encode($loadval));
            for ($i = 0; $i < sizeof($sets); $i++) { 
                $ds = $sets[$i]->get_privateDataStreams();
                for ($si=0; $si < sizeof($ds); $si++) { 
                    $v[] = $ds[$si];
                }
            }            
        }
        return YAPI_SUCCESS;
    }
    public function getDataStreams(&$v)
    {
        return $this->get_dataStreams($v);
    }

    //--- (generated code: YDataLogger implementation)

    function _parseAttr($name, $val)
    {
        switch($name) {
        case 'currentRunIndex':
            $this->_currentRunIndex = intval($val);
            return 1;
        case 'timeUTC':
            $this->_timeUTC = intval($val);
            return 1;
        case 'recording':
            $this->_recording = intval($val);
            return 1;
        case 'autoStart':
            $this->_autoStart = intval($val);
            return 1;
        case 'beaconDriven':
            $this->_beaconDriven = intval($val);
            return 1;
        case 'clearHistory':
            $this->_clearHistory = intval($val);
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Returns the current run number, corresponding to the number of times the module was
     * powered on with the dataLogger enabled at some point.
     * 
     * @return an integer corresponding to the current run number, corresponding to the number of times the module was
     *         powered on with the dataLogger enabled at some point
     * 
     * On failure, throws an exception or returns Y_CURRENTRUNINDEX_INVALID.
     */
    public function get_currentRunIndex()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_CURRENTRUNINDEX_INVALID;
            }
        }
        return $this->_currentRunIndex;
    }

    /**
     * Returns the Unix timestamp for current UTC time, if known.
     * 
     * @return an integer corresponding to the Unix timestamp for current UTC time, if known
     * 
     * On failure, throws an exception or returns Y_TIMEUTC_INVALID.
     */
    public function get_timeUTC()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_TIMEUTC_INVALID;
            }
        }
        return $this->_timeUTC;
    }

    /**
     * Changes the current UTC time reference used for recorded data.
     * 
     * @param newval : an integer corresponding to the current UTC time reference used for recorded data
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_timeUTC($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("timeUTC",$rest_val);
    }

    /**
     * Returns the current activation state of the data logger.
     * 
     * @return either Y_RECORDING_OFF or Y_RECORDING_ON, according to the current activation state of the data logger
     * 
     * On failure, throws an exception or returns Y_RECORDING_INVALID.
     */
    public function get_recording()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_RECORDING_INVALID;
            }
        }
        return $this->_recording;
    }

    /**
     * Changes the activation state of the data logger to start/stop recording data.
     * 
     * @param newval : either Y_RECORDING_OFF or Y_RECORDING_ON, according to the activation state of the
     * data logger to start/stop recording data
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_recording($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("recording",$rest_val);
    }

    /**
     * Returns the default activation state of the data logger on power up.
     * 
     * @return either Y_AUTOSTART_OFF or Y_AUTOSTART_ON, according to the default activation state of the
     * data logger on power up
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
     * Changes the default activation state of the data logger on power up.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     * 
     * @param newval : either Y_AUTOSTART_OFF or Y_AUTOSTART_ON, according to the default activation state
     * of the data logger on power up
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
     * Return true if the data logger is synchronised with the localization beacon.
     * 
     * @return either Y_BEACONDRIVEN_OFF or Y_BEACONDRIVEN_ON
     * 
     * On failure, throws an exception or returns Y_BEACONDRIVEN_INVALID.
     */
    public function get_beaconDriven()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_BEACONDRIVEN_INVALID;
            }
        }
        return $this->_beaconDriven;
    }

    /**
     * Changes the type of synchronisation of the data logger.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     * 
     * @param newval : either Y_BEACONDRIVEN_OFF or Y_BEACONDRIVEN_ON, according to the type of
     * synchronisation of the data logger
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_beaconDriven($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("beaconDriven",$rest_val);
    }

    public function get_clearHistory()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_CLEARHISTORY_INVALID;
            }
        }
        return $this->_clearHistory;
    }

    public function set_clearHistory($newval)
    {
        $rest_val = strval($newval);
        return $this->_setAttr("clearHistory",$rest_val);
    }

    /**
     * Retrieves a data logger for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     * 
     * This function does not require that the data logger is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method YDataLogger.isOnline() to test if the data logger is
     * indeed online at a given time. In case of ambiguity when looking for
     * a data logger by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     * 
     * @param func : a string that uniquely characterizes the data logger
     * 
     * @return a YDataLogger object allowing you to drive the data logger.
     */
    public static function FindDataLogger($func)
    {
        // $obj                    is a YDataLogger;
        $obj = YFunction::_FindFromCache('DataLogger', $func);
        if ($obj == null) {
            $obj = new YDataLogger($func);
            YFunction::_AddToCache('DataLogger', $func, $obj);
        }
        return $obj;
    }

    /**
     * Clears the data logger memory and discards all recorded data streams.
     * This method also resets the current run index to zero.
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function forgetAllDataStreams()
    {
        return $this->set_clearHistory(Y_CLEARHISTORY_TRUE);
    }

    /**
     * Returns a list of YDataSet objects that can be used to retrieve
     * all measures stored by the data logger.
     * 
     * This function only works if the device uses a recent firmware,
     * as YDataSet objects are not supported by firmwares older than
     * version 13000.
     * 
     * @return a list of YDataSet object.
     * 
     * On failure, throws an exception or returns an empty list.
     */
    public function get_dataSets()
    {
        return $this->parse_dataSets($this->_download('logger.json'));
    }

    public function parse_dataSets($json)
    {
        $dslist = Array();      // strArr;
        $res = Array();         // YDataSetArr;
        // may throw an exception
        $dslist = $this->_json_get_array($json);
        while(sizeof($res) > 0) { array_pop($res); };
        foreach($dslist as $each) {
            $res[] = new YDataSet($this, $each);
        }
        return $res;
    }

    public function currentRunIndex()
    { return $this->get_currentRunIndex(); }

    public function timeUTC()
    { return $this->get_timeUTC(); }

    public function setTimeUTC($newval)
    { return $this->set_timeUTC($newval); }

    public function recording()
    { return $this->get_recording(); }

    public function setRecording($newval)
    { return $this->set_recording($newval); }

    public function autoStart()
    { return $this->get_autoStart(); }

    public function setAutoStart($newval)
    { return $this->set_autoStart($newval); }

    public function beaconDriven()
    { return $this->get_beaconDriven(); }

    public function setBeaconDriven($newval)
    { return $this->set_beaconDriven($newval); }

    public function clearHistory()
    { return $this->get_clearHistory(); }

    public function setClearHistory($newval)
    { return $this->set_clearHistory($newval); }

    /**
     * Continues the enumeration of data loggers started using yFirstDataLogger().
     * 
     * @return a pointer to a YDataLogger object, corresponding to
     *         a data logger currently online, or a null pointer
     *         if there are no more data loggers to enumerate.
     */
    public function nextDataLogger()
    {   $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if($resolve->errorType != YAPI_SUCCESS) return null;
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if($next_hwid == null) return null;
        return yFindDataLogger($next_hwid);
    }

    /**
     * Starts the enumeration of data loggers currently accessible.
     * Use the method YDataLogger.nextDataLogger() to iterate on
     * next data loggers.
     * 
     * @return a pointer to a YDataLogger object, corresponding to
     *         the first data logger currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstDataLogger()
    {   $next_hwid = YAPI::getFirstHardwareId('DataLogger');
        if($next_hwid == null) return null;
        return self::FindDataLogger($next_hwid);
    }

    //--- (end of generated code: YDataLogger implementation)
};

//--- (generated code: DataLogger functions)

/**
 * Retrieves a data logger for a given identifier.
 * The identifier can be specified using several formats:
 * <ul>
 * <li>FunctionLogicalName</li>
 * <li>ModuleSerialNumber.FunctionIdentifier</li>
 * <li>ModuleSerialNumber.FunctionLogicalName</li>
 * <li>ModuleLogicalName.FunctionIdentifier</li>
 * <li>ModuleLogicalName.FunctionLogicalName</li>
 * </ul>
 * 
 * This function does not require that the data logger is online at the time
 * it is invoked. The returned object is nevertheless valid.
 * Use the method YDataLogger.isOnline() to test if the data logger is
 * indeed online at a given time. In case of ambiguity when looking for
 * a data logger by logical name, no error is notified: the first instance
 * found is returned. The search is performed first by hardware name,
 * then by logical name.
 * 
 * @param func : a string that uniquely characterizes the data logger
 * 
 * @return a YDataLogger object allowing you to drive the data logger.
 */
function yFindDataLogger($func)
{
    return YDataLogger::FindDataLogger($func);
}

/**
 * Starts the enumeration of data loggers currently accessible.
 * Use the method YDataLogger.nextDataLogger() to iterate on
 * next data loggers.
 * 
 * @return a pointer to a YDataLogger object, corresponding to
 *         the first data logger currently online, or a null pointer
 *         if there are none.
 */
function yFirstDataLogger()
{
    return YDataLogger::FirstDataLogger();
}

//--- (end of generated code: DataLogger functions)
?>