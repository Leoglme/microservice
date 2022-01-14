<?php

declare(strict_types=1);

namespace App\Application\Actions\User;

use App\Application\Common\HashedPass;
use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use App\Domain\User\User;

class AddUserAction extends UserAction
{
    private $container;

    /**
     * @OA\Post (
     *     tags={"User"},
     *     path="/user",
     *     operationId="createUser",
     *   @OA\RequestBody (
     *     name="body",
     *     in="body",
     *     description="request body used to create account.",
     *     required=true,
     *     @OA\JsonContent(ref="#/components/schemas/UserCreateViewModel"),
     *   ),
     *     @OA\Response(
     *      response="200",
     *      description="create a users",
     *      @OA\JsonContent(
     *          type="array",
     *          @OA\Items(ref="#/components/schemas/User")
     *      )
     *   )
     * ),
     */
    protected function action(): Response
    {
        $data = $this->request->getParsedBody();
        $user = new User;

        $pswHash = new HashedPass($data["password"], $this->settings->get('SECRET_SALT'));

        $user->firstname = $data["firstname"];
        $user->lastname = $data["lastname"];
        $user->email = $data["email"];
        $user->password = $pswHash->hashedPassRip160();
        $user->save();
        return $this->respondWithData($user);
    }
}
