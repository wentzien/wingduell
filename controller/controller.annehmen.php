<?php
Core::checkAccessLevel(1);
if (filter_input(INPUT_POST, "annehmen",FILTER_SANITIZE_NUMBER_INT)==""){
    
    Core::redirect("spieleliste");
    
}
else{


Core::$view->path["view1"]="views/view.annehmen.php";


}












