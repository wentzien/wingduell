<?php 
class Antwort extends DB{
// Variablenliste
    public $m_oid;
    public $c_ts;
    public $m_ts;
    public $Text0;
    public $Richtig;
    public $to_Spiel;
    public $to_Fragen;
    public $ts;

    public $dataMapping=array(
        'm_oid'=>'m_oid',
        'Text0'=>'Text0',
        'Richtig'=>'Richtig',
        'to_Spiel'=>'to_Spiel',
        'to_Fragen'=>'to_Fragen');
// Konstanten
    const SQL_INSERT='INSERT INTO Antwort (Text0, Richtig, to_Spiel, to_Fragen) VALUES (?,?,?,?)';
    const SQL_UPDATE='UPDATE Antwort SET Text0=?, Richtig=?, to_Spiel=?, to_Fragen=? WHERE m_oid=?';
    const SQL_SELECT_PK='SELECT * FROM Antwort WHERE m_oid=?';
    const SQL_SELECT_ALL='SELECT * FROM Antwort';
    const SQL_DELETE='DELETE FROM Antwort WHERE m_oid=?';
    const SQL_PRIMARY='m_oid';

    public $validateMapping=array(
        'm_oid'=>'FILTER_VALIDATE_INT',
        'Richtig'=>'FILTER_VALIDATE_INT',
        'to_Spiel'=>'FILTER_VALIDATE_INT',
        'to_Fragen'=>'FILTER_VALIDATE_INT'
    );

    public $sanitizeMapping=array(
        'm_oid'=>'FILTER_SANITIZE_NUMBER_INT',
        'Richtig'=>'FILTER_SANITIZE_NUMBER_INT',
        'to_Spiel'=>'FILTER_SANITIZE_NUMBER_INT',
        'to_Fragen'=>'FILTER_SANITIZE_NUMBER_INT'
    );
}