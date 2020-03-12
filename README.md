# CI.3.E41181728_P4
Dokumentasi Paraktikum Rest API dan CodeIgniter

# DOKUMENTASI PRAKTIKUM 4 CODEIGNITER SERVER

## Komponen yang Diperlukan
Berikut adalah komonenyang diperluan untuk pembuatan Rest API dan CI3, yaitu :
1. PHP MYSQL
2. Webserver XAMPP atau Wampp
3. Code Igniter 3.1.11
4. Text editor Visual Studio code atau Sublime (saya menggunakan Visual Studio Code)
5. Aplikasi Postman

## Persiapan 
1.	Download dan Install Postman
2.	Download Codeigniter dan library Rest sever di https://github.com/chriskacerguis/codeigniter-restserver untuk versi terbaru. Namun versi  yang kita gunakan https://github.com/ardisaurus/ci-restserver.
3.	Setelah download, extract CodeIgniter dan library Rest server  dan pindahkan ke htdocs pada direktori xampp lalu rename folder CodeIgiter dan library Restserver sesuai keinginan. Namun disini saya ganti dengan nama Belajar_CI_RA
4.	Cek instalasi berhasil, masukan http://localhost/Belajar_CI_RA/index.php/rest_server pada browser
5.	Buka folder Belajar_CI_RA dengna text editor
###  Melakukan Konfigurasi Database
1.	Buat database dengan nama “kontak”
``` bash
CREATE DATABASE kontak;
```
2.	Buat tabel pada database kontak denga nama “telepon”
``` bash
USE kontak;
CREATE TABLE IF NOT EXISTS `telepon` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) NOT NULL,
  `nomor` varchar(13) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;
```
3.	Masukkan data pada tabel telepon
``` bash
USE kontak;
INSERT INTO `telepon` (`id`, `nama`, `nomor`) VALUES
(1, 'Orion', '08576666762'),
(2, 'Mars', '08576666770'),
(7, 'Alpha', '08576666765');
```
4.	Lakukan konfigurasi pada database.php di Belajar_CI_RA/application/config ubah pada username dan databasenya menjadi sesuai dengan database yang dibuat sebelumnya, maka akan menjadi seperti dibawah ini

``` bash
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
    'dsn'   => '',
    'hostname' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'kontak',
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => (ENVIRONMENT !== 'production'),
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'encrypt' => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE
);
```

## Membuat controller 
Buat controler dengan nama kontak.php di Belajar_CI_RA/application/controller. Isikan code berikut pada kontak.php
a.	Get digunakan untuk menampilkan data dari tabel telepone pada database kontak. Ditampilkan berdasakan id atau ditampikan semua
```bash
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Kontak extends REST_Controller {

    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
    }
    //Menampilkan data kontak
    function index_get() {
        $id = $this->get('id');
        if ($id == '') {
            $kontak = $this->db->get('telepon')->result();
        } else {
            $this->db->where('id', $id);
            $kontak = $this->db->get('telepon')->result();
        }
        $this->response($kontak, 200);
    }
```

b.	Post digunakan untuk mengirimkan data baru dari client ke server Rest API
```
//Mengirim atau menambah data kontak baru
    function index_post() {
        $data = array(
                    'id'           => $this->post('id'),
                    'nama'          => $this->post('nama'),
                    'nomor'    => $this->post('nomor'));
        $insert = $this->db->insert('telepon', $data);
        if ($insert) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }

```
c.	Put digunakan untuk memperbarui data yang telah ada di server Rest API berdasarkan id
```
//Memperbarui data kontak yang telah ada
    function index_put() {
        $id = $this->put('id');
        $data = array(
                    'id'       => $this->put('id'),
                    'nama'          => $this->put('nama'),
                    'nomor'    => $this->put('nomor'));
        $this->db->where('id', $id);
        $update = $this->db->update('telepon', $data);
        if ($update) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }
```
d.	Delete digunakan untuk menghapus data yang telah ada di server Rest API
```
//Menghapus salah satu data kontak
    function index_delete() {
        $id = $this->delete('id');
        $this->db->where('id', $id);
        $delete = $this->db->delete('telepon');
        if ($delete) {
            $this->response(array('status' => 'success'), 201);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }
```
## Pengujian pada Postman
a. Metode GET. Masukkan http://localhost/Belajar_CI_RA/index.php/kontak pada addres bar lalu klik send. Maka akan menampilkan semua data, namun saat memasukkan alamat http://localhost/Belajar_CI_RA/index.php/kontak?id=7 maka yang akan keuar data berdasarkan id 7 

b. metode POST, masukan  http://localhost/Belajar_CI_RA/index.php/kontak pada address bar, klik "Body" pada menu dibawah address bar, pilih x-www-form-urlencoded, masukan key dan value yang diperlukan (id, nama, nomor), lalu klik "Send". Lalu lakukan metode GET untuk melihat data terbaru. Maka akan keluar data yang sebelumnya sudah ada sekaligus data yang baru diinputkan.
c. Untuk mengujinya buka Postman, pilih metode PUT, masukan http://localhost/Belajar_CI_RA/index.php/kontak pada address bar, klik "Body" pada menu dibawah address bar, pilih x-www-form-urlencoded, masukan key id dan value id yang akan diubah (88) diikuti key dan value selanjutnya, lalu klik "Send". Lakukan metode GET untuk melihat data terbaru. Maka akan kita bisa melihat data yang telah kita ubah tadi dari id 88.
d.	Untuk mengujinya buka Postman, pilih metode DELETE, masukan http://127.0.0.1/rest_ci/index.php/kontak pada address bar, klik "Body" pada menu dibawah address bar, pilih x-www-form-urlencoded, masukan key id dan value id yang akan dihapus (88), lalu klik "Send". Lakukan metode GET untuk melihat data terbaru. Maka data berdasarkan id 88 tidak akan tampil












