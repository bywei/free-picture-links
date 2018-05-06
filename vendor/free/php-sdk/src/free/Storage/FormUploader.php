<?php
namespace free\Storage;

use free\Config;
use free\Http\Client;
use free\Http\Error;

final class FormUploader
{
    public static function put(
        $key,
    	$fname,
        $data,
        $params,
        $mime,
        $checkCrc
    ) {
        $fields = array();
        if ($fname === null) {
            $fname = $key;
        } 
        
        if ($checkCrc) {
            $fields['crc32'] = \free\crc32_data($data);
        }
        if ($params) {
            foreach ($params as $k => $v) {
                $fields[$k] = $v;
            }
        }
		echo Config::$defaultHost;
        $response = Client::multipartPost(Config::$defaultHost, $fields, $key, $fname, $data, $mime);
        if (!$response->ok()) {
            return array(null, new Error(Config::$defaultHost, $response));
        }
        return array($response->json(), null);
    }

    public static function putFile(
        $upToken,
        $key,
        $filePath,
        $params,
        $mime,
        $checkCrc
    ) {

        $fields = array('token' => $upToken, 'Filedata' => self::createFile($filePath, $mime));
        if ($key === null) {
            $fname = 'Filedata';
        } else {
            $fname = $key;
            $fields['key'] = $key;
        }
        if ($checkCrc) {
            $fields['crc32'] = \free\crc32_file($filePath);
        }
        if ($params) {
            foreach ($params as $k => $v) {
                $fields[$k] = $v;
            }
        }
        $headers =array('Content-Type' => 'multipart/form-data');
        $response = client::post(Config::$defaultHost, $fields, $headers);
        if (!$response->ok()) {
            return array(null, new Error(Config::$defaultHost, $response));
        }
        return array($response->json(), null);
    }

    private static function createFile($filename, $mime)
    {
        // PHP 5.5 introduced a CurlFile object that deprecates the old @filename syntax
        // See: https://wiki.php.net/rfc/curl-file-upload
        if (function_exists('curl_file_create')) {
            return curl_file_create($filename, $mime);
        }

        // Use the old style if using an older version of PHP
        $value = "@{$filename}";
        if (!empty($mime)) {
            $value .= ';type=' . $mime;
        }

        return $value;
    }
}
