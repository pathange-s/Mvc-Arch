<?php
    require __DIR__."/../vendor/autoload.php";

    Toro::serve(array(
        "/"=> "\Controller\Home",
        "/login"=> "\Controller\Login",        
        "/register"=> "\Controller\Register",
        "/user" => "\Controller\User",
        "/userhistory" => "\Controller\UserHistory",
        "/approvedbooks" => "\Controller\ApprovedBooks",
        "/books" => "\Controller\Books",
        "/logout" => "\Controller\Logout",
        "/admin_login" => "\Controller\AdminLogin",
        "/admin" => "\Controller\Admin",
        "/addbooks" => "\Controller\AddBooks",
        "/checkedbooks"=>"\Controller\CheckedBooks",
        "/managebooks"=>"\Controller\ManageBooks",
          

    ));

    