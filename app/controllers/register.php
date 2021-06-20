<?php

namespace Controller;

class Register
{

    public function get()
    {
        echo \View\Loader::make()->render("templates/register.twig");
    }

    public function post()
    {
        $Name = $_POST["name"];
        $Email = $_POST["email"];
        $Password = $_POST["password"];
        $Password = password_hash($Password, PASSWORD_BCRYPT);
        //$Password = hash("sha512", $password);

        \Model\Auth::createUser($Name, $Email, $Password);

        echo \View\Loader::make()->render("templates/register.twig", array(
            "dataEntered" => true,
        ));
    }
}
