<?php

namespace Models\Entities;

use Services\ITokenGenerator;

class User
{
    public function __construct(public string $username, public string $hashedPassword, public ?string $lastAuthenticationToken)
    {
        //empty
    }

}