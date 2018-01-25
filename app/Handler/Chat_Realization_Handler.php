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
     * @param int $port 测试
     * @return void No value is returned.
     */
    public function __construct(string $address,int $port)
    {
        $this->server=new Web_Socket_Handler($address, $port);

    }

    /**
     * push
     * @param string $fd
     * @param string $message
     * @return void No value is returned.
     */
    public function push(string $fd,string $message)
    {
        $this->server->push($fd, $message);
    }

    /**
     * close
     * @param string $fd
     * @return void No value is returned.
     */
    public function close(string $fd)
    {
       $this->server->close($fd);
    }

    public function on(string $type,callable $func)
    {
        $this->server->run(function ($data)use ($func){
            if (array_keys($data)[0]=='open'){
                $func($data['open']);
            }elseif (array_keys($data)[0]=='message'){
                $func($data['message']);
            }elseif (array_keys($data)[0]=='close'){
                $func($data['close']);
            }
        });
    }




}