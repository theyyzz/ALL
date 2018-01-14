<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/01/09 0009
 * Time: 15:10
 */

namespace App\Handler;

use Illuminate\Support\Facades\Redis;
class Web_Socket_Handler {
    public $master;
    public $sockets = array();
    public $debug = false;
    public $user=array();

    function __construct($address, $port){

        $this->master=socket_create(AF_INET, SOCK_STREAM, SOL_TCP)or die("socket_create() failed");

        socket_set_option($this->master, SOL_SOCKET, SO_REUSEADDR, 1)or die("socket_option() failed");

        socket_bind($this->master, $address, $port)or die("socket_bind() failed");

        socket_listen($this->master,20)or die("socket_listen() failed");

        $this->sockets[] = $this->master;
        $this->say("Server Started : ".date('Y-m-d H:i:s'));
        $this->say("Listening on   : ".$address." port ".$port);
        $this->say("Master socket  : ".$this->master."\n");
    }

    public function run()
    {
        while(true){
            $socketArr = $this->sockets;
            $write = NULL;
            $except = NULL;
            socket_select($socketArr, $write, $except, NULL);  //自动选择来消息的socket 如果是握手 自动选择主机
            foreach ($socketArr as $socket){
                if ($socket == $this->master){  //主机
                    $client = socket_accept($this->master);
                    if ($client < 0){
                        $this->log("socket_accept() failed");
                        continue;
                    } else{
                        $this->Connect($client);
                    }
                } else {
                    $bytes = @socket_recv($socket,$buffer,2048,0);
                    if ($bytes == 0){
                        $this->disConnect($socket);
                    }
                    else{
                        $key= $this->search($socket);
                        if (!$this->user[$key]['handshake']){
                            $this->doHandShake($socket, $buffer,$key);
                        }
                        else{
                            $buffer = $this->decode($buffer);
                            echo $buffer;
                            $this->send($socket, $buffer);
                        }
                    }
                }
            }
        }

    }
    //发送消息
    function send($client, $msg){
        $msg = $this->frame($msg);
        socket_write($client, $msg, strlen($msg));
    }
    //建立连接
    function connect($socket){
        array_push($this->sockets, $socket);
        $key=uniqid();
        $this->user[$key]=[
            'socket'=>$socket,
            'handshake'=>false
        ];
    }
    //关闭连接
    function disConnect($socket){
        socket_close($socket);
        $user_key=$this->search($socket);
        unset($this->user[$user_key]);
        $this->sockets=array($this->master);
        foreach($this->user as $v){
            $this->sockets[]=$v['socket'];
        }
        $this->say($socket . " DISCONNECTED!");
    }
    //握手头信息
    function doHandShake($socket, $buffer,$userkey){
        list($resource, $host, $origin, $key) = $this->getHeaders($buffer);
        $upgrade  = "HTTP/1.1 101 Switching Protocol\r\n" .
            "Upgrade: websocket\r\n" .
            "Connection: Upgrade\r\n" .
            "Sec-WebSocket-Accept: " . $this->calcKey($key) . "\r\n\r\n";  //必须以两个回车结尾
        socket_write($socket, $upgrade, strlen($upgrade));
        $this->user[$userkey]['handshake']=true;
        return true;
    }

    //
    function getHeaders($req){
        $r = $h = $o = $key = null;
        if (preg_match("/GET (.*) HTTP/"              ,$req,$match)) { $r = $match[1]; }
        if (preg_match("/Host: (.*)\r\n/"             ,$req,$match)) { $h = $match[1]; }
        if (preg_match("/Origin: (.*)\r\n/"           ,$req,$match)) { $o = $match[1]; }
        if (preg_match("/Sec-WebSocket-Key: (.*)\r\n/",$req,$match)) { $key = $match[1]; }
        return array($r, $h, $o, $key);
    }
    //加密key
    function calcKey($key){
        //基于websocket version 13
        $accept = base64_encode(sha1($key . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11', true));
        return $accept;
    }
    //解码
    function decode($buffer) {
        $len = $masks = $data = $decoded = null;
        $len = ord($buffer[1]) & 127;

        if ($len === 126) {
            $masks = substr($buffer, 4, 4);
            $data = substr($buffer, 8);
        }
        else if ($len === 127) {
            $masks = substr($buffer, 10, 4);
            $data = substr($buffer, 14);
        }
        else {
            $masks = substr($buffer, 2, 4);
            $data = substr($buffer, 6);
        }
        for ($index = 0; $index < strlen($data); $index++) {
            $decoded .= $data[$index] ^ $masks[$index % 4];
        }
        return $decoded;
    }
    //返回数据格式
    function frame($s)
    {
        $a = str_split($s, 125);
        if (count($a) == 1) {
            return "\x81" . chr(strlen($a[0])) . $a[0];
        }
        $ns = "";
        foreach ($a as $o) {
            $ns .= "\x81" . chr(strlen($o)) . $o;
        }
        return $ns;
    }

    //根据sock在users里面查找相应的$k
    function search($sock){
        foreach ($this->user as $k=>$v){
            if($sock==$v['socket'])
                return $k;
        }
        return false;
    }

    function say($msg = ""){
        echo $msg . "\n";
    }

    function log($msg = ""){
        if ($this->debug){
            echo $msg . "\n";
        }
    }
}
