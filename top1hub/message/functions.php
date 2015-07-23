<?php

namespace top1hub\message;

use top1hub\Config;


function crc32_file($file)
{
    $hash = hash_file('crc32b', $file);
    $array = unpack('N', pack('H*', $hash));
    return sprintf('%u', $array [1]);
}


function crc32_data($data)
{
    $hash = hash('crc32b', $data);
    $array = unpack('N', pack('H*', $hash));
    return sprintf('%u', $array [1]);
}


function base64_urlSafeEncode($data)
{
    $find = array(
        '+',
        '/'
    );
    $replace = array(
        '-',
        '_'
    );
    return str_replace($find, $replace, base64_encode($data));
}


function base64_urlSafeDecode($str)
{
    $find = array(
        '-',
        '_'
    );
    $replace = array(
        '+',
        '/'
    );
    return base64_decode(str_replace($find, $replace, $str));
}


function json_decode($json, $assoc = false, $depth = 512)
{
    static $jsonErrors = array(
        JSON_ERROR_DEPTH => 'JSON_ERROR_DEPTH - Maximum stack depth exceeded',
        JSON_ERROR_STATE_MISMATCH => 'JSON_ERROR_STATE_MISMATCH - Underflow or the modes mismatch',
        JSON_ERROR_CTRL_CHAR => 'JSON_ERROR_CTRL_CHAR - Unexpected control character found',
        JSON_ERROR_SYNTAX => 'JSON_ERROR_SYNTAX - Syntax error, malformed JSON',
        JSON_ERROR_UTF8 => 'JSON_ERROR_UTF8 - Malformed UTF-8 characters, possibly incorrectly encoded'
    );

    $data = \json_decode($json, $assoc, $depth);

    if (JSON_ERROR_NONE !== json_last_error()) {
        $last = json_last_error();
        throw new \InvalidArgumentException ('Unable to parse JSON data: ' . (isset ($jsonErrors [$last]) ? $jsonErrors [$last] : 'Unknown error'));
    }
    return $data;
}

function readFile($filePath)
{
    $file = fopen($filePath, 'rb');
    if ($file === false) {
        throw new \Exception ("file can not open", 1);
    }
    $stat = fstat($file);
    $size = $stat ['size'];
    if ($size <= Config::BLOCK_SIZE) {
        $data = fread($file, $size);
        fclose($file);
        if ($data === false) {
            throw new \Exception ("file can not read", 1);
        }
        return $data;
    } else {
        throw new \Exception ("uploaded file exceed the max size", 1);
    }
}


