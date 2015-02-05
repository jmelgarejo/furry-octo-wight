<?php
function file_get_contents_curl($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);       
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}
if (isset($_GET['q'])) {
   $q = substr($_GET['q'], 0, 100);
   $ie=isset($_GET['ie'])?$_GET['ie']:"UTF-8";
   $tl=isset($_GET['tl'])?$_GET['tl']:"es-CL";
   $q = urlencode($_GET['q']);
   $file  = md5($q);
   $file = "audio/" . $file . ".mp3";
   if (!file_exists($file)) {
     $mp3 = file_get_contents_curl("https://translate.google.com/translate_tts?ie={$ie}&q={$q}&tl={$tl}");
     file_put_contents($file, $mp3);
   }
  if(file_exists($file)) {
      header('Content-Type: audio/mpeg');
      header('Content-Disposition:inline; filename="translate.mp3"');
      header('Content-length: '.filesize($file));
      header('Cache-Control: no-cache');
      header("Content-Transfer-Encoding: binary");
      readfile($file);
  } else {
      header("HTTP/1.0 404 Not Found");
  }
}
?>

