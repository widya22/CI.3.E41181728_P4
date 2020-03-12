<?php
// Mencegah agar script tidak bisa diakses secara langsung (localhost/namaweb/controller)
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Kontak extends REST_Controller {
    //untuk meload model(database) yang telah di deklarasikan
    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
    }
    //Menampilkan data yang terdapat pada database kontak
    function index_get() {
        //$id berisi data id yang diambil
        $id = $this->get('id');
    //menampilkan semua data dari tabel telepon
        if ($id == '') {
        $kontak = $this->db->get('telepon')->result();
    //menampilkan data berdasarkan id dari tabel telepon
    } else {
        $this->db->where('id', $id);
        $kontak = $this->db->get('telepon')->result();
    }
        //mengirim data ke browser berdasar data $kontak
        $this->response($kontak, 200);
    }

    //Mengirim atau menambah data baru pada database kontak 
    function index_post() {
        //data yang diinputkan disimpan dalam variabel array dengan nama data
        $data = array(
            'id'         => $this->post('id'),
            'nama'       => $this->post('nama'),
            'nomor'      => $this->post('nomor'));
            //memasukkan data ke tabel telepon dari $data 
        $insert = $this->db->insert('telepon', $data);  
        //menampilkan data pada $data ke browser jika berhasil   
        if ($insert) {
            $this->response($data, 200);
        } else {
            //menampikan ke browser jika data tidak bisa di tambahkan
            $this->response(array('status' => 'fail', 502));
        }
    }
    //Memperbarui data yag terdapat pada database kontak
    function index_put() {
        //data yang akan diubah berdasarkan id disimpan daam array id
        $id = $this->put('id');
        //perubahan data berdasarkan id disimpan pada variabel array data
        $data = array(
                    'id'       => $this->put('id'),
                    'nama'          => $this->put('nama'),
                    'nomor'    => $this->put('nomor'));
        //update data id dari $id
        $this->db->where('id', $id);
        //$update berisikan data yang telah diupdate dari database kontak pada tabel telepon dari $data
        $update = $this->db->update('telepon', $data);
        //Menampilkan data jika berhasil diupdate
        if ($update) {
            $this->response($data, 200);
        //Menampilkan status fail jika gagal mengubah data
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }
    //Menghapus salah satu data pada database kontak
    function index_delete() {
        //data yang akan dihapus berdasarkan id disimpan daam array id
        $id = $this->delete('id');
        //delete data id dari $id
        $this->db->where('id', $id);
        //$delete berisikan data yang telah dihapus dari database kontak pada tabel telepon 
        $delete = $this->db->delete('telepon');
        //menampilkan status success jika berhasil menghapus data
        if ($delete) {
            $this->response(array('status' => 'success'), 201);
        //menampilkan status fail jika tidak berhasil menghapus data
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }

}
?>