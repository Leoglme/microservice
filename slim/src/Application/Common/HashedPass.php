<?php

namespace App\Application\Common;

class HashedPass
{

    private $password;
    private $salt;

    public function __construct($password, $salt)
    {
        $this->password = $password;
        $this->salt = $salt;
    }

    public function hashedPassRip160(): string
    {
        return hash('sha512', $this->password . $this->salt);
    }
}
