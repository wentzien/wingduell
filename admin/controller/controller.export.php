<?php
if($_SERVER['HTTP_HOST']=="localhost"){Core::redirect("error",array("errorMsg"=>"Diese Seite kann nur vom Live-Server aus aufgerufen werden"));}

 $table=new Table();
Core::$view->path["view1"]="views/view.home.php";

global $username;
global $hostname;
global $password;
global $database;
$tables=$table->listTables();
$dateiname="files/data_".time()."_".$table->tables."-".$table->enums."-0_.sql";
$cmd = "mysqldump -u $username -t --insert-ignore --skip-add-locks --skip-disable-keys --complete-insert --password=$password $database >$dateiname";

exec($cmd);

// Core::addError($cmd);
Core::addMessage("Backupdatei $dateiname wurde erstellt");

$tables=$table->listTables();
  
Core::$view->tables=$tables;
 

 
 