<?php

Core::$view->path["view1"]="views/view.home.php";
$table=new Table();
$tables=$table->listTables();
  
Core::$view->tables=$tables;