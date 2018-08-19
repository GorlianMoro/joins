<?php
include 'mysqlConect.php';
$fullTask = $pdo->prepare('select * from tasks');
$fullTask->execute();
$fullUser = $pdo->prepare('select id, login from users');
var_dump($_GET);
var_dump($_POST);

if (isset($_POST['save']))
{
  if (isset($_POST['task']))
  {
    $task = htmlentities($_POST['task']);
  }
  if (!empty($task))
  {
    $insTask = $pdo->prepare("insert into tasks (description, date_added) values ('$task', NOW())");
    $insTask->execute();
    $fullTask->execute();
  }
}

$listid = $pdo->prepare('select id from tasks ');
$listid->execute();

if (isset($_POST['edittask']))
{
  $editas = htmlentities($_POST['edittask']);
}

if (isset($_POST['edit']))
{
  if (!empty($editas))
  {
    $updTask = $pdo->prepare("update tasks set description = $editas where id = $id");
    $updTask->execute();
    $fullTask->execute();
  }
}

if (isset($_POST['drop']))
{
  $dropTask = $pdo->prepare("delete from tasks where id = ");
  $dropTask->execute();
  $fullTask->execute();

}
 ?>

 <!DOCTYPE html>
 <html lang="ru">
   <head>
     <meta charset="utf-8">
     <title>Список дел</title>
     <style>
     table {
            border-collapse: collapse;
        }

        table td, table th {
            border: 1px solid black;
          }
     </style>
   </head>
   <body>
     <h1>Список дел</h1>
     <div>
       <form action="index2.php" method="post">
         <input type="text" name="task" value="" placeholder="Описание задачи">
         <input type="submit" name="save" value="Добавить">
       </form>
     </div>
   <br>
   <table>
     <tbody>
       <tr>
         <th>Описание задачи</th>
         <th>Статус</th>
         <th>Дата добавления</th>
         <th></th>
         <th>Ответственный</th>
         <th>Автор</th>
         <th>Закрепить задачу за пользователем</th>
      </tr>
      <tr>
        <?php foreach ($fullTask as $data): ?>
          <td><?php echo $data['description'] . "<br>"; ?></td>
          <td>
          <?php
          if ($data['is_done'] == 0)
          {
           echo "В процессе";
          } else
          {
           echo "Выполненно";
          }
           ?>
         </td>
          <td><?php echo $data['date_added'] . "<br />"; ?></td>
        <td>
          <form class="" action="index2.php" method="get" name="edit">
            <input type="text" name="edittask" value=""> <br>
            <input type="submit" name="edit" value="Изменить">
            <input type="submit" name="done" value="Выполнить">
            <input type="submit" name="drop" value="Удалить">
          </form>
        </td>
        <td></td>
        <td></td>
        <td></td>
     </tr>
   <?php endforeach; ?>
     </tbody>
   </table>
   </body>
 </html>
