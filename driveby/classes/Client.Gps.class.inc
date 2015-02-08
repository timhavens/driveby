<?php
/*
 * Copyright 2014 Johan Desmyter <johan@etic.yt>
 *
 * This file is part of nykopol/gpsd-client.
 *
 * nykopol/gpsd-client is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * nykopol/gpsd-client is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.

 * You should have received a copy of the GNU Lesser General Public License
 * along with nykopol/gpsd-client. If not, see http://www.gnu.org/licenses/
 *
 *
*/

/**
 * Client class for GPSD service
 * see : http://catb.org/gpsd/client-howto.html
 */
class Client
{
    /**
     * Host of the service (default: localhost)
     * @var string
     */
    protected $host;

    /**
     * Tcp port (port: 2947)
     * @var int
     */
    protected $port;

    /**
     * Stream
     * @var resource
     */
    protected $stream;

    /**
     * Constructor
     * @param string $host
     * @param int $port
     */
    public function __construct($host = 'localhost', $port = 2947){
        $this->host = $host;
        $this->port = $port;
    }

    public function __destruct() {
        $this->disconnect();
    }

    /**
     * Connect to the service
     * @return string service informations json_decoded
     * @throws Exception
     */
    public function connect(){
        $this->stream = stream_socket_client('tcp://'.$this->host.':'.$this->port, $errno, $errstr, 10);
        if(!$this->stream){
            throw new Exception("Error $errno : $errstr");
        }

        return fgets($this->stream);
    }

    /**
     * Set service watch settings
     *
     * @param bool $enable tell the service to watch or not the devices (default: true)
     * @param string $format the desired format of the returned datas (default: json)
     */
    public function watch($enable = true, $format = 'json'){
        if($enable){
            fwrite($this->stream, '?WATCH={"enable":true,"'.$format.'":true}');
        }else{
            fwrite($this->stream, '?WATCH={"enable":false}');
        }
    }

    /**
     * Get the next message of the given class (TPV, AIS, SKY, ...)
     * @param string $class Classe name of the desired message
     * @param bool $buffer get the next message from buffer or the next one in time
     * @return
     */
    public function getNext($class, $buffer = false){

        // flush buffer
        if(!$buffer){
            stream_set_blocking($this->stream, 0);
            while(fgets($this->stream)){ }
            stream_set_blocking($this->stream, 1);
        }

        // get next message
        while(1){
            $message = fgets($this->stream);
            if(false !== strpos($message, $class)){
                return $message;
            }
        }

    }

    /**
     * Disconnect from the service
     */
    public function disconnect(){
        if($this->stream){
            fclose($this->stream);
        }
    }

}
