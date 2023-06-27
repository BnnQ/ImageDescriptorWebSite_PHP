<?php

require_once 'Startup.php';
require_once 'Models/Route.php';
require_once 'DependencyContainer.php';
require_once 'vendor/autoload.php';

use Services\Router;
use Services\UserManagerBase;


class Outlet {
    public function __construct(public readonly UserManagerBase $userManager)
    {
    }
}

$component = DependencyContainer::getContainer()->get(Outlet::class);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>1</title>
    <?php require_once "CommonStylesheets.php"?>
</head>
<header class="fixed-top">
    <nav class="navbar navbar-expand-lg navbar-light bg-dark">
        <a class="navbar-brand" href="Outlet.php?page=home" style="display: flex; align-items: center;">
            <img src="media/logo.png" class="img-fluid" alt="Logo">
        </a>
        <div class="container-fluid justify-content-end" style="padding: 32px">
            <div class="row">
                <div class="col">
                    <?php
                    if ($component->userManager->isCurrentUserAuthenticated())
                        echo "<a href='Outlet.php?page=logout'><i class='fa fa-sign-out'></i>Log out</a>";
                    ?>
                </div>
            </div>

        </div>
    </nav>
</header>
<body>
<script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script src="node_modules/jquery/dist/jquery.min.js"></script>
<script src="node_modules/slick-carousel/slick/slick.min.js"></script>
<?php
$dependencyContainer = DependencyContainer::getContainer();
$startup = $dependencyContainer->get(Startup::class);

$routes = Router::getRoutes();

$currentPageKey = $_GET["page"] ?? "home";
include_once $routes[strtolower($currentPageKey)];
?>
</body>
</html>