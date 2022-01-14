<?php

declare(strict_types=1);

namespace App\Application\Actions\User;

use Psr\Http\Message\ResponseInterface as Response;

class DeleteUserAction extends UserAction
{
    /**
     * @OA\Delete (
     *   tags={"User"},
     *   path="/user/{id}",
     *   operationId="deleteUser",
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
     *     description="delete a single user",
     *     @OA\JsonContent(ref="#/components/schemas/User")
     *   )
     * )
     */
    protected function action(): Response
    {
        $userId = (int)$this->resolveArg('id');
        $user = $this->user->destroy($userId);
        return $this->respondWithData($user);
    }
}    
