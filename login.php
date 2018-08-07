<?php
include 'mysqlConect.php';

function generateCode($length=6) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789";
    $code = "";
    $clean = strlen($chars) - 1;
    while (strlen($code) < $length) {
        $code .= $chars[mt_rand(0, $clean)];
    }
    return $code;
  }

  if (isset($_COOKIE['errors']))
  {
      $errors = $_COOKIE['errors'];
      setcookie('errors', '', time() - 60*24*30*12, '/');
  }
  if (isset($_POST[butt]))
   {
     $data = $pdo->query('SELECT id, password FROM users WHERE login ="'. $pdo->quote($_POST['login']) .'" LIMIT 1');
     while ($dataAssoc = $data->fetch())
     {
       if($dataAssoc['password'] == md5(md5(trim($_POST['pass']))))
       {
         header('Location: index.php?users_id=');
         $lastIID = $pdo->query("select LAST_INSERT_ID()");
         $Liid = $lastIID->fetchColumn();
         setcookie("id", $data['id'], time()+60*60*24*30);
         session_start();
         if (isset($_GET['login']))
         {
           $_SESSION['login'] = $_GET['login'];
         }
         if (!isset($_SESSION['login']))
         {
           header('HTTP/1.0 401 Unauthorized');
         }
       }
       else
       {
         echo "Вы ввели неправильный логин/пароль<br>";
       }
     }
   }
   print_r($dataAssoc['id']);
?>

<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <title>Вход</title>
  </head>
  <body>
    <div>
      <form method="POST" action="login.php">
        Логин <input name="login" type="text"><br>
        Пароль <input name="pass" type="password"><br>
        <input name="butt" type="submit" value="Войти">
      </form>
      <form action="regist.php" method="post">
        <input type="submit" name="" value="Регистрация">
      </form>
    </div>
  </body>
</html>

  <?php
  if (isset($errors))
  {
    print '<h4>'.$error[$errors].'</h4>';
  }
?>
