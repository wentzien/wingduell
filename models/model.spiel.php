<?php 
class Spiel extends DB{
// Variablenliste
    public $m_oid;
    public $c_ts;
    public $m_ts;
    public $Status0;
    public $PunkteA;
    public $PunkteV;
    public $to_Antwort;
    public $to_Runde;
    public $Angreifer;
    public $Verteidiger;
    public $ts;

    public $dataMapping=array(
        'm_oid'=>'m_oid',
        'Status0'=>'Status0',
        'PunkteA'=>'PunkteA',
        'PunkteV'=>'PunkteV',
        'to_Antwort'=>'to_Antwort',
        'to_Runde'=>'to_Runde',
        'Angreifer'=>'Angreifer',
        'Verteidiger'=>'Verteidiger');
// Konstanten
    const SQL_INSERT='INSERT INTO Spiel (Status0, PunkteA, PunkteV, to_Antwort, to_Runde, Angreifer, Verteidiger) VALUES (?,?,?,?,?,?,?)';
    const SQL_UPDATE='UPDATE Spiel SET Status0=?, PunkteA=?, PunkteV=?, to_Antwort=?, to_Runde=?, Angreifer=?, Verteidiger=? WHERE m_oid=?';
    const SQL_SELECT_PK='SELECT * FROM Spiel WHERE m_oid=?';
    const SQL_SELECT_ALL='SELECT * FROM Spiel';
    const SQL_DELETE='DELETE FROM Spiel WHERE m_oid=?';
    const SQL_PRIMARY='m_oid';

    public $validateMapping=array(
        'm_oid'=>'FILTER_VALIDATE_INT',
        'Status0'=>'FILTER_VALIDATE_INT',
        'PunkteA'=>'FILTER_VALIDATE_INT',
        'PunkteV'=>'FILTER_VALIDATE_INT',
        'to_Antwort'=>'FILTER_VALIDATE_INT',
        'to_Runde'=>'FILTER_VALIDATE_INT',
        'Angreifer'=>'FILTER_VALIDATE_INT',
        'Verteidiger'=>'FILTER_VALIDATE_INT'
    );

    public $sanitizeMapping=array(
        'm_oid'=>'FILTER_SANITIZE_NUMBER_INT',
        'Status0'=>'FILTER_SANITIZE_NUMBER_INT',
        'PunkteA'=>'FILTER_SANITIZE_NUMBER_INT',
        'PunkteV'=>'FILTER_SANITIZE_NUMBER_INT',
        'to_Antwort'=>'FILTER_SANITIZE_NUMBER_INT',
        'to_Runde'=>'FILTER_SANITIZE_NUMBER_INT',
        'Angreifer'=>'FILTER_SANITIZE_NUMBER_INT',
        'Verteidiger'=>'FILTER_SANITIZE_NUMBER_INT'
    );
}