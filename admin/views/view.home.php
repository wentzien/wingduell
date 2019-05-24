<style>
    #remoteTable li, #remoteTable th {
     border-style: none;  
     padding-bottom: 0px;
     padding-top: 0px;
     
    }
    #remoteTable td{
        vertical-align: middle;
    }
    #remoteTable ul{
        margin-top: 0px;
        margin-bottom: 0px;
    }
    #remoteTable ul li ul li:nth-child(even){
        background-color: #eeeeee;
    }
    .tabledata{
        background-color: #cbe5ff;
        
    }
    .tabledata thead{
        background-color: #1c4a70;
        color: #f3f3f3;
        text-shadow: 0 /*{a-body-shadow-x}*/ 0px /*{a-body-shadow-y}*/ 0 /*{a-body-shadow-radius}*/ #f3f3f3 /*{a-body-shadow-color}*/;
        
    }
</style>
<h3>Folgende Tabellen befinden sich derzeit auf Ihrem Webspace:</h3><?php
 /* @var $user User */
/* @var $tbl Table */

$user=Core::$user;
$tablelist=Core::$view->tables;
if($user->vorname!=""){echo "Willkommen ".$user->vorname." ".$user->nachname."</br>";}

 /* @var $user User */
/* @var $tbl Table */
$tables=Core::$view->tables;
?>


<table data-role="table" id="remoteTable" data-mode="reflow" class="ui-responsive">
  <thead>
    <tr>
      <th data-priority="1">Tabelle</th>
      <th data-priority="persist">Typ</th>
      <th data-priority="persist">Model</th>
      
    </tr>
  </thead>
  <tbody>
<?php
 
foreach($tables as $tbl){?>
      <tr>
          <td><ul data-role="listview" data-inset="false" data-shadow="false" data-mini="true">
  <li data-role="collapsible" data-iconpos="right" data-inset="false"  data-mini="true">
      <h2><?=$tbl->tablename?></h2>
    <ul data-role="listview" data-theme="a" data-mini="true"><?php foreach($tbl->cols as $column){echo'<li data-mini="true"><b>'.$column->Field.'</b>  ('.$column->Type.')</li>';}?>
    
    
    <li><table class="tabledata"><?php $first=true;$headers=array();
  foreach($tbl->data as $dataset){
      
      $rows=array();
      
      ?>
          
      <?php foreach($dataset as $key => $value){
                 if($first){ array_push($headers,$key);}
                 array_push($rows,$value);
      }
      if($first){ ?><thead> <tr>
          <?php
          foreach($headers as $headcol){ ?>
      <th><b><?=$headcol?></b></th>
          <?php
          }
          ?>
        </tr></thead><tbody>
        <?php  
      } ?>
      <tr>
      <?php
      
        foreach($rows as $datacol){ ?>
           <td><?=$datacol?></td>
          <?php
          }
      
      
      $first=false;
      ?></tr>  <?php }  ?>
        </tbody></table></li>        
    
    
    
    
    
    
    
    
    </ul>
  </li> 
              
  
              
              
              </ul> </td><td><?=$tbl->type?>
  
  
  
  </td>
  <td><?php if($tbl->model){
      
      echo"✔";
  }else{
      echo'<a href="?task=createmodel&tablename='.$tbl->tablename.'" data-role="button" data-mini="true" data-icon="plus" data-iconpos="right" data-inset="false">create</a>';
  }
?>
  
  
  
  </td>
          
      </tr>
<?php } ?>
          
</tbody>
</table>



















