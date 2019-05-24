<?php


Core::checkAccessLevel(1);

$schluessel=Core::$user->m_oid;

$spiel=new Spiel();

//Angreifer:
//wartend
$SQLAw = "SELECT StatusAT.myval,User.kennung,Spiel.m_oid,Spiel.c_ts, Spiel.m_ts,Spiel.Status0,Spiel.PunkteA,Spiel.PunkteV,Spiel.Angreifer,Spiel.Verteidiger,Spiel.ts FROM Spiel INNER JOIN User ON Spiel.Verteidiger=User.m_oid INNER JOIN StatusAT ON Spiel.Status0=StatusAT.codes WHERE Angreifer=$schluessel AND Status0=0;";
$spielelisteAw=$spiel->findAll($SQLAw);
//laufend
$SQLAl = "SELECT StatusAT.myval,User.kennung,Spiel.m_oid,Spiel.c_ts, Spiel.m_ts,Spiel.Status0,Spiel.PunkteA,Spiel.PunkteV,Spiel.Angreifer,Spiel.Verteidiger,Spiel.ts FROM Spiel INNER JOIN User ON Spiel.Verteidiger=User.m_oid INNER JOIN StatusAT ON Spiel.Status0=StatusAT.codes WHERE Angreifer=$schluessel AND Status0=1;";
$spielelisteAl=$spiel->findAll($SQLAl);
//gewonnen oder verloren oder Unentschieden
$SQLAb = "SELECT StatusAT.myval,User.kennung,Spiel.m_oid,Spiel.c_ts, Spiel.m_ts,Spiel.Status0,Spiel.PunkteA,Spiel.PunkteV,Spiel.Angreifer,Spiel.Verteidiger,Spiel.ts  FROM Spiel INNER JOIN User ON Spiel.Verteidiger=User.m_oid INNER JOIN StatusAT ON Spiel.Status0=StatusAT.codes WHERE Angreifer=$schluessel AND (Status0=3 OR Status0=4 OR Status0=5);";
$spielelisteAb=$spiel->findAll($SQLAb);

//Verteidiger:
//wartend
$SQLVw = "SELECT StatusVT.myval,User.kennung,Spiel.m_oid,Spiel.c_ts, Spiel.m_ts,Spiel.Status0,Spiel.PunkteA,Spiel.PunkteV,Spiel.Angreifer,Spiel.Verteidiger,Spiel.ts FROM Spiel INNER JOIN User ON Spiel.Angreifer=User.m_oid INNER JOIN StatusVT ON Spiel.Status0=StatusVT.codes WHERE Verteidiger=$schluessel AND Status0=0;";
$spielelisteVw=$spiel->findAll($SQLVw);
//laufend
$SQLVl = "SELECT StatusVT.myval,User.kennung,Spiel.m_oid,Spiel.c_ts, Spiel.m_ts,Spiel.Status0,Spiel.PunkteA,Spiel.PunkteV,Spiel.Angreifer,Spiel.Verteidiger,Spiel.ts FROM Spiel INNER JOIN User ON Spiel.Angreifer=User.m_oid INNER JOIN StatusVT ON Spiel.Status0=StatusVT.codes WHERE Verteidiger=$schluessel AND Status0=1";
$spielelisteVl=$spiel->findAll($SQLVl);
//gewonnen oder verloren oder Unentschieden
$SQLVb = "SELECT StatusVT.myval,User.kennung,Spiel.m_oid,Spiel.c_ts, Spiel.m_ts,Spiel.Status0,Spiel.PunkteA,Spiel.PunkteV,Spiel.Angreifer,Spiel.Verteidiger,Spiel.ts FROM Spiel INNER JOIN User ON Spiel.Angreifer=User.m_oid INNER JOIN StatusVT ON Spiel.Status0=StatusVT.codes WHERE Verteidiger=$schluessel AND (Status0=3 OR Status0=4 OR Status0=5)";
$spielelisteVb=$spiel->findAll($SQLVb);



Core::$view->path["view1"]="views/view.spieleliste.php";
Core::$view->spielelisteAw=$spielelisteAw;
Core::$view->spielelisteAl=$spielelisteAl;
Core::$view->spielelisteAb=$spielelisteAb;
Core::$view->spielelisteVw=$spielelisteVw;
Core::$view->spielelisteVl=$spielelisteVl;
Core::$view->spielelisteVb=$spielelisteVb;
Core::$view->schluessel=$schluessel;

