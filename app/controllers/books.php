<?php

namespace Controller;

session_start();


class Books
{
    public function get()
    {
        if (!isset($_SESSION)) {
            echo \View\Loader::make()->render("templates/home.twig");
        } else {
            $Email = $_SESSION["UserEmail"];

            echo \View\Loader::make()->render("templates/books.twig", array(
                "booksavailable" => \Model\Books::findAvailable(),

            ));
        }
    }


    public function post()
    {

        $db = \DB::get_instance();
        $Data = $_POST["checkout"];

        $Email = $_SESSION["UserEmail"];

        \Model\Books::updateRequest($Email, $Data);
    }
}



class AddBooks
{

    public function post()
    {

        if (!isset($_SESSION["Role"])) {
            echo \View\Loader::make()->render("templates/home.twig");
        } else {

            $book_name = $_POST["book_name"];
            $book_count = $_POST["book_count"];

            if ($book_count < 0) {

                echo \View\Loader::make()->render("templates/adminpage.twig", array(
                    "invaliddata" => true,
                    "bookdata" =>  \Model\Books::findAvailable(),

                ));
            } else {
                \Model\Books::addBookData($book_name, $book_count);

                echo \View\Loader::make()->render("templates/adminpage.twig", array(
                    "dataEntered" => true,
                    "bookdata" =>  \Model\Books::findAvailable(),

                ));
            }
        }
    }
}


class ApprovedBooks
{


    public function get()
    {
        if (!isset($_SESSION)) {
            echo \View\Loader::make()->render("templates/home.twig");
        }
        //echo $_SESSION["UserEmail"];
        else {
            echo \View\Loader::make()->render("templates/approvedbooks.twig", array(
                "history" => \Model\Books::findApproved($_SESSION["UserEmail"]),
                "checkinsuccess" => false,
            ));
        }
    }


    public function post()
    {

        $db = \DB::get_instance();
        $Data = $_POST["checkin"];
        $Email = $_SESSION["UserEmail"];
        \Model\Books::updateCheckin($Email, $Data);
    }
}


class ManageBooks
{

    public function get()
    {
        if (!isset($_SESSION)) {
            echo \View\Loader::make()->render("templates/home.twig");
        } else {

            echo \View\Loader::make()->render("templates/managebooks.twig", array(
                "requestdata" =>  \Model\Books::findAllRequests(),
            ));
        }
    }

    public function post()
    {

        $db = \DB::get_instance();

        $Data = $_POST["request"];
        $Status = $_POST["status"];

        \Model\Books::updateRequestAdmin($Data, $Status);
    }
}

class CheckedBooks
{
    public function get()
    {

        if (!isset($_SESSION["Role"])) {
            echo \View\Loader::make()->render("templates/home.twig");
        } else {
            echo \View\Loader::make()->render("templates/checkedbooks.twig", array(
                "books" => \Model\Books::findChecked(),
            ));
        }
    }
}
