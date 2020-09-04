#### #1 - #4
The files are under the ```exercises``` folder, and contain comments about the code.

For the ``NBA`` database, the Players include overall career stats - eg cached statistics. Games include scores for each quarter and overall stats. There is ```games_players``` table for detailed statistics for each player during a game. And ```teams_players``` have start and end dates, as players can switch teams - a NULL end date would mean that the player it's currently playing for that team.
#### #5 Api

All related functionality is under the ```ApiV1``` namespace.
When a resource or collection is requested, the local DB is searched. In case of no results, a request to the ```Api``` is made. If that is successful, the result is cached.

To warm up the cache, a Console command is available:
```
php artisan api:cache
```

All responses are JSON, and include a ```meta``` property with additional information, eg pagination for requests, and a ```data``` property. If a response cannot be created, a log entry is made, containing specific error codes - to easy find and debug.

Meta example
```
"meta": {
        "showing": 10,
        "total": 100,
        "current_page": 1,
        "last_page": 10,
        "next_page_url": "http://alex_florea.test/api/v1/posts?page=2"
    },
```

The code is separated in Models, Repositories and Services. Database wise, all entities have an ```api_id``` key and a ```cached_at``` timestamp. Indexes are set based on the usage mentioned.

The Api is versioned under ```/v1``` prefix;

#### Improvements
 In Production we can add another caching layer via Ngnix or Varnish, so that we minimize hitting the DB.
 
 The endpoints should have an IP based throttle.
 
 Logging could be an external service, so that admins could see potential errors easier.
 
 A mechanism for regular caching from the remote Api can be implemented and run via a cronjob.

#### Endpoints
```
GET /user?page={int}&show={int}&search={string}
GET /users/{id}
GET /users/{id}/posts

GET /posts?page={int}&show={int}&search={string}
GET /posts/{id}/comments
```

#### Install
Development was done under Vagrant. Adjust the .env according to the environment where the code will run.

Please run the following
```
composer install
composer dump-autoload
php artisan migrate
php artisan api:cache
```
