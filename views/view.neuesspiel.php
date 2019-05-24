<?php
// Models
/* @var $kunde Kunde */

$User=Core::$view->User;
$spielerliste=Core::$view->spielerliste;
?>



<fieldset class="ui-grid-b ui-responsive">
    <div class="ui-block-a"></div>
    <div class="ui-block-b"><center><h3>Wähle deine zwei Kategorien sowie deinen Gegener!</h3></center></div>
    <div class="ui-block-c"></div>
</fieldset> 

<?php
$kategorien = KategorieT::findAll("SELECT * FROM KategorieT");

foreach($kategorien as $item){
 $i++; 
 $katname = $kategorien[$i-1]->myval;

 $katid= $kategorien->codes;
?>
<form id="newgame" method="post" action="?task=creategame" data-ajax="false" name="Form">
    

    <fieldset class="ui-grid-b">
    <div class="ui-block-a"></div>
    <div class="ui-block-b">  
        <label>
  <input type="checkbox" name="Kategorienwahl[]" value="<?=$i-1?>">
  <?=$katname?></label>
    </div>
    <div class="ui-block-c"></div>
</fieldset> 
    
    
    
    
    
<?php
        };
        
?>

  <fieldset class="ui-grid-b ui-responsive">
    <div class="ui-block-a"></div>
    <div class="ui-block-b">
        
        
        <br>
        <?php Help::htmlSelect($spielerliste,["name"=>"Verteidiger","type"=>"radiomini","key"=>"m_oid", "text"=>"kennung"]);?>
        <button type="submit" name="randomgame" value="2">Spieler Herausfodern</button>
        <br>
        <center><h3>Du scheust dich vor keinem anderen Gegner?</h3></center>
        <button type="submit" name="randomgame" value="1">Fordere einen zufälligen Spieler heraus!</button>
    
    </div>
    <div class="ui-block-c"></div>
</fieldset> 
  
  
  
  
</form>
















