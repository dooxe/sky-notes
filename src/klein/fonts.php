<?php
//------------------------------------------------------------------------------
//  NOTE API
//------------------------------------------------------------------------------
$klein->respond('GET', 'api/editor-fonts', function () use ($klein) {
    $filename = App::path('install/fonts/font-list.json');
    $fontList = (array)json_decode(file_get_contents($filename));
    return json_encode($fontList['editor']);
});
?>
