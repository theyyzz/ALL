<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/01/09 0009
 * Time: 15:10
 */

namespace App\Handler;


class Web_Socket_Handler
{
    /**
     * Connection server's client.
     *
     * @var string
     * */
    public $master;

    /**
     * Different state of the socket management.
     *
     * @var array
     * */
    public $sockets = array();

    /**
     * Judge whether to shake hands.
     *
     * @var  bool
     * */
    public $handshake = false;

    /**
     * Create a Web_Socket instance.
     *
     * @param string $address
     * @param int $port
     * @return void
     */
    public function __construct(string $address,int $port)
    {

    }


}