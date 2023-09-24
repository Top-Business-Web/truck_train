<?php

namespace App\Traits;

trait ImageUploading{

    public function UploadImage($photo, $folder_name)
    {

        // Get filename with the extension
        $filenameWithExt = $photo->getClientOriginalName();
        //Get just filename
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);


        $filename = 'trucktrip'.' '.date('Y-m-d h:i').' '.time();

        // Get just ext
        $extension =$photo->getClientOriginalExtension();
        // Filename to store
        $fileNameToStore = $filename.'_'.time().'.'.$extension;
        // Upload Image
        $photo->storeAs('public/uploads/'.$folder_name,$fileNameToStore);

        return $folder_name.'/'.$fileNameToStore;

        //return $path;


    }
}
