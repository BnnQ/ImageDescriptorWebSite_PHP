<?php

use Services\Router;
use Services\UserManagerBase;

class Logout
{
    public function __construct(private readonly UserManagerBase $userManager)
    {
        $this->userManager->signOutUser();
        Router::redirectToLocalPageByKey("home");
    }
}

$component = DependencyContainer::getContainer()->get(Logout::class);