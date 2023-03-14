<?php

class Santri_model
{
    private  $table1 = 's_primer';
    private  $table2 = 's_akun';
    private  $table3 = 's_mutasi';
    private  $table4 = 's_pendidikan';
    private  $table5 = 's_pengabdian';

    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function get()
    {
        $this->db->query('SELECT id,nama,nis,nisn,nik,
        hp_ayah,hp_ibu,hp_wali,
        concat(desa," ","RT/RW :",rt,"/",rw," ",kecamatan," ",kabupaten) alamat  FROM ' . $this->table1);
        return $this->db->resultSet();
    }


    public function get_single($id)
    {
        $id = Security::xss_input($id);
        $this->db->query('SELECT * FROM ' . $this->table1 . " where id=:id");
        $this->db->bind('id', $id);

        return $this->db->single();
    }

    public function update()
    {

        $id = intval(Security::xss_input($_POST['user']));
        $data = self::get_single($id);
        $nis = Security::xss_input($_POST['nis']);
        $nisn = Security::xss_input($_POST['nisn']);
        $nik = Security::xss_input($_POST['nik']);
        $va = Security::xss_input($_POST['va']);
        $nama = Security::xss_input($_POST['nama']);
        $jenis_kelamin = Security::xss_input($_POST['jenis_kelamin']);
        $tempat_lahir = Security::xss_input($_POST['tempat_lahir']);
        $tanggal_lahir = Security::xss_input($_POST['tanggal_lahir']);
        $anak_ke = Security::xss_input($_POST['anak_ke']);
        $jumlah_saudara = Security::xss_input($_POST['jumlah_saudara']);

        $ayah = Security::xss_input($_POST['ayah']);
        $tempat_lahir_ayah = Security::xss_input($_POST['tempat_lahir_ayah']);
        $tanggal_lahir_ayah = Security::xss_input($_POST['tanggal_lahir_ayah']);
        $pendidikan_ayah = Security::xss_input($_POST['pendidikan_ayah']);
        $pekerjaan_ayah = Security::xss_input($_POST['pekerjaan_ayah']);
        $penghasilan_ayah = Security::xss_input($_POST['penghasilan_ayah']);
        $nik_ayah = Security::xss_input($_POST['nik_ayah']);
        $hp_ayah = Security::xss_input($_POST['hp_ayah']);

        $ibu = Security::xss_input($_POST['ibu']);
        $tempat_lahir_ibu = Security::xss_input($_POST['tempat_lahir_ibu']);
        $tanggal_lahir_ibu = Security::xss_input($_POST['tanggal_lahir_ibu']);
        $pendidikan_ibu = Security::xss_input($_POST['pendidikan_ibu']);
        $pekerjaan_ibu = Security::xss_input($_POST['pekerjaan_ibu']);
        $penghasilan_ibu = Security::xss_input($_POST['penghasilan_ibu']);
        $nik_ibu = Security::xss_input($_POST['nik_ibu']);
        $hp_ibu = Security::xss_input($_POST['hp_ibu']);

        $wali = Security::xss_input($_POST['wali']);
        $tempat_lahir_wali = Security::xss_input($_POST['tempat_lahir_wali']);
        $tanggal_lahir_wali = Security::xss_input($_POST['tanggal_lahir_wali']);
        $pendidikan_wali = Security::xss_input($_POST['pendidikan_wali']);
        $pekerjaan_wali = Security::xss_input($_POST['pekerjaan_wali']);
        $penghasilan_wali = Security::xss_input($_POST['penghasilan_wali']);
        $nik_wali = Security::xss_input($_POST['nik_wali']);
        $hp_wali = Security::xss_input($_POST['hp_wali']);

        $provinsi = Security::xss_input($_POST['provinsi']);
        $kabupaten = Security::xss_input($_POST['kabupaten']);
        $kecamatan = Security::xss_input($_POST['kecamatan']);
        $desa = Security::xss_input($_POST['desa']);
        $jalan = Security::xss_input($_POST['jalan']);
        $rt = Security::xss_input($_POST['rt']);
        $rw = Security::xss_input($_POST['rw']);
        $lintang = Security::xss_input($_POST['lintang']);
        $bujur = Security::xss_input($_POST['bujur']);
        // var_dump($_FILES['akte']['name']) or die;
        $loc = "../public/" . Security::$img_santri;
        $kk = "";
        $ijazah = "";
        $skl = "";
        if (!empty($_FILES['akte']['name'])) {
            $rand = Security::random(100);
            $name = $loc . $rand . ".jpg";
            if (file_exists($loc . $data['akte'] . ".jpg")) {
                Security::remove_img($data['akte']);
            }

        move_uploaded_file($_FILES['akte']['tmp_name'], $name);
            $akte = ",akte = '" . $rand . "'";
        }

        if (!empty($_FILES['kk']['name'])) {
            $rand = Security::random(125);
            $name = $loc . $rand . ".jpg";
            if (file_exists($loc . $data['kk'] . ".jpg")) {
                Security::remove_img($data['kk']);
            }

            move_uploaded_file($_FILES['kk']['tmp_name'], $name);
            $kk = ",kk = '" . $rand . "'";
        }

        if (!empty($_FILES['ijazah']['name'])) {
            $rand = Security::random(125);
            $name = $loc . $rand . ".jpg";
            if (file_exists($loc.$data['ijazah'].".jpg")) {
                Security::remove_img($data['ijazah']);
            }
            
            move_uploaded_file($_FILES['ijazah']['tmp_name'], $name);   
            $ijazah = ",ijazah = '" . $rand . "'";
        }
        

        if (!empty($_FILES['skl']['name'])) {
            $rand = Security::random(125);
            $name = $loc . $rand . ".jpg";
            if (file_exists($loc.$data['skl'].".jpg")) {
                Security::remove_img($data['skl']);
            }
            
            move_uploaded_file($_FILES['skl']['tmp_name'], $name);   
            $skl = ",skl = '" . $rand . "'";
        }
        

        $query = "update $this->table1 set
        nis = :nis,
        nisn = :nisn,
        nik = :nik,
        va = :va,
        nama = :nama,
        jenis_kelamin = :jenis_kelamin,
        tempat_lahir = :tempat_lahir,
        tanggal_lahir = :tanggal_lahir,
        anak_ke = :anak_ke,
        jumlah_saudara = :jumlah_saudara,
        
        ayah = :ayah,
        tempat_lahir_ayah = :tempat_lahir_ayah,
        tanggal_lahir_ayah = :tanggal_lahir_ayah,
        pendidikan_ayah = :pendidikan_ayah,
        pekerjaan_ayah = :pekerjaan_ayah,
        penghasilan_ayah = :penghasilan_ayah,
        nik_ayah = :nik_ayah,
        hp_ayah = :hp_ayah,
        
        ibu = :ibu,
        tempat_lahir_ibu = :tempat_lahir_ibu,
        tanggal_lahir_ibu = :tanggal_lahir_ibu,
        pendidikan_ibu = :pendidikan_ibu,
        pekerjaan_ibu = :pekerjaan_ibu,
        penghasilan_ibu = :penghasilan_ibu,
        nik_ibu = :nik_ibu,
        hp_ibu = :hp_ibu,
        
        wali = :wali,
        tempat_lahir_wali = :tempat_lahir_wali,
        tanggal_lahir_wali = :tanggal_lahir_wali,
        pendidikan_wali = :pendidikan_wali,
        pekerjaan_wali = :pekerjaan_wali,
        penghasilan_wali = :penghasilan_wali,
        nik_wali = :nik_wali,
        hp_wali = :hp_wali,
        
        provinsi = :provinsi,
        kabupaten = :kabupaten,
        kecamatan = :kecamatan,
        desa = :desa,
        jalan = :jalan,
        rt = :rt,
        rw = :rw,
        lintang = :lintang,
        bujur = :bujur
        $akte $kk $ijazah $skl
                    where id = :id ";
        $this->db->query($query);
        $this->db->bind('id', $id);

        $this->db->bind("nis", $nis);
        $this->db->bind("nisn", $nisn);
        $this->db->bind("nik", $nik);
        $this->db->bind("va", $va);
        $this->db->bind("nama", $nama);
        $this->db->bind("jenis_kelamin", $jenis_kelamin);
        $this->db->bind("tempat_lahir", $tempat_lahir);
        $this->db->bind("tanggal_lahir", $tanggal_lahir);
        $this->db->bind("anak_ke", $anak_ke);
        $this->db->bind("jumlah_saudara", $jumlah_saudara);

        $this->db->bind("ayah", $ayah);
        $this->db->bind("tempat_lahir_ayah", $tempat_lahir_ayah);
        $this->db->bind("tanggal_lahir_ayah", $tanggal_lahir_ayah);
        $this->db->bind("pendidikan_ayah", $pendidikan_ayah);
        $this->db->bind("pekerjaan_ayah", $pekerjaan_ayah);
        $this->db->bind("penghasilan_ayah", $penghasilan_ayah);
        $this->db->bind("nik_ayah", $nik_ayah);
        $this->db->bind("hp_ayah", $hp_ayah);

        $this->db->bind("ibu", $ibu);
        $this->db->bind("tempat_lahir_ibu", $tempat_lahir_ibu);
        $this->db->bind("tanggal_lahir_ibu", $tanggal_lahir_ibu);
        $this->db->bind("pendidikan_ibu", $pendidikan_ibu);
        $this->db->bind("pekerjaan_ibu", $pekerjaan_ibu);
        $this->db->bind("penghasilan_ibu", $penghasilan_ibu);
        $this->db->bind("nik_ibu", $nik_ibu);
        $this->db->bind("hp_ibu", $hp_ibu);

        $this->db->bind("wali", $wali);
        $this->db->bind("tempat_lahir_wali", $tempat_lahir_wali);
        $this->db->bind("tanggal_lahir_wali", $tanggal_lahir_wali);
        $this->db->bind("pendidikan_wali", $pendidikan_wali);
        $this->db->bind("pekerjaan_wali", $pekerjaan_wali);
        $this->db->bind("penghasilan_wali", $penghasilan_wali);
        $this->db->bind("nik_wali", $nik_wali);
        $this->db->bind("hp_wali", $hp_wali);

        $this->db->bind("provinsi", $provinsi);
        $this->db->bind("kabupaten", $kabupaten);
        $this->db->bind("kecamatan", $kecamatan);
        $this->db->bind("desa", $desa);
        $this->db->bind("jalan", $jalan);
        $this->db->bind("rt", $rt);
        $this->db->bind("rw", $rw);
        $this->db->bind("lintang", $lintang);
        $this->db->bind("bujur", $bujur);

        $this->db->execute();

        return $this->db->rowCount();
    }
}
