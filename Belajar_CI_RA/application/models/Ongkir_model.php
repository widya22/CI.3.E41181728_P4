<?php
	class Ongkir_model{
		public function __construct()
		{
		
		}
		public function showProvince(){
			$curl = curl_init();
			curl_setopt_array($curl,array(
				CURLOPT_URL => "http://api.rajaongkir.com/starter/province",
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "GET",
				CURLOPT_HTTPHEADER => array(
					"key: 8b273fb86a0e6550ac4b20b1104cfa48"),
			));
			
			$response = curl_exec($curl);
			$err = curl_error($curl);
			curl_close($curl);
			if ($err) {
				$result = 'error';
				return 'error';
			}else {
				return $response;
			}
		}
		public function showCity($province){
			$curl = curl_init();
			curl_setopt_array($curl,array(
				CURLOPT_URL => "http://api.rajaongkir.com/starter/city?province=$province",
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "GET",
				CURLOPT_HTTPHEADER => array(
					"key: 8b273fb86a0e6550ac4b20b1104cfa48"),
			));
			$response = curl_exec($curl);
			$err = curl_error($curl);
			curl_close($curl);
			if ($err) {
				$result = 'error';
				return 'error';
			}else {
				return $response;
			}
		}
		public function hitungOngkir($origin,$destination,$weight,$courier){
			$curl = curl_init();
			curl_setopt_array($curl,array(
				CURLOPT_URL => "http://api.rajaongkir.com/starter/cost",
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "POST",
				CURLOPT_POSTFIELDS =>
				"origin=$origin&destination=$destination&weight=$weight&courier=$courier",
				CURLOPT_HTTPHEADER => array(
					"key: 8b273fb86a0e6550ac4b20b1104cfa48"),
			));
			$response = curl_exec($curl);
			$err = curl_error($curl);
			curl_close($curl);
			if ($err) {
				$result = 'error';
				return 'error';
			}else {
				return $response;
			}
		}
	}
?>