<?php

namespace App\Domain\Message;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     title="MessageViewModel"
 * )
 */
class MessageViewModel extends Model
{
    /**
     * @OA\Property(type="integer", format="int64", example=1)
     */
    private $discussionId;
    /**
     * @OA\Property(type="integer", format="int64", example=1)
     */
    private $sender;

    /**
     * @OA\Property(type="string", example="a simple message")
     */
    private $content;
}
