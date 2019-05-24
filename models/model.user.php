<?php /*  @var $help HelperClass
 
 * 
 *  */

class User extends DB{
    
 const SQL_INSERT_AUTOINCREMENT='INSERT INTO User (c_ts,m_ts,gruppe,kennung,passwort,vorname,nachname,rating) VALUES (?,?,?,?,?,?,?)';
 const SQL_INSERT='INSERT INTO User (c_ts,m_ts,gruppe,kennung,passwort,vorname,nachname,rating) VALUES (?,?,?,?,md5(?),?,?,?)';
    const SQL_UPDATE='UPDATE User SET m_ts=?,gruppe=?,passwort=?,vorname=?, nachname=?, rating=? WHERE m_oid=?';
    const SQL_SELECT_PK='SELECT * FROM User WHERE m_oid=?';
    const SQL_SELECT_ALL='SELECT * FROM User';
    const SQL_DELETE='DELETE FROM User WHERE m_oid=?';
    
    
    
 Public  $m_oid;
 Public  $c_ts;
 Public  $m_ts;
 Public  $gruppe;
 Public  $kennung;
 Public  $passwort;
 Public  $vorname;
 Public  $nachname;
 Public  $rating;

public $dataMapping=array(
        'm_oid'=>'id',
        'nachname'=>'Nachname',
        'vorname'=>'Vorname',
        'kennung'=>'Kennung',
        'passwort'=>'Passwort' );
 


 
public function login($username,$password){
    $param=array($username,$password);
    
    $SQL="SELECT * FROM User WHERE kennung=? AND passwort=md5(?)";
    
    $result=$this->query($SQL, $param);
    
    if($result){
        $this->import($result);
        $_SESSION['uid']=$this->m_oid;
        $_SESSION['fullName']=$this->vorname." ".$this->nachname;
        return true;
    }else{
        Core::redirect("login",array("message"=>"Sie konnten nicht angemeldet werden","check"=>"1"));
        return false;
        
    }   
}
 
  
public  function logout(){
	$_SESSION['uid']="";
	$_SESSION['fullName']="";
        session_destroy();
    
        foreach ($this as $key => $value) {
            $this->$key = null;  // Löscht alle Werte aus dem aktuellen User-Objekt (nicht in der DB)
        }
       
}
        

}