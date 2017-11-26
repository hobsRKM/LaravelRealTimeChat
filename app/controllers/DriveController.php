<?php

class DriveController extends Controller {

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    public function drive()
    {
     $output=  exec("ls -l");
     echo $output;
       exit;
$url_array = explode('?', 'http://'.$_SERVER ['HTTP_HOST'].$_SERVER['REQUEST_URI']);
$url = $url_array[0];
echo $url;

require_once base_path('google-api-php-client/src/Google_Client.php');
require_once base_path('google-api-php-client/src/contrib/Google_DriveService.php');

$client = new Google_Client();
$client->setClientId('767548203421-kvg9d6jnkvgh05mp5dekrsiviu4bfism.apps.googleusercontent.com');
$client->setClientSecret('Af0cSwzFvviIsXmmZXudxBmi');
$client->setRedirectUri($url);
$client->setScopes(array('https://www.googleapis.com/auth/drive'));
//echo Session::get('code');
//exit;

if (Session::get('code')!='') {
    $_SESSION['accessToken'] = $client->authenticate($_GET['code']);
    header('location:'.$url);
} elseif (Session::get('accessToken')!='') {
    $client->authenticate();
   
    
}
//echo Session::get('accessToken');
// exit;
$files= array();
$dir = dir('fusionmate/files');
while ($file = $dir->read()) {
    if ($file != '.' && $file != '..') {
        $files[] = $file;
    }
}
$dir->close();

    $client->setAccessToken('{"access_token":"ya29..uQI2E1zBl8ulgKGvg9-wy0gos_AovRnDtm9vAmE3OGTODtDvwnvE1QEYG0Yn6iKNIw","token_type":"Bearer","expires_in":3600,"refresh_token":"1\/DGZ19GkYcEir0jux7NKj6GT_jHLQL0foSDOTN-poL6EMEudVrK5jSpoR30zcRFq6","created":1459692855}');
    $service = new Google_DriveService($client);
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $file = new Google_DriveFile();
    foreach ($files as $file_name) {
        $file_path = 'fusionmate/files/'.$file_name;
        $mime_type = finfo_file($finfo, $file_path);
        $file->setTitle($file_name);
        $file->setDescription('This is a '.$mime_type.' document');
        $file->setMimeType($mime_type);
       $a= $service->files->insert(
            $file,
            array(
                'data' => file_get_contents($file_path),
                'mimeType' => $mime_type
            )
        );
    }
    finfo_close($finfo);
     print_r($a);
   // header('location:'.$url);exit;

//include 'fusionmate/index.phtml';
    }

}
