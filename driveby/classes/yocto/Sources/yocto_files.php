<?php
/*********************************************************************
 *
 * $Id: yocto_files.php 18014 2014-10-13 09:25:58Z seb $
 *
 * Implements yFindFiles(), the high-level API for Files functions
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


//--- (return codes)
//--- (end of return codes)
//--- (generated code: YFiles definitions)
if(!defined('Y_FILESCOUNT_INVALID'))         define('Y_FILESCOUNT_INVALID',        YAPI_INVALID_UINT);
if(!defined('Y_FREESPACE_INVALID'))          define('Y_FREESPACE_INVALID',         YAPI_INVALID_UINT);
//--- (end of generated code: YFiles definitions)

//--- (generated code: YFileRecord definitions)
//--- (end of generated code: YFileRecord definitions)

//--- (generated code: YFileRecord declaration)
/**
 * YFileRecord Class: Description of a file on the device filesystem
 * 
 * 
 */
class YFileRecord
{
    //--- (end of generated code: YFileRecord declaration)

    //--- (generated code: YFileRecord attributes)
    protected $_name                     = "";                           // str
    protected $_size                     = 0;                            // int
    protected $_crc                      = 0;                            // int
    //--- (end of generated code: YFileRecord attributes)

    function __construct($str_json)
    {
        //--- (generated code: YFileRecord constructor)
        //--- (end of generated code: YFileRecord constructor)
        
        $loadval = json_decode($str_json, TRUE);
        $this->_name = $loadval['name'];
        $this->_size = $loadval['size'];
        $this->_crc  = $loadval['crc'];
    }
    
    //--- (generated code: YFileRecord implementation)

    public function get_name()
    {
        return $this->_name;
    }

    public function get_size()
    {
        return $this->_size;
    }

    public function get_crc()
    {
        return $this->_crc;
    }

    //--- (end of generated code: YFileRecord implementation)

    function contentEquals($bin_content)
    {
        return ($this->_size == strlen($bin_content) && 
                $this->_crc == crc32($bin_content));
    }
}

//--- (generated code: YFiles declaration)
/**
 * YFiles Class: Files function interface
 * 
 * The filesystem interface makes it possible to store files
 * on some devices, for instance to design a custom web UI
 * (for networked devices) or to add fonts (on display
 * devices).
 */
class YFiles extends YFunction
{
    const FILESCOUNT_INVALID             = YAPI_INVALID_UINT;
    const FREESPACE_INVALID              = YAPI_INVALID_UINT;
    //--- (end of generated code: YFiles declaration)

    //--- (generated code: YFiles attributes)
    protected $_filesCount               = Y_FILESCOUNT_INVALID;         // UInt31
    protected $_freeSpace                = Y_FREESPACE_INVALID;          // UInt31
    //--- (end of generated code: YFiles attributes)

    function __construct($str_func)
    {
        //--- (generated code: YFiles constructor)
        parent::__construct($str_func);
        $this->_className = 'Files';

        //--- (end of generated code: YFiles constructor)
    }

    //--- (generated code: YFiles implementation)

    function _parseAttr($name, $val)
    {
        switch($name) {
        case 'filesCount':
            $this->_filesCount = intval($val);
            return 1;
        case 'freeSpace':
            $this->_freeSpace = intval($val);
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Returns the number of files currently loaded in the filesystem.
     * 
     * @return an integer corresponding to the number of files currently loaded in the filesystem
     * 
     * On failure, throws an exception or returns Y_FILESCOUNT_INVALID.
     */
    public function get_filesCount()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_FILESCOUNT_INVALID;
            }
        }
        return $this->_filesCount;
    }

    /**
     * Returns the free space for uploading new files to the filesystem, in bytes.
     * 
     * @return an integer corresponding to the free space for uploading new files to the filesystem, in bytes
     * 
     * On failure, throws an exception or returns Y_FREESPACE_INVALID.
     */
    public function get_freeSpace()
    {
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI_SUCCESS) {
                return Y_FREESPACE_INVALID;
            }
        }
        return $this->_freeSpace;
    }

    /**
     * Retrieves a filesystem for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     * 
     * This function does not require that the filesystem is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method YFiles.isOnline() to test if the filesystem is
     * indeed online at a given time. In case of ambiguity when looking for
     * a filesystem by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     * 
     * @param func : a string that uniquely characterizes the filesystem
     * 
     * @return a YFiles object allowing you to drive the filesystem.
     */
    public static function FindFiles($func)
    {
        // $obj                    is a YFiles;
        $obj = YFunction::_FindFromCache('Files', $func);
        if ($obj == null) {
            $obj = new YFiles($func);
            YFunction::_AddToCache('Files', $func, $obj);
        }
        return $obj;
    }

    public function sendCommand($command)
    {
        // $url                    is a str;
        $url = sprintf('files.json?a=%s',$command);
        // may throw an exception
        return $this->_download($url);
    }

    /**
     * Reinitialize the filesystem to its clean, unfragmented, empty state.
     * All files previously uploaded are permanently lost.
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function format_fs()
    {
        // $json                   is a bin;
        // $res                    is a str;
        $json = $this->sendCommand('format');
        $res = $this->_json_get_key($json, 'res');
        if (!($res == 'ok')) return $this->_throw( YAPI_IO_ERROR, 'format failed',YAPI_IO_ERROR);
        return YAPI_SUCCESS;
    }

    /**
     * Returns a list of YFileRecord objects that describe files currently loaded
     * in the filesystem.
     * 
     * @param pattern : an optional filter pattern, using star and question marks
     *         as wildcards. When an empty pattern is provided, all file records
     *         are returned.
     * 
     * @return a list of YFileRecord objects, containing the file path
     *         and name, byte size and 32-bit CRC of the file content.
     * 
     * On failure, throws an exception or returns an empty list.
     */
    public function get_list($pattern)
    {
        // $json                   is a bin;
        $filelist = Array();    // strArr;
        $res = Array();         // YFileRecordArr;
        $json = $this->sendCommand(sprintf('dir&f=%s',$pattern));
        $filelist = $this->_json_get_array($json);
        while(sizeof($res) > 0) { array_pop($res); };
        foreach($filelist as $each) {
            $res[] = new YFileRecord($each);
        }
        return $res;
    }

    /**
     * Downloads the requested file and returns a binary buffer with its content.
     * 
     * @param pathname : path and name of the file to download
     * 
     * @return a binary buffer with the file content
     * 
     * On failure, throws an exception or returns an empty content.
     */
    public function download($pathname)
    {
        return $this->_download($pathname);
    }

    /**
     * Uploads a file to the filesystem, to the specified full path name.
     * If a file already exists with the same path name, its content is overwritten.
     * 
     * @param pathname : path and name of the new file to create
     * @param content : binary buffer with the content to set
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function upload($pathname,$content)
    {
        return $this->_upload($pathname, $content);
    }

    /**
     * Deletes a file, given by its full path name, from the filesystem.
     * Because of filesystem fragmentation, deleting a file may not always
     * free up the whole space used by the file. However, rewriting a file
     * with the same path name will always reuse any space not freed previously.
     * If you need to ensure that no space is taken by previously deleted files,
     * you can use format_fs to fully reinitialize the filesystem.
     * 
     * @param pathname : path and name of the file to remove.
     * 
     * @return YAPI_SUCCESS if the call succeeds.
     * 
     * On failure, throws an exception or returns a negative error code.
     */
    public function remove($pathname)
    {
        // $json                   is a bin;
        // $res                    is a str;
        $json = $this->sendCommand(sprintf('del&f=%s',$pathname));
        $res  = $this->_json_get_key($json, 'res');
        if (!($res == 'ok')) return $this->_throw( YAPI_IO_ERROR, 'unable to remove file',YAPI_IO_ERROR);
        return YAPI_SUCCESS;
    }

    public function filesCount()
    { return $this->get_filesCount(); }

    public function freeSpace()
    { return $this->get_freeSpace(); }

    /**
     * Continues the enumeration of filesystems started using yFirstFiles().
     * 
     * @return a pointer to a YFiles object, corresponding to
     *         a filesystem currently online, or a null pointer
     *         if there are no more filesystems to enumerate.
     */
    public function nextFiles()
    {   $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if($resolve->errorType != YAPI_SUCCESS) return null;
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if($next_hwid == null) return null;
        return yFindFiles($next_hwid);
    }

    /**
     * Starts the enumeration of filesystems currently accessible.
     * Use the method YFiles.nextFiles() to iterate on
     * next filesystems.
     * 
     * @return a pointer to a YFiles object, corresponding to
     *         the first filesystem currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstFiles()
    {   $next_hwid = YAPI::getFirstHardwareId('Files');
        if($next_hwid == null) return null;
        return self::FindFiles($next_hwid);
    }

    //--- (end of generated code: YFiles implementation)
};

//--- (generated code: Files functions)

/**
 * Retrieves a filesystem for a given identifier.
 * The identifier can be specified using several formats:
 * <ul>
 * <li>FunctionLogicalName</li>
 * <li>ModuleSerialNumber.FunctionIdentifier</li>
 * <li>ModuleSerialNumber.FunctionLogicalName</li>
 * <li>ModuleLogicalName.FunctionIdentifier</li>
 * <li>ModuleLogicalName.FunctionLogicalName</li>
 * </ul>
 * 
 * This function does not require that the filesystem is online at the time
 * it is invoked. The returned object is nevertheless valid.
 * Use the method YFiles.isOnline() to test if the filesystem is
 * indeed online at a given time. In case of ambiguity when looking for
 * a filesystem by logical name, no error is notified: the first instance
 * found is returned. The search is performed first by hardware name,
 * then by logical name.
 * 
 * @param func : a string that uniquely characterizes the filesystem
 * 
 * @return a YFiles object allowing you to drive the filesystem.
 */
function yFindFiles($func)
{
    return YFiles::FindFiles($func);
}

/**
 * Starts the enumeration of filesystems currently accessible.
 * Use the method YFiles.nextFiles() to iterate on
 * next filesystems.
 * 
 * @return a pointer to a YFiles object, corresponding to
 *         the first filesystem currently online, or a null pointer
 *         if there are none.
 */
function yFirstFiles()
{
    return YFiles::FirstFiles();
}

//--- (end of generated code: Files functions)
?>