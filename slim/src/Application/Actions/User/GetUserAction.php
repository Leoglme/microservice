<?php

declare(strict_types=1);

namespace App\Application\Actions\User;

use Psr\Http\Message\ResponseInterface as Response;

class GetUserAction extends UserAction
{
    /**
     * @OA\Get(
     *   tags={"User"},
     *   path="/user/{id}",
     *   operationId="getUserById",
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
     *   @OA\Response(
     *     response=200,
     *     description="get user with your id",
     *     @OA\JsonContent(ref="#/components/schemas/User")
     *   )
     * )
     */
    protected function action(): Response
    {
        $userId = (int) $this->resolveArg('id');
        $user = $this->user->find($userId);
        if(!$user) return $this->respondWithData("user not found", 404);
        return $this->respondWithData($user);
    }
}
