Wählen Sie Ihre Datenbank für den Transfer aus<br><?php
 /* @var $user User */
/* @var $tbl Table */

$dblist=Core::$view->tables;



?>
<form name="database" id="database" method="post" action="?task=import" data-ajax="false">
	<div class="ui-field-contain">
        <label for="database">Datenbanken auf dem Localhost</label><?php Help::htmlSelect($dblist,array("name"=>"database","key"=>"tablename","text"=>"tablename")); ?>
		
        <label for="database">Datenbank</label><input type="submit" name="step" id="step" value="weiter"/>
	</div>
</form>



