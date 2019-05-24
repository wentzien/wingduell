<?php
// Models
/* @var $kunde Kunde */

$User=Core::$view->User;
?>


  <fieldset class="ui-grid-b">

    <div class="ui-block-a"></div>
    <div class="ui-block-b"><center><h3>Wähle deine zwei Kategorien!</h3></center></div>
    <div class="ui-block-c"></div>
</fieldset> 






<?php
$spiel= new Spiel();
$SpielID = filter_input(INPUT_POST, "annehmen",FILTER_SANITIZE_NUMBER_INT);
$SQL="SELECT Kategorie
From Spiel
inner join Runde on Runde.to_Spiel=$SpielID
inner join Fragen on Runde.to_Fragen=Fragen.m_oid
group by Kategorie";
$katgewaehlt=$spiel->findAll($SQL);

$erstekat = $katgewaehlt[0]->Kategorie;
$zweitekat = $katgewaehlt[1]->Kategorie;
$kategorien = KategorieT::findAll("SELECT * FROM KategorieT WHERE codes <> $erstekat AND codes <> $zweitekat");

foreach($kategorien as $item){
 $i++; 
 $katname = $kategorien[$i-1]->myval;

 $katid= $kategorien[$i-1]->codes;
?>
<form id="newgame" method="post" action="?task=besteatigen" data-ajax="false" name="Form">
  


	
<fieldset class="ui-grid-b">

    <div class="ui-block-a"></div>
    <div class="ui-block-b">      <label>
  <input type="checkbox" name="Kategorienwahl[]" value="<?=$katid?>" data-theme="h">
  <?=$katname?></label></div>
    <div class="ui-block-c"></div>
</fieldset>   
             
        
        
<?php
        }
        
?>
  <br>
  
  
  <fieldset class="ui-grid-b">

    <div class="ui-block-a"></div>
    <div class="ui-block-b"><br><center><button type="submit" name="randomgame" value="1" data-theme="k" class="ui-btn">Herrausforderung annehmen</button></center></div>
    <div class="ui-block-c"></div>
</fieldset>   
  
  <input type="hidden" name="spiel" value="<?= filter_input(INPUT_POST, "annehmen",FILTER_SANITIZE_NUMBER_INT)?>"/>
  
  
</form>



