<?php

namespace App\Http\Controllers\Redis;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;

class RedisController extends Controller
{
    //

    public function index()
    {
        Redis::set('io',88);
        $opo=Redis::get('io');
        dd($opo);
    }
}