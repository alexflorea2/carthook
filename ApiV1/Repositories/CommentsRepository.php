<?php


namespace ApiV1\Repositories;


use ApiV1\Models\Comment;
use Illuminate\Database\Eloquent\Model;

class CommentsRepository implements RepositoryInterface
{
   private Comment $model;

   public function __construct(Comment $model)
   {
       $this->model = $model;
   }

   public function findByApiId(int $id): Comment
   {
       return $this->model->where('api_id',$id)->first();
   }

    public function create(object $data) : ?Comment
   {
       $new = $this->model->newInstance();

       $new->api_post_id = $data->postId;
       $new->api_id = $data->id;
       $new->name = $data->name;
       $new->email = $data->email;
       $new->body = $data->body;
       $new->save();

       return  $new;
   }
}
