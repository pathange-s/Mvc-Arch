<?php

namespace Model;

session_start();
class Auth
{

    public static function createUser($Name, $Email, $Password)
    {
        $db = \DB::get_instance();
        $stmt = $db->prepare("INSERT INTO USERS_DATA (Name,Email,Password) VALUES (?,?,?)");
        $stmt->execute([$Name, $Email, $Password]);
    }


    public static function verifyLogin($Email, $Password)
    {
        $db = \DB::get_instance();

        $Sth = $db->prepare("SELECT * FROM USERS_DATA WHERE Email= ?");
        $Sth->execute([$Email]);

        $Result = $Sth->fetch();
        // echo "job done";
        return $Result;
    }

    public static function verifyLoginAdmin($Email, $Password)
    {
        $db = \DB::get_instance();

        $Sth = $db->prepare("SELECT * FROM ADMIN_DATA WHERE Email= ?");
        $Sth->execute([$Email]);

        $Result = $Sth->fetch();
        // echo "job done";
        return $Result;
    }
}
