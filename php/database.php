<?php
/**
 * \\Author: Thibault Napoléon "Imothep"
 * \\Company: ISEN Yncréa Ouest
 * \\Email: thibault.napoleon@isen-ouest.yncrea.fr
 * \\Created Date: 20-Apr-2023 - 16:46:23
 * \\Last Modified: 20-Apr-2023 - 17:06:46
 */

  require_once('constants.php');

  //----------------------------------------------------------------------------
  //--- dbConnect --------------------------------------------------------------
  //----------------------------------------------------------------------------
  // Create the connection to the database.
  // \return False on error and the database otherwise.
  function dbConnect()
  {
    try
    {
      $db = new PDO('mysql:host='.DB_SERVER.';dbname='.DB_NAME.';charset=utf8',
        DB_USER, DB_PASSWORD);
      $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
    }
    catch (PDOException $exception)
    {
      error_log('Connection error: '.$exception->getMessage());
      return false;
    }
    return $db;
  }

  //----------------------------------------------------------------------------
  //--- dbGetChannels ----------------------------------------------------------
  //----------------------------------------------------------------------------
  // Get channels list.
  // \param db The connected database.
  // \return The list of channels.
  function dbGetChannels($db)
  {
    try
    {
      $statement = $db->query('SELECT * FROM channels');
      $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    catch (PDOException $exception)
    {
      error_log('Request error: '.$exception->getMessage());
      return false;
    }
    return $result;
  }

  //----------------------------------------------------------------------------
  //--- dbGetMessages ----------------------------------------------------------
  //----------------------------------------------------------------------------
  // Get messages of a specified channel.
  // \param db The connected database.
  // \param channelId The id of the requested channel.
  // \return The messages list for the requested channel.
  function dbGetMessages($db, $channelId)
  {
    try
    {
      $request = 'SELECT m.message, u.nickname FROM messages m';
      $request .= ' JOIN users u ON m.userLogin=u.login';
      if ($channelId != MAIN_CHANNEL)
        $request .= ' WHERE m.channelId=:channelId';
      $request .= ' ORDER BY m.timestamp DESC LIMIT '.MAX_MESSAGES;
      $statement = $db->prepare($request);
      if ($channelId != MAIN_CHANNEL)
        $statement->bindParam(':channelId', $channelId, PDO::PARAM_INT);
      $statement->execute();
      $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    catch (PDOException $exception)
    {
      error_log('Request error: '.$exception->getMessage());
      return false;
    }
    return $result;
  }

  //----------------------------------------------------------------------------
  //--- dbAddMessage -----------------------------------------------------------
  //----------------------------------------------------------------------------
  // Add a message to a specified channel.
  // \param db The connected database.
  // \param message The message to add.
  // \param login The login of the user that post the message.
  // \param channelId The id of the requested channel.
  // \return True on success, false otherwise.
  function dbAddMessage($db, $message, $login, $channelId) {
    try {
      $request = 'INSERT INTO messages(userLogin, channelId, message)
        VALUES(:login, :channelId, :message)';
      $statement = $db->prepare($request);
      $statement->bindParam(':login', $login, PDO::PARAM_STR, 20);
      $statement->bindParam(':channelId', $channelId, PDO::PARAM_INT);
      $statement->bindParam(':message', $message, PDO::PARAM_STR, 256);
      $statement->execute();
      return dbGetMessages($db, $channelId);      
    }
    catch (PDOException $exception) {
      error_log('Request error: '.$exception->getMessage());
      var_dump($exception->getMessage());
      return false;
    }
    return true;
  }
?>
