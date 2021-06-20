<?php

namespace Model;


class Books
{

  public static function findAvailable()
  {
    $db = \DB::get_instance();
    $Sth = $db->prepare("SELECT * FROM Books WHERE book_count>0 ORDER BY book_id ASC");
    $Sth->execute();

    $Result = $Sth->fetchAll();
    //echo "job done";
    return $Result;
  }

  public static function addBookData($book_name, $book_count)
  {

    $db = \DB::get_instance();
    $stmt = $db->prepare("INSERT INTO Books (book_name,book_count) VALUES (?,?)");
    $stmt->execute([$book_name, $book_count]);

    return;
  }

  public static function updateCheckin($Email, $RequestId)
  {
    $db = \DB::get_instance();
    $Data = array($RequestId);

    $Size = sizeof($Data);

    for ($x = 0; $x < $Size; $x++) {


      $Sth = $db->prepare("UPDATE Books_Status SET Status = 'Returned' WHERE Request_ID=?");
      $Sth->execute([$RequestId[$x]]);
    }

    for ($x = 0; $x < $Size; $x++) {

      $Sth = $db->prepare("UPDATE Books INNER JOIN Books_Status USING (book_id) SET book_count = book_count+1 WHERE Request_ID = ?");
      $Sth->execute([$RequestId[$x]]);
    }
  }


  public static function findApproved($Email)
  {
    $db = \DB::get_instance();

    $Sth = $db->prepare("SELECT * FROM Books_Status INNER JOIN Books USING(book_id) WHERE User_Email = ? AND Status='Approved' ORDER BY Request_ID ASC");
    $Sth->execute([$Email]);

    $Result = $Sth->fetchAll();
    //echo "job done";
    return $Result;
  }


  public static function updateRequest($Email, $books_id)
  {
    $db = \DB::get_instance();
    $Data = array($books_id);
    $Size = sizeof($books_id);

    for ($x = 0; $x < $Size; $x++) {

      $Status = "Request";
      $Sth = $db->prepare("INSERT INTO Books_Status (User_Email,Book_ID,Status) VALUES (?,?,?)");
      $Sth->execute([$Email, $books_id[$x], $Status]);
    }
  }


  public static function findChecked()
  {
    $db = \DB::get_instance();

    $Sth = $db->prepare("SELECT * FROM Books_Status INNER JOIN Books USING(book_id) WHERE Status='Approved' ORDER BY Request_ID ASC");
    $Sth->execute();

    $Result = $Sth->fetchAll();

    return $Result;
  }

  public static function findHistory($Email)
  {
    $db = \DB::get_instance();

    $Sth = $db->prepare("SELECT * FROM Books_Status INNER JOIN Books USING(book_id) WHERE User_Email = ? ORDER BY Request_ID ASC");

    $Sth->execute([$Email]);

    $Result = $Sth->fetchAll();
    //echo "job done";
    return $Result;
  }

  public static function findAllRequests()
  {
    $db = \DB::get_instance();

    $Sth = $db->prepare("SELECT * FROM Books_Status INNER JOIN Books USING(book_id) WHERE Status = 'Request' ORDER BY Request_ID ASC");
    $Sth->execute();

    $Result = $Sth->fetchAll();
    //echo "job done";
    return $Result;
  }

  public static function updateRequestAdmin($RequestId, $Status)
  {
    $db = \DB::get_instance();
    $Data = array($RequestId);
    $Size = sizeof($Data);

    if ($Status == "approve") {
      //change status to approved and update book count            
      //changing status

      for ($x = 0; $x < $Size; $x++) {

        $Sth = $db->prepare("UPDATE Books_Status SET Status = 'Approved' WHERE Request_ID=?");
        $Sth->execute([$RequestId[$x]]);
      }

      //upadating count
      for ($x = 0; $x < $Size; $x++) {

        $Sth = $db->prepare("UPDATE Books INNER JOIN Books_Status USING (book_id) SET book_count = book_count-1 WHERE Request_ID = ?");
        $Sth->execute([$RequestId[$x]]);
      }
    } else {

      //change status to approved        
      //changing status
      for ($x = 0; $x < $Size; $x++) {

        $Sth = $db->prepare("UPDATE Books_Status SET Status = 'Denied' WHERE Request_ID=?");
        $Sth->execute([$RequestId[$x]]);
      }
    }
  }
}
