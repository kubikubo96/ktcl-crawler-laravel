<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Helpers\Response;
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
        $data['post_name'] = Helper::viToEn($payload['title']);
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

        try {
            $post = $this->postRepo->create($data);
            if (!$post) {
                return Response::error();
            }
            return Response::success($post);
        } catch (Exception $e) {
            TelegramService::sendError($e);
            return Response::error($e->getMessage());
        }
    }
}
