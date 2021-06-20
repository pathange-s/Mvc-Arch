<?php
namespace Controller;

session_start();


class Books{
    public function get(){  
        if(!isset($_SESSION)){
            echo \View\Loader::make()->render("templates/home.twig");
        }
        else{
        $Email = $_SESSION['User_Email'];
        
        echo \View\Loader::make()->render("templates/books.twig",array(
            "booksavailable" => \Model\Books::findAvailable(),
            
        ));
        
        }
     
    }

    
    public function post(){  
      
        $db = \DB::get_instance();
        $data = $_POST["checkout"];
       
        $Email = $_SESSION["User_Email"];

        \Model\Books::updateRequest($Email,$data);
       
        
    }

}


class AddBooks{

    public function post(){
        
        if(!isset($_SESSION["Role"])){
            echo \View\Loader::make()->render("templates/home.twig");
        }
        else{

            $book_name=$_POST["book_name"];
            $book_count=$_POST["book_count"];

            if($book_count<0){

                echo \View\Loader::make()->render("templates/adminpage.twig", array(
                    "invaliddata" => true,
                    "bookdata" =>  \Model\Books::findAvailable(),

                ));
            }
            else{
                \Model\Books::addBookData($book_name,$book_count);

                echo \View\Loader::make()->render("templates/adminpage.twig", array(
                    "dataEntered" => true,
                    "bookdata" =>  \Model\Books::findAvailable(),

                ));
           }
        
       
        }

    }

}


class ApprovedBooks{


    public function get(){  
        if(!isset($_SESSION)){
            echo \View\Loader::make()->render("templates/home.twig");
        }
        //echo $_SESSION['User_Email'];
        else{
            echo \View\Loader::make()->render("templates/approvedbooks.twig",array(
            "history" => \Model\Books::findApproved($_SESSION['User_Email']),
            "checkinsuccess"=>false,
        ));
    }

     
    }

    
    public function post(){  
      
        $db = \DB::get_instance();
        $data = $_POST["checkin"];
        $Email = $_SESSION["User_Email"];
        \Model\Books::updateCheckin($Email,$data);
       
        
    }
}
