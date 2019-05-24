<?php
Core::checkAccessLevel(1); 
$theanswer=Core::$view->Antwort;
$roundid = Core::$view->round;


$SpielPostID = filter_input(INPUT_POST,"Spiel",FILTER_SANITIZE_NUMBER_INT);

        If ($SpielPostID == "")
            {$SpielID = filter_input(INPUT_GET,"SpielID",FILTER_SANITIZE_NUMBER_INT);
                    
            }
            else
            {
             $SpielID = filter_input(INPUT_POST,"Spiel",FILTER_SANITIZE_NUMBER_INT); 
            }

$Spiel = Spiel::find($SpielID);
$AngreiferID = $Spiel->Angreifer;
$VerteidigerID = $Spiel->Verteidiger;
$Angreifer = User::find($AngreiferID);
$Verteidiger = User::find($VerteidigerID);
$Angreiferrating = $Angreifer->rating;
$Verteidigerrating = $Verteidiger->rating;

if ($AngreiferID == Core::$user->m_oid){
   
    
    if ($Angreiferrating>$Verteidigerrating)
{
    $ratingfaktor = $Angreiferrating/$Verteidigerrating;
    if ($ratingfaktor>2){$ratingfaktor=2;}
    
    $Ratingplus = ceil(12/$ratingfaktor);
    $Ratingminus = floor($ratingfaktor*12);
    
   
}
else{
    $ratingfaktor = $Verteidigerrating/$Angreiferrating;
    if ($ratingfaktor>2){$ratingfaktor=2;}
    $Ratingplus = ceil($ratingfaktor*12);
    $Ratingminus = floor(12/$ratingfaktor);
    
};
    
    
}


else{
    
    if ($Angreiferrating>$Verteidigerrating)
{
    $ratingfaktor = $Angreiferrating/$Verteidigerrating;
    if ($ratingfaktor>2){$ratingfaktor=2;}
    $Ratingminus = floor(12/$ratingfaktor);
    $Ratingplus = ceil($ratingfaktor*12);
    
   
}
else{
    $ratingfaktor = $Verteidigerrating/$Angreiferrating;
    if ($ratingfaktor>2){$ratingfaktor=2;}
    $Ratingminus = floor($ratingfaktor*12);
    $Ratingplus = ceil(12/$ratingfaktor);
    
};
    
    
};




shuffle($theanswer);


?>




<div class="ui-grid-b ui-responsive">
    <div class="ui-block-a"></div>
    <div class="ui-block-b">
        
        <center>
<h1><?=$roundid->Rundenummer?>.Frage:</h1><h1><?=Core::$view->Fragestellung?></h1>

<form id="newgame" method="post" action="?task=beantworten" data-ajax="false" name="Form">
 <?php Help::htmlRadioGroup($theanswer,["name"=>"Antwort","type"=>"radio","key"=>"m_oid", "text"=>"Text0", "label" =>"Antwortmöglichkeiten", "default"=>"2"]);?>

  <button type="submit" name="beantworten" value="1">Beantworten</button>
  <input  type= "hidden" name="Spiel" value="<?= filter_input(INPUT_POST,"Spiel",FILTER_SANITIZE_NUMBER_INT)?>" />
  <input  type="hidden" name="Runde" value="<?= $roundid->m_oid ?>" />

</form>

<br>
        
        
        
        <div style="background-color:yellowgreen"> <h3>Wenn du gewinnst bekommst du <?=$Ratingplus?> Punkte</h3></div>

        <div style="background-color:tomato"> <h3>Wenn du nicht gewinnst verlierst du <?=$Ratingminus?> Punkte</h3></div>
        
    </div>
    <div class="ui-block-c ui-responsive"></div>

</div>




</center>