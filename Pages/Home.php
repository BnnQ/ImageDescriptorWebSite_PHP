<?php

namespace Pages;

use DependencyContainer;
use Services\IImageManager;
use Services\UserManagerBase;
use Utils\Router;

require_once "Utils/RouteConstants.php";

class Home
{
    public function __construct(public readonly UserManagerBase $userManager, public readonly IImageManager $imageManager)
    {
        //empty
    }
}

$component = DependencyContainer::getContainer()->get(Home::class);
if (!$component->userManager->isCurrentUserAuthenticated()) {
    Router::redirectToLocalPageByKey(ROUTE_Login);
}
?>

<link rel="stylesheet" href="/LWHW/wwwroot/stylesheets/Home.css"/>
<link rel="stylesheet" href="/LWHW/wwwroot/stylesheets/Hoverable.css"/>
<div id="body" class="container-fluid">
    <div class="row justify-content-center align-items-center">
        <div>
            <div class="text-center">
                <p class="label-lg">Your images</p>
                <hr/>
            </div>
            <div class="image-container">
                <?php
                $userImages = $component->imageManager->getUserImagePaths($component->userManager->getCurrentUser()->username);
                if (count($userImages) < 1) {
                    echo "<div class='text-center'><p class='label text-light-gray'>You have not uploaded any images at the moment. Do it with the button below!</p></div>";
                } else {
                    foreach ($userImages as $image) {
                        echo "<div class='user-image-container'><img src='$image' alt='Your image slide' class='img-fluid'/></div>";
                    }
                }
                ?>
            </div>
            <form method="post" class="text-center" enctype="multipart/form-data" action="/LWHW/Outlet.php?page=upload">
                <input class="btn btn-primary" type="file" accept="image/*" name="image" onchange="this.form.submit()"/>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(() => {
        $('.image-container').slick({
            dots: true,
            infinite: false,
            speed: 300,
            slidesToShow: 5,
            slidesToScroll: 1,
            adaptiveHeight: false,
            arrows: false
        });

        function adjustToLg() {
            $("#gallery").addClass('grid-container').removeClass('row').removeClass('row-cols-1').removeClass('g-4');
        }
        function adjustToMd() {
            $("#gallery").removeClass('grid-container').addClass('row').addClass('row-cols-1').addClass('g-4');
        }
        function adjust() {
            const lgBreakpoint = 992;
            if (window.innerWidth > lgBreakpoint) adjustToLg();
            else adjustToMd();
        }

        adjust();
        $(window).on('resize', () => {
            adjust();
        });

    });
</script>
