<?php  

Core::checkAccessLevelA(2);
Core::$view->path["view1"]="views/view.neuefrage.php";

if(count($_POST)>0){   
$frage=new Fragen();



$frage->strictMapping=false;
$result=$frage->loadFormData();

//     Frage
     if(!$result){
         Core::addError($msg);
          Core::$view->path["view1"]="views/view.neuefrage.php";
          
     }else{
        $frage->m_ts=time();
        $frage->c_ts=time();
        $result=$frage->create();
        
        $nummer=$frage->m_oid;  

$richtigeantwort=new Antwort();
$richtigeantwort->Text0=filter_input(INPUT_POST,"Antwort0");
$richtigeantwort->Richtig="1";
$richtigeantwort->to_Fragen="$nummer";
$richtigeantwort->create();

$antwort1=new Antwort();
$antwort1->Text0=filter_input(INPUT_POST,"Antwort1");
$antwort1->Richtig="0";
$antwort1->to_Fragen="$nummer";
$antwort1->create();

$antwort2=new Antwort();
$antwort2->Text0=filter_input(INPUT_POST,"Antwort2");
$antwort2->Richtig="0";
$antwort2->to_Fragen="$nummer";
$antwort2->create();

$antwort3=new Antwort();
$antwort3->Text0=filter_input(INPUT_POST,"Antwort3");
$antwort3->Richtig="0";
$antwort3->to_Fragen="$nummer";
$antwort3->create();
        
         if($result>0){                 
                    Core::$view->path["view1"]="views/view.neuefrage.php";
                    Core::addMessage("Sie haben erfolgreich eine neue Frage hinzugefügt.");  
         }else
         {                 
                     Core::$view->path["view1"]="views/view.error.php";
                     Core::addError($msg);
                }
     }
  

     
}else{
    Core::$view->path["view1"]="views/view.neuefrage.php";
}


