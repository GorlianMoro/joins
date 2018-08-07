<?php
include 'mysqlConect.php';

if (isset($_POST['description']))
{
    $desc = htmlentities($_POST['description']);
}
if (!empty($desc)) {
    $sql = $pdo->exec("insert into tasks (description, date_added) values ('$desc', NOW())");
}
$fulldesc = $pdo->query("select * from tasks");
 ?>

 <!DOCTYPE html>
 <html lang="ru">
   <head>
     <meta charset="utf-8">
     <title>Список дел</title>
     <style>
       table {
        border: 2px solid black;
        text-align: center;
      }
      td {
       border: 1px solid black;
     }
     </style>
   </head>
   <body>
     <h1>Список дел</h1>
     <div style="float: left">
       <form action="index.php" method="post">
         <input type="text" name="description" value="" placeholder="Описание задачи">
         <input type="submit" name="save" value="Добавить">
       </form>
     </div>
     <div style="float: left; margin-left: 25px;">
       <form class="" action="index.php" method="post">
         <label for="sort"></label>
         <select name="sort_by">
           <option value="data_created">Дате добавления</option>
           <option value="is_done">Статусу</option>
           <option value="description">Описанию</option>
         </select>
         <input type="submit" name="sort" value="Отсортировать">
       </form>
     </div>
     <div style="clear: both">
     </div>
   <br>
     <table>
       <tbody>
         <tr>
           <th>Описание задачи</th>
           <th>Статус</th>
           <th>Дата добавления</th>
           <th></th>
         </tr>
         <tr>

           <?php
           while ($row = $fulldesc->fetch()) {
     ?>
             <td><?php echo $row['description'] . "<br />"; ?></td>
             <td><?php echo $row['is_done'] . "<br />";
             if ($row['is_done'] == 0) {
               echo "В процессе";
             } else {
               echo "Выполненно";
             }
             ?></td>
             <td><?php echo $row['date_added'] . "<br />"; ?></td>
             <td>
               <form class="" action="<?echo $row['id']?>" method="post" name="edit">
                 <input type="text" name="descr" value=""> <br>
                 <a href="index.php?id=<?echo $row['id']?>&action=edit">Изменить</a>
               </form>
               <form class="" action="index.php" method="get" name="done">
                 <a href="index.php?id=<?echo $row['id'];?>&action=done">Выполнить</a>
               </form>
               <form class="" action="index.php<?php echo "action=delete"; ?>" method="post" name="drop">
                 <a href="index.php?id=<?echo $row['id'];?>&action=delete">Удалить</a>
               </form>
            </td>
         </tr>
         <?php
         $id = $_GET['id'];
         if (isset($_GET['id'])) {
           $id = htmlentities($_GET['id']);
         }
         if (isset($_POST['edit'])) {
           $descr = htmlentities($_POST['edit']);
         }
         if (!empty($descr)) {
           $edit = $pdo->query("update tasks set description = $descr where id = $id");
         }

         $done = $_GET['is_done'];
         if (empty($_GET['is_done'])) {
           $isdone = $pdo->query("update tasks set is_done = 1 where id = $id");
         }

         if (empty($_POST['drop'])) {
           $drop = $pdo->query("delete from tasks where id = $id");
         }
 }
var_dump($_GET);
var_dump($_POST);
 ?>
       </tbody>
     </table>
   </body>
</html>
