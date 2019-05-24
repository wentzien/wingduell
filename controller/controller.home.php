<?php

Core::checkAccessLevel(1);
        
Core::$view->path["view1"]="views/view.home.php";

$spiel=new Spiel();

$schluessel=Core::$user->m_oid;

//Spielannahme
$SQLVw = "SELECT StatusVT.myval,User.kennung,Spiel.m_oid,Spiel.c_ts, Spiel.m_ts,Spiel.Status0,Spiel.PunkteA,Spiel.PunkteV,Spiel.Angreifer,Spiel.Verteidiger,Spiel.ts FROM Spiel INNER JOIN User ON Spiel.Angreifer=User.m_oid INNER JOIN StatusVT ON Spiel.Status0=StatusVT.codes WHERE Verteidiger=$schluessel AND Status0=0;";
$spielelisteVw=$spiel->findAll($SQLVw);

Core::$view->spielelisteVw=$spielelisteVw;


  
