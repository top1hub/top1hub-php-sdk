<?php
namespace ys;
include_once 'ys/Http/Client.php';
use ys\Http\Client;

final class Auth {
	public $safeCode;
	public $upToken;
	public function __construct($safeCode) {
		$this->safeCode = $safeCode;
		$this->upToken = null;
		$this->build();
	}
	private function build() {
		$response = Client::get ( Config::GET_TOKEN_HOST . "?SafeCode=" . $this->safeCode, array (
				"Content-Type" => "application/json" 
		) );
		$json = $response->json();
		$this->upToken = $json['message'];
	}
}
