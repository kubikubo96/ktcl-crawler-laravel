<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ReplaceTextCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'replace:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Replace description';

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
     * @return string
     */
    public function handle()
    {
        $table = 'wp_posts';

        $replace = 'KungFuCongNghe.Com';

        $searches = [
            'Điện Máy XANH',
            'Điện Máy Xanh',
            'Điện máy xanh',
            'DienmayXANH.com',
            'DienMayXANH.com',
            'DienMayXanh.com',
            'dienmayxanh.com',
        ];

        DB::table($table)->orderBy('ID')->chunk(100, function ($data) use ($table, $searches, $replace) {
            foreach ($data as $item) {
                foreach ($searches as $search) {
                    $old_content = $item->post_content;
                    $new_content = str_replace($search, $replace, $old_content);

                    DB::table($table)->where('ID', $item->ID)->update(['post_content' => $new_content]);

                    dump("DONE: " . $item->post_title);
                }
            }
        });

        return "SUCCESS";
    }
}
