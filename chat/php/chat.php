<?php
/**
 * \\Author: Thibault Napoléon "Imothep"
 * \\Company: ISEN Yncréa Ouest
 * \\Email: thibault.napoleon@isen-ouest.yncrea.fr
 * \\Created Date: 20-Apr-2023 - 16:46:23
 * \\Last Modified: 20-Apr-2023 - 17:06:21
 */

  require_once('database.php');

  // Enable all warnings and errors.
  ini_set('display_errors', 1);
  error_reporting(E_ALL);

  // Database connection.
  $db = dbConnect();
  if (!$db)
  {
    header('HTTP/1.1 503 Service Unavailable');
    exit;
  }
  
  // Handle channels request.
  $request = @$_GET['request'];
  if ($request == 'channels')
    $data = dbGetChannels($db);

  // Handle messages request.
  if ($request == 'messages'){
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
      if (isset($_GET['channel_id'])) {
        $data = dbGetMessages($db, intval($_GET['channel_id']));
      }
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      if (isset($_POST['channel_id']) && isset($_POST['message'])) {
        $data = dbAddMessage($db, $_POST['message'], $_POST['login'], intval($_POST['channel_id']));
      } else {
        echo 'Error';
      }
    }
  }

  // Send response to the client.
  if (isset($data))
  {
    switch (@$_GET['type'])
    {
      case 'html':
        header('Content-Type: text/html; charset=utf-8');
        echo '<h1><u>Données au format HTML</u></h1><hr>';
        echo '<table border="1">';
        foreach (array_keys($data[0]) as $key)
          echo '<th>'.$key.'</th>';
        foreach ($data as $line)
        {
          echo '<tr>';
          foreach (array_values($line) as $value)
            echo '<td>'.$value.'</td>';
          echo '</tr>';
        }
        echo '</table>';
        break;
      case 'csv':
        header('Content-Type: text/plain; charset=utf-8');
        echo implode(',', array_keys($data[0])).PHP_EOL;
        foreach ($data as $line)
          echo implode(',', array_values($line)).PHP_EOL;
        break;
      default:
        header('Content-Type: application/json; charset=utf-8');
        header('Cache-control: no-store, no-cache, must-revalidate');
        header('Pragma: no-cache');
        header('HTTP/1.1 200 OK');
        echo json_encode($data);
    }
  }
  else
    header('HTTP/1.1 400 Bad Request');
  exit;
?>
