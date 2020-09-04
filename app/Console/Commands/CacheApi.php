<?php

namespace App\Console\Commands;

use ApiV1\Repositories\CommentsRepository;
use ApiV1\Repositories\PostsRepository;
use ApiV1\Repositories\UsersRepository;
use ApiV1\Services\ExternalApi;
use ApiV1\Services\UsersService;
use Illuminate\Console\Command;

class CacheApi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'cache the first 50 posts of the first 10 users from the open API';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(
        ExternalApi $api,
        UsersRepository $usersRepository,
        PostsRepository $postsRepository
    ) {
        $this->output->title('Starting caching..');

        $users = $api->getUsers();

        $bar = $this->output->createProgressBar(count($users));
        $bar->start();

        foreach (array_slice($users, 0, 10) as $user) {
            if (!$usersRepository->findByApiId($user->id)) {
                $this->info("User id: {$user->id}");

                $usersRepository->create($user);
            }

            $userPosts = $api->getUserPosts($user->id);

            foreach (array_slice($userPosts, 0, 50) as $post) {
                if (!$postsRepository->findByApiId($post->id)) {
                    $this->info("Post id: {$post->id}");
                    $postsRepository->create($post);
                }
            }

            $bar->advance();
        }
        $bar->finish();

        $this->info("Action completed.");
    }
}
