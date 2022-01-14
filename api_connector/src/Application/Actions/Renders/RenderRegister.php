<?php
declare(strict_types=1);

namespace App\Application\Actions\Renders;

use App\Application\Actions\Action;


use App\Application\Actions\Auth\RegisterAction;
use App\Application\Actions\Connector;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Respect\Validation\Validator;
use Slim\Views\Twig;

class RenderRegister extends Connector
{
    protected function action(): Response
    {
        $flash = isset($_SESSION['flash']) ? $_SESSION['flash'] : [];
        $old = isset($_SESSION['old']) ? $_SESSION['old'] : [];
        $view = Twig::fromRequest($this->request);
        $view->render($this->response, 'pages/register.twig', ['flash' => $flash, 'old' => $old]);
        $_SESSION['flash'] = [];
        $_SESSION['old'] = [];
        return $this->response;
    }

    /**
     * @throws GuzzleException
     */
    function postRegister(Request $request, Response $response): Response
    {
        $errors = [];
        $data = $request->getParsedBody();

        Validator::email()->validate($data['email']) || $errors['email'] = 'Your email is not valid';
        Validator::notEmpty()->validate($data['password']) || $errors['password'] = 'Field password cannot be empty';
        Validator::notEmpty()->validate($data['firstname']) || $errors['firstname'] = 'Field firstname cannot be empty';
        Validator::notEmpty()->validate($data['lastname']) || $errors['lastname'] = 'Field lastname cannot be empty';




        if(empty($errors)) {
            $this->clientSlim->post('/user', [
                'debug' => fopen('php://stderr', 'w'),
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json'
                ],
                'json' => [
                    'firstname' => $data['firstname'],
                    'lastname' => $data['lastname'],
                    'email' => $data['email'],
                    'password' => $data['password']
                ]
            ]);
            $this->flash('success', 'Welcome to Quila Chat !');
            return $this->redirect('/login', $response);
        }else {
            $this->flash('errors', $errors);
            $this->old($data);
            return $this->redirect('/register', $response);
        }
    }
}
