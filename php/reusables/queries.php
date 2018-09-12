<?php

  //Create Queries
  function createQuery($searchField, $searchValue) {
    $user = $searchValue;
    
    if($searchField="username") {
      $splQuery = "SELECT * FROM users WHERE username = :username";
      $statement = $db->prepare($splQuery);
      $statement->execute(array(':username'=>$user));
    } elseif($searchField="id") {
      $splQuery = "SELECT * FROM users WHERE username = :username";
      $statement = $db->prepare($splQuery);
      $statement->execute(array(':username'=>$user));
    } else {
      $message = "No preset query base on that field. Your choices are 'username' or 'id'.";
    }
    return $statement;
  }
            


  

?>