<?php

namespace Services;

interface IImageManager
{
    public function saveImage(string $pathToTempImageFile, string $username);
    public function getUserImagePaths(string $username): array;
}