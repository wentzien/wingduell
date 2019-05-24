<style>
    #localTable li, #localTable th {
     border-style: none;  
     padding-bottom: 10px;
     padding-top: 0px;
    }
    #localTable ul li ul li:nth-child(even){
        background-color: #eeeeee;
    }
</style>
<?php
 /* @var $user User */
/* @var $tbl Table */
$tables=Core::$view->tables;
?>
<h2>Datenbank: <?=filter_input(INPUT_POST,"database"); ?></h2>
<p>
              Datenbank übertragen. Alle Daten außer Daten, die bereits im Modell stehen, werden gelöscht. Über Im-/Export können alte Daten wiederhergestellt werden
</p>
<form name="database" id="database" method="post" action="?task=import" data-ajax="false">
	<div class="ui-field-contain">
            
              <label ><input type="checkbox" name="auto1" checked="checked" value="1" data-mini="true"/>Autowerte in Anwendungsklassen</label>
              

              <label>Autowerte in Elementarklassen <input type="checkbox" name="auto2" checked="checked" value="1" data-mini="true"/></label>
               <label>Lesbaren Autotimestamp <input type="checkbox" name="autots" checked="checked" value="1" data-mini="true"/></label>          
            <label> <input type="checkbox" name="null" checked="checked" value="1" data-mini="true"/>Nullwerte zulassen generell setzen (empfohlen)</label>
             
         
       
          <label><input type="checkbox" name="janusclasses" checked="checked" value="1" data-mini="true"/>Januseigene Tabellen ignorieren</label>
           <label><input type="checkbox" name="mn" checked="checked" value="1" data-mini="true"/> m:n (=>janus) und unbekannte Tabellen entfernen(Standard, außer bei bewusster Nutzung)</label>
            <label><input type="checkbox" name="onlynew"  value="1" data-mini="true"/>Nur neue Tabellen. Bereits vorhandene Tabellen beleiben unberührt</label>
                  <label><input type="checkbox" name="dropall"  value="1" data-mini="true"/>Alle Tabellen der Datenbank vorab löschen</label>
       
        
            <input type="hidden" name="database" value="<?=filter_input(INPUT_POST,"database"); ?>">
        <button type="submit" name="step" id="step" value="2">ausführen</button>
	</div>
</form>
<h3>Tabelleninfos Lokale Datenbank (Rational Rose/ Janus)</h3>
<table data-role="table" id="localTable" data-mode="reflow" class="ui-responsive">
  <thead>
    <tr>
      <th data-priority="1">Tabelle</th>
      <th data-priority="persist">Typ</th>
      
      
    </tr>
  </thead>
  <tbody>
<?php
 
foreach($tables as $tbl){?>
      <tr>
          <td><ul data-role="listview" data-inset="false" data-shadow="false" data-mini="true">
  <li data-role="collapsible" data-iconpos="right" data-inset="false"  data-mini="true">
      <h2><?=$tbl->tablename?></h2>
    <ul data-role="listview" data-theme="a" data-mini="true"><?php foreach($tbl->cols as $column){echo'<li data-mini="true"><b>'.$column->Field.'</b>  ('.$column->Type.')</li>';}?></ul>
  </li> </ul> </td><td><?=$tbl->type?></td>
          
      </tr>
<?php } ?>
          
</tbody>
</table>





