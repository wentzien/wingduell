<?php

Core::checkAccessLevel(1);
Core::$view->path["view1"]="views/view.statistik.php";

$schluessel=Core::$user->m_oid;

$spiel=new Spiel();

//Anzahl Spiele
$SQLAnzahlSpiele="SELECT Spiel.m_oid FROM Spiel WHERE (Spiel.Verteidiger=$schluessel OR Spiel.Angreifer=$schluessel) AND (Spiel.Status0=3 OR Spiel.Status0=4 OR Spiel.Status0=5)";
$SpielAnzahlX=$spiel->findAll($SQLAnzahlSpiele);
$SpielAnzahl=count($SpielAnzahlX);

if($SpielAnzahl==0){
    core::redirect("zuwenigdaten");
//    core::addMessage("Es liegen von dir noch keine Spieldaten vor. Bitte schließe ein Spiel fertig ab.");
}

//Anzahl gewonnener Spiele
$SQLAnzahlGewSpiele="SELECT Spiel.m_oid FROM Spiel WHERE (Spiel.Verteidiger=$schluessel AND Spiel.Status0=4) OR (Spiel.Angreifer=$schluessel AND Spiel.Status0=3)";
$SpielGewAnzahlX=$spiel->findAll($SQLAnzahlGewSpiele);
$SpielGewAnzahl=count($SpielGewAnzahlX);

//Siegesquote
$SiegesquoteX=($SpielGewAnzahl/$SpielAnzahl)*100;
$Siegesquote=ceil($SiegesquoteX);

//Lieblingsgegner: Gegner gegen den man am häufigsten gespielt hat
$SQLLieblingsgegner="select neu.kennung, count(*) as Anzahl 
from 
(select User.kennung from Spiel inner join User on User.m_oid=Spiel.Verteidiger where Angreifer=$schluessel 
union all 
select User.kennung from Spiel inner join User on User.m_oid=Spiel.Angreifer where Verteidiger=$schluessel)
as neu 
group by kennung order by Anzahl desc";
$LieblingsgegnerX=$spiel->findAll($SQLLieblingsgegner);
$Lieblingsgegner=$LieblingsgegnerX[0]->kennung;

//Lieblingsherausforderer
$SQLLieblingsherausforderer="SELECT COUNT(*) as Anzahl, User.kennung FROM Spiel INNER JOIN User ON User.m_oid=Spiel.Angreifer WHERE Spiel.Verteidiger=$schluessel group by User.kennung order by Anzahl desc";
$LieblingsherausfordererX=$spiel->findAll($SQLLieblingsherausforderer);
$Lieblingsherausforderer=$LieblingsherausfordererX[0]->kennung;
if($Lieblingsherausforderer==""){
    $Lieblingsherausforderer="Du wurdest leider noch nicht herausgefordert.";
}

//Lieblingsherausgeforderter
$SQLLieblingsherausgeforderter="SELECT COUNT(*) as Anzahl, User.kennung FROM Spiel INNER JOIN User ON User.m_oid=Spiel.Verteidiger WHERE Spiel.Angreifer=$schluessel group by User.kennung order by Anzahl desc";
$LieblingsherausgeforderterX=$spiel->findAll($SQLLieblingsherausgeforderter);
$Lieblingsherausgeforderter=$LieblingsherausgeforderterX[0]->kennung;
if($Lieblingsherausgeforderter==""){
    $Lieblingsherausgeforderter="Du hast noch niemanden herausgefordert.";
}

//Häufigste Frage
$SQLFrage="SELECT COUNT(*) as Anzahl, Fragen.Fragestellung
From User
inner join Spiel on User.m_oid=Spiel.Verteidiger
inner join Runde on Runde.to_Spiel=Spiel.m_oid
inner join Fragen on Runde.to_Fragen=Fragen.m_oid
where Spiel.Angreifer=$schluessel Or Spiel.Verteidiger=$schluessel
group by Fragen.Fragestellung order by Anzahl desc";
$FrageX=$spiel->findAll($SQLFrage);
$Frage=$FrageX[0]->Fragestellung;

//Häufigste Kategorie
$SQLKategorie="SELECT COUNT(*) as Anzahl, KategorieT.myval
From User
inner join Spiel on User.m_oid=Spiel.Verteidiger
inner join Runde on Runde.to_Spiel=Spiel.m_oid
inner join Fragen on Runde.to_Fragen=Fragen.m_oid
inner join KategorieT on Fragen.Kategorie=KategorieT.codes
where Spiel.Angreifer=2 Or Spiel.Verteidiger=2
group by Fragen.Kategorie order by Anzahl desc";
$KategorieX=$spiel->findAll($SQLKategorie);
$Kategorie=$KategorieX[0]->myval;

//Übergabe zur View
Core::$view->SpielGewAnzahl=$SpielGewAnzahl;
Core::$view->SpielAnzahl=$SpielAnzahl;
Core::$view->Siegesquote=$Siegesquote;
Core::$view->Lieblingsgegner=$Lieblingsgegner;
Core::$view->Lieblingsherausforderer=$Lieblingsherausforderer;
Core::$view->Lieblingsherausgeforderter=$Lieblingsherausgeforderter;
Core::$view->Frage=$Frage;
Core::$view->Kategorie=$Kategorie;
