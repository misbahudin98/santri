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

        $user = $this->model('tu_akademik_model')->get();
        if (empty($user)) {
            $data['data'] = '[["","","","",""]]';
        } else {
            $a = [];
            foreach ($user as $key) {
                $b = [];
                foreach ($key as $key1 => $value1) {
                    if ($key1 == 'id') {
                        $button = '<button type="button" class="btn btn-warning" 
                        data-id="' . $value1 . '" title="edit user"><i class="fas fa-edit"></i></button>';
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
        
        $data['column'] = "[{title:'Aksi'},  {title:'username'},{title:'Status'},{title:'Terakhir Diakses'},{title:'IP'}]";
        $data['edit'] = 'edit';
        $data['update'] = 'update';
        $data['tambah'] = 'tambah';

        $data['output'] = flasher::input("", 'username');


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



    public function edit()
    {
        $id = Security::xss_input($_POST['id']);
        $user = $this->model('User_model')->get_single($id);
        $output = "";

        if ($user['id'] != 0) {
            $output = flasher::input($user['id'], 'user', "text", "hidden");
            $output .= flasher::input($user['username'], 'username', 'text');
            $output .= flasher::input($user['status_akun'], 'status', "select", "required", "", "", ['Aktif' => 1, 'Nonaktif' => 0]);
            $output .= flasher::input("reset", 'reset_password', "checkbox", "", "");
        }
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
}
