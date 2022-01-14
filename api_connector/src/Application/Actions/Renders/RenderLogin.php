<?php
declare(strict_types=1);

namespace App\Application\Actions\Renders;

use App\Application\Actions\Action;


use App\Application\Actions\Connector;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Respect\Validation\Validator;
use Slim\Views\Twig;

class RenderLogin extends Connector
{
    protected function action(): Response
    {
        $flash = isset($_SESSION['flash']) ? $_SESSION['flash'] : [];
        $old = isset($_SESSION['old']) ? $_SESSION['old'] : [];
        $view = Twig::fromRequest($this->request);
        $view->render($this->response, 'pages/login.twig', ['flash' => $flash, 'old' => $old]);
        $_SESSION['flash'] = [];
        $_SESSION['old'] = [];
        return $this->response;
    }

    function disconnect(Request $request, Response $response): Response
    {
        session_destroy();
        return $this->redirect('/login', $response);
    }

    function postLogin(Request $request, Response $response): Response
    {
        $errors = [];
        $data = $request->getParsedBody();

        Validator::email()->validate($data['email']) || $errors['email'] = 'Your email is not valid';
        Validator::notEmpty()->validate($data['password']) || $errors['password'] = 'Field password cannot be empty';


        if (empty($errors)) {
            $this->flash('success', 'Welcome to Quila Chat !');
            $res = $this->clientSlim->post('/auth/login', [
                'debug' => fopen('php://stderr', 'w'),
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json'
                ],
                'json' => [
                    'email' => $data['email'],
                    'password' => $data['password']
                ]
            ]);
            $data = json_decode($res->getBody()->getContents())->data;
            $user = $data->User;
            $token_auth = $data->Authorization;
            $this->flash('success', 'Welcome to Quila Chat !');
            $this->setConnectedUser($user);
            $this->setAuthToken($token_auth);
            return $this->redirect('/', $response);
        } else {
            $this->flash('errors', $errors);
            $this->old($data);
            return $this->redirect('/login', $response);
        }
    }
}
