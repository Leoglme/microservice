<?php

declare(strict_types=1);

namespace App\Application\Actions\Message;

use Psr\Http\Message\ResponseInterface as Response;
use App\Domain\Message\Message;

class UpdateMessageAction extends MessageAction
{
    /**
     * @OA\Put (
     *   tags={"Message"},
     *   path="/message/update/{id}",
     *   operationId="updateMessage",
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
     *   @OA\RequestBody (
     *     name="body",
     *     in="body",
     *     description="request body used to create message.",
     *     required=true,
     *     @OA\JsonContent(ref="#/components/schemas/MessageViewModel"),
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="update a message",
     *     @OA\JsonContent(ref="#/components/schemas/Message")
     *   )
     * )
     */
    protected function action(): Response
    {
        $input = $this->request->getParsedBody();
        $data = json_decode((string)json_encode($input), false);
        $messageId = (int)$this->resolveArg('id');
        $message = $this->message->find($messageId);

        if (!isset($message)) {
            return $this->respondWithData("Le message n'existe pas", 404);
        }

        foreach ($data as $key => $value) {
            if (isset($message->$key)) {
                $message->$key = $value;
            }
        }
        $message->save();
        return $this->respondWithData($message);
    }
}
