<?php
/**
 * Created by PhpStorm.
 * User: dage
 * Date: 2018/1/22
 * Time: 17:59
 */

namespace App\Handler;


use Illuminate\Support\Facades\Redis;

class App_Handler
{

    public $users=array();

    public function on_open($data)
    {
        var_dump($data);
        $this->users[$data[0]]='';
        Redis::set($data[0],'');
        
    }

    public function on_message($data)
    {
        $SeqNum=$data['SeqNum'];
        $data=json_decode($data['data']);
        if (empty($this->users[$SeqNum])){
            $this->users[$SeqNum]=array('UserInfo:',$data['UserInfo']);
            Redis::set($SeqNum,json_encode(array('UserInfo:',$data['UserInfo'])));
        }else{
            $data['CmdType'];

        }
    }

    public function on_close($data)
    {
        var_dump($data);
        
    }

}