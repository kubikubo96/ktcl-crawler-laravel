<?php

namespace App\Console\Commands;

use App\Helpers\Helper;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ConvertSeoCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'convert:seo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command seo';

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
        DB::table($table)
            ->whereNotNull('url_crawl')
            ->where('post_status', 'private')
            ->orderBy('ID')
            ->chunk(100, function ($data) use ($table) {
                foreach ($data as $post) {
                    $data_yoast_indexable = [
                        'title' => Helper::handleKeySeo($post->post_title),
                        'primary_focus_keyword' => Helper::handleKeySeo($post->post_title),
                    ];
                    DB::table('wp_yoast_indexable')->where(
                        [
                            ['object_id', $post->ID],
                            ['object_type', 'post'],
                            ['object_sub_type', 'post'],
                        ]
                    )->update($data_yoast_indexable);

                    $data_postmeta = [
                        'meta_value' => Helper::handleKeySeo($post->post_title),
                    ];
                    DB::table('wp_postmeta')->where(
                        [
                            ['post_id', $post->ID],
                            ['meta_key', '_yoast_wpseo_focuskw']
                        ]
                    )->update($data_postmeta);

                    dump(Helper::handleKeySeo($post->post_title) . "\n");
                }
            });
        return "SUCCESS";
    }
}
