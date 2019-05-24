<?php
Core::checkAccessLevel(1); 
if(count($_POST)>0){
    
    if ($_POST["Antwort"] =="")
    {
        $thespielId= $_POST["Spiel"];
        if ($thespielId == ""){ 
        $SpielID= $_GET["SpielID"];
        }
        else{ 
        $SpielID= $_POST["Spiel"];
        };       
       Core::redirect("spielen",array("SpielID"=>"$SpielID")); 
    }    
        else{
    $Antwort = New Antwort();
    $AntwortID = $_POST["Antwort"];
    $SpielID = $_POST["Spiel"];
    $RundeID = $_POST["Runde"];
    $UserID = Core::$user->m_oid;
    if($SpielID==""){
        $zwRunde = New Runde();
        $SQLRunde1 = Runde::findAll("Select * FROM Runde WHERE m_oid =$RundeID");
        $zwRunde->import($SQLRunde1);
        $SpielID = $zwRunde->to_Spiel;
    };

    $Runde= New Runde();
    $SQLRunde = Runde::findAll("Select * FROM Runde WHERE m_oid =$RundeID");
    $Runde->import($SQLRunde);
    $Rundennummer = $Runde->Rundenummer;


    $SQLAntwort = Antwort::findAll("Select * FROM Antwort WHERE m_oid =$AntwortID");
    $Antwort->import($SQLAntwort);

    if ($Antwort->Richtig == 1){

        $Runde->Rundenstatus = 1 ;
        $Runde->to_Antwort = $Antwort->m_oid;
        $result = $Runde->update();
    }

    else {
        $Runde= New Runde();
        $SQLRunde = Runde::findAll("Select * FROM Runde WHERE m_oid =$RundeID");
        $Runde->import($SQLRunde);

        $Runde->Rundenstatus = 2 ;
        $Runde->to_Antwort = $Antwort->m_oid;
        $result = $Runde->update();
    };

    if($Rundennummer == 12){

        $Rundenanzahl = Runde::findAll("SELECT COUNT(m_oid)FROM Runde WHERE Rundenstatus=0 AND to_Spiel = 85");

    $SQLrichtigerunden = "Select * From Runde Where to_Spiel = $SpielID And Rundenstatus = 0";

    $SQLRunden = $Runde->findAll($SQLrichtigerunden);
    $Rundenanzahl = count($SQLRunden);

       Core::redirect("home");
       Core::addMessage("Glückwunsch Sie haben das Spiel beendet");
    
    
        if ($Rundenanzahl== 0) { 

        $Spielbeendet = New Spiel();
        $SQLSpiel = Spiel::findAll("Select * FROM Spiel WHERE m_oid =$SpielID"); 
        $Spielbeendet->import($SQLSpiel);
        $Spielbeendet->Status0= 2;
        $Spielbeendet->update();

        Core::redirect("siegerbestimmung",array("SpielID"=>"$SpielID"));

        };






    }
    else{


      Core::redirect("spielen",array("SpielID"=>"$SpielID"));

    };



    };



}