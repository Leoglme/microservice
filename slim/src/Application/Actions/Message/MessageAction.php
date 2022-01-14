<?php

declare(strict_types=1);

namespace App\Application\Actions\Message;

use App\Application\Actions\Action;
use App\Domain\Message\Message;
use App\Domain\User\User;
use Psr\Log\LoggerInterface;

abstract class MessageAction extends Action
{
    /**
    * @var Message
    */
    protected $message;
    /**
     * @var User
     */
    protected $user;

    /**
     * @param LoggerInterface $logger
     * @param Message $message
     * @param User $user
     */
    public function __construct(LoggerInterface $logger, Message $message, User $user)
    {
        parent::__construct($logger);
        $this->message = $message;
        $this->user = $user;
    }
}
