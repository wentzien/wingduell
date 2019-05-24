<?php

Core::checkAccessLevel(1);



Core::addMessage("Bitte wählen Sie nur maximal zwei Kategorien aus"); 
Core::showMessages();
Core::$view->path["view1"]="views/view.neuesspiel.php";
$userID = Core::$user->m_oid;
$liste=User::findAll("SELECT * FROM User WHERE m_oid<>$userID");
Core::$view->spielerliste=$liste;
