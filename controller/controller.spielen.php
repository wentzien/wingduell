<?php

Core::checkAccessLevel(1);
$theround=new Runde();
$userID=Core::$user->m_oid;
$thespielId = $_POST["Spiel"];
if ($thespielId == ""){ 
$Spielid= $_GET["SpielID"];
}
else{ 
$Spielid= $_POST["Spiel"];
};

$aktround=Runde::findAll("SELECT * FROM Runde WHERE to_Spiel = $Spielid AND to_user = $userID AND Rundenstatus = 0 AND Rundenummer = (SELECT Min(Rundenummer)FROM Runde WHERE to_Spiel = $Spielid AND to_user = $userID AND Rundenstatus = 0)");


$myAntwort = Antwort::findAll("SELECT * FROM Antwort WHERE to_Fragen = (SELECT to_Fragen FROM Runde WHERE to_Spiel = $Spielid AND to_user = $userID AND Rundenstatus = 0 AND Rundenummer = (SELECT Min(Rundenummer)FROM Runde WHERE to_Spiel = $Spielid AND to_user = $userID AND Rundenstatus = 0))");


if(count($aktround)==0)
{
   Core::redirect("home");
   Core::addMessage("Hallo sie haben schon alle Fragen beantwortet bitte warten Sie bis der Gegener alle Fragen beantwortet hat"); 
}
else
{
$theround->import($aktround);
$Frage = New Fragen();
$myfrage = Fragen::findAll("SELECT * FROM Fragen WHERE m_oid=(SELECT to_Fragen FROM Runde WHERE to_Spiel = $Spielid AND to_user = $userID AND Rundenstatus = 0 AND Rundenummer = (SELECT Min(Rundenummer)FROM Runde WHERE to_Spiel = $Spielid AND to_user = $userID AND Rundenstatus = 0))");
$Frage->import($myfrage);  
Core::$view->round = $theround;
Core::$view->Fragestellung = $Frage->Fragestellung;
Core::$view->Antwort = $myAntwort;
Core::$view->path["view1"]="views/view.spielen.php";
    
}




