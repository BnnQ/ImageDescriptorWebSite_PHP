<?php

use Models\Route;
use Services\Router;

class Startup
{
    public function __construct()
    {
        Router::registerRoute(new Route(key: "home", pagePath: "Home.php"));
        Router::registerRoute(new Route(key: "upload", pagePath: "UploadedImageHandler.php"));
        Router::registerRoute(new Route(key: "login", pagePath: "Login.php"));
        Router::registerRoute(new Route(key: "register", pagePath: "Register.php"));
        Router::registerRoute(new Route(key: "logout", pagePath: "Logout.php"));
    }
}