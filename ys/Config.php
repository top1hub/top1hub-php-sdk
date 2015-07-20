<?php
namespace ys;
final class Config{
	const SDK_VER = '1.0.0';
	const GET_TOKEN_HOST = 'http://api.top1cloud.com/getuploadtoken';
	const UPLOAD_HOST = 'http://upload.top1cloud.com/upload';
    const BLOCK_SIZE = 5242880; //5*1024*1024
    public static $defaultHost = UPLOAD_HOST;
}
