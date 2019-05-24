<?php  
    
if(count($_POST)>0){   
 $user=new User();


     $result=$user->loadFormData();    
     if(!$result){
         Core::addError($msg);
          Core::$view->path["view1"]="views/view.register.php";
          
     }else{
        $user->m_ts=time();
        $user->c_ts=time();
        $user->gruppe=1;
        $user->rating= 1000;
        $result=$user->create();
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
