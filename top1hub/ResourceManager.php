<?php
namespace top1hub;
include_once 'message/Client.php';
include_once 'Config.php';
include_once 'message/functions.php';
include_once 'message/Result.php';
use top1hub\message\Client;
use top1hub\message\Result;

class ResourceManager
{
    private $token;
    private $safeCode;
    private $container;

    private function __construct()
    {
    }

    static function create()
    {
        return new ResourceManager();
    }

    function safeCode($safeCode)
    {
        $this->safeCode = $safeCode;
        return $this;
    }

    function container($name)
    {
        $this->container = $name;
        return $this;
    }

    function build()
    {
        $response = Client::get(Config::GET_TOKEN_HOST . "?SafeCode=" . $this->safeCode);
        $json = $response->json();
        $this->token = $json['message'];
        return $this;
    }

    function upload($fileKey, $filePath, $isCover ,$mimeType)
    {

        try {
            $fileContent = \top1hub\message\readFile($filePath);
            $dataHash = sha1($fileContent);
            $fields = array(
                'token' => $this->token,
                'container' => $this->container,
                'fileKey' => $fileKey,
                'dataHash' => $dataHash,
                'file' => $fileContent,
                'isCover' => $isCover
            );
            $response = client::multipartPost(Config::UPLOAD_HOST, $fields, 'file', $fileKey, $fileContent, $mimeType);
            if($response->statusCode >= 300){
                return new Result(false,$response->statusCode,$response->error);
            }else{
                return new Result(true,$response->statusCode,"success");
            }
        } catch (\Exception $e) {
            return new Result(false,500,$e->getMessage());
        }
    }

    function delete($fileKey)
    {
        try {
            $url = Config::DELETE_HOST . "?token=" . $this->token . "&container=" . $this->container . "&fileKey=" . $fileKey;
            $response = Client::get($url);
            if($response->statusCode >= 300){
                return new Result(false,$response->statusCode,$response->error);
            }else{
                return new Result(true,$response->statusCode,"success");
            }
        } catch (\Exception $e) {
            return new Result(false,500,$e->getMessage());
        }
    }
}