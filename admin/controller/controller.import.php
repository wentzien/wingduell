<?php
function exec_sql_from_file($SQL, PDO $pdo) {
    if (! preg_match_all("/('(\\\\.|.)*?'|[^;])+/s", $SQL, $m))
        return;

    foreach($m[0] as $sql){
        if(strlen(trim($sql))){  
                @$r=$pdo->exec($sql);                                           
        }
    }
}
if($_SERVER['HTTP_HOST']!="localhost"){Core::redirect("error",array("errorMsg"=>"Diese Seite kann nur vom Localhost aus aufgerufen werden"));}
    $table=new Table();
Core::$view->path["view1"]="views/view.import.php";
if(count($_POST)>0){
    switch(filter_input(INPUT_POST, "step")){
        Case "weiter":
           Core::$view->path["view1"]="views/view.import2.php"; 
            $tables=$table->listLocalTables(filter_input(INPUT_POST, "database"));
        break;
        Case "2":
            $DBUSER="root";
            $DATABASE=filter_input(INPUT_POST, "database");
            $DBPASSWD="";
            global $username;
            global $hostname;
            global $password;
            global $database;
            
            /* @var $tbl Table */
            if(filter_input(INPUT_POST,"dropall")==1){
               $tables=$table->listTables();
               foreach($tables as $tbl){
                  $SQL="DROP table ".$tbl->tablename;
                  db::execQuery($SQL);
               }

            }     
            
            
            $tables=$table->listLocalTables(filter_input(INPUT_POST,"database"));
             foreach($tables as $tbl){
                 if ($tbl->type == "Enumeration") {
                    $localDB = filter_input(INPUT_POST, "database");
                    $dbuser = "root";
                    $con = new PDO("mysql:host=localhost;dbname=$localDB;charset=utf8", $dbuser);
                    $SQL = "SHOW index FROM " . $tbl->tablename;
                    $stmt = $con->query($SQL);
                    $row= $stmt->fetch();
                    $idx=$row['Key_name'];
                    $SQL = " ALTER TABLE `".$tbl->tablename."` DROP INDEX `$idx`, ADD UNIQUE INDEX `$idx` (`codes`);";
                    
                   $con->exec($SQL);
                }
            }            
            
            
            
            if(filter_input(INPUT_POST,"onlynew")==1){
                   $cmd = "mysqldump -u $DBUSER --skip-add-drop-table --skip-disable-keys  --password=$DBPASSWD $DATABASE  >dump.sql";  
            }else{
                $cmd = "mysqldump -u $DBUSER  --skip-disable-keys  --password=$DBPASSWD $DATABASE  >dump.sql"; 
            }         
            exec($cmd);
            $SQLDump = file_get_contents('dump.sql');
            // ********** ALLE Tabellen im Dumpfile großschreiben, Windwos kennt das nämlic h nicht)
            $offset = 0;
            $results = array();
            $tabellen= array();
            while (($pos = strpos($SQLDump, "CREATE TABLE", $offset)) !== false) {
                $results[] = $pos;
                $offset = $pos+1;
                $start=$pos+15;
                $ende=strpos($SQLDump,'`',$start);
                array_push($tabellen,substr($SQLDump,$start-1,($ende-$start+1))); // Alle Tabellen finden
            }
            foreach($tabellen as $tabelle){
                 $cols=table::listLocalColumns($tabelle,filter_input(INPUT_POST, "database")); // Bei Enumerationen letztes T großschreiben           
                 if($cols[0]->Field=="myval"){
                        if(substr($tabelle, -1)=="t"){
                              $newstring=table::uclast($tabelle);
                              $newstring='`'.ucfirst($newstring).'`';
                        }else{
                             $newstring='`'.ucfirst($tabelle).'`';
                        }                            
                  }else{
                         $newstring='`'.ucfirst($tabelle).'`';
                  }
                  
                 
                  $SQLDump=str_replace('`'.$tabelle.'`', $newstring, $SQLDump);
            }
     

            $SQLDump= str_replace("CREATE TABLE","CREATE TABLE IF NOT EXISTS",$SQLDump);
            
            
            $handle = fopen ("dump5.sql", "w");
            fwrite ($handle, $SQLDump);
            fclose ($handle);
          //  $rs=Core::$pdo->exec($SQLDump);
           exec_sql_from_file($SQLDump, Core::$pdo);
            
            
            if(filter_input(INPUT_POST, "janusclasses")==1){ //Janus Tabellen entfernen               
                $del_tables="Tableerg;Tableoid;Tableproperties;Userlistentries;Userlists;tableerg;tableoid;tableproperties;userlistentries;userlists";
                $del_table=explode(";",$del_tables);
                foreach($del_table as $a){
                             DB::execQuery("DROP TABLE IF EXISTS ".$a)	;
                        }
            }
            if(filter_input(INPUT_POST,"mn")==1){ // mn Tabellen löschen
                $tables=$table->listTables();
                foreach($tables as $tbl){
                    if($tbl->mn==1){
                         DB::execQuery("DROP TABLE ".$tbl->tablename); 
                    }
                }
            }
            
            if(filter_input(INPUT_POST,"null")==1){ // Nullwerte erlauben
                 $tables=$table->listTables();
                 foreach($tables as $tbl){
                       $SQL="SHOW COLUMNS FROM ".$tbl->tablename; // läuft nur mit mysqli
                       $mysql= mysqli_connect( Core::$dbhost, Core::$dbuser, Core::$dbpassword, Core::$dbdatabase);
                       $rs3= mysqli_query($mysql, $SQL);
                       while($row3= mysqli_fetch_array($rs3)){
                             $spalte=$row3[0];
                              if($spalte!="m_oid" && $spalte!="codes"){
                                  $SQL="ALTER TABLE ".$tbl->tablename." MODIFY  `$spalte` ".$row3[1]." NULL";
                                  $rs4= mysqli_query($mysql, $SQL);                       
                              }
                        }
                 }
               }
              
            if(filter_input(INPUT_POST,"auto1")==1) {
                 $tables=$table->listTables();
                 foreach($tables as $tbl){
                    //$SQL="ALTER TABLE ".$tbl->tablename." CHANGE COLUMN `m_oid` `m_oid` int(11) NOT NULL auto_increment";
                    if ($tbl->type == "Anwendungsklasse") {
                        $SQL = "ALTER TABLE " . $tbl->tablename . " ADD PRIMARY KEY (`m_oid`), CHANGE COLUMN `m_oid` `m_oid` int(11) NOT NULL auto_increment";
                        @db::execQuery($SQL);
                    }
                }
             }
            if(filter_input(INPUT_POST,"auto2")==1) {
                 $tables=$table->listTables();
                 foreach($tables as $tbl){
                    if ($tbl->type == "Enumeration") {
                        $SQL="UPDATE `".$tbl->tablename."` SET `codes`=-1 WHERE `codes`=0 "; // Da er mit 0 den Primärschlüssel nicht setzen kann, weil der Wert irgendwie gleichzeiti 1 und 0 ist!?!?
                         Core::$pdo->exec($SQL);
                      $SQL="ALTER TABLE ".$tbl->tablename." ADD PRIMARY KEY (`codes`) , CHANGE COLUMN `codes` `codes` int(11) NOT NULL auto_increment";
                     db::execQuery($SQL);
                     $SQL="UPDATE `".$tbl->tablename."` SET `codes`=0 WHERE `codes`=-1 ";
                         Core::$pdo->exec($SQL);
                    }
                 }
             }
            if(filter_input(INPUT_POST,"autots")==1) {
                 $tables=$table->listTables();
                 foreach($tables as $tbl){
                    $SQL="ALTER TABLE ".$tbl->tablename." ADD COLUMN `ts` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP";
                    @db::execQuery($SQL);
                 }
             }  
        
            Core::$view->path["view1"]="views/view.home.php";
             $tables=$table->listTables();
            break;
        default :
          Core::redirect("error",array("errorMsg"=>"Unbekannter Schritt"))  ;
    } // Ende Switch  
}else // man kommt direkt auf die Seite
{
   $tables=$table->listLocalDatabases(); 
}
Core::$view->tables=$tables;
 

 
 