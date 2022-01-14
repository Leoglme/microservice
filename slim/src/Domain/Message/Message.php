<?php

namespace App\Domain\Message;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     title="Message"
 * )
 */
class Message extends Model
{
    /**
     * @OA\Property(type="integer", format="int64", readOnly=true, example=1)
     */
    private $id;
    /**
     * @OA\Property(type="integer", format="int64", readOnly=true, example=1)
     */
    private $sender;

    /**
     * @OA\Property(type="integer", format="int64", readOnly=true, example=1)
     */
    private $discussionId;

    /**
     * @OA\Property(type="string", example="a simple message")
     */
    private $content;
}
