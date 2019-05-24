<?php
$listeAw=Core::$view->spielelisteAw;
$listeAl=Core::$view->spielelisteAl;
$listeAb=Core::$view->spielelisteAb;
$listeVw=Core::$view->spielelisteVw;
$listeVl=Core::$view->spielelisteVl;
$listeVb=Core::$view->spielelisteVb;
$schluessel=Core::$view->schluessel;
?>

<!--Angreifer-->	
<div class="ui-grid-a">

<div class="ui-block-b" style="background-color:lightgrey">
<h3>Spiele in denen du herausgefordert hast:</h3>
<br>
<hr>
<table data-role="table" id="movie-table" data-mode="reflow" class="ui-responsive">
  <thead>
    <tr>
      <th data-priority="1">Erstellt</abbr></th>  
      <th data-priority="1">Gegner</th>
      <th data-priority="1">Status</th>
      <th data-priority="1">Meine Punktzahl</th>
      <th data-priority="1">Gegnerpunktzahl</th>
      <th data-priority="1">geändert</th>
      <th data-priority="1"></th>
    </tr>
  </thead>
  <tbody>
  <?php
//Angreifer wartend  
/* @var $itemAw Spiel */
  foreach($listeAw as $itemAw){
   ?>
<tr>
      <td><?=Help::toDate($itemAw->c_ts)?></td>
      <td><?=$itemAw->kennung?></td>
      <td><?=$itemAw->myval?></td>
      <td><?=$itemAw->PunkteA?></td>
      <td><?=$itemAw->PunkteV?></td>
      <td><?=Help::toDate($itemAw->m_ts)?></td>
      <th data-priotity="1"><label>Du kannst leider nur warten...</label><div style="height:32px"></div></tr>
<?php }
?>

  <?php
//Angreifer laufend  
/* @var $itemAl Spiel */
  foreach($listeAl as $itemAl){
   ?>
<tr>
      <td><?=Help::toDate($itemAl->c_ts)?></td>
      <td><?=$itemAl->kennung?></td>
      <td><?=$itemAl->myval?></td>
      <td><?=$itemAl->PunkteA?></td>
      <td><?=$itemAl->PunkteV?></td>
      <td><?=Help::toDate($itemAl->m_ts)?></td>
      <?php 
      $spiel=new Spiel();
      $id=$itemAl->m_oid;
      $SQL="SELECT COUNT(*) as ergebnis FROM Runde WHERE Runde.to_Spiel=$id AND Runde.to_User=$schluessel AND Runde.Rundenstatus=0";
      $anzahlX=$spiel->findAll($SQL);
      $anzahl=$anzahlX[0]->ergebnis;
              if ($anzahl==0){
                ?>
                <th data-priotity="1"><label>Du hast bereits alle Fragen beantwortet.</label><div style="height:32px"></div></tr>
                <?php
              }
              else { ?>
      <th data-priotity="1">
       <form id="weiterspielenAngreifer" method="post" action="?task=spielen" data-ajax="false">
       <button class="ui-responsive" type="submit" value="<?=$itemAl->m_oid?>" name="Spiel">Weiterspielen</button>
       </form>
      </th>
              <?php } ?>
</tr>
<?php }
?>

<?php
//Angreifer beendet  
/* @var $itemAb Spiel */
  foreach($listeAb as $itemAb){
   ?>
<tr>
      <td><?=Help::toDate($itemAb->c_ts)?></td>
      <td><?=$itemAb->kennung?></td>
      <td><?=$itemAb->myval?></td>
      <td><?=$itemAb->PunkteA?></td>
      <td><?=$itemAb->PunkteV?></td>
      <td><?=Help::toDate($itemAb->m_ts)?></td>
      <th data-priotity="1">
       <form id="spielinfoAngreifer" method="post" action="?task=spielinfo" data-ajax="false">
       <button class="ui-responsive" type="submit" value="<?=$itemAb->m_oid?>" name="spielinfo">Spielinfo</button>
       </form>
      </th>
</tr>
<?php }
?>
  </tbody>  
</table>

</div>

<div class="ui-block-b" style="background-color:lightgray">
    
<!--Verteidiger-->
<h3> Spiele in denen du herausgefordert wurdest:</h3>
<br>
<hr>
<table data-role="table" id="movie-table" data-mode="reflow" class="ui-responsive">
  <thead>
    <tr>
      <th data-priority="1">Erstellt</abbr></th>  
      <th data-priority="1">Gegner</th>
      <th data-priority="1">Status</th>
      <th data-priority="1">Meine Punktzahl</th>
      <th data-priority="1">Gegnerpunktzahl</th>
      <th data-priority="1">geändert</th>
      <th data-priority="1"></th>
    </tr>
  </thead>
  <tbody>
  <?php
//Verteidiger wartend  
/* @var $itemVw Spiel */
  foreach($listeVw as $itemVw){
   ?>
<tr>
      <td><?=Help::toDate($itemVw->c_ts)?></td>
      <td><?=$itemVw->kennung?></td>
      <td><?=$itemVw->myval?></td>
      <td><?=$itemVw->PunkteV?></td>
      <td><?=$itemVw->PunkteA?></td>
      <td><?=Help::toDate($itemVw->m_ts)?></td>
      <th data-priotity="1"><label>
          <form id="annehmen" method="post" action="?task=annehmen" data-ajax="false">
       <button class="ui-responsive" type="submit" value="<?=$itemVw->m_oid?>" name="annehmen">Annehmen</button>
       </form>
</tr>
<?php }
?>

  <?php
//Verteidiger laufend  
/* @var $itemVl Spiel */
  foreach($listeVl as $itemVl){
   ?>
<tr>
      <td><?=Help::toDate($itemVl->c_ts)?></td>
      <td><?=$itemVl->kennung?></td>
      <td><?=$itemVl->myval?></td>
      <td><?=$itemVl->PunkteV?></td>
      <td><?=$itemVl->PunkteA?></td>
      <td><?=Help::toDate($itemVl->m_ts)?></td>
      
      
      
      <?php 
      $spiel=new Spiel();
      $id=$itemVl->m_oid;
      $SQL="SELECT COUNT(*) as ergebnis FROM Runde WHERE Runde.to_Spiel=$id AND Runde.to_User=$schluessel AND Runde.Rundenstatus=0";
      $anzahlX=$spiel->findAll($SQL);
      $anzahl=$anzahlX[0]->ergebnis;
              if ($anzahl==0){
                ?>
                <th data-priotity="1"><label>Du hast bereits alle Fragen beantwortet.</label><div style="height:32px"></div></tr>
                <?php
              }
              else { ?>
      <th data-priotity="1">
       <form id="weiterspielenAngreifer" method="post" action="?task=spielen" data-ajax="false">
       <button class="ui-responsive" type="submit" value="<?=$itemVl->m_oid?>" name="Spiel">Weiterspielen</button>
       </form>
      </th>
              <?php } ?>
      
      
      
      
</tr>
<?php }
?>

<?php
//Verteidiger beendet  
/* @var $itemVb Spiel */
  foreach($listeVb as $itemVb){
   ?>
<tr>
      <td><?=Help::toDate($itemVb->c_ts)?></td>
      <td><?=$itemVb->kennung?></td>
      <td><?=$itemVb->myval?></td>
      <td><?=$itemVb->PunkteV?></td>
      <td><?=$itemVb->PunkteA?></td>
      <td><?=Help::toDate($itemVb->m_ts)?></td>
      <th data-priotity="1">
       <form id="spielinfoVerteidiger" method="post" action="?task=spielinfo" data-ajax="false">
       <button class="ui-responsive" type="submit" value="<?=$itemVb->m_oid?>" name="spielinfo">Spielinfo</button>
       </form>
      </th>
</tr>
<?php }
?>
  </tbody>  
</table>



    
    
    
    
</div>
    
    
    
    
</div><!-- /grid-a -->