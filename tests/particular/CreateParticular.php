<?php

class CreateParticular extends AbsTest
{

    public function __construct()
    {
        $method = 'POST';
        $url = '/api/register';
        $positive_user_id = null;
        $negative_user_id = null;
        $positive_parameters = [
            "name" => "Manolo",
            "surname" => "García",
            "phone" => '658086507',
            "email" => 'manolo@gmail.com',
            "province" => "Sevilla",
            "city" => "Alcalá de Guadaíra",
            "password" => 'holahola',
            "confirm_password" => 'holahola'
        ];
        $negative_parameters= array(array("name" => "Manolo",
            "surname" => "García",
            "phone" => '658086507',
            "email" => 'manolo@gmail.com',
            "province" => "Sevilla",
            "city" => "Alcalá de Guadaíra",
            "password" => 'holahola',
            "confirm_password" => 'holaholaa'));



        parent::__construct($method, $url, $positive_user_id, $negative_user_id, $positive_parameters, $negative_parameters);
    }
}