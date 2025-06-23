<?php

  require_once('constants.php');
  require_once('Routeur/response.php');

/**
 * Create the connection to the database.
 * @return PDO|false
 */
  function dbConnect()
  {
    try
    {
      $db = new PDO('pgsql:host='.DB_SERVER.';port='.DB_PORT.';dbname='.DB_NAME, DB_USER, DB_PASSWORD);
      $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (PDOException $exception)
    {
      error_log('Connection error: '.$exception->getMessage());
      return false;
    }
    return $db;
  }

/** 
 * Exemple
 */

  function getUser($db, $id){
  // echo $id;
  $query = $db->prepare('SELECT * FROM Users WHERE id_user = :id_user');
  $query->execute(array(':id_user' => $id));
  $result = $query->fetch(PDO::FETCH_ASSOC);

  return $result;
}
