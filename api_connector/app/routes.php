<?php
declare(strict_types=1);


use App\Application\Actions\Auth\LoginAction;
use App\Application\Actions\Auth\RegisterAction;
use App\Application\Actions\Renders\RenderHome;
use App\Application\Actions\Renders\RenderProfile;
use App\Application\Actions\Renders\RenderLogin;
use App\Application\Actions\Renders\RenderRegister;
use App\Application\Middleware\RoutingMiddleware;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;
use Slim\App;

return function (App $app) {
    $RoutingMiddleware = new RoutingMiddleware('http://localhost:8080', 'http://localhost:5000');

    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/', RenderHome::class . ':redirectToChat')->setName('home');
    $app->get('/chat', RenderHome::class)->setName('home');
    $app->post('/addMessage', RenderHome::class . ':addMessage')->setName('home');
    $app->get('/chat/{id}', RenderHome::class)->setName('home');
    $app->get('/profile', RenderProfile::class)->setName('profile');
    $app->get('/login', RenderLogin::class)->setName('login');
    $app->get('/register', RenderRegister::class)->setName('register');
    $app->post('/login', RenderLogin::class . ':postLogin')->setName('register');
    $app->post('/register', RenderRegister::class . ':postRegister')->setName('register');

    /*Slim api*/
    $app->group('/auth', function (Group $group) {
        $group->post('/login', LoginAction::class);
        $group->get('/disconnect', RenderLogin::class . ':disconnect');
    });


    $app->group('/user', function (Group $group) use ($RoutingMiddleware) {
        //create user
        $group->post('', RegisterAction::class);

        //update user
        $group->put('/update/{id}', function (Request $request, Response $response, array $args) use ($RoutingMiddleware) {
            $input = (array)$request->getParsedBody();
            $data = json_decode((string)json_encode($input), false);
            $RoutingMiddleware->issetEmail($data);
            $RoutingMiddleware->issetPassword($data);
            $id = $args['id'];
            $token = $RoutingMiddleware->getBearerToken($request);

            $res = $RoutingMiddleware->clientSlim->put("/user/update/$id", [
                'debug' => fopen('php://stderr', 'w'),
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                    'Authorization' => $token
                ],
                'json' => [
                    'firstname' => $data->firstname,
                    'lastname' => $data->lastname,
                    'email' => $data->email,
                    'password' => $data->password
                ]
            ]);
            return $RoutingMiddleware->responseWithData($res, $response);
        });

        //list users
        $group->get('s', function (Request $request) use ($RoutingMiddleware) {
            $token = $RoutingMiddleware->getBearerToken($request);
            $headers = [
                'Authorization' => $token
            ];
            return $RoutingMiddleware->clientSlim->get('/users', ['headers' => $headers]);
        });
        //user by id
        $group->get('/{id}', function (Request $request, Response $response, array $args) use ($RoutingMiddleware) {
            $token = $RoutingMiddleware->getBearerToken($request);
            $headers = [
                'Authorization' => $token
            ];
            $id = $args['id'];
            return $RoutingMiddleware->clientSlim->get("/user/$id", ['headers' => $headers]);
        });

        //delete user
        $group->delete('/{id}', function (Request $request, Response $response, array $args) use ($RoutingMiddleware) {
            $token = $RoutingMiddleware->getBearerToken($request);
            $headers = [
                'Authorization' => $token
            ];
            $id = $args['id'];
            return $RoutingMiddleware->clientSlim->delete("/user/$id", ['headers' => $headers]);
        });
    });

    $app->group('/message', function (Group $group) use ($RoutingMiddleware) {
        $group->post('', function (Request $request, Response $response) use ($RoutingMiddleware) {
            $input = (array)$request->getParsedBody();
            $data = json_decode((string)json_encode($input), false);
            $token = $RoutingMiddleware->getBearerToken($request);

            $RoutingMiddleware->issetDiscussion($data->discussionId, $request);
            $RoutingMiddleware->addUserToDiscussion($data->discussionId, [$data->sender], $request, $response);


            $res = $RoutingMiddleware->clientSlim->post("/message", [
                'debug' => fopen('php://stderr', 'w'),
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                    'Authorization' => $token
                ],
                'json' => [
                    'sender' => $data->sender,
                    'discussionId' => $data->discussionId,
                    'content' => $data->content,
                ]
            ]);
            return $RoutingMiddleware->responseWithData($res, $response);
        });

        $group->get('s', function (Request $request) use ($RoutingMiddleware) {
            $token = $RoutingMiddleware->getBearerToken($request);
            $headers = [
                'Authorization' => $token
            ];
            return $RoutingMiddleware->clientSlim->get('/messages', ['headers' => $headers]);
        });

        $group->get('s/{discussionId}', function (Request $request, Response $response, array $args) use ($RoutingMiddleware) {
            $token = $RoutingMiddleware->getBearerToken($request);
            $discussionId = $args['discussionId'];
            $headers = [
                'Authorization' => $token
            ];
            return $RoutingMiddleware->clientSlim->get("/messages/$discussionId", ['headers' => $headers]);
        });

        $group->get('/{id}', function (Request $request, Response $response, array $args) use ($RoutingMiddleware) {
            $id = $args['id'];
            return $RoutingMiddleware->issetDiscussion($id, $request);
        });

        $group->put('/update/{id}', function (Request $request, Response $response, array $args) use ($RoutingMiddleware) {
            $input = (array)$request->getParsedBody();
            $data = json_decode((string)json_encode($input), false);
            $token = $RoutingMiddleware->getBearerToken($request);
            $id = $args['id'];

            $RoutingMiddleware->issetDiscussion($data->discussionId, $request);
            $RoutingMiddleware->addUserToDiscussion($data->discussionId, [$data->sender], $request, $response);

            $res = $RoutingMiddleware->clientSlim->put("/message/update/$id", [
                'debug' => fopen('php://stderr', 'w'),
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                    'Authorization' => $token
                ],
                'json' => [
                    'sender' => $data->sender,
                    'discussionId' => $data->discussionId,
                    'content' => $data->content,
                ]
            ]);
            return $RoutingMiddleware->responseWithData($res, $response);
        });

        $group->delete('/{id}', function (Request $request, Response $response, array $args) use ($RoutingMiddleware) {
            $id = $args['id'];
            $token = $RoutingMiddleware->getBearerToken($request);
            $headers = [
                'Authorization' => $token
            ];
            return $RoutingMiddleware->clientSlim->delete("/message/$id", ['headers' => $headers]);
        });
    });


    //Node js Discussion APi

    $app->group('/discussion', function (Group $group) use ($RoutingMiddleware) {
        $group->post('', function (Request $request, Response $response) use ($RoutingMiddleware) {
            $input = (array)$request->getParsedBody();
            $data = json_decode((string)json_encode($input), false);
            $token = $RoutingMiddleware->getBearerToken($request);

            $res = $RoutingMiddleware->clientNode->post("/discussion", [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                    'Authorization' => $token
                ],
                'json' => [
                    'name' => $data->name
                ]
            ]);
            return $RoutingMiddleware->responseWithData($res, $response);
        });

        $group->get('/list', function (Request $request, Response $response, array $args) use ($RoutingMiddleware) {
            $token = $RoutingMiddleware->getBearerToken($request);
            $headers = [
                'Authorization' => $token
            ];
            return $RoutingMiddleware->clientNode->get("/discussion/list", ['headers' => $headers]);
        });
        $group->get('/{id}', function (Request $request, Response $response, array $args) use ($RoutingMiddleware) {
            $id = $args['id'];
            $token = $RoutingMiddleware->getBearerToken($request);
            $headers = [
                'Authorization' => $token,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ];
            $res = $RoutingMiddleware->clientNode->get("/discussion/$id", ['headers' => $headers]);
            $data = $res->json();
            echo $data['type'];
            return $res;
        });

        $group->get('/isset/{id}', function (Request $request, Response $response, array $args) use ($RoutingMiddleware) {
            $id = $args['id'];
            return $RoutingMiddleware->issetDiscussion($id, $request);
        });

        $group->put('/{id}', function (Request $request, Response $response, array $args) use ($RoutingMiddleware) {
            $input = (array)$request->getParsedBody();
            $data = json_decode((string)json_encode($input), false);
            $token = $RoutingMiddleware->getBearerToken($request);
            $id = $args['id'];

            $res = $RoutingMiddleware->clientNode->put("/discussion/$id", [
                'headers' => [
                    'Authorization' => $token
                ],
                'json' => [
                    'name' => $data->name,
                    'users' => $data->users,
                ]
            ]);
            return $RoutingMiddleware->responseWithData($res, $response);
        });

        $group->put('/users/{id}', function (Request $request, Response $response, array $args) use ($RoutingMiddleware) {
            $id = $args['id'];
            $input = (array)$request->getParsedBody();
            $data = json_decode((string)json_encode($input), false);
            return $RoutingMiddleware->addUserToDiscussion($id, $data->users, $request, $response);
        });

        $group->delete('/{id}', function (Request $request, Response $response, array $args) use ($RoutingMiddleware) {
            $id = $args['id'];
            $token = $RoutingMiddleware->getBearerToken($request);
            $headers = [
                'Authorization' => $token
            ];
            return $RoutingMiddleware->clientNode->delete("/discussion/$id", ['headers' => $headers]);
        });
    });
};
