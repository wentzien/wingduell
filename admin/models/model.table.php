<?php /*  @var $help HelperClass
 
 * 
 *  */

class Table extends DB{
    
  const SQL_INSERT_AUTOINCREMENT='';
  const SQL_UPDATE='';
  const SQL_SELECT_PK='';
  const SQL_SELECT_ALL='SHOW TABLES';
  const SQL_DELETE='';
    
    
  public $tablename;
  public $type;
  public $colNumber;
  public $cols=array();
  public $data=array();
  public $model=false;
  public $tables=0;
  public $enums=0;
  public $mn=0;
  public static function uclast($str) {
    return strrev(ucfirst(strrev($str)));
}
  public function rename(){
      $old=$this->tablename;
      $this->tablename= ucfirst($this->tablename);
      db::execQuery("DROP TABLE IF EXISTS ".$this->tablename);
      db::execQuery("RENAME TABLE $old TO ".$this->tablename);
      
  }
  public function renameLocal($database){
      $dbuser="root";
      $con=new PDO("mysql:host=localhost;dbname=$database;charset=utf8",$dbuser);
     
      
      $old=$this->tablename;
      $this->tablename= ucfirst($this->tablename);
     // $con->query("DROP TABLE IF EXISTS ".$this->tablename);
     $con->query("RENAME TABLE $old TO ".$this->tablename);
      
  }
  
  
  
  
          

 public function listTables(){
     global $database;
     /* @var $tbl Table */
     $this->tables=0;
     $this->enums=0;
     $this->mn=0;
     $list=$this->findAll();
     $del_tables="Tableerg;Tableoid;Tableproperties;Userlistentries;Userlists;tableerg;tableoid;tableproperties;userlistentries;userlists";
     $del_table=explode(";",$del_tables);
     foreach($list as $tbl){
          $tbl->type="m:n or unknown";
          $tbl->mn=1;
         $tmp="Tables_in_".$database;
         $tbl->tablename=$tbl->$tmp;
         $cols=$this->listColumns($tbl->tablename);
         $tbl->cols=$cols;
         $filename="model.".lcfirst($tbl->tablename).".php";
         if(file_exists("../models/".$filename)){$tbl->model=true;}
         foreach($del_table as $a){
		if ($a==$tbl->tablename){
                     $tbl->type="janusspezifische -> obsolet";
                      $tbl->mn=0;
		}
	 }     
         if($cols[0]->Field=="m_oid"){
             $tbl->type="Anwendungsklasse";
             $this->tables++;
              $tbl->mn=0;
         }
         if($cols[0]->Field=="myval"){
             $tbl->type="Enumeration";
             $this->enums++;
             $tbl->mn=0;
         }
         
         $tbl->data=db::query("SELECT * FROM ".$tbl->tablename);
      }
     return $list;
 }
 
 public function listLocalTables($database){
      $dbuser="root";
     $con=new PDO("mysql:host=localhost;dbname=$database;charset=utf8",$dbuser);
      $stmt=$con->query("SHOW TABLES");
      $list=array();
      while ($tmp=$stmt->fetchObject()){
          array_push($list,$tmp);
      }
     /* @var $tbl Table */
    // $list=$this->findAll();
     $del_tables="tableerg;tableoid;tableproperties;userlistentries;userlists";
     $del_table=explode(";",$del_tables);
    
     foreach($list as $tbl){
         $tbl->type="m:n or unknown";
         $tmp="Tables_in_".$database;
         $tbl->tablename=$tbl->$tmp;
         $cols=$this->listLocalColumns($tbl->tablename,$database);
          $tbl->cols=$cols;
         foreach($del_table as $a){
		if ($a==$tbl->tablename){
                     $tbl->type="janusspezifische -> obsolet";
		}
	 }     
         if($cols[0]->Field=="m_oid"){
             $tbl->type="Anwendungsklasse";
         }
         if($cols[0]->Field=="myval"){
             $tbl->type="Enumeration";
         }
      }
      usort($list, Help::arrSortObjsByKey('type','ASC'));
      
     return $list;
 }
 
 
 
 
 
 
    public function listLocalDatabases(){
    $dbuser="root";
    $a=array();
    $tbl=new table();
    
    $dbpassword="";
    $con=new PDO("mysql:host=localhost;",$dbuser);
    $dbs=$con->query("SHOW DATABASES");
   while( ( $db = $dbs->fetchColumn( 0 ) ) !== false )
{
     $tbl=new table();
     $tbl->tablename=$db;
   
     if($db!="information_schema" && $db!="mysql" && $db!="test" && $db!="performance_schema"){
            array_push($a,$tbl) ;
     }
}
    return $a;
    
    }
 
 
 
    public static function listColumns($tablename)    {
        $SQL="SHOW COLUMNS FROM $tablename";
        $cols=DB::query($SQL);
        return $cols;
    }
    public static function listLocalColumns($tablename,$database)    {
       $dbuser="root";
        $SQL="SHOW COLUMNS FROM $tablename";
        $con=new PDO("mysql:host=localhost;dbname=$database;charset=utf8",$dbuser);
      $stmt=$con->query($SQL);
        $cols=array();
      while ($tmp=$stmt->fetchObject()){
          array_push($cols,$tmp);
      }
        return $cols;
    }
}