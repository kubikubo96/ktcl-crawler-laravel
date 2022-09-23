<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ConvertCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'convert:data';

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
        $table = 'wp_yoast_indexable';

        DB::table($table)->orderBy('id')->chunk(100, function ($data) use ($table) {
            foreach ($data as $item) {
                $new_url = str_replace("https://kungfucongnghe.com", "http://localhost/develop/kungfucongnghe", $item->permalink);
                DB::table($table)->where('id', $item->id)->update(['permalink' => $new_url]);
                dump("DONE: " . $new_url);
            }
        });

        return "SUCCESS";
    }
}
