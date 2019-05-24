<?php 
class KategorieT extends DB{
// Variablenliste
    public $myval;
    public $codes;
    public $valActive;
    public $rno;
    public $ts;

    public $dataMapping=array(
        'myval'=>'myval',
        'codes'=>'codes',
        'valActive'=>'valActive',
        'rno'=>'rno');
// Konstanten
    const SQL_INSERT='INSERT INTO KategorieT (myval, codes, valActive, rno) VALUES (?,?,?,?)';
    const SQL_UPDATE='UPDATE KategorieT SET myval=?, valActive=?, rno=? WHERE codes=?';
    const SQL_SELECT_PK='SELECT * FROM KategorieT WHERE codes=?';
    const SQL_SELECT_ALL='SELECT * FROM KategorieT';
    const SQL_DELETE='DELETE FROM KategorieT WHERE codes=?';
    const SQL_PRIMARY='codes';

    public $validateMapping=array(
        'codes'=>'FILTER_VALIDATE_INT',
        'valActive'=>'FILTER_VALIDATE_INT',
        'rno'=>'FILTER_VALIDATE_INT'
    );

    public $sanitizeMapping=array(
        'codes'=>'FILTER_SANITIZE_NUMBER_INT',
        'valActive'=>'FILTER_SANITIZE_NUMBER_INT',
        'rno'=>'FILTER_SANITIZE_NUMBER_INT'
    );
}