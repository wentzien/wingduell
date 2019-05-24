<?php 
class Fragen extends DB{
// Variablenliste
    public $m_oid;
    public $c_ts;
    public $m_ts;
    public $Kategorie;
    public $Fragestellung;
    public $to_Antwort0;
    public $to_Runde;
    public $ts;

    public $dataMapping=array(
        'm_oid'=>'m_oid',
        'Kategorie'=>'Kategorie',
        'Fragestellung'=>'Fragestellung');
//        'to_Antwort0'=>'to_Antwort0',
//        'to_Runde'=>'to_Runde');
// Konstanten
    const SQL_INSERT='INSERT INTO Fragen (Kategorie, Fragestellung) VALUES (?,?)';
    const SQL_UPDATE='UPDATE Fragen SET Kategorie=?, Fragestellung=? WHERE m_oid=?';
    const SQL_SELECT_PK='SELECT * FROM Fragen WHERE m_oid=?';
    const SQL_SELECT_ALL='SELECT * FROM Fragen';
    const SQL_DELETE='DELETE FROM Fragen WHERE m_oid=?';
    const SQL_PRIMARY='m_oid';

    public $validateMapping=array(
        'm_oid'=>'FILTER_VALIDATE_INT',
        'Kategorie'=>'FILTER_VALIDATE_INT',
        'to_Antwort0'=>'FILTER_VALIDATE_INT',
        'to_Runde'=>'FILTER_VALIDATE_INT'
    );

    public $sanitizeMapping=array(
        'm_oid'=>'FILTER_SANITIZE_NUMBER_INT',
        'Kategorie'=>'FILTER_SANITIZE_NUMBER_INT',
        'to_Antwort0'=>'FILTER_SANITIZE_NUMBER_INT',
        'to_Runde'=>'FILTER_SANITIZE_NUMBER_INT'
    );
}