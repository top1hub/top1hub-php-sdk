<?php
namespace ys\Storage;
include_once 'ys/Http/Client.php';
use ys\Config;
use ys\Http\Client;
use ys\Http\Error;

final class FormUploader {
	public static function putFile($upToken, $container, $key, $filePath, $params) {
		$fileContent = self::readFile ( $filePath);
		$dataHash = sha1 ( $fileContent );
		var_dump ( $dataHash );
		$fields = array (
				'token' => $upToken,
				'container' => $container,
				'fileKey' => $key,
				'dataHash' => $dataHash,
				'file' => $fileContent,
				'isCover' => true
		);
		if ($params) {
			foreach ( $params as $k => $v ) {
				$fields [$k] = $v;
			}
		}
		$headers = array (
				'Content-Type' => 'multipart/form-data' 
		);
		$response = client::multipartPost( Config::UPLOAD_HOST, $fields, 'file',$key,$fileContent,null,$headers );
		return $response->json ();
	}
	private static function readFile($filePath) {
		$file = fopen ( $filePath, 'rb' );
		if ($file === false) {
			throw new \Exception ( "file can not open", 1 );
		}
		$stat = fstat ( $file );
		$size = $stat ['size'];
		if ($size <= Config::BLOCK_SIZE) {
			$data = fread ( $file, $size );
			fclose ( $file );
			if ($data === false) {
				throw new \Exception ( "file can not read", 1 );
			}
			return $data;
		} else {
			throw new \Exception ( "uploaded file exceed the max size", 1 );
		}
	}
}
