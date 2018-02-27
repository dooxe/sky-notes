<?php
//------------------------------------------------------------------------------
//  Download Google web fonts
//  @author dooxe
//------------------------------------------------------------------------------
echo "Downlading fonts ...";
$fontFilename = dirname(__FILE__).'/font-list.json';
$fontLists = (array)json_decode(file_get_contents($fontFilename));
$fontUrl = 'https://fonts.googleapis.com/css?family=';
$i = 0;
foreach($fontLists as $fontType=>$fontList){
    foreach($fontList as $font){
        $font = str_replace(' ', '+', $font);
        if($i > 0){
            $font = "|$font";
        }
        $fontUrl .= $font;
        $i += 1;
    }
}
$fontCss = file_get_contents($fontUrl);

//
$match = array();
preg_match_all('#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', $fontCss, $match);
$fontUrls = $match[0];
foreach($fontUrls as $downloadUrl){
    $fontFile = file_get_contents($downloadUrl);
    $tokens = explode("/s/", $downloadUrl);
    $dirname = "app/fonts/".dirname($tokens[1]);
    $fontFilename = $dirname.'/'.basename($tokens[1]);
    if(!file_exists($dirname)){
        if(!mkdir($dirname, 0777, true)){
            echo "Impossible to create directory '$dirname'";
            continue;
        }
    }
    file_put_contents($fontFilename,$fontFile);
}

//
$fontCss = str_replace('https://fonts.gstatic.com/s/','font/',$fontCss);
file_put_contents("app/fonts/fonts.css", $fontCss);
echo "\rDownloading fonts ... DONE !\n\n";
?>
