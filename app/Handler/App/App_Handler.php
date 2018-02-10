<?php
/**
 * Created by PhpStorm.
 * User: dage
 * Date: 2018/1/22
 * Time: 17:59
 */

namespace App\Handler\App;


use Illuminate\Support\Facades\Redis;

class App_Handler
{

    public $users;

    public function on($data)
    {
        if (array_key_exists('open',$data))
        {
            $this->on_open($data['open']);
        }
        elseif (array_key_exists('message',$data))
        {
            $this->on_message($data['message']);
        }
        elseif (array_key_exists('close',$data))
        {
            $this->on_close($data['close']);
        }

    }

    public function all()
    {


    }

    public function on_open($data)
    {

    }
    public function on_message($data)
    {
        $data=json_decode($data['data']);//中间件来做验证规则，以及路由，感觉在写框架啊
        var_dump($data);
        var_dump($data->data->content);
        if ($data->data->content==50){
            $opo=include '1.php';
            var_dump($opo);
        }


      /*  $SeqNum=$data->SeqNum;
        if ($SeqNum==500){
            var_dump(include_once 'test.php');
        }*/
       /* Redis::set([$all_data['fd']],json_encode(array('UserInfo'=>$data['UserInfo'])));
        $this->users[$all_data['fd']]=array('UserInfo'=>$data['UserInfo']['id']);*/
    }

    public function on_close($data)
    {
        var_dump($data);

        
    }

}