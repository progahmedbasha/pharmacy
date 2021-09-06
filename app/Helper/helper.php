<?php


use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;




if (!function_exists('get_file')) {
    function get_file($file){
        if ($file){
            $file_path=asset('storage/uploads').'/'.$file;
        }else{
            $file_path=asset('no_image.png');
        }
        return $file_path;
    }//end
}


if (!function_exists('store_file')) {
    function store_file($request,$file_name,$path) {
        return $request->file($file_name)->store($path,'public');
    }
}
