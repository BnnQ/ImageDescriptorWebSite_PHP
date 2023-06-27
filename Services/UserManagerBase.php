<?php

namespace Services;

use Exceptions\UserNotFoundException;
use Models\Entities\User;

abstract class UserManagerBase
{
    public abstract function getUser(string $username): User;
    public abstract function signUpUser(string $username, string $password): void;
    public abstract function verifyAndSignInUser(string $username, string $password);
    public abstract function signInUser(string $username): void;
    public abstract function signOutUser(): void;
    public abstract function getCurrentUser(): User;
    public function isCurrentUserAuthenticated(): bool {
        try {
            $currentUser = $this->getCurrentUser();
            $token = $_COOKIE[COOKIE_AuthenticationToken] ?? null;
            return isset($token) && $token === $currentUser->lastAuthenticationToken;
        } catch (UserNotFoundException $exception) {
            return false;
        }
    }
}