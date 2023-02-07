<?php 

class Santri_model
{
    private  $table = 'user';
    private  $table1 = 'akses';
    private  $table2 = 'sdm';
    private  $table3 = 's_akun';
    private  $table4 = 's_primer';

    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }



}