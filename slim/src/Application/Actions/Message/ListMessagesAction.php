<?php

declare(strict_types=1);

namespace App\Application\Actions\Message;

use App\Application\Actions\ActionPayload;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ListMessagesAction extends MessageAction
{
    /**
     * @OA\Get (
     *   tags={"Message"},
     *   path="/messages",
     *   operationId="getMessages",
     *   security={{"bearerAuth":{}}},
     *   @OA\Response(
     *     response=200,
     *     description="list all messages",
     *     @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Message"))
     *   )
     * )
     */
    protected function action(): Response
    {
        $allMessages = $this->message->all();
        return $this->respondWithData($allMessages);
    }


    /**
     * @OA\Get (
     *   tags={"Message"},
     *   path="/messages/{discussionId}",
     *   operationId="DiscussionMessages",
     *   security={{"bearerAuth":{}}},
     *   @OA\Parameter(
     *          name="discussionId",
     *          in="path",
     *          required=true,
     *          description="Discussion id",
     *          @OA\Schema(
     *              type="string"
     *          )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="list all messages",
     *     @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Message"))
     *   )
     * )
     */
    public function discussionMessages(Request $request, Response $response, array $args): Response
    {
        $allMessages = $this->message->all();
        $currentDiscussion = $args['discussionId'];
        $filteredDiscussion = [];
        foreach ($allMessages as &$value) {
            if (strval($value['discussionId']) == strval($currentDiscussion)) {
                if($value['sender']){
                    $user = $this->user->find($value['sender']);
                    if($user){
                        $userData = [
                            'id' => $user['id'],
                            'lastname' => $user['lastname'],
                            'firstname' => $user['firstname'],
                            'email' => $user['email'],
                        ];
                        $value['user'] = $userData;
                    }
                }
                array_push($filteredDiscussion, $value);
            }
        }
        $payload = new ActionPayload(200, $filteredDiscussion);
        $json = json_encode($payload, JSON_PRETTY_PRINT);
        $response->getBody()->write($json);
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($payload->getStatusCode());
    }
}
