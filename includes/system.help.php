<?php

class Help{
    
  
    
    /**
     * Wandelt Kommazahl ins kaufmännische Format um
     * 
     * Üblicherweis zur Ausgabe in der View
     * @param float $value zu konvertierende Zahl
     * @return String im kaufmännischen Format z.B. 1.234,25 €
     * 
     */
    public static function currency($value)
    {
        return number_format($value,2,",",".")." €";
    }
       /**
     * Wandelt  kaufmännische Format in Kommazahl  mit . für MySQL um
     * 
     * Üblicherweis zur Ausgabe in der View
     * @param String $value Zahl (kaufmännisches Format
     * @return float im MySQL-tauglichen Format 1.234,25 € => 1234.25
     * 
     */
    public static function currencyMySQL($value)
    {
        $temp= str_replace(".","",$value); //entfernt den Tausenderpunkt
        $temp= str_replace(",",".",$temp);
        $temp= filter_var($temp, FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION); // konvertiert in Zahl und entfernt ungültige Zeichen, auch €-Zeichen
        return  $temp; // ersetzt deutsches Komma mit Punkt
      }
    
    
     /**
     * Formatiert einen Boolean Wert mit individuellem Text
     * @param Boolean $value Wert der gerendert werden soll
     * @param String $true optional Anzeige für Wahr
     * @param String $false optional Anzeige für Falsch 
     * @return String im Format z.B. 21.12.2018 
     */
    public static function boolText($value,$true="richtig",$false="falsch"){
        if($value){
            return $true;
        }else{
            return $false;
        }
    }
    
    
    
    
    /**
     * Formatiert einen Timestamp in deutsches Datum 
      * 
      * In PHP bekommt man mittels time() den Zeitstempel der aktuellen Systemzeit
      * Formell handelt es sich bei einem Timestamp um einen Long-Wert
     * @param long $ts Timestamp
     * @return String im Format z.B. 21.12.2018 
     */
    public static function toDate($ts){
        return date('d.m.Y',$ts);    
    }
      /**
     * Formatiert einen Timestamp in deutsches Datum samt Uhrzeit
      * 
      * In PHP bekommt man mittels time() den Zeitstempel der aktuellen Systemzeit
      * Formell handelt es sich bei einem Timestamp um einen Long-Wert
     * @param long $ts Timestamp
     * @return String im Format z.B. 21.12.2018 20:15:37
     */
    public static function toDateTime($ts){
        return date('d.m.Y H:i:s',$ts);    
    }
   
    
     /**
     * Erzeugt eine mit dynamischen Daten gefüllte HTML-Klappbox/Menü (<select>)
      * 
      * Es ist dafür eine Liste(Array) mit Objekten einer Tabelle nötig(z.B: $help->sql_queryList), die über ein entsprechendes model bereitgestellt werden muss.
      * Das Ganze ist  für eine Janus-Enumeration automatisch voreingerstellt, kann aber über Parameter konfiguriert werden. 
      * Standardmäßig wird ein Menü mit dem Namen SELECT erzeugt
      * @param Objectarray $obj Objektarray der Datenbanktabelle/Abfrage
      * @param array $arr folgende Arrayfelder sind zulässig:
      * $name="select";
      * $key="rno";
      * $text="myval";
      * $default="";
      * $class="";
 *
     * @return String HTML-Ausgabe, samt Daten
     */	
	public static function htmlSelect($obj,$arr= [])    {
        $name="select";
        $key="rno";
        $text="myval";
        $default="";
        $class="";
        if(isset($arr['name'])){$name=$arr['name'];}
        if(isset($arr['default'])){$default=$arr['default'];}
        if(isset($arr['key'])){$key=$arr['key'];}
        if(isset($arr['text'])){$text=$arr['text'];}
        if(isset($arr['class'])){$class=$arr['class'];}
        if(isset($arr['label'])){             
        $label=$arr['label'];
        ?> <label for="<?=$name?>"><?=$label?>:</label><?php
        }
        ?><select name="<?=$name?>" id="<?=$name?>" class="<?=$class?>">
         <?php
        foreach($obj as $item){
        ?>
  <option value="<?=$item->$key?>"
    <?php
  if($default!=""){
      if($item->$key==$default){
          echo ' selected="selected"';          
      }
  }
  ?>><?=$item->$text?></option>
      <?php } ?>
</select>
        <?php        
    }
	
  /**
 * Sort a multi-domensional array of objects by key value
 * Usage: usort($array, arrSortObjsByKey('VALUE_TO_SORT_BY'));
 * Expects an array of objects. 
 *
 * @param String    $key  The name of the parameter to sort by
 * @param String 	$order the sort order
 * @return A function to compare using usort
 */ 
public static function  arrSortObjsByKey($key, $order = 'DESC') {
	return function($a, $b) use ($key, $order) {
		// Swap order if necessary
		if ($order == 'DESC') {
 	   		list($a, $b) = array($b, $a);
 		} 
 		// Check data type
 		if (is_numeric($a->$key)) {
 			return $a->$key - $b->$key; // compare numeric
 		} else {
 			return strnatcasecmp($a->$key, $b->$key); // compare string
 		}
	};
} 
    
  /**
     * Erzeugt eine mit dynamischen Daten gefüllte HTML-Radioboxgruppe (<select>)
      * 
      * Es ist dafür eine Liste(Array) mit Objekten einer Tabelle nötig(z.B: $help->sql_queryList), die über ein entsprechendes model bereitgestellt werden muss.
      * Das Ganze ist  für eine Janus-Enumeration automatisch voreingerstellt, kann aber über Parameter konfiguriert werden. 
      * Standardmäßig wird ein Menü mit dem Namen <b>radio</b> erzeugt
      * @param Objectarray $obj Objektarray der Datenbanktabelle/Abfrage
      * @param array $arr folgende Arrayfelder sind zulässig:
      *  $name="radio";
      *  $label="radio";
      *  $key="codes";
      *  $text="myval";
      *  $default="";
      *  $class="";
      *  $type="button"; // button, buttonmini, radio, radiomini
     * @return String HTML-Ausgabe, samt Daten
     */	  
    
    
 
   public static function htmlRadioGroup( $obj, $arr= [] ){
        $name="radio";
        $label="radio";
        $key="codes";
        $text="myval";
        $default="1";
        $class="";
        $type="button"; // button, buttonmini, radio, radiomini
        if(isset($arr['name'])){$name=$arr['name'];}
        if(isset($arr['default'])){$default=$arr['default'];}
        if(isset($arr['key'])){$key=$arr['key'];}
        if(isset($arr['text'])){$text=$arr['text'];}
        if(isset($arr['class'])){$class=$arr['class'];}
        if(isset($arr['label'])){$label=$arr['label'];}
        if(isset($arr['type'])){$type=$arr['type'];}
       
        ?>

 <fieldset data-role="controlgroup" <?php        
           switch($type){
               case "button":
                   echo' data-type="horizontal"';
                   break;
               case "buttonmini":
                     echo' data-type="horizontal" data-mini="true"';
                   break;
               case "radio":
                   break;
               case "radiomini":
                    echo' data-mini="true"';
                   break;
               default:
                 echo' data-type="horizontal"';   
           }                    
          ?> >                  
       <legend><?=$label?></legend>
         <?php
         $i=0;
        foreach($obj as $radio){
        $i++ ;?>
       <input type="radio" checked="checked" name="<?=$name?>" id="<?=$name.$i?>" value="<?=$radio->$key?>" <?php  if($default!=""){
        if($radio->$key == $default){echo ' checked="checked"';}}
      ?>>
        <label for="<?=$name.$i?>"><?=$radio->$text?></label>
       
        <?php        
    } ?>
    </fieldset>
    <?php
   }       
    
}