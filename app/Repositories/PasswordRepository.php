<?php
/**
 * Created by PhpStorm.
 * User: Usuario
 * Date: 06/04/2017
 * Time: 18:13
 */

namespace App\Repositories;


interface PasswordRepository
{

    public function sendLink($credentials);
    public function resetPassword($request);
}