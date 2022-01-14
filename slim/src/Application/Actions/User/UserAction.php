<?php

declare(strict_types=1);

namespace App\Application\Actions\User;

use App\Application\Actions\Action;
use App\Application\Settings\SettingsInterface;
use App\Domain\User\User;
use App\Domain\Message\Message;
use Psr\Log\LoggerInterface;

abstract class UserAction extends Action
{
    /**
     * @var User
     */
    protected $user;

    /**
     * @var Message
     */
    protected $messages;
    /**
     * @var SettingsInterface
     */
    protected $settings;

    /**
     * @param LoggerInterface $logger
     * @param User $user
     * @param Message $messages
     * @param SettingsInterface $settings
     */
    public function __construct(LoggerInterface $logger, User $user, Message $messages, SettingsInterface $settings)
    {
        parent::__construct($logger);
        $this->user = $user;
        $this->messages = $messages;
        $this->settings = $settings;
    }
}
