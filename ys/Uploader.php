<?php
namespace ys;
include_once 'ys/Storage/FormUploader.php';
use ys\Http\Client;
use ys\Storage\FormUploader;
class Uploader {
	private $upToken;
	private $container;
	private $key;
	private $filePath;
	private $isCover;
	private static $auth;
	static function build(){
		return new Uploader();
	}
	function auth($auth) {
		$this->upToken = $auth->upToken;
		return $this;
	}
	function container($name) {
		$this->container = $name;
		return $this;
	}
	function key($key) {
		$this->key = $key;
		return $this;
	}
	function filePath($path) {
		$this->filePath = $path;
		return $this;
	}
	function isCover($cover) {
		$this->isCover = $cover;
		return $this;
	}
	function start() {
		$result = FormUploader::putFile ( $this->upToken, $this->container, $this->key, $this->filePath, array (
				'isCover' => $this->isCover 
		), null );
		return $result;
	}
}