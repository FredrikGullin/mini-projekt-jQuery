<!DOCTYPE html>
<html>

<head>
   <title>jQuery UI Sortable - Example</title>
   <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
   <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
   <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

   <!-- TODO: Lägg till styles -->
   <style>
      body{
         background: #00001B;
         display: inline-flex;
      }
      .lists{
         width: 30em;
         padding: 2em;
      }
      .lists h3{
         margin-right: 2.5em;
         text-align: center;
         font-family: monospace;
         font-size: 2rem;
         color: #F0F0F0;
      }
      .lists ul{
         list-style: none;
         background-image: linear-gradient(to right, white, #EDD94C);
         border: 0px solid black;
         border-radius: 10px;
         padding: 1em;
         margin: 1em;
         width: 20em;
         height: 50vh;
      }
      .lists ul li{
         background: #C40233;
         color: white;
         padding: .5em;
         margin: .5em;
         margin-top: .8em;
         border: 1px solid white;
         border-radius: 10px;
         box-shadow: 5px 10px #00001B;
         font-family: sans-serif;
         font-size: 1.1rem;
         font-weight: bold;
      }
      .lists ul li:hover{
         background: red;
         transform: scale(1.1);
         transition: .5s;
      }
   </style>

   <!-- TODO: lägg till JQuery för att connecta de olika listorna 
   och för att posta id och state till "/api/update_tasks.php" --> 
   <script>
      $(function() {
          $("#todo, #doing, #done").sortable({
            connectWith: "ul",
            revert: true,
            revertDuration: 100,

            receive: function(event, ui) {
               var id = ui.item.attr('id');
               var state = this.id;

               console.log($(ui.item).attr('id'));
               console.log(this.id);

               $.post("/api/update_tasks.php",
               {
                  id:id,
                  state:state
               });
            }
          }).disableSelection();
      });
   </script>
</head>

<?php
require("includes/conn_mysql.php");
require("includes/tasks_functions.php");

$connection = dbConnect();
$allTodos = getAllTodos($connection);
$allDoing = getAllDoing($connection);
$allDone = getAllDone($connection);

dbDisconnect($connection);
?>

<body>

<div class="lists">
   <h3>Todo-list</h3>
   <ul id="todo">
      <?php
      foreach ($allTodos as $item) {
         print('<li class="default" ');
         print('id="');
         print($item['id'] . '">');
         print($item['name']);
         print('</li>');
      }
      ?>
   </ul>
</div>
<div class="lists">
   <h3>Doing-list</h3>
   <ul id="doing">
      <?php
      foreach ($allDoing as $item) {
         print('<li class="default" ');
         print('id="');
         print($item['id'] . '">');
         print($item['name']);
         print('</li>');
      }
      ?>
   </ul>
</div>
<div class="lists">
   <h3>Done-list</h3>
   <ul id="done">
      <?php
      foreach ($allDone as $item) {
         print('<li class="default" ');
         print('id="');
         print($item['id'] . '">');
         print($item['name']);
         print('</li>');
      }
      ?>
   </ul>
</div>
</body>

</html>