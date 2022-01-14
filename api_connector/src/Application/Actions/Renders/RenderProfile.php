<?php
declare(strict_types=1);

namespace App\Application\Actions\Renders;

use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\Twig;

class RenderProfile extends Action
{
    protected function action(): Response
    {
        $view = Twig::fromRequest($this->request);
        return $view->render($this->response, 'pages/profile.twig');
    }
}