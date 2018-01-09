<?php

namespace App\Console\Commands;

use App\Handler\Web_Socket_Handler;
use Illuminate\Console\Command;

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
        $this->server=new Web_Socket_Handler("",9527);
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
