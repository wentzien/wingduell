<?php 
class Runde extends DB{
// Variablenliste
    public $m_oid;
    public $c_ts;
    public $m_ts;
    public $Rundenummer;
    public $to_Fragen;
    public $to_User;
    public $to_Spiel;
    public $ts;
    public $Rundenstatus;
    public $to_Antwort;

    public $dataMapping=array(
        'm_oid'=>'m_oid',
        'Rundenummer'=>'Rundenummer',
        'to_Fragen'=>'to_Fragen',
        'to_User'=>'to_User',
        'Rundenstatus'=>'Rundenstatus',
        'to_Antwort'=>'to_Antwort',
        'to_Spiel'=>'to_Spiel');
// Konstanten
    const SQL_INSERT='INSERT INTO Runde (Rundenummer, to_Fragen, to_User, to_Spiel, Rundenstatus,to_Antwort) VALUES (?,?,?,?,?,?)';
    const SQL_UPDATE='UPDATE Runde SET Rundenummer=?, to_Fragen=?, to_User=?, to_Spiel=?, Rundenstatus=?, to_Antwort=? WHERE m_oid=?';
    const SQL_SELECT_PK='SELECT * FROM Runde WHERE m_oid=?';
    const SQL_SELECT_ALL='SELECT * FROM Runde';
    const SQL_DELETE='DELETE FROM Runde WHERE m_oid=?';
    const SQL_PRIMARY='m_oid';

    public $validateMapping=array(
        'm_oid'=>'FILTER_VALIDATE_INT',
        'Rundenummer'=>'FILTER_VALIDATE_INT',
        'to_Fragen'=>'FILTER_VALIDATE_INT',
        'to_User'=>'FILTER_VALIDATE_INT',
        'to_Spiel'=>'FILTER_VALIDATE_INT'
    );

    public $sanitizeMapping=array(
        'm_oid'=>'FILTER_SANITIZE_NUMBER_INT',
        'Rundenummer'=>'FILTER_SANITIZE_NUMBER_INT',
        'to_Fragen'=>'FILTER_SANITIZE_NUMBER_INT',
        'to_User'=>'FILTER_SANITIZE_NUMBER_INT',
        'to_Spiel'=>'FILTER_SANITIZE_NUMBER_INT'
    );
}