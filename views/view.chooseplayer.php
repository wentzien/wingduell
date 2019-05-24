<?php
$liste=Core::$view->artikelliste;
?>
<table data-role="table" id="movie-table" data-mode="reflow" class="ui-responsive">
  <thead>
    <tr>
      <th data-priority="1">ID</th>
      <th data-priority="persist">Artikel</th>
      <th data-priority="2">Preis</th>
      <th data-priority="3"><abbr title="Rotten Tomato Rating">erstellt</abbr></th>
      <th data-priority="4">geändert</th>
    </tr>
  </thead>
  <tbody>
  <?php
/* @var $item Artikel */
  foreach($liste as $item){
     
   ?>
<tr>
      <td><?=$item->m_oid?></td>
      <td><a href="?task=artikeldetail&id=<?=$item->m_oid?>"><?=$item->Bezeichnung?></a></td>
      <td><?=Help::currency($item->Preis)?></td>
      <td><?=Help::toDate($item->c_ts)?></td>
      <td><?=Help::toDate($item->m_ts)?></td>
</tr>
<?php }
?>
  </tbody>
</table>