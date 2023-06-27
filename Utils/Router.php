<?php

namespace Utils;

use Models\Route;

class Router
{
    private static array $routes = [];

    public static function registerRoute(Route $route): void {
        self::$routes[$route->key] = $route->pagePath;
    }

    public static function getRoutes(): array {
        return self::$routes;
    }

    public static function redirectToPage(string $pageAddress) : void {
        echo "<script>location.replace('$pageAddress');</script>";
    }

    public static function redirectToLocalPageByKey(string $routeKey): void
    {
        echo "<script>location.replace('/LWHW/Outlet.php?page=$routeKey');</script>";
    }

}