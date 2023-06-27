<?php
namespace Pages;

use DependencyContainer;
use Services\UserManagerBase;
use Utils\Router;

class Logout
{
    public function __construct(private readonly UserManagerBase $userManager)
    {
        $this->userManager->signOutUser();
        Router::redirectToLocalPageByKey("home");
    }
}

$component = DependencyContainer::getContainer()->get(Logout::class);