<?php

namespace App\Application\Middleware;

use Error;
use \GuzzleHttp\Client as Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface as Response;

class RoutingMiddleware
{
    /**
     * @var string
     */
    public $SLIM_SERVICE;
    /**
     * @var string
     */
    public $NODE_SERVICE;

    /**
     * @var string
     */
    public $clientSlim;

    /**
     * @var string
     */
    public $clientNode;

    public function __construct($slim_uri, $node_uri)
    {
        $this->SLIM_SERVICE = $slim_uri;
        $this->NODE_SERVICE = $node_uri;
        $this->clientSlim = new Client(['base_uri' => $this->SLIM_SERVICE]);
        $this->clientNode = new Client(['base_uri' => $this->NODE_SERVICE]);
    }

    public function issetPassword($data)
    {
        if (!isset($data->password)) {
            throw new Error('The field "password" is required.', 400);
        }
    }
    public function issetEmail($data)
    {
        if (!isset($data->email)) {
            throw new Error('The field "email" is required.', 400);
        }
    }

    function responseWithData($res, $response) {
        $responseData = $res->getBody()->getContents();
        $result = json_decode($responseData);

        $json = json_encode($result, JSON_PRETTY_PRINT);
        $response->getBody()->write($json);

        return $response
            ->withHeader('Content-Type', 'application/json');
    }

    function getBearerToken($request){
        $token = $request->getHeader('Authorization');
        return $token ? $token[0] : null;
    }

    /**
     * @param $id
     * @param $request
     * @return Response
     * @throws GuzzleException
     */
    function issetDiscussion($id, $request): Response{
        $token = $this->getBearerToken($request);
        $headers = [
            'Authorization' => $token,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];
        return $this->clientNode->get("/discussion/isset/$id", ['headers' => $headers]);
    }

    function addUserToDiscussion($id, $users, $request, $response): Response{
        $token = $this->getBearerToken($request);

        $res = $this->clientNode->put("/discussion/users/$id", [
            'headers' => [
                'Authorization' => $token
            ],
            'json' => [
                'users' => $users
            ]
        ]);
        return $this->responseWithData($res, $response);
    }
}
