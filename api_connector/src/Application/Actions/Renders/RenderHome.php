<?php
declare(strict_types=1);

namespace App\Application\Actions\Renders;

use App\Application\Actions\Action;
use App\Application\Actions\Connector;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Respect\Validation\Validator;
use Slim\Views\Twig;

class RenderHome extends Connector
{
    /**
     * @throws GuzzleException
     */
    protected function action(): Response
    {
        if (!$this->isConnected()) {
            return $this->redirect('/login', $this->response);
        }
        $discussionId = $this->args ? $this->args['id'] : null;
        $users = $this->getUsers();
        $user = $_SESSION['user'];
        $discussions = $this->getDiscussions();
        $discussionMessage = $this->getDiscussionMessages($discussionId);
        $view = Twig::fromRequest($this->request);
        return $view->render($this->response, 'pages/home.twig', ['discussionId' => $discussionId, 'user' => $user, 'users' => $users, 'discussions' => $discussions, 'messages' => $discussionMessage]);
    }

    function redirectToChat(Request $request, Response $response): Response
    {
        return $this->redirect('/chat', $response);
    }

    protected function getUsers()
    {
        $token = $this->getAuthToken();
        $headers = [
            'Authorization' => $token
        ];
        $res = $this->clientSlim->get('/users', ['headers' => $headers, 'debug' => fopen('php://stderr', 'w')]);
        return json_decode($res->getBody()->getContents())->data;
    }
    function addMessage(Request $request, Response $response): Response
    {
        $errors = [];
        $data = $request->getParsedBody();
        $token = $this->getAuthToken();
        $sender = $this->getConnectedUser()->id;

        Validator::notEmpty()->validate($data['content']) || $errors['password'] = 'Message cannot be empty';

        if(empty($errors)) {
            $this->clientSlim->post('/message', [
                'debug' => fopen('php://stderr', 'w'),
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                    'Authorization' => $token
                ],
                'json' => [
                    'sender' => $sender,
                    'discussionId' => $data['discussionId'],
                    'content' => $data['content']
                ]
            ]);
            $this->flash('success', 'Welcome to Quila Chat !');
        }else {
            $this->flash('errors', 'Message cannot be empty');
            $this->old($data);
        }
        return $this->redirect("/chat/" . $data['discussionId'], $response);
    }

    protected function getDiscussionMessages($id)
    {
        if (!$id) {
            return [];
        }
        $token = $this->getAuthToken();
        $headers = [
            'Authorization' => $token
        ];
        $res = $this->clientSlim->get("/messages/$id", ['headers' => $headers, 'debug' => fopen('php://stderr', 'w')]);
        return json_decode($res->getBody()->getContents())->data;
    }

    /**
     * @throws GuzzleException
     */
    protected function getDiscussions()
    {
        $token = $this->getAuthToken();
        $headers = [
            'Authorization' => $token
        ];
        $res = $this->clientNode->get('/discussion/list', ['headers' => $headers, 'debug' => fopen('php://stderr', 'w')]);
        return json_decode($res->getBody()->getContents())->discussions;
    }
}
