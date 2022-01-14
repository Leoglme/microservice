<?php

declare(strict_types=1);

namespace App\Application\Actions\User;

use Psr\Http\Message\ResponseInterface as Response;
use App\Domain\User\User;

class UpdateUserAction extends UserAction
{
    /**
     * @OA\Put (
     *   tags={"User"},
     *   path="/user/update/{id}",
     *   operationId="updateUser",
     *   security={{"bearerAuth":{}}},
     *   @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="User id",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *   ),
     *   @OA\RequestBody (
     *     name="body",
     *     in="body",
     *     description="request body used to update user.",
     *     required=true,
     *     @OA\JsonContent(ref="#/components/schemas/UserCreateViewModel"),
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="update a user",
     *     @OA\JsonContent(ref="#/components/schemas/User")
     *   )
     * )
     */
    protected function action(): Response
    {
        $input = $this->request->getParsedBody();
        $data = json_decode((string)json_encode($input), false);
        $userId = (int)$this->resolveArg('id');
        $user = $this->user->find($userId);

        if (!isset($user)) {
            return $this->respondWithData("L'utilisateur n'existe pas", 404);
        }

        foreach ($data as $key => $value) {
            if (isset($user->$key)) {
                $user->$key = $value;
            }
        }
        $user->save();
        return $this->respondWithData($user);
    }
}
