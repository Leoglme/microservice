<?php
declare(strict_types=1);

namespace App\Application\Actions\Auth;

use App\Application\Actions\Connector;
use Error;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface as Response;

class RegisterAction extends Connector
{
    /**
     * @throws GuzzleException
     */
    protected function action(): Response
    {
        $input = (array)$this->request->getParsedBody();
        $data = json_decode((string)json_encode($input), false);

        if (!isset($data->email)) {
            throw new Error('The field "email" is required.', 400);
        }
        if (!isset($data->password)) {
            throw new Error('The field "password" is required.', 400);
        }

        $res = $this->clientSlim->post('/user', [
            'debug' => fopen('php://stderr', 'w'),
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ],
            'json' => [
                'firstname' => $data->firstname,
                'lastname' => $data->lastname,
                'email' => $data->email,
                'password' => $data->password
            ]
        ]);
        $responseData = $res->getBody()->getContents();
        $result = json_decode($responseData);
        return $this->respondWithData($result);
    }
}
