    <?php

    class User_model
    {
        private  $table = 'user';
        private  $table1 = 'akses';
        private  $table2 = 'sdm';
        private  $table3 = 's_akun';
        private  $table4 = 's_primer';
        private  $table5 = 'ak_kampus';
        private  $table6 = 'ak_sekolah';

        private $db;

        public function __construct()
        {
            $this->db = new Database;
        }

        //session
        public function login()
        {
            if (isset($_POST['nry'], $_POST['password'])) {
                $nry = Security::xss_input($_POST['nry']);
                $password = Security::xss_input($_POST['password']);


                $query = "select * from $this->table a  
                inner join $this->table2 b on a.id = b.id_user  
                where  a.nry =:nry  and a.status_akun = '1' ";
                $this->db->query($query);
                $this->db->bind("nry", $nry);
                $this->db->execute();

                $result =  $this->db->single();
                // var_dump($result['password']) or die;
                // var_dump(password_verify($password , $result['password']))or die();

                if (is_array($result)) {
                    $pass = Security::pass_verify($password, $result['password']);
                    $data = $this->db->single();
                    // var_dump($data['nama'])or die();
                    if ($pass == true && !empty($data['nama']))  return $data;
                    else return false;
                } else return false;
            } else return false;
        }

        public function login_santri()
        {
            if (isset($_POST['nisn'], $_POST['password'])) {
                $nisn = Security::xss_input($_POST['nisn']);
                $password = Security::xss_input($_POST['password']);


                $query = "select * from $this->table3 a  inner join $this->table4 b on a.id_santri = b.id  where  b.nisn =:nisn  and a.status_akun = '1' ";
                $this->db->query($query);
                $this->db->bind("nisn", $nisn);
                $this->db->execute();

                $result =  $this->db->single();


                if (is_array($result)) {
                    $pass = Security::pass_verify($password, $result['password']);
                    $data = $this->db->single();

                    if ($pass == 1 && !empty($data['nisn']))  return $data;
                    else return false;
                } else return false;
            } else return false;
        }
        //session


        public function set_session(array $data)
        {
            $ip = self::get_client_ip();
            if ($ip != "UNKNOWN") {

                $query = "update $this->table set
            ip_address = :user 
            ,last_access = sysdate()
            ,session = :session
            where id = :id ";
                $this->db->query($query);
                $this->db->bind('session', $data['session']);
                $this->db->bind('id', $data['id']);
                $this->db->bind('user', $ip);
                $this->db->execute();
            }
        }

        public function set_session_santri(array $data)
        {
            $ip = self::get_client_ip();
            if ($ip != "UNKNOWN") {
                $query = "update $this->table3 set
            ip_address = :user 
            ,last_access = sysdate()
            ,session = :session
            where id_santri = :id ";
                $this->db->query($query);
                $this->db->bind('session', $data['session']);
                $this->db->bind('id', $data['id_santri']);
                $this->db->bind('user', $ip);
                $this->db->execute();
            }
        }

        public    function get_client_ip()
        {
            $ipaddress = '';
            if (getenv('HTTP_CLIENT_IP'))
                $ipaddress = getenv('HTTP_CLIENT_IP');
            else if (getenv('HTTP_X_FORWARDED_FOR'))
                $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
            else if (getenv('HTTP_X_FORWARDED'))
                $ipaddress = getenv('HTTP_X_FORWARDED');
            else if (getenv('HTTP_FORWARDED_FOR'))
                $ipaddress = getenv('HTTP_FORWARDED_FOR');
            else if (getenv('HTTP_FORWARDED'))
                $ipaddress = getenv('HTTP_FORWARDED');
            else if (getenv('REMOTE_ADDR'))
                $ipaddress = getenv('REMOTE_ADDR');
            else
                $ipaddress = 'UNKNOWN';
            return $ipaddress;
        }

        public function session(array $data)
        {
            $ip = self::get_client_ip();
            if ($ip != "UNKNOWN") {
                # code...
                $this->db->query('SELECT * FROM ' . $this->table . " 
                a inner join " . $this->table2 . "  b on a.id = b.id_user where
                a.ip_address = :ip and a.session=:session and b.nama=:nama and a.status_akun = '1' ");
                $this->db->bind('session', $data[0]);
                $this->db->bind('ip', $ip);
                $this->db->bind('nama', $data[1]);
                return $this->db->single();
            }
        }
        public function session_santri(array $data)
        {
            $ip = self::get_client_ip();
            if ($ip != "UNKNOWN") {
                # code...
                $this->db->query('SELECT * FROM ' . $this->table3 . " a inner join " . $this->table4 . "  b on a.id_santri = b.id where a.ip_address = :ip and a.session=:session and b.nama=:nama and a.status_akun = '1' ");
                $this->db->bind('session', $data[0]);
                $this->db->bind('ip', $ip);
                $this->db->bind('nama', $data[1]);
                return $this->db->single();
            }
        }


        public function delete_session($data)
        {
            $query = "update $this->table AS a inner join $this->table2 as b  
            set ip_address ='', last_access = '', session ='' where a.session= :id and b.nama = :nama";
            $this->db->query($query);
            $this->db->bind('id', $data['id']);
            $this->db->bind('nama', $data['nama']);
            $this->db->execute();
        }

        public function delete_session_santri($data)
        {
            $query = "update $this->table3 AS a inner join $this->table4 as b  
            set ip_address ='', last_access = '', session ='' 
            where a.session= :id and b.nama = :nama";
            $this->db->query($query);
            $this->db->bind('id', $data['id']);
            $this->db->bind('nama', $data['nama']);
            $this->db->execute();
        }





        // penggunaan biasa model 
        public function get()
        {
            $this->db->query('SELECT id,nry,status_akun,last_access,ip_address FROM ' . $this->table);
            // var_dump($this->db->resultSet()) or die;
            return $this->db->resultSet();
        }

        public function nry()
        {
            $this->db->query('SELECT id, nry FROM ' . $this->table . " where status_akun = '1'");
            // var_dump($this->db->resultSet()) or die;
            $data = $this->db->resultSet();
            foreach ($data as $key => $value) {
                $final[$value['nry']] = $value['id'];
            }
            return $final;
        }

        public function sekolah()
        {
            $this->db->query('SELECT * FROM ' . $this->table6);
            // var_dump($this->db->resultSet()) or die;
            $data = $this->db->resultSet();
            foreach ($data as $key => $value) {
                $final[$value['sekolah']] = $value['kd'];
            }
            return $final;
        }

        public function kampus()
        {
            $this->db->query('SELECT * FROM ' . $this->table5);
            // var_dump($this->db->resultSet()) or die;
            $data = $this->db->resultSet();
            foreach ($data as $key => $value) {
                $final[$value['nama']] = $value['kd'];
            }
            return $final;
        }

        public function access()
        {
            $this->db->query('SELECT a.id,b.nry,a.akses,
            a.updated_at ,a.status_akses FROM ' . $this->table1 . " a left  join 
            $this->table b on a.id_user = b.id  where b.id > 0  ");
            return $this->db->resultSet();
        }

        public function detail()
        {
            $this->db->query('SELECT 
            a.id_user,c.kd_kampus,c.sekolah,b.nry,a.nama,
            a.tgl_lahir ,a.nik,a.jalan,
            a.rt,a.rw,a.desa,
            a.kecamatan,a.kota_kabupaten,
            a.provinsi,a.kontak,a.email 
            FROM ' . $this->table2 . " a left  join 
            $this->table b on a.id_user = b.id  
            left join $this->table6 c on a.kd_sekolah = c.kd
            ");

            return $this->db->resultSet();
        }

        public function get1($id)
        {
            $id = Security::xss_input($id);

            $this->db->query('SELECT akses FROM ' . $this->table1 . " where id_user=:id and status_akses = '1' ");
            $this->db->bind('id', $id);
            return $this->db->resultSet();
        }

        public function get_single($id)
        {
            $id = Security::xss_input($id);
            $this->db->query('SELECT id,nry,status_akun FROM ' . $this->table . " where id=:id");
            $this->db->bind('id', $id);
            return $this->db->single();
        }

        public function get_single1($id)
        {
            $id = Security::xss_input($id);
            $this->db->query('SELECT a.id,a.id_user,b.nry,a.akses,a.updated_at ,a.status_akses  FROM ' . $this->table1 . " a left join $this->table b on a.id_user=b.id where a.id=:id");
            $this->db->bind('id', $id);
            return $this->db->single();
        }

        public function get_single2($id)
        {
            $id = Security::xss_input($id);
            $this->db->query('SELECT a.id_user,c.kd_kampus,a.kd_sekolah,b.nry,a.nama,
            a.tgl_lahir ,a.nik,a.jalan,a.rt,a.rw,a.desa,a.kecamatan,a.kota_kabupaten,a.provinsi,a.kontak,a.email   
            FROM ' . $this->table2 . " a 
            left join $this->table b on a.id_user=b.id
            left join $this->table6 c on a.kd_sekolah = c.kd
            where a.id_user=:id");
            $this->db->bind('id', $id);
            return $this->db->single();
        }

        //insert
        public function tambah()
        {
            $nry = Security::xss_input($_POST['nry']);
            $nama = Security::xss_input($_POST['nama']);
            $query = "select * from $this->table where nry = :nry";
            $this->db->query($query);
            $this->db->bind('nry', $nry);
            $this->db->execute();
            $us = $this->db->rowCount();

            if (isset($_POST['nry']) && $us == 0) {
                $pass = Security::pass_hash('123');
                $query = "INSERT INTO $this->table 
                (id,nry,password,status_akun) 
                values(null, :nry, :password, '1');
                SET @a := (SELECT id FROM user where nry = :nry );
                INSert into $this->table2 (id_user,nama) values(@a,:nama); ";
                $this->db->query($query);
                $this->db->bind('nry', $nry);
                $this->db->bind('nama', $nama);
                $this->db->bind('password', $pass);
                $this->db->execute();
                return $this->db->rowCount();
            } else {
                return 0;
            }
        }

        public function tambah_akses()
        {
            if (isset($_POST['nry'], $_POST['akses'])) {
                $nry = Security::xss_input($_POST['nry']);
                // var_dump($nry) or die; 
                $akses = Security::xss_input($_POST['akses']);
                $query = "INSERT INTO $this->table1  values(null, :nry,:akses,sysdate(),'1')";

                $this->db->query($query);
                $this->db->bind('nry', $nry);
                $this->db->bind('akses', $akses);
                $this->db->execute();
                return $this->db->rowCount();
            }
        }

        public function tambah_detail()
        {
            if (isset($_POST['user'], $_POST['nama'])) {
                $id = intval(Security::xss_input($_POST['user']));
                $nama = Security::xss_input($_POST['nama']);
                $tgl_lahir = Security::xss_input($_POST['tgl_lahir']);
                $nik = Security::xss_input($_POST['nik']);
                $jalan = Security::xss_input($_POST['jalan']);
                $rt = Security::xss_input($_POST['rt']);
                $rw = Security::xss_input($_POST['rw']);
                $desa = Security::xss_input($_POST['desa']);
                $kecamatan = Security::xss_input($_POST['kecamatan']);
                $kota_kabupaten = Security::xss_input($_POST['kota_kabupaten']);
                $provinsi = Security::xss_input($_POST['provinsi']);
                $kontak = Security::xss_input($_POST['kontak']);
                $email = Security::xss_input($_POST['email']);
                $kampus = Security::xss_input($_POST['kampus']);
                $sekolah = Security::xss_input($_POST['sekolah']);

                $query = "INSERT INTO $this->table2  values
                (:id, :nama,:tgl_lahir,:nik,:jalan,:rt,:rw,:desa,:kecamatan,:kota_kabupaten,:provinsi,:kontak,:email,:kampus,:sekolah)";

                $this->db->query($query);
                $this->db->bind('id', $id);
                $this->db->bind('nama', $nama);
                $this->db->bind('tgl_lahir', $tgl_lahir);
                $this->db->bind('nik', $nik);
                $this->db->bind('jalan', $jalan);
                $this->db->bind('rt', $rt);
                $this->db->bind('rw', $rw);
                $this->db->bind('desa', $desa);
                $this->db->bind('kecamatan', $kecamatan);
                $this->db->bind('kota_kabupaten', $kota_kabupaten);
                $this->db->bind('provinsi', $provinsi);
                $this->db->bind('kontak', $kontak);
                $this->db->bind('email', $email);

                $this->db->execute();


                return $this->db->rowCount();
            }
        }

        //update
        public function update()
        {
            $id = intval(Security::xss_input($_POST['user']));
            $nry = Security::xss_input($_POST['nry']);
            $status = Security::xss_input($_POST['status']);
            $pass = isset($_POST['reset_password']) ? $_POST['reset_password']  : "";

            $pass = $pass == 'reset' ? Security::pass_hash($nry) : "";

            $password = !empty($pass)  ? ",password = :pass" : "";

            $query = "update $this->table set
                nry = :nry,
                status_akun = :status
                $password
                where id = :id

            ";
            $this->db->query($query);
            $this->db->bind('id', $id);
            $this->db->bind('nry', $nry);

            $this->db->bind('status', $status);
            // var_dump($this->db,$_POST) or die;
            if (!empty($password)) {
                $this->db->bind('pass', $pass);
            }

            $this->db->execute();

            return $this->db->rowCount();
        }

        public function password()
        {
            $user = SessionManager::getCurrentUser();
            // var_dump('dsada') or die;

            $this->db->query('SELECT * FROM ' . $this->table . " 
                a inner join " . $this->table2 . "  b on a.id = b.id_user where
                b.nama=:nama and a.status_akun = '1' ");
            $this->db->bind('nama', $user['nama']);
            $data = $this->db->single();
            $id = $data['id'];
            $pass = Security::xss_input($_POST['password']);
            // var_dump('dsada') or die;

            $query = "update $this->table set
                password =:pass where id = :id";
            $this->db->query($query);
            $this->db->bind('id', $id);
            $this->db->bind('pass', Security::pass_hash($pass));

            $this->db->execute();
            return $this->db->rowCount();
        }

        public function update_akses()
        {
            $id = intval(Security::xss_input($_POST['user']));
            $nry = Security::xss_input($_POST['nry']);
            $akses = Security::xss_input($_POST['akses']);
            $status = Security::xss_input($_POST['status']);


            $query = "update $this->table1 set
            akses = :akses,
            id_user= :nry,
                status_akses   = :status
                updated_at   = sysdate()
                where id = :id

            ";
            $this->db->query($query);
            $this->db->bind('id', $id);
            $this->db->bind('akses', $akses);
            $this->db->bind('nry', $nry);

            $this->db->bind('status', $status);


            $this->db->execute();

            return $this->db->rowCount();
        }


        public function update_detail()
        {
            $id = intval(Security::xss_input($_POST['user']));
            $nama = Security::xss_input($_POST['nama']);
            $tgl_lahir = Security::xss_input($_POST['tgl_lahir']);
            $nik = Security::xss_input($_POST['nik']);
            $jalan = Security::xss_input($_POST['jalan']);
            $rt = Security::xss_input($_POST['rt']);
            $rw = Security::xss_input($_POST['rw']);
            $desa = Security::xss_input($_POST['desa']);
            $kecamatan = Security::xss_input($_POST['kecamatan']);
            $kota_kabupaten = Security::xss_input($_POST['kabupaten']);
            $provinsi = Security::xss_input($_POST['provinsi']);
            $kontak = Security::xss_input($_POST['kontak']);
            $email = Security::xss_input($_POST['email']);
            $sekolah = Security::xss_input($_POST['sekolah']);


            $query = "update $this->table2 set        
            nama = :nama,
            kd_sekolah = :sekolah,
            tgl_lahir =  :tgl_lahir,
            nik = :nik,
            jalan = :jalan,
            rt = :rt,
            rw = :rw,
            desa = :desa,
            kecamatan = :kecamatan,
            kota_kabupaten = :kota_kabupaten,
            provinsi = :provinsi,
            kontak = :kontak,
            email = :email
            where id_user = :id
            ";
            $this->db->query($query);
            $this->db->bind('id', $id);
            $this->db->bind('sekolah', $sekolah);
            $this->db->bind('email', $email);
            $this->db->bind('kontak', $kontak);
            $this->db->bind('provinsi', $provinsi);
            $this->db->bind('kota_kabupaten', $kota_kabupaten);
            $this->db->bind('kecamatan', $kecamatan);
            $this->db->bind('desa', $desa);
            $this->db->bind('rw', $rw);
            $this->db->bind('rt', $rt);
            $this->db->bind('jalan', $jalan);
            $this->db->bind('nik', $nik);
            $this->db->bind('tgl_lahir', $tgl_lahir);
            $this->db->bind('nama', $nama);


            $this->db->execute();

            return $this->db->rowCount();
        }
    }
