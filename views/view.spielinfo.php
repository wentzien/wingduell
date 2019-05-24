<?php
$Gegner=Core::$view->gegner;
$Endstatus=Core::$view->endstatus;
$GesamtIch=Core::$view->gesamtich;
$GesamtGegner=Core::$view->gesamtgegner;
$liste=Core::$view->liste;
$liste1=Core::$view->liste1;
$liste2=Core::$view->liste2;
$durchschnitt=Core::$view->durchschnitt;
$prozent=Core::$view->prozent;
$spielanzahl=Core::$view->spielanzahl;
?>
<h2>Deine Statistik zum Spiel gegen <?php echo($Gegner) ?></h2>
<?php

//Du hast das Spiel gegen XY gespielt und mit XY Punkten gewonnen/verloren
if($Endstatus!="unentschieden"){
echo("Du hast mit $GesamtIch zu $GesamtGegner Punkten $Endstatus.");
}
else{
  echo("Du hast ein Unentschieden mit $GesamtIch zu $GesamtGegner Punkten erzielt.");  
}
?>
<br><br>
<?php
echo("Von insgesamt $spielanzahl Spielen hast du gegen $Gegner eine Siegesrate von $prozent% erzielt.");
?>
<br>
<h4>Folgende Fragen kamen in eurer Partie vor:</h4>

<table data-role="table" id="movie-table" data-mode="reflow" class="ui-responsive">
  <thead>
    <tr>
      <th data-priority="1">Fragestellung</abbr></th>  
      <th data-priority="1">Richtige Antwort</th>
       <th data-priority="1">Deine Antwort</th>
       <th data-priority="1">Gegner-Antwort</th>
    </tr>
  </thead>
  <tbody>
  <?php
//Angreifer wartend  
/* @var $item Fragen */
  foreach($liste as $item){
      $i++
   ?>     
<tr>
        
      <td><?=$item->Fragestellung?></td>
      <td><?=$item->Text0?></td>
      <td><?=$liste1[$i-1]->DeineAntwort?></td>
      <td><?=$liste2[$i-1]->GegnerAntwort?></td>
<?php }
?>
</tr>
  </tbody>  
</table>
