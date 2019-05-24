<?php
Core::checkAccessLevel(1);    
if(count($_POST)>0){
    $kategorie = $_POST["Kategorienwahl"];
    if (count($kategorie) == 2){
        $Spiel=new Spiel();
        $Spielid = $_POST["spiel"];
        $kategorie = $_POST["Kategorienwahl"];
        $id = Spiel::findAll("SELECT * FROM Spiel WHERE m_oid= $Spielid");
        $Spiel->import($id);

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

                        

                        if ($u == 0){$round->to_User = $Spiel->Verteidiger;}
                        else   {$round->to_User = $Spiel->Angreifer;}                    


                        $round->Rundenummer = $i+6+($k*3);
                        $round->to_Spiel = $Spiel->m_oid;
                        $round->Rundenstatus = 0;
                        $result=$round->create();                                                                
                        if($result>0){                 
                            //Core::$view->path["view1"]="views/view.home.php";
                            Core::redirect("spielen",array("SpielID"=>"$Spielid"));
                        }
                        else{                 
                            Core::$view->path["view1"]="views/view.error.php";
                            Core::addError($msg);
                        }
                    }
                }
            }
            
            $Spiel->Status0 = 1;
            $result1= $Spiel->update();
            if($result1>0){Core::$view->path["view1"]="views/view.home.php";}
            else{ Core::$view->path["view1"]="views/view.error.php";
                  Core::addError($msg);}
    }
    else{
        Core::addMessage("Bitte wählen Sie nur maximal zwei Kategorien aus"); 
        Core::showMessages();
        Core::redirect("annehmen");        
        Core::addMessage("Bitte wählen Sie nur maximal zwei Kategorien aus"); 
        Core::showMessages();
    }
    
}