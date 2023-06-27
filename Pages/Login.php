<?php

namespace Pages;

use DependencyContainer;
use Exceptions\InvalidCredentialsException;
use Exceptions\UserNotFoundException;
use Services\UserManagerBase;
use Utils\Router;


require_once "Utils\RouteConstants.php";

class Login
{
    public function __construct(public readonly UserManagerBase $userManager)
    {

    }
}

$component = DependencyContainer::getContainer()->get(Login::class);
?>

<?php
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        $component->userManager->verifyAndSignInUser($username, $password);
        Router::redirectToLocalPageByKey(ROUTE_Home);
    } catch (UserNotFoundException $exception) {
        $errorMessage = "User with this username does not exist.";
        include "ErrorToast.php";
    } catch (InvalidCredentialsException $exception) {
        $errorMessage = "Invalid username or password.";
        include "ErrorToast.php";
    }
}
?>
<link rel="stylesheet" href="/LWHW/wwwroot/stylesheets/Account.css"/>
<link rel="stylesheet" href="/LWHW/wwwroot/stylesheets/Login.css"/>
<div id="body" class="d-flex flex-column align-items-center justify-content-center min-vh-100">
    <div id="form-wrapper" class="container-fluid">
        <div class="text-center">
            <h1 class="fw-bold mb-4" style="font-size: 35px">Login</h1>
            <h2 class="mb-4" style="font-size: 20px">Welcome back</h2>
        </div>

        <div class="pb-3 text-center">
            <a href="/LWHW/Outlet.php?page=register" class="btn btn-primary btn-block create-btn">
                Join
            </a>
        </div>
        <div class="or">
            <div class="or-line"></div>
            <div class="or-or">
                <span>OR</span>
            </div>
        </div>

        <form method="POST" action="/LWHW/Outlet.php?page=login">
            <div class="form-group mb-1">
                <label class="form-label" for="username"></label>
                <input name="username" id="username" class="form-control" placeholder="username" required/>
            </div>
            <div class="form-group mb-3">
                <label class="form-label" for="password"></label>
                <input name="password" id="password" type="password" class="form-control" placeholder="••••••••"
                       required/>
            </div>
            <div>
                <button type="submit" name="submit" id="submit" class="btn btn-primary text-nowrap fw-bold w-100"
                        style="border-radius: 2px; padding: 7px 0;  font-size: 18px">
                    Login
                </button>
            </div>
        </form>

    </div>
</div>