<?php

namespace app\interfaces;

interface UserInterface
{

    public function login(): bool;

    public function logout(): bool;

    public function UserAccessCoockie(): bool;

    public function UserAccessAPI(): bool;

    public function isGuest(): bool;

    public function isAdmin(): bool;

    public function accessPage(): bool;

    public function accessAction(): bool;

}