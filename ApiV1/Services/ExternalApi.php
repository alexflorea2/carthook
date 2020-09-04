<?php

namespace ApiV1\Services;


use Illuminate\Support\Facades\Http;

class ExternalApi
{
    protected const API_URL = "http://jsonplaceholder.typicode.com/";

    public function call(string $path)
    {
        $response = Http::get(self::API_URL . $path);
        $response->throw();
        return json_decode($response->body());
    }

    public function getUsers()
    {
        return $this->call('users');
    }

    public function getPosts()
    {
        return $this->call('posts');
    }

    public function getUser(int $id)
    {
        return $this->call("users/{$id}");
    }

    public function getUserPosts(int $id)
    {
        return $this->call("users/{$id}/posts");
    }

    public function getPostComments(int $id)
    {
        return $this->call("posts/{$id}/comments");
    }

}
