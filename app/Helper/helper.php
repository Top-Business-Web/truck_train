<?php

if (! function_exists('setting')) {
    function setting() 
    {
        return \App\Models\Setting::first();
    }
}

 function get_file($file){
    if ($file){
        $file_path=asset('storage/uploads').'/'.$file;
    }else{
        $file_path=asset('admin/no_image.png');
    }
    return $file_path;
}//end