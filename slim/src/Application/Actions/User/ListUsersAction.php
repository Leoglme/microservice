<?php

declare(strict_types=1);

namespace App\Application\Actions\User;

use Psr\Http\Message\ResponseInterface as Response;

class ListUsersAction extends UserAction
{
    /**
     * @OA\Get(
     *   tags={"User"},
     *   path="/users",
     *   operationId="getUsers",
     *   security={{"bearerAuth":{}}},
     *   @OA\Response(
     *     response=200,
     *     description="list all users",
     *     @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/User"))
     *   )
     * )
     */
    protected function action(): Response
    {
        $allUsers = $this->user->all();
        return $this->respondWithData($allUsers);
    }
}
