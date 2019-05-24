<?php
Core::$view->path["view1"]="views/view.createmodel.php";

$table=new Table();
$table->tablename=ucfirst(filter_input(INPUT_GET, "tablename"));
$table->cols=$table->listColumns($table->tablename);


if(file_exists("../models/model.".lcfirst($table->tablename).".php")){
    Core::redirect("error",array("errorMsg"=>"Dieses Model existiert bereits"));
 
    
}
$datei = fopen("../models/model.".lcfirst($table->tablename).".php","w");
$txt="<?php \r\nclass ".$table->tablename." extends DB{\r\n";
 fwrite($datei,$txt);
 $txt="// Variablenliste\r\n";
 fwrite($datei,$txt);
 
 
 $fieldlist="";
 $paramlist="";
  $paramlistUpdate="";
  $dataMapping="";
  $primary="";
  $validateFloatTypes=array("float","float unsigned", "double", "double unsigned","decimal", "decimal unsigned");
  $validateIntTypes=array("int(10) unsigned", "int(11)","tinyint(4)","tinyint(3) unsigned","smallint(6)","smallint(5) unsigned","mediumint(9)","mediumint(8) unsigned","bigint(20)","bigint(20) unsigned");
foreach($table->cols as $col){
    $txt="    public $".$col->Field.";\r\n";
   if($col->Field!="ts" && $col->Field!="m_oid"&& $col->Field!="m_ts"&& $col->Field!="c_ts"){
         $fieldlist=$fieldlist."$col->Field".", ";
         $paramlist=$paramlist."?,";
   }
     if($col->Field!="c_ts" && $col->Field!="m_ts" && $col->Field!="ts"){
         $dataMapping=$dataMapping."        '".$col->Field."'=>'".$col->Field."',\r\n";
     }
    if($col->Key=="PRI"){
        $primary=$col->Field;
    }else{
       
        if($col->Field!="ts" && $col->Field!="c_ts" && $col->Field!="m_ts"){
            $paramlistUpdate=$paramlistUpdate.$col->Field."=?, ";
          
        }
    }
    if($col->Field!="m_ts" && $col->Field!="c_ts" && in_array($col->Type,$validateFloatTypes)){
        $validateMapping=$validateMapping."        '".$col->Field."'=>'FILTER_VALIDATE_FLOAT',\r\n";
        $sanitizeMapping=$sanitizeMapping."        '".$col->Field."'=>'FILTER_SANITIZE_NUMBER_FLOAT',\r\n";
    }
     if($col->Field!="m_ts" && $col->Field!="c_ts"  && in_array($col->Type,$validateIntTypes)){
         $validateMapping=$validateMapping."        '".$col->Field."'=>'FILTER_VALIDATE_INT',\r\n";
          $sanitizeMapping=$sanitizeMapping."        '".$col->Field."'=>'FILTER_SANITIZE_NUMBER_INT',\r\n";
    }
    fwrite($datei,$txt);
}
$fieldlist=substr($fieldlist, 0, -2);
$paramlist=substr($paramlist, 0, -1);
$paramlistUpdate=substr($paramlistUpdate, 0, -2);
$dataMapping=substr($dataMapping, 0, -3);
$validateMapping=substr($validateMapping, 0, -3)."\r\n";
$sanitizeMapping=substr($sanitizeMapping, 0, -3)."\r\n";
$txt="\r\n".'    public $dataMapping=array('."\r\n".$dataMapping.");\r\n";
fwrite($datei,$txt);

 $txt="// Konstanten\r\n";
fwrite($datei,$txt);


$txt="    const SQL_INSERT='INSERT INTO ".$table->tablename." ($fieldlist) VALUES ($paramlist)';\r\n";
fwrite($datei,$txt);
$txt="    const SQL_UPDATE='UPDATE ".$table->tablename." SET $paramlistUpdate WHERE $primary=?';\r\n";
fwrite($datei,$txt);
$txt="    const SQL_SELECT_PK='SELECT * FROM ".$table->tablename." WHERE $primary=?';\r\n";
fwrite($datei,$txt);
$txt="    const SQL_SELECT_ALL='SELECT * FROM ".$table->tablename."';\r\n";
fwrite($datei,$txt);
$txt="    const SQL_DELETE='DELETE FROM ".$table->tablename." WHERE $primary=?';\r\n";
fwrite($datei,$txt);
if($primary!=""){
    $txt="    const SQL_PRIMARY='$primary';\r\n";";=?';\r\n";
    fwrite($datei,$txt);  
}

   

$txt="\r\n".'    public $validateMapping=array('."\r\n".$validateMapping."    );\r\n";
fwrite($datei,$txt);
$txt="\r\n".'    public $sanitizeMapping=array('."\r\n".$sanitizeMapping."    );\r\n";
fwrite($datei,$txt);


$txt="}";
fwrite($datei,$txt);
fclose($datei);