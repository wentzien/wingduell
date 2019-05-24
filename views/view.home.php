<?php
 /* @var $user User */

$listeVw=Core::$view->spielelisteVw;

$user=Core::$user;
if($user->vorname!=""){$eingeloggt= "Eingeloggt als: ".$user->kennung;}

if($user->vorname!=""){$willkommen= "Willkommen ".$user->vorname;}

$userrating = $user->rating;



If ($userrating > 2500)
    {$farbe = "Tomato";
     $Beiname = "Großmeister";
    
    }
    elseif ($userrating > 2000) {
        $farbe = "Orange";
        $Beiname = "Meister";
    
}  
    elseif ($userrating > 1500) {
        $farbe = "DodgerBlue";
        $Beiname = "Experte";
    
}
    elseif ($userrating > 900) {
        $farbe = "MediumSeaGreen";
        $Beiname = "Lehrling";
    
}
    elseif ($userrating > 500) {
        $farbe = "LightGray";
        $Beiname = "Amateur";
    
}
    elseif ($userrating < 500) {
        $farbe = "Violet";
        $Beiname = "Hör lieber auf!";
    
}


?>


<label><i><?php echo($eingeloggt) ?></i></label>


<center><label><h1><?php echo($willkommen) ?></h1></label></center>




	
<div class="ui-grid-d ui-responsive">
    <div class="ui-block-a"></div>
    <div class="ui-block-b"></div>
    <div class="ui-block-c ui-responsive" style="background-color:<?=("$farbe")?>"><center><label><h2><?=($Beiname) ?></h2></label><label><h1>Rating: <?php echo($userrating) ?></h1></label></center></div>
    <div class="ui-block-d"></div>
    <div class="ui-block-e"></div>
</div>
<br>
<form id="NeuesSpielstarten" method="post" action="?task=neuesspiel" data-ajax="false">
	
       <button type="submit" name="Neues Spiel starten" value="1">Neues Spiel starten</button>
   
</form>
<form id="Spieleliste" method="post" action="?task=spieleliste" data-ajax="false">

       <button type="submit" name="Spieleliste" value="1">Liste aller Spiele</button>
 
</form>

<?php
$anzahl=count($listeVw);
if($anzahl > 0){
?>
<!--ab hier-->
<br>
<center><h2>Du wurdest herausgefordert. Stelle dich deinem Gegner!</h2></center>
  <fieldset class="ui-grid-b">

      <div class="ui-block-a"></div>
      <div class="ui-block-b">
          

<table data-role="table" id="movie-table" data-mode="reflow" class="ui-body-c ui-shadow table-stripe ui-responsive" data-column-btn-theme="b" data-column-btn-text="Columns to display..." data-column-popup-theme="b">
  <thead>
    <tr>
      <th data-priority="1">Herausgefordert am</abbr></th>  
      <th data-priority="1">Herausforderer</th>
      <th data-priority="1"></th>
    </tr>
  </thead>
  <tbody>
  <?php
//Verteidiger wartend  
/* @var $itemVw Spiel */
  foreach($listeVw as $itemVw){
   ?>
<tr>
      <td><?=Help::toDate($itemVw->c_ts)?></td>
      <td><?=$itemVw->kennung?></td>
      <th data-priotity="1"><label>
          <form id="annehmen" method="post" action="?task=annehmen" data-ajax="false">
       <button type="submit" value="<?=$itemVw->m_oid?>" name="annehmen" data-theme="a">Annehmen </button>
       </form>
</tr>
<?php }
?>
      </tbody>
</table>
<!--bis da-->
<?php

}
 else {
     ?>

      </div>
      <div class="ui-block-c"></div>
    
</fieldset> 
<br>
<center><h3>Du hast leider keine weiteren Herausforderungen. :( <br><br>
    Fordere andere Spieler heraus! :)</h3>
</center>
<?php
 }
?>