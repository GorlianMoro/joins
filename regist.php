<?php
include 'mysqlConect.php';
if (isset($_POST['registr'])) {
	$err = array();
	if(!preg_match("/^[a-zA-Z0-9]+$/", $_POST['name']))
	{
		$err[] = "Логин может состоять только из букв латинского алфавита и цифр";
	}
	if(strlen($_POST['name']) < 3 or strlen($_POST['name']) > 30)
	{
		$err[] = "Логин должен быть  не меньше 3-х символов и не больше 30";
	}

	if (isset($_POST['name']))
	{
		$login = htmlentities($_POST['name']);
	}
	if (isset($_POST['pass']))
	{
		$password = htmlentities($_POST['pass']);
	}
	$password = md5(md5(trim($_POST['pass'])));
	if (count($err) == 0) {
				$reg = $pdo->prepare("insert into users (login, password) values ('$login', '$password')");
				$reg->execute();
	}
}
$lastInsID = $pdo->query("select LAST_INSERT_ID()");
$lastindiid = $lastInsID->fetchColumn();
 ?>

 <!DOCTYPE html>
 <html lang="ru">
   <head>
     <meta charset="utf-8">
     <title>Регистрация</title>
   </head>
   <body>
     <form class="" action="regist.php" method="post">
       <input type="text" name="name" value="" placeholder="Имя">
       <input type="password" name="pass" value="" placeholder="Пароль">
       <input type="submit" name="registr" value="Зарегистрироваться">
     </form>
     <a href="login.php">Вернутся на главную страницу</a><br>
   </body>
 </html>

 <?php
 if (isset($err)){
	 if (count($err) !== 0) {
		print "<b>При регистрации произошли ошибки:</b><br>";
		foreach($err as $erro)
		{
			echo $erro."<br>";
		}
	 }
	}
  ?>
