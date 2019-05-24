<?php
Core::$view->path["view1"]="views/view.login.php";
if(count($_POST)>0){
 //Core::$user=new User();
    
   
  Core::$user->login(filter_input(INPUT_POST,"username"), filter_input(INPUT_POST, "passwort"));
  if ($_SESSION['uid']!=""){
      Core::redirect("home");
  }
  else {
     Core::$view->path["view1"]="views/view.login.php"; 
  }


}





  
