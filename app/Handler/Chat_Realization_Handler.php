<?php
/**
 * Created by PhpStorm.
 * User: dage
 * Date: 2018/1/20
 * Time: 16:14
 */

namespace App\Handler;


class Chat_Realization_Handler
{
    public $server;

    /**
     * construct
     * @param string $address
     * @param int $port
     * @return void No value is returned.
     */
    public function __construct($address, $port)
    {
        $this->server=new Web_Socket_Handler($address, $port);

    }

    /**
     * push
     * @param resource $fd
     * @param string $message
     * @return void No value is returned.
     */
    public function push($fd, $message)
    {
        $this->server->push($fd, $message);

    }

    /**
     * close
     * @param resource $fd
     * @return void No value is returned.
     */
    public function close($fd)
    {
        $this->server->close($fd);
    }

    public function on(string $type,callable $func)
    {
        $this->server->run(function ($data)use ($type,$func){
            if (array_keys($data)[0]=='open'){
                $func($data['open']);
            }elseif (array_keys($data)[0]=='message'){
                $func($data['message']);
            }
        });
    }




}