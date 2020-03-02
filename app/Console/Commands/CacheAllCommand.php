<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;

/**
 * Class CacheAllCommand
 * @package App\Console\Commands
 */
class CacheAllCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cache:all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Cache files for route, config all in one command';

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
        $this->call('cache:clear');
        $this->call('config:cache');

        // Check if app environment is production
        if (Config::get('app.APP_ENV') === 'production') {
            $this->call('route:cache');
            $this->call('view:cache');
        }

        return true;
    }
}
