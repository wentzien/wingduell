<?php require("includes/system.main.php"); ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?=$title?></title>
<link rel="stylesheet" href="../css/themes/hs.css" />
<link rel="stylesheet" href="../css/themes/jquery.mobile.icons.min.css" />
<link href="../css/themes/jqm-icon-pack-fa.css" rel="stylesheet" type="text/css" />
<link href="../css/jquery.mobile.custom.structure.min.css" rel="stylesheet" type="text/css">
<link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
<script src="../includes/js/jquery-2.1.3.min.js"></script>
<script src="../includes/js/jquery.mobile.custom.min.js"></script>
<script src="../includes/js/jquery.validate.min.js"></script>
<script src="../includes/js/additional-methods.min.js"></script>


<script type="text/javascript">
 
 $(function () {
	 <?php
	 foreach(Core::$javascript as $script ){ 
             if(is_file($script)){
                include($script); 
             }else
             {
               core::debug("Javaskriptdatei: ".$script." konnte nicht geladen werden" )  ;
             }
             
         }
	 ?>
 
  
   
});

</script>


</head>

<body>
 <div data-role="header" id="header" data-position="fixed" class="ui-header ui-bar-inherit ui-header-fixed slidedown ui-fixed-hidden">
 
  
    <div id="menu">
       	  <a href="#menupanel" data-role="button" data-icon="bars" data-mini="true" data-iconpos="notext" data-inline="true" class="ui-link ui-btn ui-icon-bars ui-btn-icon-notext ui-btn-inline ui-shadow ui-corner-all ui-mini"></a>
         <?=core::$title ?>
    </div>
    
    <div id="logo"></div>
     <div id="search">
     	
     <?php if($_SESSION['uid']==""){?> <a href="?task=login" data-role="button" data-icon="user" data-mini="true" data-iconpos="notext" class="ui-link ui-btn ui-icon-user ui-btn-icon-notext ui-shadow ui-corner-all ui-mini" data-ajax="false"></a><?php }?>
   <?php if($_SESSION['uid']!=""){?><a href="?task=logout" data-role="button" data-icon="user" data-mini="true" data-iconpos="notext" class="ui-link ui-btn ui-icon-sign-out ui-btn-icon-notext ui-shadow ui-corner-all ui-mini" data-ajax="false"></a><?php }?>
 
     
     
     </div>
  </div>
<div id="page1" class="page" data-role="page">

 
  <div data-role="content" class="ui-content">
      <?php 
      require(Core::$navbar) ?>
        <?php if(count(Core::$errorMsg)>0) { ?>
      <div id="ErrorMessage" class="errorMessage">
   
    <?php echo(Core::showErrors());?>
   </div>
   <?php } ?>
   <?php if(count(core::$message)>0) { ?>
      <div id="message" class="message">
   
    <?php echo(Core::showMessages());?>
   </div>
   <?php } ?>
       <script type="text/javascript">
        function fadeMessage(){
   $('#message').fadeTo("fast",1);
  $('#message').fadeTo("slow",0);
  // $('#message').fadeOut("slow");
}
setTimeout(fadeMessage, 2500);
    </script>
    <div id="view1">
    <?php 
  Core::$view->render("view1");
    ?>
   </div>
   <div id="view2">
    <?php Core::$view->render("view2");?>
   </div>
   
 
  <?php if(core::$debugMode==1){?>
  <div id="debug">

  <?php
  if(Core::$debugPrint==1 ){
     if(count(core::$debug)>0){
      var_dump(core::$debug);    
     }
  }
  
  if(Core::$debugConsole==1 && count(core::$debug)>0){
  ?>
      <script language="javascript">
    <?php foreach(core::$debug as $debugitem){ ?>      
    console.log(<?=json_encode($debugitem);?>);
          
    <?php } ?></script>
 <?php
  }
  ?>
  </div>
      <div id="phpErrors">
  <?php }
  foreach($debugarray=xdebug_get_collected_errors() as $info){
   echo($info);
  }
  ?></div>
</div>

</div>
    
   
</body>

</html>