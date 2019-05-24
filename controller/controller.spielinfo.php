<?php
Core::checkAccessLevel(1);
Core::$view->path["view1"]="views/view.spielinfo.php";

$Spielid= $_POST["spielinfo"];

$db= new Spiel();
$frage=new Fragen();

$SQLangreifer="SELECT Spiel.Angreifer FROM Spiel WHERE Spiel.m_oid=$Spielid";
$SQLverteidiger="SELECT Spiel.Verteidiger FROM Spiel WHERE Spiel.m_oid=$Spielid";

$angreifer=$db->findAll($SQLangreifer);
$verteidiger=$db->findAll($SQLverteidiger);

$angreifer=$angreifer[0]->Angreifer;
$verteidiger=$verteidiger[0]->Verteidiger;

$schluessel=Core::$user->m_oid;


//Entscheidet ob der Spieler der Angreifer oder der Verteidiger war... Angreifer kommt zuerst
if ($angreifer==$schluessel){
    $SQLGegner="SELECT User.kennung FROM Spiel INNER JOIN User ON Spiel.Verteidiger=User.m_oid WHERE Spiel.m_oid=$Spielid";
    $gegner=$db->findAll($SQLGegner);
    $gegner=$gegner[0]->kennung;
    $SQLEndstatus="SELECT StatusAT.myval FROM Spiel INNER JOIN StatusAT ON Spiel.Status0=StatusAT.codes WHERE Spiel.m_oid=$Spielid";
    $endstatus=$db->findAll($SQLEndstatus);
    $endstatus=$endstatus[0]->myval;
    $SQLGesamtIch="SELECT Runde.Rundenstatus FROM Runde WHERE Runde.Rundenstatus=1 AND Runde.to_Spiel=$Spielid AND Runde.to_User=$schluessel";
    $gesamtich=$db->findAll($SQLGesamtIch);
    $anzahl=count($gesamtich);
    $SQLGesamtGegner="SELECT Runde.Rundenstatus FROM Runde WHERE Runde.Rundenstatus=1 AND Runde.to_Spiel=$Spielid AND Runde.to_User=$verteidiger";
    $gesamtgegner=$db->findAll($SQLGesamtGegner);
    $anzahlgegner=count($gesamtgegner);
    $SQLliste="
        SELECT Runde.m_oid, Fragen.Fragestellung, Antwort.Text0
        FROM Antwort 
        INNER JOIN Fragen ON Fragen.m_oid=Antwort.to_Fragen
        INNER JOIN Runde ON Fragen.m_oid=Runde.to_Fragen 
        WHERE Runde.to_Spiel=$Spielid AND Antwort.Richtig=1 AND  Runde.to_User=$schluessel";
    $liste=$frage->findAll($SQLliste);
    $SQLliste1="
        SELECT Runde.m_oid, Antwort.Text0 AS DeineAntwort
        FROM Antwort
        INNER JOIN Runde ON Antwort.m_oid=Runde.to_Antwort
        WHERE Runde.to_Spiel=$Spielid AND Runde.to_User=$schluessel";
    $liste1=$frage->findAll($SQLliste1);
    $SQLliste2="
        SELECT Runde.m_oid, Antwort.Text0 AS GegnerAntwort
        FROM Antwort
        INNER JOIN Runde ON Antwort.m_oid=Runde.to_Antwort
        WHERE Runde.to_Spiel=$Spielid AND Runde.to_User=$verteidiger";
    $liste2=$frage->findAll($SQLliste2);
    
//    View zweite Satz, wie viel man durchschnittlich gegen den Gegner gewinnt.
    $SQLspielanzahl="SELECT * FROM Spiel WHERE (Spiel.Angreifer=$schluessel AND Spiel.Verteidiger=$verteidiger AND (Spiel.Status0=3 OR Spiel.Status0=4 OR Spiel.Status0=5)) OR (Spiel.Angreifer=$verteidiger AND Spiel.Verteidiger=$schluessel AND (Spiel.Status0=3 OR Spiel.Status0=4 OR Spiel.Status0=5))";
    $spielanzahlX=$frage->findAll($SQLspielanzahl);
    $spielanzahl=count($spielanzahlX);
    $SQLgewonnen="SELECT * FROM Spiel WHERE (Spiel.Angreifer=$schluessel AND Spiel.Verteidiger=$verteidiger AND Spiel.Status0=3) OR (Spiel.Angreifer=$verteidiger AND Spiel.Verteidiger=$schluessel AND Spiel.Status0=4)";
    $gewonnen1=$frage->findAll($SQLgewonnen);
    $gewonnen=count($gewonnen1);
    $prozent=$gewonnen/$spielanzahl;
    $prozent=ceil($prozent*100);
    
}
else{
    $SQLGegner="SELECT User.kennung FROM Spiel INNER JOIN User ON Spiel.Angreifer=User.m_oid WHERE Spiel.m_oid=$Spielid";
    $gegner=$db->findAll($SQLGegner);
    $gegner=$gegner[0]->kennung;
    $SQLEndstatus="SELECT StatusVT.myval FROM Spiel INNER JOIN StatusVT ON Spiel.Status0=StatusVT.codes WHERE Spiel.m_oid=$Spielid";
    $endstatus=$db->findAll($SQLEndstatus);
    $endstatus=$endstatus[0]->myval;
    $SQLGesamtIch="SELECT Runde.Rundenstatus FROM Runde WHERE Runde.Rundenstatus=1 AND Runde.to_Spiel=$Spielid AND Runde.to_User=$schluessel";
    $gesamtich=$db->findAll($SQLGesamtIch);
    $anzahl=count($gesamtich);
    $SQLGesamtGegner="SELECT Runde.Rundenstatus FROM Runde WHERE Runde.Rundenstatus=1 AND Runde.to_Spiel=$Spielid AND Runde.to_User=$angreifer";
    $gesamtgegner=$db->findAll($SQLGesamtGegner);
    $anzahlgegner=count($gesamtgegner);
    $SQLliste="
        SELECT Runde.m_oid, Fragen.Fragestellung, Antwort.Text0
        FROM Antwort 
        INNER JOIN Fragen ON Fragen.m_oid=Antwort.to_Fragen
        INNER JOIN Runde ON Fragen.m_oid=Runde.to_Fragen 
        WHERE Runde.to_Spiel=$Spielid AND Antwort.Richtig=1 AND  Runde.to_User=$schluessel";
    $liste=$frage->findAll($SQLliste);
    $SQLliste1="
        SELECT Runde.m_oid, Antwort.Text0 AS DeineAntwort
        FROM Antwort
        INNER JOIN Runde ON Antwort.m_oid=Runde.to_Antwort
        WHERE Runde.to_Spiel=$Spielid AND Runde.to_User=$schluessel";
    $liste1=$frage->findAll($SQLliste1);
    $SQLliste2="
        SELECT Runde.m_oid, Antwort.Text0 AS GegnerAntwort
        FROM Antwort
        INNER JOIN Runde ON Antwort.m_oid=Runde.to_Antwort
        WHERE Runde.to_Spiel=$Spielid AND Runde.to_User=$angreifer";
    $liste2=$frage->findAll($SQLliste2);
    
// View zweite Satz, wie viel man durchschnittlich gegen den Gegner gewinnt
    $SQLspielanzahl="SELECT * FROM Spiel WHERE (Spiel.Angreifer=$schluessel AND Spiel.Verteidiger=$angreifer AND (Spiel.Status0=3 OR Spiel.Status0=4 OR Spiel.Status0=5)) OR (Spiel.Angreifer=$angreifer AND Spiel.Verteidiger=$schluessel AND (Spiel.Status0=3 OR Spiel.Status0=4 OR Spiel.Status0=5))";
    $spielanzahlX=$frage->findAll($SQLspielanzahl);
    $spielanzahl=count($spielanzahlX);
    $SQLgewonnen="SELECT * FROM Spiel WHERE (Spiel.Angreifer=$schluessel AND Spiel.Verteidiger=$angreifer AND Spiel.Status0=3) OR (Spiel.Angreifer=$angreifer AND Spiel.Verteidiger=$schluessel AND Spiel.Status0=4)";
    $gewonnen1=$frage->findAll($SQLgewonnen);
    $gewonnen=count($gewonnen1);
    $prozent=$gewonnen/$spielanzahl;
    $prozent=ceil($prozent*100);
}



Core::$view->gegner=$gegner;
Core::$view->endstatus=$endstatus;
Core::$view->gesamtich=$anzahl;
Core::$view->gesamtgegner=$anzahlgegner;
Core::$view->liste=$liste;
Core::$view->liste1=$liste1;
Core::$view->liste2=$liste2;

Core::$view->durchschnitt=$durchschnitt;
Core::$view->prozent=$prozent;
Core::$view->spielanzahl=$spielanzahl;