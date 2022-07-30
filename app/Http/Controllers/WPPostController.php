<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Helpers\Response;
use App\Models\Term;
use App\Models\TermRelation;
use App\Models\TermTaxonomy;
use App\Models\WPPost;
use App\Repositories\WPPostRepository;
use App\Services\TelegramService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WPPostController extends Controller
{

    protected $postRepo;

    public function __construct(WPPostRepository $postRepo)
    {
        $this->postRepo = $postRepo;
    }

    public function index(Request $request): JsonResponse
    {
        try {
            $data = $this->postRepo->paginate([], $request->page, $request->limit);
            return Response::success($data['data'], $data['total']);
        } catch (Exception $e) {
            TelegramService::sendError($e);
            return Response::error($e->getMessage());
        }
    }


    public function view()
    {
        $posts = $this->postRepo->query()->paginate(1);
        return view('post', ['posts' => $posts]);
    }

    public function store(Request $request): JsonResponse
    {
        if (empty($request->input('content'))) {
            return Response::error('EMPTY_CONTENT');
        }
        $post = WPPost::where('url_crawl', $request->url_crawl)->first();
        if ($post) {
            return Response::success();
        }

        $payload = $request->all();

        $data['post_author'] = 1;
        $data['post_date'] = now();
        $data['post_date_gmt'] = now();
        $data['post_content'] = $payload['content'];
        $data['post_title'] = $payload['title'];
        $data['post_excerpt'] = '';
        $data['post_status'] = 'private';
        $data['comment_status'] = 'open';
        $data['ping_status'] = 'open';
        $data['post_password'] = '';
        $data['post_name'] = Helper::makeSlug($payload['title']);
        $data['to_ping'] = '';
        $data['pinged'] = '';
        $data['post_modified'] = now();
        $data['post_modified_gmt'] = now();
        $data['post_content_filtered'] = '';
        $data['post_parent'] = 0;
        $data['guid'] = '';
        $data['menu_order'] = 0;
        $data['post_type'] = 'post';
        $data['post_mime_type'] = '';
        $data['comment_count'] = 0;
        $data['url_crawl'] = $payload['url_crawl'];

        try {
            $post = $this->postRepo->create($data);
            if (!$post) {
                return Response::error();
            }

            if (!empty($payload['tag'])) {
                foreach ($payload['tag'] as $tag) {
                    $tag = ucfirst(strtolower($tag));

                    //term
                    $term = Term::where('name', $tag)->first();
                    if (!$term) {
                        $data_term = [
                            'name' => $tag,
                            'slug' => Helper::viToEn($tag),
                            'term_group' => 0,
                        ];
                        $term = Term::create($data_term);
                        $term = Term::where('name', $term['name'])->first();
                    }

                    //term_taxonomy
                    $term_taxonomy = TermTaxonomy::where('term_id', $term['term_id'])->where('taxonomy', 'post_tag')->first();
                    if (!$term_taxonomy) {
                        $data_term_taxonomy = [
                            'term_id' => $term['term_id'],
                            'taxonomy' => 'post_tag',
                            'description' => '',
                            'parent' => 0,
                            'count' => 0,
                        ];
                        TermTaxonomy::create($data_term_taxonomy);
                        $term_taxonomy = TermTaxonomy::where('term_id', $term['term_id'])->where('taxonomy', 'post_tag')->first();
                    }

                    //term_relationship
                    $data_term_relationship = [
                        'object_id' => $post['ID'],
                        'term_taxonomy_id' => $term_taxonomy['term_taxonomy_id'],
                        'term_order' => 0,
                    ];
                    TermRelation::create($data_term_relationship);
                }
            }

            return Response::success($post);
        } catch (Exception $e) {
            TelegramService::sendError($e);
            return Response::error($e->getMessage());
        }
    }
}
