<?php


$data = SessionManager::getCurrentAdmin();

class SDM extends Controller
{


    private  $subdomain = "sdm";

    public function index()
    {

        $this->sdm("assalamu'alaikum-warohmatullohi-wabarokatuh", "success");
    }

    public function akses($pesan = '', $tipe = '')
    {
        $data['judul'] = "Data Akses";
        $data['table'] = true;
        $data['button'] = true;
        $data['session'] = SessionManager::getCurrentAdmin();

        if (!empty($pesan) && !empty($tipe)) {

            $data['pesan'] = flasher::setFlash($pesan, $tipe);
        }

        $data['subdomain'] = $this->subdomain;

        $user = $this->model('User_model')->access();
        if (empty($user)) {
            $data['data'] = '[["","","","",""]]';
        } else {
            $a = [];
            foreach ($user as $key) {
                $b = [];
                foreach ($key as $key1 => $value1) {
                    if ($key1 == 'id') {
                        $button = '<button type="button" class="btn btn-warning" data-id="' . $value1 . '" title="edit user"><i class="fas fa-edit"></i></button>';
                        array_push($b, $button);
                    } elseif ($key1 == 'status_akses') {
                        $button = $value1 == 1 ? "Aktif" : "Nonaktif";
                        array_push($b, $button);
                    } else {
                        array_push($b, $value1);
                    }
                }
                array_push($a, $b);
            }
            $data['data'] = json_encode($a);
        }

        $nry = $this->model('User_model')->nry();

        $output = flasher::input("", 'nry', 'select', "", "required", "", $nry);
        $output .= flasher::input("", 'akses', "select", "required", "", "", ['SDM' => 'sdm', 'Logistik' => 'logistik', 'Konten' => 'konten', 'Marketing' => 'marketing', 'Customer Service' => 'cs', 'Penjualan' => 'penjualan', 'Keuangan' => 'keuangan', 'Pendapatan' => 'pendapatan']);
        $data['output']  = $output;

        $data['column'] = "[{title:'Aksi'},  {title:'nry'},{title:'akses'},{title:'Terakhir diupdate'},{title:'Status Akses'}]";
        $data['edit'] = 'edit_akses';
        $data['update'] = 'update_akses';



        $data['tambah'] = 'tambah_akses';

        $this->view('templates/header', $data);
        $this->view('templates/crud', $data);

        $this->view('templates/footer', $data);
    }

    public function sdm($pesan = "", $tipe = "")
    {

        $data['judul'] = "Data Akun";
        $data['table'] = true;
        $data['button'] = true;
        $data['session'] = SessionManager::getCurrentAdmin();

        if (!empty($pesan) && !empty($tipe)) {

            $data['pesan'] = flasher::setFlash($pesan, $tipe);
        }

        $data['subdomain'] = $this->subdomain;

        $user = $this->model('User_model')->get();
        if (empty($user)) {
            $data['data'] = '[["","","","",""]]';
        } else {
            $a = [];
            foreach ($user as $key) {
                $b = [];
                foreach ($key as $key1 => $value1) {
                    if ($key1 == 'id') {
                        $button = '<button type="button" class="btn btn-warning" data-id="' . $value1 . '" title="edit user"><i class="fas fa-edit"></i></button>';
                        array_push($b, $button);
                    } elseif ($key1 == 'status_akun') {
                        $button = $value1 == 1 ? "Aktif" : "Nonaktif";
                        array_push($b, $button);
                    } else {
                        array_push($b, $value1);
                    }
                }
                array_push($a, $b);
            }
            $data['data'] = json_encode($a);
        }


        $data['column'] = "[{title:'Aksi'},  {title:'nry'},{title:'Status'},{title:'Terakhir Diakses'},{title:'IP'}]";
        $data['edit'] = 'edit';
        $data['update'] = 'update';
        $data['tambah'] = 'tambah';
        $data['output'] = flasher::input("", 'nry');
        $data['output'] .= flasher::input("", 'nama');


        $this->view('templates/header', $data);
        $this->view('templates/crud', $data);
        $this->view('templates/footer', $data);
    }

    public function detail($pesan = "", $tipe = "")
    {
        $data['judul'] = "Data Pribadi";
        $data['table'] = true;
        $data['button'] = true;
        $data['session'] = SessionManager::getCurrentAdmin();

        if (!empty($pesan) && !empty($tipe)) {

            $data['pesan'] = flasher::setFlash($pesan, $tipe);
        }
        $data['subdomain'] = $this->subdomain;
        $user = $this->model('User_model')->detail();
        // var_dump($user) or die;
        if (empty($user)) {
            $data['data'] = '[["","","","","","","","","","","","","","",""]]';
        } else {
            $a = [];
            foreach ($user as $key) {
                $b = [];
                foreach ($key as $key1 => $value1) {
                    if ($key1 == 'id_user') {
                        $button = '<button type="button" class="btn btn-warning" 
                        data-id="' . $value1 . '" title="edit user"><i class="fas fa-edit"></i></button>';
                        array_push($b, $button);
                    } else {
                        array_push($b, $value1);
                    }
                }
                array_push($a, $b);
            }
            $data['data'] = json_encode($a);
        }


        $data['column'] = "[{title:'Aksi'},  {title:'Kampus'},  {title:'Sekolah'}
        ,  {title:'nry'},{title:'nama'},
        {title:'tgl_lahir'},{title:'nik'},{title:'jalan'},{title:'rt'},{title:'rw'},
        {title:'desa'},{title:'kecamatan'},{title:'kota_kabupaten'},{title:'provinsi'},
        {title:'kontak'},{title:'email'}]";
        $data['edit'] = 'edit_detail';
        $data['update'] = 'update_detail';

        $nry = $this->model('User_model')->nry();
        $provinsi = $this->model("Alamat_model")->provinsi();
        

        $this->view('templates/header', $data);
        $this->view('templates/crud', $data);
        $this->view('templates/footer', $data);
    }
    public function tambah()
    {

        if ($this->model('User_model')->tambah() > 0) {
            header("Location:" . BASEURL . "sdm/sdm/berhasil-menambah-data!/success");
            exit();
        } else {
            header("Location:" . BASEURL . "sdm/sdm/Gagal-menambah-data!/error");
            exit();
        }
    }

    public function tambah_akses()
    {

        if ($this->model('User_model')->tambah_akses() > 0) {
            header("Location:" . BASEURL . "sdm/akses/berhasil-menambah-data!/success");
            exit();
        } else {
            header("Location:" . BASEURL . "sdm/akses/Gagal-menambah-data!/error");
            exit();
        }
    }
    public function tambah_detail()
    {

        if ($this->model('User_model')->tambah_detail() > 0) {
            header("Location:" . BASEURL . "sdm/detail/berhasil-menambah-data!/success");
            exit();
        } else {
            header("Location:" . BASEURL . "sdm/detail/Gagal-menambah-data!/error");
            exit();
        }
    }

    public function edit()
    {
        $id = Security::xss_input($_POST['id']);
        $user = $this->model('User_model')->get_single($id);
        $output = flasher::input($user['id'], 'user', "text", "hidden");

        $output .= flasher::input($user['nry'], 'nry', 'text');
        if($user['id'] != '0'){
            $output .= flasher::input($user['status_akun'], 'status', "select", "required", "", "", ['Aktif' => 1, 'Nonaktif' => 0]);

        }
        $output .= flasher::input("reset", 'reset_password', "checkbox", "", "");

        echo $output;
    }
    public function edit_akses()
    {
        $id = Security::xss_input($_POST['id']);
        $user = $this->model('User_model')->get_single1($id);
        $nry = $this->model('User_model')->nry();

        $output = flasher::input($user['id'], 'user', "text", "hidden");
        $output .= flasher::input($user['id_user'], 'nry', 'select', "", "required", "", $nry);
        $output .= flasher::input($user['akses'], 'akses', "select", "required", "", "", ['SDM' => 'sdm', 'Logistik' => 'logistik', 'Konten' => 'konten', 'Marketing' => 'marketing', 'Customer Service' => 'cs', 'Penjualan' => 'penjualan', 'Keuangan' => 'keuangan', 'Pendapatan' => 'pendapatan']);
        $output .= flasher::input($user['status_akses'], 'status', "select", "required", "", "", ['Aktif' => 1, 'Nonaktif' => 0]);

        echo $output;
    }

    public function edit_detail()
    {
        $id = Security::xss_input($_POST['id']);
        $user = $this->model('User_model')->get_single2($id);
        $provinsi = $this->model("Alamat_model")->provinsi();
        $kampus = $this->model("User_model")->kampus();
        $sekolah = $this->model("User_model")->sekolah();
        // var_dump($sekolah ) or die;

        // var_dump($user) or die;
        $output = flasher::input($user['id_user'], 'user', "text", "hidden");
        $output .= flasher::input($user['kd_kampus'], 'kampus', 'select', "", "required", "", $kampus, "");
        $output .= flasher::input($user['kd_sekolah'], 'sekolah', 'select', "", "required", "", $sekolah, "");
        
        $output .= flasher::input($user['nama'], 'nama');
        $output .= flasher::input($user['tgl_lahir'], 'tgl_lahir', 'date');
        $output .= flasher::input($user['nik'], 'nik', 'number');
        $output .= flasher::input($user['provinsi'], 'provinsi', 'select', "", "required", "", $provinsi, "", 'provinsi');
        $output .= flasher::input($user['kota_kabupaten'], 'kabupaten', 'select', "", "required", "");
        $output .= flasher::input($user['kecamatan'], 'kecamatan', 'select', "", "required", "");
        $output .= flasher::input($user['desa'], 'desa', 'select', "", "required", "");
        $output .= flasher::input($user['jalan'], 'jalan');
        $output .= flasher::input($user['rt'], 'rt', 'number');
        $output .= flasher::input($user['rw'], 'rw', 'number');

        $output .= flasher::input($user['kontak'], 'kontak', 'number');
        $output .= flasher::input($user['email'], 'email');



        echo $output;
    }

    public function update()
    {

        if ($this->model('User_model')->update() > 0) {
            header("Location:" . BASEURL . "sdm/sdm/berhasil-mengubah-data!/success");
            exit();
        } else {
            header("Location:" . BASEURL . "sdm/sdm/Tidak-ada-data-yang-berubah!/error");
            exit();
        }
    }

    public function update_akses()
    {

        if ($this->model('User_model')->update_akses() > 0) {
            header("Location:" . BASEURL . "sdm/akses/berhasil-mengubah-data!/success");
            exit();
        } else {
            header("Location:" . BASEURL . "sdm/akses/Tidak-ada-data-yang-berubah!/error");
            exit();
        }
    }

    public function update_detail()
    {
        if ($this->model('User_model')->update_detail() > 0) {
            header("Location:" . BASEURL . "sdm/detail/berhasil-mengubah-data!/success");
            exit();
        } else {
            header("Location:" . BASEURL . "sdm/detail/Tidak-ada-data-yang-berubah!/error");
            exit();
        }
    }
}
