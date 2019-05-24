<?php

    
if(count($_POST)>0){   
 $Spiel=new Spiel();


     $result=$Spiel->loadFormData();    
     if(!$result){
         Core::addError($msg);
          Core::$view->path["view1"]="views/view.neuesspiel.php";
          
     }else{

        $Spiel->Status0=1;
        $Spiel->rating= 1000;
        $result=$Spiel->create();
         if($result>0){                 
                    Core::$view->path["view1"]="views/view.login.php";
                    Core::addMessage("Sie haben sich erfolgreich angemeldet! Bitte loggen Sie sich jetzt ein");  
         }else
         {                 
                     Core::$view->path["view1"]="views/view.error.php";
                     Core::addError($msg);
                }
     }
}else{
    Core::$view->path["view1"]="views/view.register.php";
}













Core::$view->path["view1"]="views/view.runninggame.php";
