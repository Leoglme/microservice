<?php
declare(strict_types=1);

namespace App\Application\Actions\Renders;

use App\Application\Actions\User\UserAction;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\Twig;

class RenderHome extends UserAction
{
    protected function action(): Response
    {
        $allUsers = $this->user->all();
        $allMessages = $this->messages->all();
        foreach ($allMessages as &$value) {
            $userById = $this->user->find($value['sender']);
            if ($userById === null || ($userById['firstname'] === null && $userById['lastname'] === null)) {
                $userById['firstname'] = "anonymous";
            }
            json_encode($value['sender'] = [
                'id' => $userById['id'],
                'firstname' => $userById['firstname'],
                'lastname' => $userById['lastname']
            ]);
        }
        $view = Twig::fromRequest($this->request);
        return $view->render($this->response, 'pages/home.twig', ['users' => $allUsers, 'messages' => $allMessages]);
    }
}
