<?php 

class Akademik_model
{
    private  $table = 'ak_kampus';
    private  $table1 = 'ak_sekolah';
    private  $table2 = 'ak_kepala_sekolah';
    private  $table3 = 'ak_mapel';
    private  $table4 = 'ak_mengajar';
    private  $table5 = 'ak_rombel';
    private  $table6 = 'ak_wali_kelas';

    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }


}