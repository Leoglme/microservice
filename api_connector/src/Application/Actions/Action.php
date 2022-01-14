<?php
declare(strict_types=1);

namespace App\Application\Actions;

use App\Domain\DomainException\DomainRecordNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Log\LoggerInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpNotFoundException;


/**
 * @OA\Server(url="http://localhost:8000")
 * @OA\Info(title="Microservices - Slim Connector", version="0.1",
 *     license={
 *       "name": "MIT",
 *       "url": "https://github.com/Leoglme"
 *     },
 *     description="Microservices connector made with `Slim framework` for microservices chat application",
 *     contact={
 *     "email": "contact@dibodev.com",
 *     "url": "https://dibodev.com",
 *     "name": "Leoglme"
 * })
 * @OA\SecurityScheme(
 *      securityScheme="bearerAuth",
 *      type="http",
 *      scheme="Bearer"
 * ),
 * @OA\Tag(
 *     name="User",
 *     description="Users api"
 * ),
 * @OA\Tag(
 *     name="Auth",
 *     description="Auth api"
 * ),
 * @OA\Tag(
 *     name="Message",
 *     description="Message api"
 * )
 */
abstract class Action
{
    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Response
     */
    protected $response;

    /**
     * @var array
     */
    protected $args;

    /**
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     * @throws HttpNotFoundException
     * @throws HttpBadRequestException
     */
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $this->request = $request;
        $this->response = $response;
        $this->args = $args;

        try {
            return $this->action();
        } catch (DomainRecordNotFoundException $e) {
            throw new HttpNotFoundException($this->request, $e->getMessage());
        }
    }

    /**
     * @return Response
     * @throws DomainRecordNotFoundException
     * @throws HttpBadRequestException
     */
    abstract protected function action(): Response;

    /**
     * @return array|object
     * @throws HttpBadRequestException
     */
    protected function getFormData()
    {
        $input = json_decode(file_get_contents('php://input'));

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new HttpBadRequestException($this->request, 'Malformed JSON input.');
        }

        return $input;
    }

    /**
     * @param string $name
     * @return mixed
     * @throws HttpBadRequestException
     */
    protected function resolveArg(string $name)
    {
        if (!isset($this->args[$name])) {
            throw new HttpBadRequestException($this->request, "Could not resolve argument `{$name}`.");
        }

        return $this->args[$name];
    }

    /**
     * @param array|object|null $data
     * @param int $statusCode
     * @return Response
     */
    protected function respondWithData($data = null, int $statusCode = 200): Response
    {
        $payload = new ActionPayload($statusCode, $data);

        return $this->respond($payload);
    }

    /**
     * @param string $location
     * @param Response $response
     * @param int $code
     * @return Response
     */
    protected function redirect(string $location, Response $response, int $code = 302): Response
    {
        $response = $response->withStatus($code);
        return $response->withHeader('Location', $location);
    }

    protected function flash(string $type, $message)
    {
        if(!isset($_SESSION['flash'])) {
            $_SESSION['flash'] = [];
        }
        return $_SESSION['flash'][$type] = $message;
    }
    protected function getConnectedUser(){
        if(!isset($_SESSION['user']) || !$this->isConnected()) {
            $_SESSION['user'] = [];
        }
        return $_SESSION['user'];
    }
    protected function setConnectedUser($user)
    {
        if(!isset($_SESSION['user'])) {
            $_SESSION['user'] = [];
        }
        return $_SESSION['user'] = $user;
    }
    protected function getAuthToken(){
        if(!isset($_SESSION['token_auth'])) {
            $_SESSION['token_auth'] = [];
        }
        return $_SESSION['token_auth'];
    }

    protected function setAuthToken($token)
    {
        if(!isset($_SESSION['token_auth'])) {
            $_SESSION['token_auth'] = [];
        }
        return $_SESSION['token_auth'] = $token;
    }

    protected function isConnected(): bool
    {
        return isset($_SESSION['token_auth']) && isset($_SESSION['user']);
    }

    protected function old($data)
    {
        if(!isset($_SESSION['old'])) {
            $_SESSION['old'] = [];
        }
        return $_SESSION['old'] = $data;
    }

    /**
     * @param ActionPayload $payload
     * @return Response
     */
    protected function respond(ActionPayload $payload): Response
    {
        $json = json_encode($payload, JSON_PRETTY_PRINT);
        $this->response->getBody()->write($json);

        return $this->response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($payload->getStatusCode());
    }
}
