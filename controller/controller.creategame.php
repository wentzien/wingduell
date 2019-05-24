<?php
Core::checkAccessLevel(1);    
if(count($_POST)>0){   
    
    $kategorie = $_POST["Kategorienwahl"];  
            
    if (count($kategorie) == 2){

        $Spiel=new Spiel();

        $Vid=User::findAll('SELECT m_oid FROM User ORDER BY RAND() LIMIT 1');


        $randomUser= new User;

        /* @var $randomUser User */
        $randomUser->import($Vid);



        $randomid = filter_input(INPUT_POST,"randomgame");   

        $Spiel->strictMapping=false;     
        $result=$Spiel->loadFormData();    
        if(!$result){
            Core::addError($msg);
            Core::$view->path["view1"]="views/view.neuesspiel.php";          
        }
        else{       

            if($randomid == "1"){
            $Spiel->Verteidiger = $randomUser->m_oid;
            }  
            $Spiel->Angreifer = Core::$user->m_oid;
            $Spiel->Status0=0;        
            $result=$Spiel->create();
            if($result>0){                 
                Core::$view->path["view1"]="views/view.home.php";
                Core::addMessage("Spiel wurde erstellt, bitte gedulden Sie sich bis der Verteidiger die Herausforderung annimmt");  
            }
            else{                 
                Core::$view->path["view1"]="views/view.error.php";
                Core::addError($msg);
            }
        }


        for($u=0;$u<=1;$u++){
            for($k=0;$k<=1;$k++){
                    $kat1=$kategorie[$k];
                    $Fid=Fragen::findAll("SELECT m_oid FROM Fragen WHERE Kategorie= $kat1 ORDER BY RAND() LIMIT 3");                    
                for($i=1;$i<=3;$i++){
                    $round=new Runde();
          

                    $round->strictMapping=false;
                    if ($u==0){
                    $Fragenliste[$i+($k*3)]=$Fid[$i-1]->m_oid;    
                    $round->to_Fragen = $Fid[$i-1]->m_oid;
                    }
                    else{
                    $round->to_Fragen = $Fragenliste[$i+($k*3)];   
                    };
                    if ($u == 1){$round->to_User = $Spiel->Verteidiger;}
                    else   {$round->to_User = $Spiel->Angreifer;}                    
                    
                    
                    $round->Rundenummer = $i+($k*3);
                    $round->to_Spiel = $Spiel->m_oid;
                    $round->Rundenstatus = 0;
                    $result=$round->create();
                    if($result>0){                 
                        Core::$view->path["view1"]="views/view.home.php";              
                    }
                    else{                 
                        Core::$view->path["view1"]="views/view.error.php";
                        Core::addError($msg);
                    }
                }
            }
        }
    }
 else {
        
    Core::redirect("neuesspiel");
    
}
}