<?php

declare(strict_types=1);

namespace App\Application\Actions\Auth;

use App\Application\Settings\Settings;
use App\Application\Settings\SettingsInterface;
use App\Domain\User\User;
use Psr\Log\LoggerInterface;
use App\Application\Actions\Action;

abstract class AuthAction extends Action
{
    /**
     * @var User
     */
    protected $user;

    /**
     * @var SettingsInterface
     */
    protected $settings;

    public function __construct(LoggerInterface $logger, User $user, SettingsInterface $settings)
    {
        parent::__construct($logger);
        $this->user = $user;
        $this->settings = $settings;
    }
}
