<?php

require_once "Utils\Router.php";
use Models\Route;
use Utils\Router;

class Startup
{
    public function __construct()
    {
        Router::registerRoute(new Route(key: "home", pagePath: "Pages/Home.php"));
        Router::registerRoute(new Route(key: "upload", pagePath: "Pages/UploadedImageHandler.php"));
        Router::registerRoute(new Route(key: "login", pagePath: "Pages/Login.php"));
        Router::registerRoute(new Route(key: "register", pagePath: "Pages/Register.php"));
        Router::registerRoute(new Route(key: "logout", pagePath: "Pages/Logout.php"));
    }
}