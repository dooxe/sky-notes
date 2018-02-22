<?php
//------------------------------------------------------------------------------
//  NOTE API
//------------------------------------------------------------------------------
/*
$klein->respond('GET', 'api/themes', function () use ($klein) {
    $dirname = App::path('themes');
    $themes = array();
    if ($handle = opendir($dirname)) {
        while (false !== ($entry = readdir($handle))) {
            if ($entry != "." && $entry != "..") {
                $themeDir = "$dirname/$entry/";
                $filename = "$dirname/$entry/theme.json";
                $theme = json_decode(file_get_contents($filename),true);
                $themes []= $theme;
            }
        }
        closedir($handle);
    }
    return json_encode($themes);
});
*/
?>
