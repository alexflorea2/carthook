<?php

namespace ApiV1\Controllers;

use ApiV1\ErrorResponse;
use ApiV1\PagedResponse;
use ApiV1\Services\UsersService;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    private Request $request;
    private UsersService $userService;

    private const ERR_USERS_NOT_FOUND = "U001:users_not_found";
    private const ERR_USER_NOT_FOUND = "U002:user_not_found";
    private const ERR_POSTS_NOT_FOUND = "U003:posts_not_found";

    public function __construct(Request $request, UsersService $userService)
    {
        $this->request = $request;
        $this->userService = $userService;
    }

    public function index(): JsonResponse
    {
        $show = $this->request->get('show',10);
        $search = $this->request->get('search');

        try {
            $users = $this->userService->getUsers( $show, $search );

            return PagedResponse::output($users);
        } catch (\Exception $e) {
            return ErrorResponse::output(
                $e->getMessage(),
                self::ERR_USERS_NOT_FOUND,
                'Cannot get list of users.'
            );
        }
    }

    public function show(int $id): JsonResponse
    {
        try {
            $user = $this->userService->getUser($id);
        } catch (\Exception $e) {
            return ErrorResponse::output(
                $e->getMessage(),
                self::ERR_USER_NOT_FOUND,
                'Cannot find user.'
            );
        }

        return response()->json(
            [
                "meta" => [
                    'posts' => route('api.v1.users.posts', [$id])
                ],
                "data" => $user,
            ],
            JsonResponse::HTTP_OK
        );
    }

    public function posts(int $id): JsonResponse
    {
        $show = $this->request->get('show', 10);
        $search = $this->request->get('search');

        try {

            $posts = $this->userService->getUserPosts($id, $show, $search);

            return PagedResponse::output($posts);
        } catch (\Exception $e) {
            return ErrorResponse::output(
                $e->getMessage(),
                self::ERR_POSTS_NOT_FOUND,
                'Cannot get list of user posts.'
            );
        }
    }
}
