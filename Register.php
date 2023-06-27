<?php

use Exceptions\UsernameAlreadyTakenException;
use Services\Router;
use Services\UserManagerBase;

require_once "Utils\RouteConstants.php";

class Register
{
    public function __construct(public readonly UserManagerBase $userManager)
    {

    }
}

$component = DependencyContainer::getContainer()->get(Register::class);
?>

<?php
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        $component->userManager->signUpUser($username, $password);
        Router::redirectToLocalPageByKey(ROUTE_Home);
    } catch (UsernameAlreadyTakenException $exception) {
        ?>
        <div class="toast-container position-fixed" style="top: 50px; left: 50%; transform: translateX(-50%)">
            <div id="errorToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true"
                 style="width: 600px!important">
                <div class="toast-header bg-danger">
                    <strong class="me-auto text-light">Error</strong>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"
                            aria-label="Close"></button>
                </div>
                <?php
                echo "<div class='toast-body'><div>Username already taken!</div></div>";
                ?>
            </div>
        </div>
        <script type="text/javascript">
            const toastElement = document.getElementById("errorToast");
            if (toastElement) {
                const toast = new bootstrap.Toast(toastElement, {delay: 10000});
                toast.show();
            }
        </script>
        <?php
    }
}
?>
<link rel="stylesheet" href="stylesheets/Account.css"/>
<link rel="stylesheet" href="stylesheets/Register.css"/>
<div id="body" class="container-fluid p-0">
    <div class="row">
        <div class="col-md-4 col-12">
            <div class="image">
                <div class="text">
                    Creation starts here<br>
                    Access 5,153,037 free, high-resolution photos you can't find anywhere else.
                </div>
            </div>
        </div>
        <div class="col-md-8 col-12 d-flex justify-content-center align-items-center">
            <div id="form-wrapper" class="container-fluid">
                <div class="text-center">
                    <h1 class="fw-bold mb-4" style="font-size: 35px">Join SeeSay</h1>
                    <h2 class="mb-4 label-sm text-light-gray">Already have an account? <a href="Outlet.php?page=login"
                                                                                          class="d-inline text-primary">Login</a>
                    </h2>
                </div>

                <form method="POST" action="Outlet.php?page=register">
                    <div class="row mb-1">
                        <div class="form-group">
                            <label class="form-label" for="username"></label>
                            <input name="username" id="username" class="form-control" placeholder="username"/>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="form-group">
                            <label class="form-label" for="password"></label>
                            <input name="password" id="password" type="password" class="form-control"
                                   placeholder="••••••••"/>
                        </div>
                    </div>

                    <div>
                        <button type="submit" name="submit" id="submit"
                                class="btn btn-primary text-nowrap fw-bold w-100"
                                style="border-radius: 2px; padding: 7px 0;  font-size: 18px">
                            Join
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>