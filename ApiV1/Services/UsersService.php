<?php

namespace ApiV1\Services;


use ApiV1\Models\Post;
use ApiV1\Models\User;
use ApiV1\Repositories\PostsRepository;
use ApiV1\Repositories\UsersRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UsersService
{
    protected ExternalApi $api;
    protected UsersRepository $userRepository;
    protected PostsRepository $postsRepository;

    public function __construct(
        ExternalApi $api,
        UsersRepository $userRepository,
        PostsRepository $postsRepository
    )
    {
        $this->api = $api;
        $this->userRepository = $userRepository;
        $this->postsRepository = $postsRepository;
    }

    public function getUsers(int $show = 10, ?string $search = null) : LengthAwarePaginator
    {
        $count = User::count();

        if( $count == 0 )
        {
            $this->cacheUsers();
        }

        $query = User::query();
        $search = "%{$search}%";

        if (!empty($search)) {
            $query->where(
                function ($query) use ($search) {
                    $query->where('name', 'LIKE', $search)->orWhere('email', 'LIKE', $search);
                }
            );
        }

        return $query->orderBy('api_id', 'DESC')->paginate($show);
    }

    public function cacheUsers() :void
    {
        $fromApi = $this->api->getUsers();

        foreach ($fromApi as $apiPost)
        {
            $this->userRepository->create($apiPost);
        }
    }

    public function cacheUser(int $id) : User
    {
        $fromApi = $this->api->getUser($id);
        return $this->userRepository->create($fromApi);
    }

    public function getUser(int $id) : User
    {
        $user = User::where('api_id', $id)->first();

        if (!$user) {
            $user = $this->cacheUser($id);
        }

        return $user->refresh();
    }

    public function cacheUserPosts(int $id) :void
    {
        $fromApi = $this->api->getUserPosts($id);

        foreach ($fromApi as $apiPost)
        {
            $this->postsRepository->create($apiPost);
        }
    }

    public function getUserPosts(int $id, int $show = 10, ?string $search = null) : LengthAwarePaginator
    {
        $count = Post::where('api_user_id', $id)->count();

        if( $count == 0 )
        {
            $this->cacheUserPosts($id);
        }

        $query = Post::where('api_user_id', $id);
        $search = "%{$search}%";

        if (!empty($search)) {
            $query->where('title', 'LIKE', $search);
        }

        return $query->orderBy('api_id', 'DESC')->paginate($show);
    }

}
