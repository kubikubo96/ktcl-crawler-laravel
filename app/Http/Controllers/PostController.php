<?php

namespace App\Http\Controllers;

use App\Helpers\Response;
use App\Repositories\PostRepository;
use App\Services\TelegramService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostController extends Controller
{

    protected $postRepo;

    public function __construct(PostRepository $postRepo)
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
        try {
            $data = $this->postRepo->create($request->all());
            if (!$data) {
                return Response::error();
            }
            return Response::success($data);
        } catch (Exception $e) {
            TelegramService::sendError($e);
            return Response::error($e->getMessage());
        }
    }
}
