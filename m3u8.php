<?php
session_start();

header("Content-Type: application/vnd.apple.mpegurl");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Expose-Headers: Content-Length,Content-Range");
header("Access-Control-Allow-Headers: Range");
header("Accept-Ranges: bytes");

$p= @file_get_contents("http://localhost/geo/token.php");

#$p="?jct=Rqtgn1yIaDlhHspji1rcFg&pxe=1579845275&st=2rABpyTLSDzkoYSlKcWJhg";



$_SESSION["p"]=$p;

if($p!="" && @$_REQUEST["c"]!=""){


$opts = [
    "http" => [
        "method" => "GET",
        "header" => "User-Agent: plaYtv/5.3.2 (Linux;Android 5.1.1) ExoPlayerLib/2.3.0\r\n" 


    ]
];

$cx = stream_context_create($opts);


$hs = file_get_contents("http://hdbdsite.cdnsrv.jio.com/jiotv.live.cdn.jio.com/" . $_REQUEST["c"] . "/" . $_REQUEST["c"] . "_" . $_REQUEST["q"] . ".m3u8" .  $p,false,$cx);

$hs= @preg_replace("/" . $_REQUEST["c"] . "_" . $_REQUEST["q"] ."-([^.]+\.)key/", 'stream.php?key='  . $_REQUEST["c"] . '/' .   $_REQUEST["c"] . '_' . $_REQUEST["q"] . '-\1key', $hs);
$hs= @preg_replace("/" . $_REQUEST["c"] . "_" . $_REQUEST["q"] ."-([^.]+\.)ts/", 'stream.php?ts='  . $_REQUEST["c"] . '/' .   $_REQUEST["c"] . '_' . $_REQUEST["q"] . '-\1ts', $hs);
$hs=str_replace("https://tv.media.jio.com/streams_live/" .  $_REQUEST["c"] . "/","",$hs);
$hs = str_replace("https://tv.media.jio.com/streams_hotstar/" . $_REQUEST["c"] . "/","",$hs);

print $hs;

}

?>
