<?php
session_start();
//  ****** System Dateien einbinden *******
require("includes/system.core.php");
require("includes/system.db.php");
require("includes/system.help.php");
require("includes/system.view.php");
require("includes/config.php");
//  ***** Anwendungsklassen einbinden *****
require("models/model.user.php");
require("models/model.fragen.php");
require("models/model.kategorieT.php");
require("models/model.runde.php");
require("models/model.spiel.php");
require("models/model.antwort.php");

// ****** Initialisierung  *******
$core=new Core($hostname,$username,$password,$database); // Bei der Instanzierung wird die (statische) DB-Verbnindung automatisch aufgebaut. 



Core::init(); // sicher den Task auslesen

// ************ Nachfolgende Variablen aus Config ***********
Core::$title=$title;
Core::$defaultTask=$defaultTask;
Core::$debugMode=$debugmode;
Core::$debugPrint=$debugprint;
Core::$debugConsole=$debugconsole;
if(Core::$debugMode==1 || Core::$debugConsole==1){
	error_reporting(E_ALL & ~E_NOTICE);
}else {
    error_reporting(0);
}   
// sorgt dafür, dass PHP-Fehlermeldungen erst am Schluss angezeigt werden.
// xdebug_start_error_collection();

// Whitelist für gültige Tasks
Core::setTaskMap(array(
  'home'=>'controller.home.php',
  'login'=>'',
  'logout'=>'',
  'error'=>'',
  'register'=>'',
  'newregister'=>'',
  'annehmen'=>'controller.annehmen.php',
  'neuesspiel'=>'controller.neuesspiel.php',
  'neuefrage'=>'controller.neuefrage.php',
  'creategame'=>'controller.creategame.php',
  'spieleliste'=>'controller.spieleliste.php',
  'besteatigen'=>'controller.besteatigen.php',
  'spielen'=>'controller.spielen.php',
  'beantworten'=>'controller.beantworten.php',
  'siegerbestimmung'=>'controller.siegerbestimmung.php',
  'spielinfo'=>'controller.spielinfo.php',
  'statistik'=>'controller.statistik.php',
  'zuwenigdaten'=>'controller.zuwenigdaten.php'
    
    
    
   ));


Core::controller(); // lädt abhängig vom Task den korrekten Controller

