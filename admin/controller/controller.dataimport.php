<?php
 $table=new Table();
function exec_sql_from_file($SQL, PDO $pdo) {
 
    $n=preg_split('/\n|\r/', $SQL, -1, PREG_SPLIT_NO_EMPTY);


    foreach ($n as $sql) {
        if (strlen(trim($sql)))
            $pdo->exec($sql);
    }
}
if($_SERVER['HTTP_HOST']=="localhost"){Core::redirect("error",array("errorMsg"=>"Diese Seite kann nur vom Live-Server aus aufgerufen werden"));}


Switch(filter_input(INPUT_GET,"step")){
    
    Case "delete":
        $datei=filter_input(INPUT_GET,"id");
        unlink("files/".$datei);
        $file=new sqlData();
        $liste=$file->findAll();
        Core::addMessage("Datei erfolgreich gelöscht");
        Core::$view->path["view1"]="views/view.dataimport.php";
        break;
    Case "import":
        $datei=filter_input(INPUT_GET,"id");
         $SQLDump = file_get_contents("files/".$datei);
     /* try{
         Core::$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, 0);
        Core::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $rs=Core::$pdo->exec($SQLDump);
      }
      catch (PDOException $e){
            Core::debug( "DataBase Errorz: " .$e->getMessage());
       }
      * 
      * 
      * 
      */
  
         
     exec_sql_from_file($SQLDump, Core::$pdo);
        $tables=$table->listTables();
        Core::$view->tables=$tables;
        Core::addMessage("Erfolgreich");
        
        Core::$view->path["view1"]="views/view.home.php";
      //  Core::redirect("home", array("message"=>"Die Daten wurden erfolgreich importiert"));
        break;
    default:
        $file=new sqlData();
        $liste=$file->findAll();
        Core::$view->path["view1"]="views/view.dataimport.php";
}

Core::$view->liste=$liste;
 
 