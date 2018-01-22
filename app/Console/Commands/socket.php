<?php

namespace App\Console\Commands;

use App\Handler\App_Handler;
use App\Handler\Chat_Realization_Handler;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Redis;

class socket extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'socket:websocket {status}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'websocket[start|stop|restart|status]';

    public $server='';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
       $arg = $this->argument('status');
       switch ($arg){
           case 'start':
               $this->info('Hello! Here is thev , Welcome use ALL-seocket:websocket');
               $this->info('Starting......... Please wait');
               $this->start();
               break;
           case 'stop':
               break;
           case 'restart':
               break;
           case 'status':
               break;
       }
    }
    /**
     * Starting  up ALL->socket:websocket
     *
     * @return string
     * */
    public function start()
    {
        Redis::select(3);
        $socket_id=Redis::get('socket_id');
        if (empty($socket_id)){
            $this->server=new Chat_Realization_Handler("0.0.0.0",9527);
            Redis::set('status','runing');
            $handler=App::make(App_Handler::class);
            $this->server->on('open',array($handler,'on_open'));
            $this->server->on('message',array($handler,'message'));
            $this->server->on('close',array($handler,'close'));
        }else{
            $this->error('socket still running');
        }


        $this->info('Started');
    }
    public function stop()
    {
        $this->info('Stoped');
    }
    public function restart()
    {
        $this->info('Restarted');
    }
    public function status()
    {
        $this->info('Started');
    }
}
