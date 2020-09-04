<?php

namespace ApiV1\Services;


use ApiV1\Models\Comment;
use ApiV1\Models\Post;
use ApiV1\Models\User;
use ApiV1\Repositories\CommentsRepository;
use ApiV1\Repositories\PostsRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PostsService
{
    protected ExternalApi $api;
    protected PostsRepository $postsRepository;
    protected CommentsRepository $commentsRepository;

    public function __construct(
        ExternalApi $api,
        PostsRepository $postsRepository,
        CommentsRepository $commentsRepository
    )
    {
        $this->api = $api;
        $this->postsRepository = $postsRepository;
        $this->commentsRepository = $commentsRepository;
    }

    public function getPosts(int $show = 10, ?string $search = null) : LengthAwarePaginator
    {
        $count = Post::count();

        if( $count == 0 )
        {
            $this->cachePosts();
        }

        $query = Post::query();
        $search = "%{$search}%";

        if (!empty($search)) {
            $query->where('title', 'LIKE', $search);
        }

        return $query->orderBy('api_id', 'DESC')->paginate($show);
    }

    public function cachePosts()
    {
        $fromApi = $this->api->getPosts();
        foreach ($fromApi as $apiPost)
        {
            $this->postsRepository->create($apiPost);
        }
    }

    public function cachePostComments(int $id) : void
    {
        $fromApi = $this->api->getPostComments($id);
        foreach ($fromApi as $apiComment)
        {
            $this->commentsRepository->create($apiComment);
        }
    }

    public function getPostComments(int $id, int $show = 10) : LengthAwarePaginator
    {
        $count = Comment::where('api_post_id', $id)->count();

        if( $count == 0 )
        {
            $this->cachePostComments($id);
        }

        $query = Comment::where('api_post_id', $id);

        return $query->orderBy('api_post_id', 'DESC')->paginate($show);
    }

}
