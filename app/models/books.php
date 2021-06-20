<?php

namespace Model;


class Books
{

  public static function findAvailable()
  {
    $db = \DB::get_instance();
    $sth = $db->prepare("SELECT * FROM Books WHERE book_count>0 ORDER BY book_id ASC");
    $sth->execute();

    $result = $sth->fetchAll();
    //echo "job done";
    return $result;
  }

  public static function addBookData($book_name, $book_count)
  {

    $db = \DB::get_instance();
    $stmt = $db->prepare("INSERT INTO Books (book_name,book_count) VALUES (?,?)");
    $stmt->execute([$book_name, $book_count]);

    return;
  }

  public static function updateCheckin($Email, $request_id)
  {
    $db = \DB::get_instance();
    $data = array($request_id);

    $size = sizeof($data);

    for ($x = 0; $x < $size; $x++) {


      $sth = $db->prepare("UPDATE Books_Status SET Status = 'Returned' WHERE Request_ID=?");
      $sth->execute([$request_id[$x]]);
    }

    for ($x = 0; $x < $size; $x++) {

      $sth = $db->prepare("UPDATE Books INNER JOIN Books_Status USING (book_id) SET book_count = book_count+1 WHERE Request_ID = ?");
      $sth->execute([$request_id[$x]]);
    }
  }


  public static function findApproved($Email)
  {
    $db = \DB::get_instance();

    $sth = $db->prepare("SELECT * FROM Books_Status INNER JOIN Books USING(book_id) WHERE User_Email = ? AND Status='Approved' ORDER BY Request_ID ASC");
    $sth->execute([$Email]);

    $result = $sth->fetchAll();
    //echo "job done";
    return $result;
  }


  public static function updateRequest($Email, $books_id)
  {
    $db = \DB::get_instance();
    $data = array($books_id);
    $size = sizeof($books_id);

    for ($x = 0; $x < $size; $x++) {

      $status = "Request";
      $sth = $db->prepare("INSERT INTO Books_Status (User_Email,Book_ID,Status) VALUES (?,?,?)");
      $sth->execute([$Email, $books_id[$x], $status]);
    }
  }


  public static function findChecked()
  {
    $db = \DB::get_instance();

    $sth = $db->prepare("SELECT * FROM Books_Status INNER JOIN Books USING(book_id) WHERE Status='Approved' ORDER BY Request_ID ASC");
    $sth->execute();

    $result = $sth->fetchAll();

    return $result;
  }

  public static function findHistory($Email)
  {
    $db = \DB::get_instance();

    $sth = $db->prepare("SELECT * FROM Books_Status INNER JOIN Books USING(book_id) WHERE User_Email = ? ORDER BY Request_ID ASC");

    $sth->execute([$Email]);

    $result = $sth->fetchAll();
    //echo "job done";
    return $result;
  }

  public static function findAllRequests()
  {
    $db = \DB::get_instance();

    $sth = $db->prepare("SELECT * FROM Books_Status INNER JOIN Books USING(book_id) WHERE Status = 'Request' ORDER BY Request_ID ASC");
    $sth->execute();

    $result = $sth->fetchAll();
    //echo "job done";
    return $result;
  }

  public static function updateRequestAdmin($request_id, $status)
  {
    $db = \DB::get_instance();
    $data = array($request_id);
    $size = sizeof($data);

    if ($status == "approve") {
      //change status to approved and update book count            
      //changing status

      for ($x = 0; $x < $size; $x++) {

        $sth = $db->prepare("UPDATE Books_Status SET Status = 'Approved' WHERE Request_ID=?");
        $sth->execute([$request_id[$x]]);
      }

      //upadating count
      for ($x = 0; $x < $size; $x++) {

        $sth = $db->prepare("UPDATE Books INNER JOIN Books_Status USING (book_id) SET book_count = book_count-1 WHERE Request_ID = ?");
        $sth->execute([$request_id[$x]]);
      }
    } else {

      //change status to approved        
      //changing status
      for ($x = 0; $x < $size; $x++) {

        $sth = $db->prepare("UPDATE Books_Status SET Status = 'Denied' WHERE Request_ID=?");
        $sth->execute([$request_id[$x]]);
      }
    }
  }
}
