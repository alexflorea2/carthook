<?php


namespace ApiV1\Repositories;


use ApiV1\Models\Post;

class PostsRepository
{
   private Post $model;

   public function __construct(Post $model)
   {
       $this->model = $model;
   }

    public function findByApiId(int $id): ?Post
    {
        return $this->model->where('api_id', $id)->first();
    }

   public function create(object $data) : Post
   {
       $new = $this->model->newInstance();

       $new->api_user_id = $data->userId;
       $new->api_id = $data->id;
       $new->title = $data->title;
       $new->body = $data->body;
       $new->save();

       return  $new;
   }
}
