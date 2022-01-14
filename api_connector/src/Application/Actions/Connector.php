<?php

declare(strict_types=1);

namespace App\Application\Actions;



use App\Application\Settings\SettingsInterface;
use GuzzleHttp\Client;
use Psr\Log\LoggerInterface;

abstract class Connector extends Action
{
    /**
     * @var SettingsInterface
     */
    protected $settings;


    protected $SLIM_SERVICE;
    protected $clientSlim;
    /**
     * @var Client
     */
    protected $clientNode;
    /**
     * @var string
     */
    protected $NODE_SERVICE;

    /**
     * @param LoggerInterface $logger
     * @param SettingsInterface $settings
     */
    public function __construct(LoggerInterface $logger, SettingsInterface $settings)
    {
        parent::__construct($logger);
        $this->settings = $settings;
        $this->SLIM_SERVICE = 'http://localhost:8080';
        $this->NODE_SERVICE = 'http://localhost:5000';
        $this->clientSlim = new Client(['base_uri' => $this->SLIM_SERVICE, 'debug' => true, 'exceptions' => false, 'headers' => ["Accept" => "application/json"], 'verify' => false]);
        $this->clientNode = new Client(['base_uri' => $this->NODE_SERVICE, 'debug' => true, 'exceptions' => false, 'headers' => ["Accept" => "application/json"], 'verify' => false]);
    }
}
