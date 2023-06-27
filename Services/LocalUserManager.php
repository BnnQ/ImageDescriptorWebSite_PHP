<?php

namespace Services;

use Exceptions\InvalidCredentialsException;
use Exceptions\UsernameAlreadyTakenException;
use Exceptions\UserNotFoundException;
use Models\Entities\User;
require_once "Utils/CookieConstants.php";
require_once "Utils/Utils.php";

class LocalUserManager extends UserManagerBase
{
    private readonly string $pathToUserStorage;

    public function __construct(private readonly ITokenGenerator $tokenGenerator)
    {
        $this->pathToUserStorage = "wwwroot/media/users/";
    }

    /**
     * @throws UserNotFoundException
     */
    public function getUser(string $username): User
    {
        $pathToSerializedUser = $this->pathToUserStorage . $username . ".user";
        if (!is_file($pathToSerializedUser))
            throw new UserNotFoundException();

        $serializedUser = file_get_contents($pathToSerializedUser);
        $deserializedData = json_decode($serializedUser, true);

        return new User($deserializedData['username'], $deserializedData['hashedPassword'], $deserializedData['lastAuthenticationToken']);
    }


    /**
     * @throws UsernameAlreadyTakenException
     * @throws UserNotFoundException
     */
    public function signUpUser(string $username, string $password): void
    {
        $usernames = scandir($this->pathToUserStorage);
        if (in_array($username.'.user', $usernames)) {
            throw new UsernameAlreadyTakenException();
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $user = new User($username, $hashedPassword, null);
        $serializedUser = json_encode($user);
        file_put_contents($this->pathToUserStorage.$username.".user", $serializedUser);

        $this->signInUser($username);
    }

    /**
     * @throws UserNotFoundException
     */
    public function signInUser(string $username): void
    {
        $user = $this->getUser($username);

        $authenticationToken = $username.'_'.$this->tokenGenerator->generateToken(length: 9);
        $secondsInMinute = 60;
        $minutesInHour = 60;
        $expiresTime = time() + ($secondsInMinute * $minutesInHour * 3);
        setcookie(COOKIE_AuthenticationToken, $authenticationToken, $expiresTime);

        $user->lastAuthenticationToken = $authenticationToken;
        $serializedUpdatedUser = json_encode($user);
        file_put_contents($this->pathToUserStorage.$username.".user", $serializedUpdatedUser);
    }

    /**
     * @throws UserNotFoundException
     * @throws InvalidCredentialsException
     */
    public function verifyAndSignInUser(string $username, string $password): void
    {
        $user = $this->getUser($username);

        if (password_verify($password, $user->hashedPassword)) {
            $this->signInUser($username);
        } else {
            throw new InvalidCredentialsException();
        }

    }

    public function signOutUser(): void
    {
        unsetCookie(COOKIE_AuthenticationToken);
    }

    /**
     * @throws UserNotFoundException
     */
    public function getCurrentUser(): User
    {
        $separator = '_';
        $splittedAuthenticationToken = explode($separator, $_COOKIE[COOKIE_AuthenticationToken] ?? throw new UserNotFoundException());
        $username = $splittedAuthenticationToken[0];

        return $this->getUser($username);
    }

}