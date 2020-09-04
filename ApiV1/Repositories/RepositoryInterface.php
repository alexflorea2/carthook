<?php


namespace ApiV1\Repositories;


use Illuminate\Database\Eloquent\Model;

interface RepositoryInterface
{
    public function findByApiId(int $id);
}
