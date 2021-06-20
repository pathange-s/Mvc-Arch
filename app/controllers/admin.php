<?php

namespace Controller;

session_start();

class Admin
{
    public function get()
    {
        if (!isset($_SESSION)) {
            echo \View\Loader::make()->render("templates/home.twig");
        } else {
            echo \View\Loader::make()->render("templates/adminpage.twig", array(
                "bookdata" => \Model\Books::findAvailable(),
            ));
        }

    }

}

class AdminLogin
{

    public function get()
    {

        echo \View\Loader::make()->render("templates/admin_login.twig");
    }

    public function post()
    {
        $Email = $_POST["email"];
        $Password = $_POST["password"];
        $result = \Model\Auth::verifyLoginAdmin($Email, $Password);

        if ($result['Password'] == null) {
            echo \View\Loader::make()->render("templates/admin_login.twig", array(
                "EmailDNE" => true,
            ));
        } else if ($Password == $result['Password']) {
            //echo "Correct Pw";
            $_SESSION["User_Email"] = $Email;
            $_SESSION["Role"] = "Admin";
            header("Location:/admin");

        } else {
            echo \View\Loader::make()->render("templates/admin_login.twig", array(
                "wrongpw" => true,
            ));
        }

    }

}
