<?php
  require_once 'login.php';
  $conne = new mysqli($hn, $un, $pw, $db);

  if ($conne->connect_error) die("Fatal Error");

  if (isset($_SERVER['PHP_AUTH_USER']) &&
      isset($_SERVER['PHP_AUTH_PW']))
  {
    $un_temp = mysql_entities_fix_string($conne, $_SERVER['PHP_AUTH_USER']);
    $pw_temp = mysql_entities_fix_string($conne, $_SERVER['PHP_AUTH_PW']);
    $query   = "SELECT * FROM users WHERE username='$un_temp'";
    $result  = $conne->query($query);

    if (!$result) die("User not found");
    elseif ($result->num_rows)
    {
      $row = $result->fetch_array(MYSQLI_NUM);

      $result->close();

      if (password_verify($pw_temp, $row[3]))
      {
        session_start();
        $_SESSION['forename'] = $row[0];
        $_SESSION['surname']  = $row[1];
        echo
        htmlspecialchars("$row[0] $row[1] :
        Hi $row[0], you are now logged in as '$row[2]'");
        die ("<p><a href='continue.php'>Click hear to continue</a></p>");
      }
      else die("Invalid username and password combination");
    }
      else die("Invalid username and password combination");
  }
    else
    {
      header('WWW-Authenticate: Basic realm="Restricted Area"');
      header('HTTP/1.0 401 Unauthorized');
      die ("Please enter username and password");
    }

    $conne->close();

    function mysql_entities_fix_string($conne, $string)

    {
      return htmlentities(mysql_fix_string($conne, $string));
    }
    function mysql_fix_string($conne, $string)
    {
      if (get_magic_quotes_gpc()) $string = stripslashes($string);
      return $conne->real_escape_string($string);
    }
?>