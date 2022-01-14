<?php

declare(strict_types=1);

namespace App\Application\Actions\Auth;

use App\Application\Actions\Connector;
use Error;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class LoginAction extends Connector
{
    protected function action(): Response
    {
        $input = (array)$this->request->getParsedBody();
        $data = $this->login($input);

        $res = $this->clientSlim->post('/auth/login', [
            'debug' => fopen('php://stderr', 'w'),
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ],
            'json' => [
                'email' => $data->email,
                'password' => $data->password
            ]
        ]);
        $responseData = $res->getBody()->getContents();
        $result = json_decode($responseData);
        return $this->respondWithData($result);
    }


    private function login(array $input)
    {
        $data = json_decode((string)json_encode($input), false);
        if (!isset($data->email)) {
            throw new Error('The field "email" is required.', 400);
        }
        if (!isset($data->password)) {
            throw new Error('The field "password" is required.', 400);
        }
        return $data;
    }
}
