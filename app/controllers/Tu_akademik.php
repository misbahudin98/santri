<?php


$data = SessionManager::getCurrentUser();

class Tu_akademik extends Controller
{

    private  $subdomain = "tu_akademik";

    public function index($pesan = '', $tipe = '')
    {
        if (!empty($pesan) && !empty($tipe)) {
            $this->primer($pesan, $tipe);
        } else {
            $this->primer("assalamu'alaikum-warohmatullohi-wabarokatuh", "success");
        }
    }

    public function primer($pesan = "", $tipe = "")
    {

        $data['judul'] = "Data Siswa ";
        $data['table'] = true;
        $data['button'] = true;
        $data['session'] = SessionManager::getCurrentUser();
        $data['subdomain'] = $this->subdomain;

        if (!empty($pesan) && !empty($tipe)) {
            $data['pesan'] = flasher::setFlash($pesan, $tipe);
        }

        $user = $this->model('Santri_model')->get();
        if (empty($user)) {
            $data['data'] = '[["","","","","","","","",""]]';
        } else {
            $a = [];
            foreach ($user as $key) {
                $b = [];
                foreach ($key as $key1 => $value1) {
                    if ($key1 == 'id') {
                        $button = '<button type="button" class="btn btn-warning" 
                        data-id="' . $value1 . '" title="edit user"><i class="fas fa-edit"></i></button>';
                        array_push($b, $button);
                    } else {
                        if (empty($value1)) array_push($b, "$key1 Kosong");
                        else array_push($b, $value1);
                    }
                }
                array_push($a, $b);
            }
            $data['data'] = json_encode($a);
        }

        $data['column'] = "[{title:'Aksi'},{title:'Nama'},{title:'NIS'},{title:'NISN'},{title:'NIK'},{title:'Ayah'},{title:'Ibu'},{title:'Wali'},{title:'Alamat'}]";
        $data['edit'] = 'edit';
        $data['update'] = 'update';
        // $data['tambah'] = 'tambah';

        $this->view('templates/header', $data);
        $this->view('templates/crud', $data);
        $this->view('templates/footer', $data);
    }

    public function coba($pesan = "", $tipe = "")
    {

        $data['judul'] = "Data Siswa ";
        $data['session'] = SessionManager::getCurrentUser();
        $data['subdomain'] = $this->subdomain;

        $data['button'] = true;
        $user = $this->model('Santri_model')->get_single(1);

        // var_dump($user )or die;

        $button1 = '<button type="button" class="btn btn-success extras" data-status="sudah" title="Order SUplier">
        Order 
        </button>';
        $data['tambah'] = 'tambah';
        $data['output'] = ' <img src="../'   .Security::$img_santri. $user['akte'] . '.jpg" width="80%" style="display: inline-block;" id="img">';

        $this->view('templates/header', $data);
        $this->view('templates/crud', $data);
        $this->view('templates/footer', $data);
    }



    public function edit()
    {
        $id = Security::xss_input($_POST['id']);
        $user = $this->model('Santri_model')->get_single($id);
        $data = $this->model("Alamat_model")->edit($user['provinsi']);
        //    var_dump($data['desa']) or die;
        $output = "";

        $output = flasher::input($user['id'], 'user', "text", "hidden");
        $output .= "<div class='row'><div class='col-md-4' ><h3>Data Dasar</h2>";
        $output .= " <img src='" . Security::$img_santri . "{$user['foto']}'  width='80%'  /> <br><br>";
        $output .= flasher::input($user['nis'], 'nis', 'number', "", "");
        $output .= flasher::input($user['nisn'], 'nisn', 'number', "", "");
        $output .= flasher::input($user['nik'], 'nik', 'number', "", "");
        $output .= flasher::input($user['va'], 'va', 'number', "", "");
        $output .= flasher::input($user['nama'], 'nama', 'text', "", "");
        $output .= flasher::input($user['jenis_kelamin'], 'jenis_kelamin', 'select', "", "", "", ["Perempuan" => "P", "Laki Laki" => "L"]);
        $output .= flasher::input($user['tempat_lahir'], 'tempat_lahir', 'date', "", "");
        $output .= flasher::input($user['tanggal_lahir'], 'tanggal_lahir', 'date', "", "");
        $output .= flasher::input($user['anak_ke'], 'anak_ke', 'number', "", "");
        $output .= flasher::input($user['jumlah_saudara'], 'jumlah_saudara', 'number', "", "");
        $output .= "<br><h4>Ayah </h4>";
        $output .= flasher::input($user['ayah'], 'ayah', 'text', "", "");
        $output .= flasher::input($user['tempat_lahir_ayah'], 'tempat_lahir_ayah', 'text', "", "");
        $output .= flasher::input($user['tanggal_lahir_ayah'], 'tanggal_lahir_ayah', 'date', "", "");
        $output .= flasher::input($user['pendidikan_ayah'], 'pendidikan_ayah', 'text', "", "");
        $output .= flasher::input($user['pekerjaan_ayah'], 'pekerjaan_ayah', 'text', "", "");
        $output .= flasher::input($user['penghasilan_ayah'], 'penghasilan_ayah', 'text', "", "");
        $output .= flasher::input($user['nik_ayah'], 'nik_ayah', 'text', "", "");
        $output .= flasher::input($user['hp_ayah'], 'hp_ayah', 'text', "", "");
        $output .= "<br>
        <h4>ibu </h4>";

        $output .= flasher::input($user['ibu'], 'ibu', 'text', "", "");
        $output .= flasher::input($user['tempat_lahir_ibu'], 'tempat_lahir_ibu', 'text', "", "");
        $output .= flasher::input($user['tanggal_lahir_ibu'], 'tanggal_lahir_ibu', 'date', "", "");
        $output .= flasher::input($user['pendidikan_ibu'], 'pendidikan_ibu', 'text', "", "");
        $output .= flasher::input($user['pekerjaan_ibu'], 'pekerjaan_ibu', 'text', "", "");
        $output .= flasher::input($user['penghasilan_ibu'], 'penghasilan_ibu', 'text', "", "");
        $output .= flasher::input($user['nik_ibu'], 'nik_ibu', 'text', "", "");
        $output .= flasher::input($user['hp_ibu'], 'hp_ibu', 'text', "", "");

        $output .= "<br><h4>wali </h4>";

        $output .= flasher::input($user['wali'], 'wali', 'text', "", "");
        $output .= flasher::input($user['tempat_lahir_wali'], 'tempat_lahir_wali', 'text', "", "");
        $output .= flasher::input($user['tanggal_lahir_wali'], 'tanggal_lahir_wali', 'date', "", "");
        $output .= flasher::input($user['pendidikan_wali'], 'pendidikan_wali', 'text', "", "");
        $output .= flasher::input($user['pekerjaan_wali'], 'pekerjaan_wali', 'text', "", "");
        $output .= flasher::input($user['penghasilan_wali'], 'penghasilan_wali', 'text', "", "");
        $output .= flasher::input($user['nik_wali'], 'nik_wali', 'text', "", "");
        $output .= flasher::input($user['hp_wali'], 'hp_wali', 'text', "", "");
        $output .= flasher::input($user['id'], 'user', "text", "hidden");

        $output .= "<br><h4>alamat orang tua / wali </h4>";
        $output .= flasher::input($user['provinsi'], 'provinsi', 'select', "", "required", "", $data['prov']);
        $output .= flasher::input($user['kabupaten'], 'kabupaten', 'select', "", "required", "", $data['kab']);
        $output .= flasher::input($user['kecamatan'], 'kecamatan', 'select', "", "required", "", $data['kec']);
        $output .= flasher::input($user['desa'], 'desa', 'select', "", "required", "", $data['desa']);

        $output .= flasher::input($user['jalan'], 'jalan');
        $output .= flasher::input($user['rt'], 'rt', 'number');
        $output .= flasher::input($user['rw'], 'rw', 'number');
        $output .= flasher::input($user['lintang'], 'lintang', 'number', "", "");
        $output .= flasher::input($user['bujur'], 'bujur', 'number', "", "");

        $output .= "</div><div class='col-md-8' > <h3>Data Pemberkasan</h3>";
        $output .= flasher::input($user['akte'], "akte", "file", "", "");
        $output .= flasher::input($user['kk'], "kk", "file", "", "");
        $output .= flasher::input($user['ijazah'], "ijazah", "file", "", "");
        $output .= flasher::input($user['skl'], "skl", "file", "", "");
        $output .= "<br><br><div class='input-group'><h4>Akte</h4> </div> <div class='input-group '> <img src='".BASEURL. Security::$img_santri . "{$user['akte']}.jpg'    width='80%'/></div>";
        $output .= "<br><br><div class='input-group'><h4>KK</h4> </div> <div class='input-group '> <img src='../" . Security::$img_santri . "{$user['kk']}.jpg'    width='80%'/></div>";
        $output .= "<br><br><div class='input-group'><h4>Ijazah</h4> </div> <div class='input-group '> <img src='../" . Security::$img_santri . "{$user['ijazah']}.jpg'    width='80%'/></div>";
        $output .= "<br><br><div class='input-group'><h4>SKL</h4> </div> <div class='input-group '> <img src='../" . Security::$img_santri . "{$user['skl']}.jpg'    width='80%'/></div>";
        $output .= "</div></div>";
        echo $output;
    }

    public function update()
    {

        if ($this->model('Santri_model')->update() > 0) {
            header("Location:" . BASEURL . "tu_akademik/primer/berhasil-mengubah-data!/success");
            exit();
        } else {
            header("Location:" . BASEURL . "tu_akademik/primer/Tidak-ada-data-yang-berubah!/error");
            exit();
        }
    }
}
