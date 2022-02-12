<?php

use Illuminate\Support\Facades\Config;
// get active language
function getLanguage(){
  return  App\models\Language::lang()->languages()->get();
}
// get default language
function get_default_lang(){
    return  Config::get('app.locale');
}

// save images
function uploadImage($folder, $image)
{
    $image->store('/', $folder);
    $filename = $image->hashName();
    $path = 'images/' . $folder . '/' . $filename;
    return $path;
}
