<?php

namespace Services;

require_once "Utils\RouteConstants.php";
class LocalImageManager implements IImageManager
{
    private readonly string $pathToImageDirectory;
    public function __construct(private readonly ITokenGenerator $tokenGenerator)
    {
        $this->pathToImageDirectory = "wwwroot/media/images/";
    }

    public function saveImage(string $pathToTempImageFile, string $username): void
    {
        $uniqueName = $this->tokenGenerator->generateToken(length: 16);
        $pathToUserImageDirectory = $this->pathToImageDirectory.$username;
        if (!is_dir($pathToUserImageDirectory))
            mkdir($pathToUserImageDirectory, 0777, true);

        move_uploaded_file($pathToTempImageFile, $pathToUserImageDirectory."/$uniqueName.png");
    }

    public function getUserImagePaths(string $username): array
    {
        $dir = $this->pathToImageDirectory.$username;
        $imagePaths = [];

        if (is_dir($dir)) {
            $files = scandir($dir);
            foreach ($files as $file) {
                if ($file !== '.' && $file !== '..') {
                    $imagePaths[] = $dir.'/'.$file;
                }
            }
        }

        return $imagePaths;
    }

}