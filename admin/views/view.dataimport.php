<style>
    #datadumps td{
        vertical-align: middle;
    }
    
</style>
    
    
    <?php
 /* @var $user User */
/* @var $data sqlData */


$liste=Core::$view->liste;


?>
<table data-role="table" id="datadumps" data-mode="reflow" class="ui-responsive">
  <thead>
    <tr>
     
      <th data-priority="persist">Sicherung</th>
      <th data-priority="2">Anwendungsklassen</th>
      <th data-priority="3">Enumerationen</th>
      <th data-priority="4">m:n-Klassen</th>
      <th data-priority="5">löschen</th>
    </tr>
  </thead>
  <tbody>
  <?php

  foreach($liste as $data){
     
   ?>
<tr>
      
     
      <td><a href="?task=dataimport&step=import&id=<?=$data->filename?>" data-role="button" data-icon="upload" data-mini="true" data-ajax="false"><?=$data->created?></a>
      
      <a href="files/<?=$data->filename?>"  data-role="button" data-icon="download" data-mini="true" data-ajax="false">SQL-Datei</a>
      </td>
      <td><?=$data->classes?></td>
      <td><?=$data->enums?></td>
      <td><?=$data->mn?></td>
      <td><a href="?task=dataimport&step=delete&id=<?=$data->filename?>" data-role="button" data-icon="delete" data-mini="true">löschen</a></td>
</tr>
<?php }
?>
  </tbody>
</table>
