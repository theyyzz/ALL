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

    public $users;

    public function on_open($data)
    {
        $this->users=array($data=>'');
        Redis::set($data,'');
    }

    public function on_message($data)
    {
        $all_data=$data;
        $data=json_decode($all_data['data']);//中间件来做验证规则，以及路由，感觉在写框架啊
        $SeqNum=$data['SeqNum'];
        Redis::set([$all_data['fd']],json_encode(array('UserInfo'=>$data['UserInfo'])));
        $this->users[$all_data['fd']]=array('UserInfo'=>$data['UserInfo']['id']);

    }

    public function on_close($data)
    {
        var_dump($data);

        
    }

}