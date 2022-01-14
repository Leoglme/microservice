<?php
declare(strict_types=1);

use App\Application\Actions\Auth\LoginAction;
use App\Application\Actions\Message\AddMessageAction;
use App\Application\Actions\Message\GetMessageAction;
use App\Application\Actions\Message\ListMessagesAction;
use App\Application\Actions\Message\DeleteMessageAction;
use App\Application\Actions\Message\UpdateMessageAction;
use App\Application\Actions\Renders\RenderHome;
use App\Application\Actions\User\AddUserAction;
use App\Application\Actions\User\GetUserAction;
use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\DeleteUserAction;
use App\Application\Actions\User\UpdateUserAction;
use App\Application\Middleware\AuthMiddleware as AuthMiddleware;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use App\Middleware\Auth;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;
use Slim\Views\Twig;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/', RenderHome::class)->setName('home');

    /* Auth group routes*/
    $app->group('/auth', function (Group $group) {
        $group->post('/login', LoginAction::class);
    });

    $app->group('/user', function (Group $group) {
        $group->get('s', ListUsersAction::class)->add(new AuthMiddleware());
        $group->post('', AddUserAction::class);
        $group->get('/{id}', GetUserAction::class)->setName('userById')->add(new AuthMiddleware());
        $group->put('/update/{id}', UpdateUserAction::class)->add(new AuthMiddleware());
        $group->delete('/{id}', DeleteUserAction::class)->add(new AuthMiddleware());
    });

    $app->group('/message', function (Group $group) {
        $group->get('s', ListMessagesAction::class);
        $group->get('s/{discussionId}', ListMessagesAction::class . ':discussionMessages');
        $group->post('', AddMessageAction::class);
        $group->get('/{id}', GetMessageAction::class);
        $group->put('/update/{id}', UpdateMessageAction::class);
        $group->delete('/{id}', DeleteMessageAction::class);
    })->add(new AuthMiddleware());
};
