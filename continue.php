<?php //страница пример для продолжения сесии две переменные с глобального массива
  session_start();

  if (isset($_SESSION['forename']))
  {
    $forename = $_SESSION['forename'];
    $surname  = $_SESSION['surname'];

    echo "Welcome back, $forename.<br>
    Your full name $forename $surname.<br>";
  }
  else echo "Please, <a href='authenticate2.php'>click hear to enter</a>.";
?>