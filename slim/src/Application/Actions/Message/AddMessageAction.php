<?php

declare(strict_types=1);

namespace App\Application\Actions\Message;

use Psr\Http\Message\ResponseInterface as Response;
use App\Domain\Message\Message;

class AddMessageAction extends MessageAction
{
    /**
     * @OA\Post (
     *   tags={"Message"},
     *   path="/message",
     *   operationId="createMessage",
     *   security={{"bearerAuth":{}}},
     *   @OA\RequestBody (
     *     name="body",
     *     in="body",
     *     description="request body used to create message.",
     *     required=true,
     *     @OA\JsonContent(ref="#/components/schemas/MessageViewModel"),
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="create new message",
     *     @OA\JsonContent(ref="#/components/schemas/Message")
     *   )
     * )
     */
    protected function action(): Response
    {
        $data = $this->request->getParsedBody();
        $message = new Message;
        $message->sender = $data["sender"];
        $message->discussionId = $data["discussionId"];
        $message->content = $data["content"];
        $message->save();
        return $this->respondWithData($message);
    }
}
