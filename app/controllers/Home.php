<?php
class Home extends Controller
{
  private $judul = "Home";
  public function index()
  {
    $data['judul'] = $this->judul;
    $this->view('home/index', $data);
  }

  public function login($pesan ="",$tipe = "")
  {
    $data['judul'] = $this->judul;
    if (!empty($pesan) && !empty($tipe) ) {        
      $data['pesan'] = flasher::setFlash($pesan, $tipe);
   }
    $this->view('home/login', $data);
  }

  public function santri($pesan ="",$tipe = "")
  {
    $data['judul'] = $this->judul;
    if (!empty($pesan) && !empty($tipe) ) {        
      $data['pesan'] = flasher::setFlash($pesan, $tipe);
   }
    $this->view('home/login_santri', $data);
  }

  public function do_login()
  {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
      $login =  SessionManager::login();

      if($login !== false && $login[0]['akses'] == 'admin'){
        header("Location:" . BASEURL.'sdm');
        exit(0);
      }elseif ($login !== false ) {
        header("Location:" . BASEURL.$login[0]['akses']);
        exit(0);
      } else {
        self::login('Periksa Kembali Masukan Anda', 'error');
      }
    } else {
      self::login('gagal', 'error');
    }
  }

  public function do_login_santri()
  {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
      $login =  SessionManager::santri();
      if ($login !== false ) {
        header("Location:" . BASEURL."santri");
        exit(0);
      } else {
        self::login('Periksa Kembali Masukan Anda', 'error');
      }
    } else {
      self::login('gagal', 'error');
    }
  }

  public function logout()
  {
    SessionManager::logout();
  }

  public function password()
  {
    $pass = Security::xss_input($_POST['password']);

    if(!empty($pass)) {
        
        if ($this->model('User_model')->password() > 0) {
          header("Location:".$_SERVER['HTTP_REFERER']."/index/berhasil-ganti-password/success");
          exit();
      } else {
        header("Location:".$_SERVER['HTTP_REFERER']."/index/anda-ngapain/error");
          exit();
      }

      }else{
        header("Location:".$_SERVER['HTTP_REFERER']."/anda-ngapain/error");
    }
  }
  public function logout_santri()
  {
    SessionManager::logout_santri();
  }
}
