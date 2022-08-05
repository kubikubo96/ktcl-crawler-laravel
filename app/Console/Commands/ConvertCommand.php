<?php

namespace App\Console\Commands;

use App\Models\WPPost;
use App\Repositories\WPPostRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ConvertCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'convert:post';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle()
    {
        return "SUCCESS";
    }
}
