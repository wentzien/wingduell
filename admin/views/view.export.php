Achten Sie darauf, diese Seite von Ihrem Livewebspace aus aufzurufen, da Sie sonst nicht tut!!<br><?php
 /* @var $user User */
/* @var $tbl Table */

$user=Core::$user;
$tablelist=Core::$view->tables;
if($user->vorname!=""){echo "Willkommen ".$user->vorname." ".$user->nachname."</br>";}

foreach($tablelist as $tbl){
    
    echo $tbl->tablename."(".$tbl->type.")</br>";
}

?>
