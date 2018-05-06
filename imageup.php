<?php
error_reporting(E_ALL & ~ E_NOTICE); 
require_once 'vendor/autoload.php';

use free\Auth;
use free\Storage\UploadManager;

$accessKey = $_GET['ak'];
$secretKey = $_GET['sk'];

$auth = new Auth($accessKey, $secretKey);

$bucket = $_GET['bucket'];

$prefix = $_GET['prefix'];

$opts = array(
	        'saveKey'    => $prefix . '/$(fname)'
            );

$token = $auth->uploadToken($bucket, null, 3600, $opts);

if ($_FILES["Filedata"]["error"] > 0)
{
	echo "Error: " . $_FILES["Filedata"]["error"] . "";
}

$uploadManager = new UploadManager();
$imgFile = $uploadManager->put('Filedata',$_FILES["Filedata"]["name"],$_FILES["Filedata"]);
echo "Upload_put: " . json_encode($imgFile) . "<br />";

echo "Upload: " . $_FILES["Filedata"]["name"] . "<br />";
echo "Type: " . $_FILES["Filedata"]["type"] . "<br />";
echo "Size: " . ($_FILES["Filedata"]["size"] / 1024) . " Kb<br />";
echo "Stored in: " . $_FILES["Filedata"]["tmp_name"]. " Kb<br />";

$imgFile2 = $uploadManager->postFile($token,'Filedata',$_FILES["Filedata"]["tmp_name"]);
echo "Upload post: " . json_encode($imgFile2). " Kb<br />";
echo json_encode($imgFile);
?>