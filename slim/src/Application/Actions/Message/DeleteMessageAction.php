<?php

declare(strict_types=1);

namespace App\Application\Actions\Message;

use Psr\Http\Message\ResponseInterface as Response;

class DeleteMessageAction extends MessageAction
{
    /**
     * @OA\Delete (
     *   tags={"Message"},
     *   path="/message/{id}",
     *   operationId="deleteMessage",
     *   security={{"bearerAuth":{}}},
     *   @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="Message id",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="delete a message",
     *     @OA\JsonContent(ref="#/components/schemas/Message")
     *   )
     * )
     */
    protected function action(): Response
    {
        $messageId = (int) $this->resolveArg('id');
        $message = $this->message->destroy($messageId);
        if(!$message) return $this->respondWithData("message not found", 404);
        return $this->respondWithData($message);
    }
}    
