<?php

namespace ApiV1\Controllers;

use ApiV1\ErrorResponse;
use ApiV1\PagedResponse;
use ApiV1\Services\PostsService;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    private Request $request;
    private PostsService $postsService;

    private const ERR_COMMENTS_NOT_FOUND = "P001:comments_not_found";
    private const ERR_POSTS_NOT_FOUND = "P002:comments_not_found";

    public function __construct(Request $request, PostsService $postsService)
    {
        $this->request = $request;
        $this->postsService = $postsService;
    }

    public function index(): JsonResponse
    {
        $show = $this->request->get('show',10);
        $search = $this->request->get('search');

        try {
            $posts = $this->postsService->getPosts( $show, $search );

            return PagedResponse::output($posts);
        } catch (\Exception $e) {
            return ErrorResponse::output(
                $e->getMessage(),
                self::ERR_POSTS_NOT_FOUND,
                'Cannot get list of posts.'
            );
        }
    }

    public function comments(int $id): JsonResponse
    {
        $show = $this->request->get('show', 10);

        try {
            $comments = $this->postsService->getPostComments($id, $show);

            return PagedResponse::output($comments);
        } catch (\Exception $e) {
            return ErrorResponse::output(
                $e->getMessage(),
                self::ERR_COMMENTS_NOT_FOUND,
                'Cannot get list of post comments.'
            );
        }
    }
}
