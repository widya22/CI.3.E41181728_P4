<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->model('toko_online_model');
		$this->load->library('session');
		if ($this->session->userdata('acak') == null) {
			$acak = rand(10000, 100000);
			$this->session->set_userdata('acak', $acak);
		}
		// 			$data = $this->db->query("SHOW VARIABLES WHERE VARIABLE_NAME = 'event_scheduler'")->result_array();
		// 			if ($data[0]['value'] = 'OFF') {
		// 				$this->db->query("SET GLOBAL event_scheduler = ON");
		// 			}
	}

	public function index()
	{

		$data['kategori'] = $this->toko_online_model->get_table('kategori_produk');
		$data['content'] = 'user/index1';
		$this->load->view('user/dashboard1', $data);
	}

	public function detail($id)
	{
		$data['detail_produk'] = $this->toko_online_model->get_table_where('produk', array('id_produk' => $id));
		$data['content'] = 'user/produk_detail1';
		$this->load->view('user/dashboard1', $data);
	}

	public function produk($id_kategori_produk, $offset = 0)
	{
		$this->load->library('pagination');

		$data['content'] = 'user/produk1';



		$config['per_page'] = 6; /*Jumlah data yang dipanggil perhalaman*/



		$data['produk'] = $this->toko_online_model->get_table_where('produk', array('kategori_produk' => $id_kategori_produk));
		$data['kategori'] = $this->toko_online_model->get_table('kategori_produk');

		$this->load->view('user/dashboard1', $data);
	}

	public function semua_produk($offset = 0)
	{
		$this->load->library('pagination');

		$data['content'] = 'user/produk_all';



		$config['per_page'] = 6; /*Jumlah data yang dipanggil perhalaman*/



		$data['produk'] = $this->toko_online_model->get_where_limmi_semua($config['per_page'], $offset);
		$data['kategori'] = $this->toko_online_model->get_table('kategori_produk');

		$this->load->view('user/dashboard1', $data);
	}

	public function cari_produk($offset = 0)
	{
		$produk = $this->input->post('nama_produk');
		$this->load->library('pagination');

		$data['content'] = 'user/cari_produk1';



		$config['per_page'] = 6; /*Jumlah data yang dipanggil perhalaman*/



		$data['produk'] = $this->toko_online_model->get_where_limmi2($produk, $config['per_page'], $offset);
		//print_r($this->db->last_query());
		$data['kategori'] = $this->toko_online_model->get_table('kategori_produk');

		$this->load->view('user/dashboard1', $data);
	}

	public function produk_detail($id_produk)
	{
		// $data['menu'] =$this->toko_online_model->get_table_where('menu', array('aktif_menu' => 1));
		$data['detail_produk'] = $this->toko_online_model->get_table_where('produk', array('id_produk' => $id_produk));
		$data['content'] = 'user/produk_detail1';
		$this->load->view('user/dashboard1', $data);
	}

	public function account()
	{
		$data['content'] = 'user/account';
		$this->load->view('user/dashboard', $data);
	}

	public function keranjang_belanja()
	{

		$ip = $this->session->userdata('acak');
		$id_produk = $this->input->post('id_produk');
		$harga = $this->input->post('harga');
		$quantity = $this->input->post('quantity');
		$subtotal = $harga * $quantity;

		$ambil_data = $this->toko_online_model->get_table_where('keranjang_belanja', array('id_keranjang_belanja' => $ip, 'id_produk' => $id_produk));

		if ($ambil_data != null) {
			$quantity_new = $ambil_data[0]['jumlah_produk'] + $quantity;
			$subtotal_new = $ambil_data[0]['subtotal_belanja'] + $subtotal;

			$data = array(
				'jumlah_produk' => $quantity_new,
				'subtotal_belanja' => $subtotal_new
			);

			$update = $this->toko_online_model->update_table('keranjang_belanja', $data, array('id_keranjang_belanja' => $ip, 'id_produk' => $id_produk));
		} else {
			$data = array(
				'id_keranjang_belanja' 	=> $this->session->userdata('acak'),
				'id_produk'				=> $id_produk,
				'harga_produk'			=> $harga,
				'jumlah_produk'			=> $quantity,
				'subtotal_belanja'		=> $subtotal,
			);
			$insert = $this->toko_online_model->insert_table('keranjang_belanja', $data);
		}

		redirect(base_url('/user/home/produk_detail/' . $id_produk));
	}

	public function update_keranjang_belanja()
	{
		$id_produk = $this->input->post('id_produk');
		$id_keranjang_belanja = $this->input->post('id_keranjang_belanja');
		$quantity = $this->input->post('quantity');

		foreach ($id_produk as $id) {
			$where = array(
				'id_keranjang_belanja' 	=> $id_keranjang_belanja,
				'id_produk'				=> $id
			);
			$cek_q = $this->toko_online_model->get_table_where('keranjang_belanja', $where);
			if ($cek_q[0]['jumlah_produk'] != $quantity[$id]) {
				$data = array(
					'jumlah_produk' 	=> $quantity[$id],
					'subtotal_belanja'	=> $quantity[$id] * $cek_q[0]['harga_produk']
				);
				$this->toko_online_model->update_table('keranjang_belanja', $data, $where);
			}
		}

		redirect('user/home/cart/' . $id_keranjang_belanja);
	}

	public function remove_keranjang_belanja($id)
	{
		$where = array(
			'id' 	=> $id
		);
		$this->toko_online_model->delete_table('keranjang_belanja', $where);
		echo "<script>
				window.history.go(-1);
				location.reload();
		</script>";
	}

	public function cart()
	{
		$data['total'] = $this->toko_online_model->get_total('keranjang_belanja', array('id_keranjang_belanja' => $this->session->userdata('acak')), 'jumlah_produk', 'subtotal_belanja');
		$data['cart'] = $this->toko_online_model->get_keranjang_belanja(array('keranjang_belanja.id_keranjang_belanja' => $this->session->userdata('acak')));
		$data['content'] = 'user/cart1';
		$this->load->view('user/dashboard1', $data);
	}



	function kontak()
	{
		$data_konten = $this->toko_online_model->get_table_where('konten', array('id_konten', 1));
		$data['data'] = $data_konten[0]['tentang'];
		$data['content'] = 'user/contact';
		$data['label'] = "Tentang";
		$this->load->view('user/dashboard1', $data);
	}

	// function kontak()
	// {
	// 	$data_konten = $this->toko_online_model->get_table_where('konten', array('id_konten', 1));
	// 	$data['data'] = $data_konten[0]['alamat'];
	// 	$data['content'] = 'user/contact';
	// 	$data['label'] = "contact";
	// 	$this->load->view('user/dashboard1', $data);
	// }


	function aturan()
	{
		$data_konten = $this->toko_online_model->get_table_where('konten', array('id_konten', 1));
		$data['data'] = $data_konten[0]['aturan'];
		$data['content'] = 'user/about1';
		$data['label'] = "Aturan Umum";
		$this->load->view('user/dashboard1', $data);
	}

	function panduan()
	{
		$data_konten = $this->toko_online_model->get_table_where('konten', array('id_konten', 1));
		$data['data'] = $data_konten[0]['panduan'];
		$data['content'] = 'user/about1';
		$data['label'] = "Panduan";
		$this->load->view('user/dashboard1', $data);
	}

	public function checkout()
	{
		$data['kecamatan'] = $this->toko_online_model->get_table('kecamatan');
		$data['daerah_kirim'] = $this->toko_online_model->get_table('daerah_kirim');
		$data['jam_kirim'] = $this->toko_online_model->get_table('jam_kirim');
		$data['kota'] = $this->toko_online_model->get_table('kota');
		$data['kelurahan'] = $this->toko_online_model->get_table('kelurahan');
		$data['total'] = $this->toko_online_model->get_total('keranjang_belanja', array('id_keranjang_belanja' => $this->session->userdata('acak')), 'jumlah_produk', 'subtotal_belanja');
		$data['cart'] = $this->toko_online_model->get_keranjang_belanja(array('keranjang_belanja.id_keranjang_belanja' => $this->session->userdata('acak')));
		if ($data['cart'] == null) {
			$this->session->set_flashdata(
				'cart',
				'<div class="alert alert-danger" role="alert">
					Keranjang Belanja Kosong
				</div>'
			);
			$data['content'] = 'user/cart1';
			$this->load->view('user/dashboard1', $data);
		} else {
			$penjual = $this->toko_online_model->get_penjual_cart(array('keranjang_belanja.id_keranjang_belanja' => $this->session->userdata('acak')));
			$angka = 0;
			foreach ($penjual as $p) {
				$data_penjual[$angka] = $this->toko_online_model->get_table_where('user', array('id_user' => $p['id_user']));
				$angka++;
			}

			// $data_penjual = array();
			// $angka = 0;
			// foreach ($data['cart'] as $cart) {
			// 	$data_penjual[$angka] = $this->toko_online_model->get_penjual(array('produk.id_produk' => $cart['id_produk']));
			// 	// print_r($data_penjual[$angka]);
			// 	// echo "<br>";
			// 	$angka++;
			// }
			// foreach ($data_penjual as $penjual) {
			// 	if
			// }

			$data['penjual'] = $data_penjual;
			$data['content'] = 'user/checkout1';
			$this->load->view('user/dashboard1', $data);
		}
	}

	public function get_kelurahan()
	{
		$id = $_GET['kecamatan'];
		$data = $this->toko_online_model->get_kelurahan($id);
		echo json_encode($data);
	}

	public function get_city()
	{
		require_once 'application/libraries/REST_Ongkir.php';

		$rest = new REST_Ongkir(array(
			'server' => 'http://api.ongkir.info/'
		));

		$result = $rest->post('city/list', array(
			'query' 	=> 'so',
			'type' 	=> 'origin',
			'courier' 	=> 'jne',
			'API-Key' 	=> '4557591a4e8814e57d36558e2a9370e3'
		));

		try {
			$status = $result['status'];

			// Handling the data
			if ($status->code == 0) {
				$cities = $result['cities'];

				foreach ($cities->item as $item) {
					echo 'Kota: ' . $item . '<br />';
				}
			} else {
				echo 'Tidak ditemukan kota yang diawali "band"';
			}
		} catch (Exception $e) {
			echo 'Processing error.';
		}
	}
}
