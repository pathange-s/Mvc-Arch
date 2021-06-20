<?php

namespace Controller;

session_start();

class Login
{

    public function get()
    {

        echo \View\Loader::make()->render("templates/login.twig");
    }

    public function post()
    {
        $Email = $_POST["email"];
        $Password = $_POST["password"];
        $Result = \Model\Auth::verifyLogin($Email, $Password);

        if ($Result['Password'] == null) {
            echo \View\Loader::make()->render("templates/login.twig", array(
                "EmailDNE" => true,
            ));
        } else if (password_verify($Password, $Result['Password'])) {

            $_SESSION["UserEmail"] = $Email;

            header("Location:/user");
        } else {
            echo \View\Loader::make()->render("templates/login.twig", array(
                "wrongpw" => true,
            ));
        }
    }
}

class Logout
{

    public function get()
    {
        session_destroy();
        header("Location:/");
    }
}
