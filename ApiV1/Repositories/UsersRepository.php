<?php


namespace ApiV1\Repositories;


use ApiV1\Models\User;

class UsersRepository
{
   private User $model;

   public function __construct(User $model)
   {
       $this->model = $model;
   }

    public function findByApiId(int $id): ?User
    {
        return $this->model->where('api_id', $id)->first();
    }

   public function create(object $data) : User
   {
       $new = $this->model->newInstance();

       $new->api_id = $data->id;
       $new->name = $data->name;
       $new->username = $data->username;
       $new->email = $data->email;

       $new->save();

       return  $new;
   }
}
