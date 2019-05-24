<?php

$Spiel = New Spiel;
$Angreifer = New User;
$Verteidiger = New User;
$Runde = New Runde();
$SpielID = $_GET["SpielID"];
$SQLSpiel = Spiel::findAll("SELECT * FROM Spiel WHERE m_oid = $SpielID");
$Spiel->import($SQLSpiel);
$AngreiferID = $Spiel->Angreifer;
$VerteidigerID = $Spiel->Verteidiger;

if ($Spiel->Status0 != 2 ){
    Core::redirect("home");
}
else{
    



$SQLAngreifer = User::findAll("SELECT * FROM User WHERE m_oid = $AngreiferID");


$Angreifer->import($SQLAngreifer);

$SQLVerteidiger = User::findAll("SELECT * FROM User WHERE m_oid = $VerteidigerID");
$Verteidiger->import($SQLVerteidiger);


$SQLrichtigerundenA = "Select * From Runde Where to_Spiel = $SpielID And to_User = $AngreiferID And Rundenstatus = 1";

$SQLRundenA = $Runde::findAll($SQLrichtigerundenA);
$AngreiferAnzahl = count($SQLRundenA);

$SQLrichtigerundenV = "Select * From Runde Where to_Spiel = $SpielID And to_User = $VerteidigerID And Rundenstatus = 1";

$SQLRundenV = $Runde::findAll($SQLrichtigerundenV);
$VerteidigerAnzahl = count($SQLRundenV);


$Spiel->PunkteA = $AngreiferAnzahl;
$Spiel->PunkteV = $VerteidigerAnzahl;

$AngreiferElo = $Angreifer->rating;
$VerteidigerElo = $Verteidiger->rating;       






If($AngreiferAnzahl>$VerteidigerAnzahl){
$Spiel->Status0 = 3; 




If ($AngreiferElo>$VerteidigerElo){
    
    $Punktefaktor = $AngreiferElo/$VerteidigerElo;
    
    if ($Punktefaktor>20){$Punktefaktor = 2;}
    
    $Angreifer->rating = ceil($Angreifer->rating +(12/$Punktefaktor));
    $Verteidiger->rating = floor($Verteidiger->rating -( 12/$Punktefaktor));
}
else{$Punktefaktor = $VerteidigerElo/$AngreiferElo;
    
    if ($Punktefaktor>2){$Punktefaktor = 2;}
    $Angreifer->rating = ceil($Angreifer->rating +($Punktefaktor*12));
    $Verteidiger->rating = floor($Verteidiger->rating -($Punktefaktor*12));

}





}
Elseif($AngreiferAnzahl<$VerteidigerAnzahl){
$Spiel->Status0 = 4;



If ($AngreiferElo>$VerteidigerElo){
    
    $Punktefaktor = $AngreiferElo/$VerteidigerElo;
    if ($Punktefaktor>2){$Punktefaktor = 2;}
    $Angreifer->rating = floor($Angreifer->rating -($Punktefaktor*12));
    $Verteidiger->rating = ceil($Verteidiger->rating +($Punktefaktor*12));
    
}
else{$Punktefaktor = $VerteidigerElo/$AngreiferElo;
if ($Punktefaktor>20){$Punktefaktor = 2;}
    $Angreifer->rating = floor($Angreifer->rating -(12/$Punktefaktor));
    $Verteidiger->rating = ceil($Verteidiger->rating +( 12/$Punktefaktor));

}





}
else{
  $Spiel->Status0 = 5;  
  
  
  
  If ($AngreiferElo>$VerteidigerElo){
    
    $Punktefaktor = $AngreiferElo/$VerteidigerElo;
    if ($Punktefaktor>3){$Punktefaktor = 2;}
    $Angreifer->rating = floor($Angreifer->rating -(12*($Punktefaktor-1)));
    $Verteidiger->rating = ceil($Verteidiger->rating +( 12*($Punktefaktor-1)));
    
    
}
else{$Punktefaktor = $VerteidigerElo/$AngreiferElo;
  
    if ($Punktefaktor>3){$Punktefaktor = 2;}
    $Angreifer->rating = ceil($Angreifer->rating +(12*($Punktefaktor-1)));
    $Verteidiger->rating = floor($Verteidiger->rating -(12*($Punktefaktor-1)));
  
  }
  
}

$Angreifer->update();
$Verteidiger->update();
$Spiel->update();







Core::redirect("home");
Core::addMessage("Glückwunsch Sie haben das Spiel beendet");
   

 

}
