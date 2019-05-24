<?php
/*  @var $help HelperClass */
/**
 * Zentrale Datenbankklasse die alle CRUD Funktionen zur Verfügung stellt. Die eigenen Anwendungsklassen erben diese dann.
 * Hauptsächlich müssen nur die Konstanten kLassenbezogen angepasst werden.<br>Außerdem werden Methode zur automatischen Verarbeitung von Formulardaten zur Verfügung gestellt.
 * @version 1.0
 * @author Markus Nippa<markus.nippa@hs-pforzheim.de.com>
 */
 
class DB{
    /*  @var $core Core */
    /* @var $db PDO */
    /* @var Core::$pdo PDO */
    /* @var $stmt PDOStatement */
    
    /** @var String Legt die SQL-Anweisung für <b><i>create()</b></i> fest.
     */
    const SQL_INSERT='INSERT INTO artikel (m_oid,c_ts,m_ts,Artikelnummer,Bezeichnung,Preis,Preis_c,bild) VALUES (?,?,?,?,?,?,?,?)'; // Nur als Beispiel, wird von Kindklasse überschrieben
     /** @var String Legt die SQL-Anweisung für <b><i>update()</b></i> fest
     */
    const SQL_UPDATE='UPDATE Kunde SET c_ts=?,m_ts=?,Kundennummer=?,Bezeichnung=?,Preis=?,Preis_c=?,bild=? WHERE m_oid=?';
     /** @var String SQL-Anweisung für die <b><i>find()</i/</b>-Methode zur Rückgabe eines einzelnen Objekts anhand der ID.
     */
    const SQL_SELECT_PK='SELECT * FROM Artikel WHERE m_oid=?';
     /** @var String SQL-Anweisung für die <b><i>findAll()</i/</b>-Methode zur Rückgabe aller Objekte einer KLasse.
     */
    const SQL_SELECT_ALL='SELECT * FROM Artikel';
     /** @var String Legt die SQL-Anweisung für <b><i>delete()</b></i> fest (lösch einen Datensatz anhand der ID.
     */
    const SQL_DELETE_PK='DELETE FROM Artikel WHERE m_oid=?';
    /**
     *  @var String Legt den Primärschlüssel einer Klasse fest, meist m_oid
     */
    const SQL_PRIMARY_KEY='m_oid';
    /**
     * @var Array Ordnet Formularfelder bei <b><i>loadFormData()</i></b> den korrekten Attributen zu.
     */
    Public $dataMapping=Array(); // für den Import von Formulardaten
   // Public $dataTypeMapping=Array(); 
    /**
     * @var Array Legt für jedes Attribut fest, gegen welchen Datentyp validiert werden soll. Wird das Attribut nicht aufgeführt wird <b><i>core::$defaultFilterValidate</i></b> verwendet.
     */
    Public $validateMapping=Array();
       /**
     * @var Array Legt für jedes Attribut fest, wie Formulardaten gesäubert(sanitize) werden sollen. Wird das Attribut nicht aufgeführt wird <b><i>core::$defaultFilterSanitize</i></b> verwendet.
     */
    Public $sanitizeMapping=Array();
    /**
     *
     * @var Boolean Gibt an, wie die Validierung beim Mapping damit umgehen soll, wenn Felder gar nicht erst vorhanden sind. Es wird immer NULL zurückgegeben. Wenn <b>true</b> gubt die loadFormadata <i>false/i>  zurück und wirft eine Fehlermeldung aus.</br>Bei <b>false</> wird das Feld überprungen und ein Debughinweis gegeben.
     */
    Public $strictMapping; // wird bei __construct() auf die EEintstellung aus dem Core gesetzt
    
    /**
     * Lädt anhand von <b><i>SQL_SELECT_PK</i></b> die Daten in das aktuelle Objekt. Defacto wird die <b><i>find()</i></b>-Methode und anschließend <b><i>import()</i></b> durchgeführt.
     * @param type $id Wert des Primärschlüssels (Feld in SQL-Anweisung angegeben)
     * @return boolean Gibt true oder false zurück.
     */
    
     public function __construct() {
        $this->strictMapping=Core::$defaultStrictMapping; 
     }
    
    
    
    
    public function loadDBData($id){ 
       $obj=self::find($id);
       
        if(is_object($obj)){
            $this->import($obj);
            return true;    
        }else {
            
            core::addMessage("Kein Datensatz gefunden");
            return false;
        }
    }  
    /**
     * Statisch, gibt ein einzelnes <b>Objekt</> der Klasse zurück anhand von <b><i>SQL_SELECT_PK</i></b> 
     * @param Long $id Wert des Primärschlüssels.
     * @return Object/false
     */
    public static function find($id){  
      $id= filter_var($id,FILTER_VALIDATE_INT);
      if($id==false){
           core::debug("Kein Schlüssel übergeben");
           core::addMessage("Kein Schlüssel übergeben");
           return false;
       }
      $db=Core::$pdo;
      $stmt=$db->prepare(static::SQL_SELECT_PK);
      $result=$stmt->execute([$id]);
      self::stmtDebug($stmt);
      $class=get_called_class();
      if(class_exists($class)){
        $obj=$stmt->fetchObject($class); // Object der aufrufenden Klasse
      }else{
        $obj=$stmt->fetchObject(); // Standardobject
      }                    
      return $obj;
    }
    /**
     * Statisch. Gibt eine Liste/Array von Objekten einer SQL-Anweisung zurück. Wird nichts angegeben, wird <b><i>SQL_SELECT_ALL</i></b> verwendet.<br>Hier kann eine <b>eigene</b> SQL-Anweisung direkt aus der <b>DB</b>-Klasse ausgeführt werden.. Rückgabe-Klasse ist diejenige, die neben <i>FROM</i> steht.
     * @param String $SQL
     * @return Array/false
     */
    public static function findAll($SQL=""){
      if($SQL==""){
          $SQL=static::SQL_SELECT_ALL;
      }
      $db=Core::$pdo;
      $daten[]=array(); 
      $stmt=$db->prepare($SQL);
      $result=$stmt->execute();
      // Debugging und resultierende SQL-Anweisung
      self::stmtDebug($stmt);
      ///
     
      $daten=$stmt->fetchAll(PDO::FETCH_CLASS,get_called_class());
     // $this->import($test);
      return $daten;
    
    }
    /**
     * Legt aus dem aktuellen Objekt einen Datensatz an. Wenn nicht anders angegeben mit <b><i>SQL_INSERT</i></b>. Der erzeugte Primärschlüssel wird im Objekt aktualisiert.<br>Sollten durch SQL (Default-Werte, autotimestamp...) weitere eigene Werte erzeugt worden sein, wird ein erneutes <b><i>loadDBData()</i></b>empfohlen 
     * @param Array $param Ein ordinales Array mit den Feldern in korrekter Reihenfolge. Wenn nicht angegeben, automatisch aus Insert-Anweisung generiert.
     * @param String $SQL ggf. eigene SQL-Anweisung
     * @return Long Die via autoincrement angelegte ID, der letzten Anweisung
     */
    public function create($param=array(),$SQL=""){
      
      $db=Core::$pdo;
      if($SQL==""){
          $SQL=static::SQL_INSERT;
      }
       if(Core::$useTimestamps && property_exists($this, "c_ts") && property_exists($this, "m_ts")){
           
           if(strpos($SQL,"m_ts")===FALSE){
                $SQL= preg_replace('/\(/', '(m_ts, ', $SQL,1);
                $this->m_ts=time();
                 $SQL= str_ireplace('VALUES(', 'VALUES(?,', $SQL);
                 $SQL= str_ireplace('VALUES (', 'VALUES (?,', $SQL);
              }
              if(strpos($SQL,"c_ts")===FALSE){
                $SQL= preg_replace('/\(/', '(c_ts, ', $SQL,1);
                $this->c_ts=time();
                $SQL= str_ireplace('VALUES(', 'VALUES(?,', $SQL);
                 $SQL= str_ireplace('VALUES (', 'VALUES (?,', $SQL);
              }
       }
      
      
      
      
       if($param[0]==""){ // Dann zieht er sich automatisch die Feldnamen aus der Insert Anweisung
         $start=strpos($SQL,"(");
         $ende=strpos($SQL,")");
         $fields=substr($SQL,$start+1,($ende-$start-1));
         $fieldlist=explode(",",$fields);    
         foreach($fieldlist as $field){
           $feld=trim($field);  
           array_push($param,$this->$feld);
         } 
       }
      
       
      $stmt=$db->prepare($SQL);
      $result=$stmt->execute($param);
      
      self::stmtDebug($stmt);
        
       
     $autoID=$db->lastInsertId();
     $col=static::SQL_PRIMARY_KEY;
    $this->$col=$autoID;
      return $autoID;
        
        
        
    }
    /**
     * Aktualisiert die Daten in der Datenbank mit den Werten des aktuellen Objektes. Standardmäßig <b><i>SQL_UPDATE</i></b>
     * @param Array $param  Ordinales Array mit Feldliste, der zu aktualisierenen Feldern.<br> Wenn nicht angegeben, werden die Felder automatisch aus  Der SQL-Anweisung bzw. SQL_UPDATE generiert
     * @param String $SQL
     * @return boolean
     */
    public function update($param=array(), $SQL=""){ // Aktualisiert das aktuelle Element
        $db=Core::$pdo;
        if($SQL==""){
            $SQL=static::SQL_UPDATE;
        
        }
        
        if(Core::$useTimestamps && property_exists($this, "m_ts")){ // m_ts in Anweisung integrieren
            if(strpos($SQL,"m_ts")===FALSE){
                $SQL= str_replace(" WHERE", " ,m_ts=? WHERE", $SQL);
                $this->m_ts=time();
            }
        }
        
         $stmt=$db->prepare($SQL);
     
        if($param[0]==""){     // Aus SET-Anweisung die Felder extrahieren
             $abschnitt=explode('=',$SQL);
    
             foreach($abschnitt as $teil){ 
               $tmp=rtrim($teil); //Fängt ab, falls zwischen Feld un = ein Leerzeichen war
               $pos= strripos($tmp," ");
               $tmp2=substr($tmp,$pos+1);
               $tmp2=ltrim($tmp2,",");
                if($tmp2!=""){
                     array_push($param,$this->$tmp2);
                }
             }
        }

      $result=$stmt->execute($param);
      
     self::stmtDebug($stmt);
     return $result;
    }
    /**
     * Statisch. Löscht einen einzelnen Datensatz
     * @param Long $id Primärschlüsselwert des zu Löschenden Datensatzes auf Grundlage <b><i>SQL_DELETE_PK</i></b>
     * @return boolean
     */
    public static function delete($id){
          $db=Core::$pdo;
          if($id!=""){ 
           $stmt=$db->prepare(static::SQL_DELETE_PK);
           $result=$stmt->execute([$id]);
           return $result;
          }else{
              return false;
          }
     }
     
     /**
      * Führt ein Prepared-SQL-Statement aus(PDO). Es sollte sich um eine Auswahlabfrage handeln, die ein oder mehrere Elemente zurückliefert.<br>Sie werden als Objektarray der aufrufenden Klasse oder als Standard objekte in einem Array zurückgegeben.<br>Standardobjekte beinhalten alle Attribute der Abfrage, aber keine Methoden etc.
      * @param String $SQL SQL-Statement (prepared). Parameter werden über Fragezeichen angegeben, Werte müssen in gleicher Reihenfolge über <b><i>$param</i></b> übergeben werden 
      * @param Array $param Ordinales Array mit den Werten für die SQL Anweisung
      * @return ObjektArray
      */
     public static function query($SQL,$param=array()){
          $db=Core::$pdo;
          $stmt=$db->prepare($SQL);
          $result=$stmt->execute($param);
          self::stmtDebug($stmt);
          $class=get_called_class();
          if(class_exists($class) & $class!="DB"){
             $daten=$stmt->fetchAll(PDO::FETCH_CLASS,$class);
          }else{
             $daten=$stmt->fetchAll(PDO::FETCH_CLASS); 
          }
             
          return $daten;
     }
     
      /**
      * Führt ein Prepared-SQL-Statement als Aktionsabfrage(UPDATE, DELETE etc.) aus(PDO). Als Ergebnis wird true oder false zurückgegeben
      * @param String $SQL SQL-Statement (prepared). Parameter werden über Fragezeichen angegeben, Werte müssen in gleicher Reihenfolge über <b><i>$param</i></b> übergeben werden 
      * @param Array $param Ordinales Array mit den Werten für die SQL Anweisung
      * @return boolean
       * 
      */
     public static function execQuery($SQL,$param=array()){
          $db=Core::$pdo;
          $stmt=$db->prepare($SQL);
          $result=$stmt->execute($param);
          self::stmtDebug($stmt);
          
             
          return $result;
     }
     
     
     
    /**
     * Überträgt Formulardaten direkt in das aktuelle Objekt.<br>Die Zuordnung der Formularfelder zu den Attributen erfolgt über den Parameter <b><i>$mapping</i></b>. Wenn nicht angegeben, wird <b><i>$dataMapping</i></b> der Klasse verwendet.<br>
     * Alle Felder werden automatisch nach den Vorgaben in  <b><i>$sanitizeMapping</i></b> und  <b><i>$validateMapping</i></b> bereinigt und validiert.
     * @param Array $mapping Assoziatives Array mit Attribut=>Formularfeld Paaren (siehe <i>DB::dataMapping</i>)
     * @param String $method POST oder GET
     
     * @return Boolean gibt by Validation-Error false zurück ansonsten true    
     */
     public function loadFormData($mapping=array(),$method="POST"){
         $success=true;
         if(count($mapping)==0){
             $mapping=$this->dataMapping;
            
         }
         foreach($mapping as $fieldname => $value){
           if((isset($_POST[$this->dataMapping[$fieldname]]) || $this->strictMapping==true)){
             if($this->sanitizeMapping[$fieldname]!=""){
                $sanitize= constant($this->sanitizeMapping[$fieldname]);
             }else{
                  $sanitize=constant(Core::$defaultFilterSanitize);
             }
             // SANITIZE
             if($sanitize==FILTER_SANITIZE_NUMBER_FLOAT){  // zusätzlich optionalen Parameter 
                  $wert=filter_var($_POST[$this->dataMapping[$fieldname]],$sanitize,FILTER_FLAG_ALLOW_FRACTION);
             }else{
                $wert=filter_var($_POST[$this->dataMapping[$fieldname]],$sanitize);
             }
             
             if($this->validateMapping[$fieldname]!=""){
                $validate= constant($this->validateMapping[$fieldname]);
                 $wert=filter_var($wert,$validate,FILTER_NULL_ON_FAILURE);
             }
             
             
             
             
             
             if($wert===NULL){
                 $this->$fieldname=NULL;
                
                     Core::debug("Validation Error for {". $fieldname."}");
                    Core::addError("Bitte geben Sie gültige Daten für ´".$fieldname."´an" );
                    $success=false;
                
             }else{
                  
                  $this->$fieldname=$wert;
                  
             }
           }else{
             $this->$fieldname=NULL;  
              Core::debug("Validation Skipped(No Formdata) for {". $fieldname."}");
           }    
         }
         return $success;
     }
     /**
      *  Private Funktion zur Ausgabe von Fehlern während eines Prepared Statements
      * @param PDOStatement $stmt Das zu untersuchende Prepared-Statement-Objekt
      */
     private static function stmtDebug($stmt){
         ob_start();
          $stmt->debugDumpParams();
          $tmp= ob_get_contents();
          $a= strpos($tmp, 'Key: Position');
          $info=substr($tmp,0,$a);
          ob_clean();
          Core::debug($info);
     }
     /**
      * Überträgt die Daten aus einem anderen Objekt in das aktuelle Objekt (clone).<br>Damit kann das Ergebnis einer Abfrage in das aktuelle Objekt übertragen werden.
      * @param type $object Objekt der gleichen Klasse, welche die Methode aufruft
      */
     public function import( $object)
    {   
        
         if(is_array($object)){  // betrifft ggf. Standardobject aus Query
                        foreach (get_object_vars($object[0]) as $key => $value) {
            $this->$key = $value;
            }
            
         }else{   
         foreach (get_object_vars($object) as $key => $value) {
            $this->$key = $value;
        }
         }
    }   
     
    
}


