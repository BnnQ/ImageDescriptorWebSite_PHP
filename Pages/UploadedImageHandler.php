<?php

namespace Pages;

use DependencyContainer;
use Services\IImageManager;
use Services\UserManagerBase;
use Utils\Router;

class UploadedImageHandler {
    public function __construct(public readonly UserManagerBase $userManager, public readonly IImageManager $imageManager)
    {
    }
}

$component = DependencyContainer::getContainer()->get(UploadedImageHandler::class);
if (!$component->userManager->isCurrentUserAuthenticated()) {
    Router::redirectToLocalPageByKey(ROUTE_Login);
}

$component->imageManager->saveImage($_FILES['image']['tmp_name'], $component->userManager->getCurrentUser()->username);
Router::redirectToLocalPageByKey(ROUTE_Home);