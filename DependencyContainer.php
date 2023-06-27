<?php


use FiveTwo\DependencyInjection\Container;
use Services\IImageManager;
use Services\ITokenGenerator;
use Services\LocalImageManager;
use Services\LocalUserManager;
use Services\PseudoRandomTokenGenerator;
use Services\UserManagerBase;

class DependencyContainer
{
    private static ?Container $container = null;

    public static function getContainer(): Container {
        if (self::$container == null) {
            self::$container = new Container();

            self::$container
                ->addSingletonClass(Startup::class)
                ->addTransientClass(Outlet::class)
                ->addTransientClass(Home::class)
                ->addTransientClass(UploadedImageHandler::class)
                ->addTransientClass(Login::class)
                ->addTransientClass(Register::class)
                ->addTransientClass(Logout::class)
                ->addTransientImplementation(ITokenGenerator::class, PseudoRandomTokenGenerator::class)
                ->addTransientClass(PseudoRandomTokenGenerator::class)
                ->addSingletonImplementation(UserManagerBase::class, LocalUserManager::class)
                ->addSingletonClass(LocalUserManager::class)
                ->addSingletonImplementation(IImageManager::class, LocalImageManager::class)
                ->addSingletonClass(LocalImageManager::class);
        }

        return self::$container;
    }

}