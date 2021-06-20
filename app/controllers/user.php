<?php

namespace Controller;
session_start();

class Home{
    public function get(){
          
        if($_SESSION['User_Email']!=NULL){

            if($_SESSION['Role']!=NULL){
                header("Location:/admin");
            }
            else{
                // echo \View\Loader::make()->render("templates/userpage.twig");
                header("Location:/user");
            }
        }
        else{
            echo \View\Loader::make()->render("templates/home.twig");
        }
       
        
    }
}


class User{
    
    public function get(){
        if(!isset($_SESSION)){
            echo \View\Loader::make()->render("templates/home.twig");
        }

        else{
            echo \View\Loader::make()->render("templates/userpage.twig");
        }

    }

}


class UserHistory{
    
    public function get(){  
        //echo $_SESSION['User_Email'];
        if(!isset($_SESSION)){
            echo \View\Loader::make()->render("templates/home.twig");
        }
        else{
        echo \View\Loader::make()->render("templates/userhistory.twig",array(
            "book" => \Model\Books::findHistory($_SESSION['User_Email']),
        ));
    }
    }
}
