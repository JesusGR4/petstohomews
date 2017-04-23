<?php

namespace App\Repositories;

interface UserRepository
{
    function getAll();
    function getUserByEmail($email);
    function login($request);

}